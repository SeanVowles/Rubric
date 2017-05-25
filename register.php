<?php
    require_once ('resources/config.php');

    require_once (TEMPLATE_PATH.'/header.php');

    require_once (TEMPLATE_PATH.'/nav.php');

    if (isset($_POST['btn-register'])) {
        $user_name      = trim($_POST['user_name_text_box']);
        $user_email     = trim($_POST['user_email_text_box']);
        $user_password  = trim($_POST['user_password_text_box']);

        if ($user_name == '') {
            $error[] = 'Username is required';
        } else if (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
            $error[] = 'Enter the email in a valid format';
        } else if ($user_email == '') {
            $error[] = 'Email address is required';
        } else if ($user_password == '') {
            $error[] = 'Password is required';
        } else if (strlen($user_password) < 6 ) {
            $error[] = 'Password must be at least 6 characters';
        } else {
            try {
                $stmt = $conn->prepare('SELECT user_name, user_email
                                        FROM users
                                        WHERE user_name=:user_name
                                        OR user_email=:user_email');
                $stmt->execute(array(':user_name' => $user_name, ':user_email' => $user_email));
                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($row['user_name'] == $user_name) {
                    $error[] = 'Username is already taken';
                } else if ($row['user_email'] == $user_email) {
                    $error[] = 'Email address is already registered';
                } else {
                    if ($user->register($user_name, $user_email, $user_password)) {
                        $user->redirect('login.php');
                    }
                }
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }
    }
?>

<form method="post">
    <?php
        if (isset($error)) {
            foreach ($error as $error) {
                echo $error . "<br />";
            }
        } else if (isset($_GET['joined'])) {
            echo "Successfully registered account <br />";
        }
    ?>

    <label for="user_name_text_box">Username:</label>
    <input type="text" name="user_name_text_box" />

    <label for="user_email_text_box">Email:</label>
    <input type="text" name="user_email_text_box" />

    <label for="user_password_text_box">Password:</label>
    <input type="text" name="user_password_text_box" />

    <button type="submit" name="btn-register">Register account</button>
</form>
