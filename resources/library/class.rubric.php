<?php

// show data in json format for testing
// header('Content-Type: application/json');

require_once('class.schema.php');

class Rubric
{
    private $db;

// constructor takes the connection as a parameter
    public function __construct($conn)
    {
        $this->db = $conn;
    }
    // function to create a rubric table
    public function create_rubric_table($table_name)
    {
        try {
            // SQL statement to be held in variable
            $stmt = $this->db->prepare(
                "CREATE TABLE $table_name (
                    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                    criteria VARCHAR(30) NOT NULL,
                    fail VARCHAR(30) NOT NULL,
                    pass VARCHAR(30) NOT NULL,
                    merit VARCHAR(30) NOT NULL,
                    distinction VARCHAR(30) NOT NULL
                )");
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function get_tables()
    {
        try {
            // sql statement to show to tables
                $stmt = $this->db->prepare(
                    'SHOW TABLES');

            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_COLUMN);

            if ($stmt->rowCount() > 0) {
                return array(
                        'rows_in_table' => $stmt->rowCount(),
                        'data' => array('tables' => $result));
            } else {
                return array(
                        'status' => 'ERROR',
                        'message' => 'No tables found in selected database.');
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    // get the contents of a specific table passed into the variable as parameter
    public function get_table_contents($table)
    {
        try {
            // gets list of the tables from this class
            $list_of_tables = $this->get_tables();

            if (in_array(
                $table, $list_of_tables['data']['tables'])) {
                $stmt = "SELECT * FROM ".$table;
                $stmt = $this->db->query($stmt);

                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return array(
                        'table' => $table,
                        'rows_in_table' => $stmt->rowCount(),
                        'data' => $result);
            } else {
                return array(
                    'status' => 'ERROR',
                    'message' => 'Table was not found in selected database');
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function list_all_users()
    {
        header('Content-Type: application/json');
        try {
            $stmt = $this->db->prepare(
                'SELECT user_id
                FROM user'
            );
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($stmt->rowCount() > 0) {
                return array('data' => $result);
            } else {
                return array(
                    'status' => 'ERROR',
                    'message' => 'No rows in table'
                );
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function list_user_modules($user_id)
    {
        header('Content-Type: application/json');
        try {
            $stmt = $this->db->prepare(
                "SELECT module.module_name
                FROM user_modules
                LEFT JOIN module ON user_modules.module_id = module.module_id
                WHERE user_modules.user_id = $user_id");

            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($stmt->rowCount() > 0) {
                return array(
                    'rows_in_table' => $stmt->rowCount(),
                    'data' => $result
                );
            } else {
                return array(
                    'status' => 'ERROR',
                    'message' => 'No rows in table'
                );
            }
        } catch (PDOException $e) {
            $e->getMessage();
        }
    }

    // list assignments for user based on module selected
    public function list_user_assignments($user_id, $module_name)
    {
        header('Content-Type: application/json');
        try {
            $stmt = $this->db->prepare(
                "SELECT assignment.assignment_name
                FROM user_modules
                LEFT JOIN module ON user_modules.module_id = module.module_id
                LEFT JOIN assignment ON assignment.module_id = module.module_id
                WHERE (user_modules.user_id = $user_id and module.module_name = \"$module_name\")");

            $stmt->execute();

            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($stmt->rowCount() > 0) {
                return array(
                    'rows_in_table' => $stmt->rowCount(),
                    'data' => $result
                );
            } else {
                return array(
                    'status' => 'ERROR',
                    'message' => 'No rows in table'
                );
            }
        } catch (PDOException $e) {
            $e->getMessage();
        }
    }

    public function get_assignment_rubric($user_id, $module_name, $assignment_name)
    {
        header('Content-Type: application/json');
        try {
            $user_id = $_SESSION['user_session'];

            $stmt = $this->db->prepare(
                "SELECT rubric.criteria, rubric.fail, rubric.pass, rubric.merit, rubric.distinction, rubric.weight
                FROM user
                LEFT JOIN user_modules
                ON user_modules.user_id
                LEFT JOIN module ON user_modules.module_id = module.module_id
                LEFT JOIN assignment ON assignment.module_id = module.module_id
                LEFT JOIN rubric ON rubric.assignment_id = assignment.assignment_id
                WHERE (user.user_id = $user_id AND module.module_name = '$module_name' AND assignment.assignment_name = '$assignment_name')");

            $stmt->execute(array(':user_id' => $user_id));

            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($stmt->rowCount() > 0) {
                return array(
                        'rows_in_table' => $stmt->rowCount(),
                        'columns_in_table' => $stmt->columnCount(),
                        'data' => $result);
            } else {
                return array(
                        'status' => 'ERROR', 'message' => 'No data in table');
            }
        } catch (PDOException $e) {
            $e->getMessage();
        }
    }

    public function update_user_assignment_grade($grade, $user_id, $assignment_id)
    {
        header('Content-Type: application/json');

        try {
            $stmt = $this->db->prepare(
                "UPDATE
                    user_assignment_grade
                SET
                    grade = $grade
                WHERE
                    user_id = $user_id AND assignment_id = $assignment_id");

            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            $e->getMessage();
        }
    }

    public function get_assignment_id_from_name($assignment_name)
    {
        header('Content-Type: application/json');

        try {
            $stmt = $this->db->prepare(
                "SELECT user_assignment_grade.assignment_id
                FROM assignment
                LEFT JOIN user_assignment_grade ON user_assignment_grade.assignment_id = assignment.assignment_id
                WHERE (assignment.assignment_name = '$assignment_name')");

            $stmt->execute();

            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($stmt->rowCount() > 0) {
                return array(
                    'data' => $result
                );
            } else {
                return array(
                    'status' => 'ERROR',
                    'message' => 'No rows in table'
                );
            }
        } catch (PDOException $e) {
            $e->getMessage();
        }
    }
}
