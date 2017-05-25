<?php

    require_once ('login_status.php');

    require_once ('resources/config.php');

    require_once (TEMPLATE_PATH.'/header.php');

    require_once (TEMPLATE_PATH.'/nav.php');



 ?>

 <a href="add_user.php">Add user</a>

 <table id="user_table">
     <tr>
         
     </tr>
 </table>

<?php
    require_once (TEMPLATE_PATH.'/footer.php');
    echo '<script src="resources/content/scripts/users.js"></script>';
 ?>
