<?php

    /*
    * config file loaded in each file
    * connection state is stored here for database access and code reusability
    */

    //
    session_start();

    $db_host = "localhost";
    $db_name = "rubric";
    $db_user = "root";
    $db_pass = "";

    try {
        // store connection in $conn variable
        $conn = new PDO("mysql:host={$db_host};dbname={$db_name}", $db_user, $db_pass);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo 'Connection failed ' .$e->getMessage();
    }

    // load user class
    include_once 'resources/library/class.user.php';
    // set user with current connection
    $user = new User($conn);

    defined('LIBRARY_PATH')
    or define('LIBRARY_PATH', realpath(dirname(__FILE__).'/library'));

    defined('TEMPLATE_PATH')
    or define('TEMPLATE_PATH', realpath(dirname(__FILE__).'/templates'));

    ini_set('display_errors', 'On');
?>
