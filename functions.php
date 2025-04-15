<?php


function isUserLoggedIn(){
    return (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true);
}


function redirect($location){
    header("Location: $location");
    exit;
}

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

    function readableDate($date){
        return date ("F j, Y", strtotime($date));
    }



?>