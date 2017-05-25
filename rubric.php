<?php
    require_once('login_status.php');

    require_once(TEMPLATE_PATH.'/header.php');

    require_once(TEMPLATE_PATH.'/nav.php');
 ?>

 <div class="container">
     <div class="row">
         <div class="form-group col-xs-4">
             <!-- build a select list of users -->
             <select id="user_dropdown" class="form-control">
                 <option>--- Select User Identifier ---</option>
             </select>
         </div>

         <div class="form-group col-xs-4">
             <!-- build select list of modules associated to user -->
             <select id="module_dropdown" class="form-control">
                 <<option>--- Select Module ---</option>
             </select>
         </div>

         <div class="form-group col-xs-4">
             <!-- build select list of assignments related to that module and user -->
             <select id="assignment_dropdown" class="form-control">
                 <<option>--- Select Assignment ---</option>
             </select>
         </div>
     </div>

     <div class="panel panel-default">
         <div class="panel-heading">
             <div class="row">
                 <div class="left col-sm-6 text-left">
                     <h3 class="panel-title">Panel Title</h3>
                 </div>
                 <div class="right col-sm-6 text-right">
                     <button id="calculate_score" class="btn btn-default btn-sm btn-primary"><span class="glyphicon glyphicon-plus-sign"></span></button>
                     <button id="save_score" class="btn btn-default btn-sm btn-primary"><span class="glyphicon glyphicon-save"></span></button>
                 </div>
             </div>
         </div>
         <!-- build a rubric table from the information from select list -->
         <div class="table_container">
             <table id="rubric_table" class="table"></table>
         </div>
     </div>

 </div>

<?php
    require_once(TEMPLATE_PATH.'/footer.php');
    echo '<script src="resources/content/scripts/rubric.js"></script>';
 ?>
