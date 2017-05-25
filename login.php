<?php
    // load config file
    require_once ('resources/config.php');

    // load the templated header
    require_once (TEMPLATE_PATH.'/header.php');

    if (isset($_POST['btn-login'])) {
        $user_name = $_POST['user_name_text_box'];
        $user_email = $_POST['user_name_text_box'];
        $user_password = $_POST['user_password_text_box'];

        if ($user->login($user_name, $user_email, $user_password)) {
            $user->redirect('index.php');
        } else {
            $error = 'Wrong details <br />';
        }
    }
?>

<div id="content">
    <div class="container">
        <form method="post">
            <?php
                if (isset($error)) {
                    echo 'error' . '<br />';
                }
            ?>
            <label for="user_name_text_box">Username:</label>
            <input type="text" name="user_name_text_box" />

            <label for="user_password_text_box">Password:</label>
            <input type="text" name="user_password_text_box" />

            <button type="submit" name="btn-login">Login</button>
        </form>
    </div>
</div>

<?php
    require_once (TEMPLATE_PATH.'/footer.php');
 ?>
