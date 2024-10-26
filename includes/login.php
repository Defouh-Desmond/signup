<?php
$info = (object)[];
$data = [];

if (isset($_POST['email']) && isset($_POST['password'])) {
    $arr['email'] = $_POST['email'];
    $sql = "select * from users where email = :email limit 1";
    $result = $DB->read($sql, $arr);
    if (is_array($result)) {
        $result = $result[0];
        if (password_verify($_POST['password'], $result->password)) {
            $_SESSION['userid'] = $result->userid;
            $info->message = "You are logged in.";
            $info->data_type = "info";
            echo json_encode($info);
        } else {
            $info->message = "Incorrect password.";
            $info->data_type = "error";
            echo json_encode($info);
        }
    } else {
        $info->message = "User not found.";
        $info->data_type = "error";
        echo json_encode($info);
    }
} else {
    $info->message = "Please enter email and password.";
    $info->data_type = "error";
    echo json_encode($info);
}
?>
