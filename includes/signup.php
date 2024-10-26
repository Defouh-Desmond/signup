<?php
$info = (object)[];
$Error = '';
$data = [];
$data['userid'] = $DB->generate_id(20);
$data['date'] = date("y-m-d H:i:s");
$arr['email'] = $_POST['email'];

$sql = "select * from users where email = :email limit 1";
$result = $DB->read($sql, $arr);
if (is_array($result)) {
    $Error = "This user already exists, please login.";
}

$data['firstName'] = $_POST['firstName'];
if (empty($_POST['firstName']) || strlen($_POST['firstName']) < 3 || !preg_match("/^[a-zA-Z ]*$/", $_POST['firstName'])) {
    $Error .= "Invalid first name. <br>";
}

$data['lastName'] = $_POST['lastName'];
if (empty($_POST['lastName']) || strlen($_POST['lastName']) < 3 || !preg_match("/^[a-zA-Z ]*$/", $_POST['lastName'])) {
    $Error .= "Invalid last name. <br>";
}

$data['email'] = $_POST['email'];
if (empty($_POST['email']) || !preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/", $_POST['email'])) {
    $Error .= "Invalid email. <br>";
}

$data['password'] = $_POST['password'];
if (empty($_POST['password']) || $_POST['password'] != $_POST['password2'] || strlen($_POST['password']) < 8) {
    $Error .= "Invalid password. <br>";
}

if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == 0) {
    $allowed_extensions = array('jpg', 'jpeg', 'png', 'gif');
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
        $Error .= "Invalid image format.";
    }
} else {
    $data['profile_image'] = "default.png";
}

if ($Error == "") {
    $query = "insert into users (userid, firstName, lastName, email, password, profile_image, date) values (:userid, :firstName, :lastName, :email, :password, :profile_image, :date)";
    $result = $DB->write($query, $data);
    if ($result) {
        $info->message = "Your profile was created.";
        $info->data_type = "info";
        echo json_encode($info);
    } else {
        $info->message = "Your profile was not created due to an error.";
        $info->data_type = "error";
        echo json_encode($info);
    }
} else {
    $info->message = $Error;
    $info->data_type = "error";
    echo json_encode($info);
}
?>
