<?php
    require_once ('login_status.php');

    require_once (TEMPLATE_PATH.'/header.php');

    require_once (TEMPLATE_PATH.'/nav.php');

    // $rubric = new Rubric($conn);
    // $module = new Module($conn);
    //
    // if (isset($_POST['create_new_rubric_btn'])) {
    //     $table_name = trim($_POST['rubric_table_name_text_box']);
    //     $rubric->create_rubric_table($table_name);
    // }
    //
    // if (isset($_POST['create_new_module_btn'])) {
    //     $table_name = trim($_POST['module_table_name_text_box']);
    //     $module->create_module_table($table_name);
    // }

 ?>

 <!-- <div id="content">
     <div class="container">
         <form method="post">
             <label for="rubric_table_name_text_box">Table name: </label>
             <input type="text" name="rubric_table_name_text_box">
             <button type="submit" name="create_new_rubric_btn">Create rubric</button>

             <label for="module_table_name_text_box">Module name: </label>
             <input type="text" name="module_table_name_text_box" />
             <button type="submit" name="create_new_module_btn">Create module</button>
         </form>
     </div>
 </div> -->


<?php
    require_once (TEMPLATE_PATH.'/footer.php');
 ?>
