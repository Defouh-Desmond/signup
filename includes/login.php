<?php
$info = (object)[];
$Error = '';

// Validate email
if (empty($_POST['email']) || !filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL)) {
    $Error .= "Invalid email. <br>";
}

// Validate password
if (empty($_POST['password'])) {
    $Error .= "Password is required. <br>";
}

// If there are errors, return them
if (!empty($Error)) {
    $info->success = false;
    $info->message = $Error;
    echo json_encode($info);
    die;
}

// Prepare data
$email = trim($_POST['email']);
$password = $_POST['password'];

// Check if the user exists
$sql = "SELECT * FROM users WHERE email = :email LIMIT 1";
$arr ['email'] = $email;
$result = $DB->read($sql, $arr);
if (is_array($result)) {
    $user_data = $result[0];
    if (password_verify($password, $user_data['password'])) {
        $_SESSION['userid'] = $user_data['userid'];
        $info->success = true;
        $info->message = "You are logged in.";
        $info->data_type = "info";
    } else {
        $info->success = false;
        $info->message = "Invalid password.";
        $info->data_type = "error";
    }
} else {
    $info->success = false;
    $info->message = "User not found.";
    $info->data_type = "error";
}

// Return the JSON response
echo json_encode($info);
?>