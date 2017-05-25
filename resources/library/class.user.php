<?php
require_once 'class.schema.php';

class User
{
    private $db;

// constructor takes connection as parameter (this is probably true for all classes that access database)
    public function __construct($conn)
    {
        $this->db = $conn;
    }

    // function to register a new user
    // pass in required parameters to populate database
    public function register($user_name, $user_email, $user_password)
    {
        try {
            $new_password = password_hash($user_password, PASSWORD_DEFAULT);

    // SQL statement to be held in variable
    $stmt = $this->db->prepare(
        'INSERT INTO user(user_name, user_email, user_password)
        VALUES(:user_name, :user_email, :user_password)');

            $stmt->bindparam(':user_name', $user_name);
            $stmt->bindparam(':user_email', $user_email);
            $stmt->bindparam(':user_password', $new_password);
            $stmt->execute();

            return $stmt;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    // function for users to log in
    // takes username or email to get ID
    public function login($user_name, $user_email, $user_password)
    {
        try {
            $stmt = $this->db->prepare(
                'SELECT * FROM user
                WHERE user_name=:user_name
                OR user_email=:user_email LIMIT 1');

            $stmt->execute(array(
                ':user_name' => $user_name,
                ':user_email' => $user_email));

            $user_row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($stmt->rowCount() > 0) {
                if (password_verify($user_password, $user_row['user_password'])) {
                    $_SESSION['user_session'] = $user_row['user_id'];

                    return true;
                } else {
                    return false;
                }
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    // function to check if users are logged in
    public function is_logged_in()
    {
        if (isset($_SESSION['user_session'])) {
            return true;
        }
    }

    // function to redirect user
    public function redirect($url)
    {
        header("Location: $url");
    }

    public function get_columns_in_table($table)
    {
        header('Content-Type: application/json');
        try {
            $stmt =
                "SELECT COLUMN_NAME
                FROM INFORMATION_SCHEMA.COLUMNS
                WHERE TABLE_SCHEMA = 'rubric'
                AND TABLE_NAME = '$table'";

            $stmt = $this->db->prepare($stmt);
            $stmt->execute();

            $result = $stmt->fetchAll(PDO::FETCH_COLUMN);

            return array(
                'table' => $table,
                'rows_in_table' => $stmt->rowCount(),
                'data' => array('columns' => $result));
        } catch (PDOException $error) {
            return array(
                'status' => 'ERROR',
                'message' => $error->getMessage());
        }
    }

    // generate a list of users
    public function get_contents_in_table($table)
    {
        header('Content-Type: application/json');
        try {
            $stmt = $this->db->prepare("SELECT * FROM $table");
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return array(
                'table' => $table,
                'rows_in_table' => $stmt->rowCount(),
                'columns_in_table' => $stmt->columnCount(),
                'data' => $result);
        } catch (PDOException $e) {
            $e->getMessage();
        }
    }

    public function list_enrolled_modules()
    {
        header('Content-Type: application/json');
        try {
            $user_id = $_SESSION['user_session'];
            $stmt = $this->db->prepare(
                'SELECT * FROM user_modules
                WHERE user_id=:user_id');

            $stmt->execute(array(':user_id' => $user_id));
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($stmt->rowCount() > 0) {
                return array(
                    'rows_in_table' => $stmt->rowCount(),
                    'columns_in_table' => $stmt->columnCount(),
                    'data' => $result, );
            } else {
                return array(
                    'status' => 'ERROR',
                    'message' => 'No data in table.');
            }
        } catch (PDOException $e) {
            $e->getMessage();
        }
    }

    public function list_user_assignments()
    {
        header('Content-Type: application/json');
        try {
            $user_id = $_SESSION['user_session'];

            $stmt = $this->db->prepare(
                'SELECT module.module_name, assignment.assignment_name, user.user_id
                FROM user
                LEFT JOIN user_modules
                ON user_modules.user_id = :user_id
                LEFT JOIN module ON user_modules.module_id = module.module_id
                LEFT JOIN assignment ON assignment.module_id = module.module_id
                WHERE (user.user_id = :user_id)');

            $stmt->execute(array(':user_id' => $user_id));

            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($stmt->rowCount() > 0) {
                return array(
                        'rows_in_table' => $stmt->rowCount(),
                        'columns_in_table' => $stmt->columnCount(),
                        'data' => $result, );
            } else {
                return array(
                        'status' => 'ERROR', 'message' => 'No data in table');
            }
        } catch (PDOException $e) {
            $e->getMessage();
        }
    }

    // function to log the user out
    public function logout()
    {
        // destroy all data registered to the session
    session_destroy();
    // unset a given variable
    unset($_SESSION['user_session']);

        return true;
    }
}
