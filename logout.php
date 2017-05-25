<?php
    require_once ('resources/config.php');

    if ($user->is_logged_in()) {
        $user->logout();
        $user->redirect('login.php');
        echo 'Successfully logged out... ';
    } else {
        echo 'Error logging out... ';
    }
 ?>
