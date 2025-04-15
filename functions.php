<?php

function setActiveClass($pageName){
    $current_page = basename($_SERVER['PHP_SELF']);
    return ($current_page === $pageName . ".php") ? "active" : '';
}

function getPageClass(){
    return basename($_SERVER['PHP_SELF'], ".php"); 
}

function user_exists($conn, $username){
     // Check if the username already exists in the database
     $sql = "SELECT * FROM users WHERE username= '$username' LIMIT 1";
     $result = mysqli_query($conn, $sql);

       return mysqli_num_rows($result) > 0; 
    }


?>