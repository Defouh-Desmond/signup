<?php
session_start();
$info = (object)[];

if (!isset($_SESSION['userid'])) {
    if (!isset($_POST['data_type']) || ($_POST['data_type'] != 'login' && $_POST['data_type'] != 'signup')) {
        $info->logged_in = false;
        echo json_encode($info);
        die;
    }
}

require_once("classes/autoload.php");
$DB = new Database();
$Error = "";

if (isset($_POST['data_type'])) {
    switch ($_POST['data_type']) {
        case 'signup':
            include("includes/signup.php");
            break;
        case 'login':
            include("includes/login.php");
            break;
        default:
            $info->success = false;
            $info->message = "Invalid data type";
            echo json_encode($info);
            break;
    }
}
?>
