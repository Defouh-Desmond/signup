<?php
$info = (object)[];
$Error = '';
$data = [];
$data['userid'] = $DB->generate_id(20);
$data['date'] = date("Y-m-d H:i:s");
$arr['email'] = $_POST['email'];

// Check if the email already exists
$sql = "SELECT * FROM users WHERE email = :email LIMIT 1";
$result = $DB->read($sql, $arr);
if (is_array($result)) {
    $Error .= "This user already exists, please login.<br>";
}

// Validate first name
$data['firstName'] = trim($_POST['firstName']);
if (empty($data['firstName']) || strlen($data['firstName']) < 3 || !preg_match("/^[a-zA-Z ]*$/", $data['firstName'])) {
    $Error .= "Invalid first name. <br>";
}

// Validate last name
$data['lastName'] = trim($_POST['lastName']);
if (empty($data['lastName']) || strlen($data['lastName']) < 3 || !preg_match("/^[a-zA-Z ]*$/", $data['lastName'])) {
    $Error .= "Invalid last name. <br>";
}

// Validate email
$data['email'] = trim($_POST['email']);
if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
    $Error .= "Invalid email. <br>";
}

// Validate password
$data['password'] = $_POST['password'];
if (empty($data['password']) || strlen($data['password']) < 8 || $data['password'] !== $_POST['password2']) {
    $Error .= "Invalid password. <br>";
}

// Validate profile image
if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == 0) {
    $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
    $file_extension = strtolower(pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION));

    if (in_array($file_extension, $allowed_extensions)) {
        $image_folder = "uploads/";
        if (!file_exists($image_folder)) {
            mkdir($image_folder, 0777, true);
        }
        $image_path = $image_folder . basename($_FILES['profile_image']['name']);
        move_uploaded_file($_FILES['profile_image']['tmp_name'], $image_path);
        $data['profile_image'] = $image_path;
    } else {
        $Error .= "Invalid image format. <br>";
    }
} else {
    $data['profile_image'] = "default.png"; // Use default image if none is uploaded
}

// Check for errors
if (empty($Error)) {
    $query = "INSERT INTO users (userid, firstName, lastName, email, password, profile_image, date) VALUES (:userid, :firstName, :lastName, :email, :password, :profile_image, :date)";
    $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT); // Hash the password before storing
    $result = $DB->write($query, $data);
    if ($result) {
        $info->success = true;
        $info->message = "Your profile was created.";
        $info->data_type = "info";
    } else {
        $info->success = false;
        $info->message = "Your profile was not created due to an error.";
        $info->data_type = "error";
    }
} else {
    $info->success = false;
    $info->message = $Error;
    $info->data_type = "error";
}

// Return the JSON response
echo json_encode($info);
?>