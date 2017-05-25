<?php
    require_once ('login_status.php');

    if ($user->is_logged_in()) {
        $user->redirect('home.php');
    }

    require_once (TEMPLATE_PATH.'/header.php');
 ?>

 <?php
    require_once (TEMPLATE_PATH.'/footer.php');
  ?>
