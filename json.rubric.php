<?php
    require_once('login_status.php');
    require_once('resources/library/class.rubric.php');

    // main program body
    $rubric = new Rubric($conn);
    $response = new Schema();

    if (isset($_GET['action'])) {
        switch ($_GET['action']) {
            case 'get_tables':
                echo $response->get_response($rubric->get_tables());
                break;
            case 'get_table_contents':
                if (isset($_GET['table'])) {
                    echo $response->get_response($rubric->get_table_contents($_GET['table']));
                }
                break;
            case 'list_all_users':
                echo $response->get_response($rubric->list_all_users());
                break;
            case 'list_user_modules':
                if (isset($_GET['user_id'])) {
                    echo $response->get_response($rubric->list_user_modules($_GET['user_id']));
                }
                break;
            case 'list_user_assignments':
                if (isset($_GET['user_id']) and (isset($_GET['module_name']))) {
                    echo $response->get_response($rubric->list_user_assignments($_GET['user_id'], $_GET['module_name']));
                }
                break;
            case 'get_assignment_rubric':
                if (isset($_GET['user_id']) and isset($_GET['module_name']) and isset($_GET['assignment_name'])) {
                    echo $response->get_response($rubric->get_assignment_rubric($_GET['user_id'], $_GET['module_name'], $_GET['assignment_name']));
                }
                break;
            case 'update_user_assignment_grade':
                if (isset($_GET['grade']) and isset($_GET['user_id']) and isset($_GET['assignment_id'])) {
                    $rubric->update_user_assignment_grade($_GET['grade'], $_GET['user_id'], $_GET['assignment_id']);
                }
                break;
            case 'get_assignment_id_from_name':
                if (isset($_GET['assignment_name'])) {
                    echo $response->get_response($rubric->get_assignment_id_from_name($_GET['assignment_name']));
                }
                break;
            default:
                # code...
                break;
        }
    }
