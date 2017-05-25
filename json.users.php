<?php
    require_once ('login_status.php');

    require_once ('resources/config.php');

    // program body
    $response = new Schema();

    if (isset($_GET['action'])) {
        switch ($_GET['action']) {
            case 'get_columns_in_table':
                if (isset($_GET['table'])) {
                    echo $response->get_response($user->get_columns_in_table($_GET['table']));
                }
                break;
            case 'get_contents_in_table':
                if (isset($_GET['table'])) {
                    echo $response->get_response($user->get_contents_in_table($_GET['table']));
                }
                break;
            case 'list_enrolled_modules':
                echo $response->get_response($user->list_enrolled_modules());
                break;
            case 'list_user_assignments':
                echo $response->get_response($user->list_user_assignments());
                break;
            default:
                # code...
                break;
        }
    }
 ?>
