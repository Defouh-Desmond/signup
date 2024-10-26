<?php
session_start();
$info = (object)[];

require_once("classes/autoload.php");
$DB = new Database();

// Check if the data_type is set
if (!isset($_POST['data_type'])) {
    $info->success = false;
    $info->message = "No data type specified.";
    echo json_encode($info);
    die;
}

// If data_type is not 'login' or 'signup', check for session
if ($_POST['data_type'] != 'login' && $_POST['data_type'] != 'signup' && !isset($_SESSION['userid'])) {
    $info->success = false;
    $info->message = "Unauthorized access. Please log in or provide valid data type.";
    echo json_encode($info);
    die;
}

// Handle the request based on the data_type
switch ($_POST['data_type']) {
    case 'signup':
        include("includes/signup.php");
        break;
    case 'login':
        include("includes/login.php");
        break;
    default:
        $info->success = false;
        $info->message = "Invalid data type.";
        echo json_encode($info);
        break;
}
?>