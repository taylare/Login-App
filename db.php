<?php

$host = "localhost";
$username = "root";
$password = "";
$db = "login-app";


$conn = mysqli_connect($host, $username, $password, $db);
function check_query($result){
    global $conn;
    if(!$result){
        return "Error" . mysqli_error($conn);
    }
    return true;
}

?>