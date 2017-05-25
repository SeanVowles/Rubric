<?php
    require_once ('resources/config.php');

    if (!$user->is_logged_in()) {
        $user->redirect('login.php');
    }
 ?>
