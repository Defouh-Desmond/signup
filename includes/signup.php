<?php
$info = (object)[];
$data = false;
$data['userid'] = $DB->generate_id(20);
$data['date'] = date("y-m-d H:i:s");



$arr['email'] = $DATA_OBJ->email;;
if (isset($DATA_OBJ->find->email)) {

    $arr['email'] = $DATA_OBJ->find->email;
}

$sql = "select * from user where email = :email limit 1";
$result = $DB->read($sql,$arr);

if(is_array($result)){
    //user found
    $Error= "This user already exist please login";
    
}

//for the  first name
$data['firstName'] = $DATA_OBJ->firstName;
//validate username
if (empty($DATA_OBJ->firstName)) {
    $Error= "please the name field is empty. <br>";
}else
{
    if (strlen($DATA_OBJ->firstName)< 3) {
        $Error= "Name must be at least 3 characters long. <br>";
    }

    //regular expression
    if (!preg_match("/^[a-z A-Z]*$/",$DATA_OBJ->firstName)) {
        $Error= "please enter a valid name. <br>";
    }
}

// for the last name
$data['lastName'] = $DATA_OBJ->lastName;
//validate username
if (empty($DATA_OBJ->lastName)) {
    $Error= "please the last name field is empty. <br>";
}else
{
    if (strlen($DATA_OBJ->lastName)< 3) {
        $Error= "last name must be at least 3 characters long. <br>";
        
    }

    //regular expression
    if (!preg_match("/^[a-z A-Z]*$/",$DATA_OBJ->lastName)) {
        $Error= "please enter a valid last name. <br>";
    }
}


//for email
$data['email'] = $DATA_OBJ->email;
    //validate email
if (empty($DATA_OBJ->email)) {
    $Error= "please enter a valid email. <br>";
}else
{
    //regular expression
    if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/",$DATA_OBJ->email)) {
        $Error= "please enter a valid email. <br>";
    }
}

//for password
$data['password'] = $DATA_OBJ->password;
$password = $DATA_OBJ->password2;
    //validate password
if (empty($DATA_OBJ->password)) {
    $Error= "please enter a valid Password. <br>";
}else
{
    if ($DATA_OBJ->password != $DATA_OBJ->password2) {
        $Error= "Password must match. <br>";
        
    }
    if (strlen($DATA_OBJ->password)< 8) {
        $Error= "Password must be atleast 8 characters long. <br>";
        
    }

}

if ($Error == "") {
    # code...
    $query = "insert into user (userid, firstName, lastName, email, password, date) values(:userid, :firstName, :lastName, :email, :password, :date)";
$result = $DB->write($query,$data);


if ($result) {
    # code...
    $info->message = "your profile was created";
    $info->data_type = "info";
    echo json_encode($info);
}else 
{
    # code...
    $info->message = "your profile was not created due to an error";
    $info->data_type = "error";
    echo json_encode($info);
}
}else {
    # code...
    $info->message = $Error;
    $info->data_type = "error";
    echo json_encode($info);
}
