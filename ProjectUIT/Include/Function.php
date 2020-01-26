<?php require_once ("DB.php"); ?>
<?php require_once("Sessions.php"); ?>
<?php

function Redirect_to($New_Location) {
    header("Location:" .$New_Location);
    exit;
}

function Login_Attempt($UserName, $Password) {
    global $conn;
    $Query = "SELECT * FROM registration WHERE USERNAME='$UserName' AND  PASSWORD='$Password'";
    $Execute = mysqli_query($conn, $Query);
    if ($admin = mysqli_fetch_assoc($Execute)) {
        return $admin;
    } else {
        return null;
    }
}

function Login() {
    if (isset($_SESSION["User_ID"])) {
        return true;
    }
}

function Confirm_Login() {      // Proverava da li je admin logovan
    if (!Login()) {
        Redirect_to("index.php");
    }
}

// Logovanje usera
function Login_Attempt_User($UserName, $Password) {
    global $conn;
    $query = "SELECT * FROM users WHERE USER_NAME='$UserName' AND  PASSWORD='$Password'";
    $execute = mysqli_query($conn, $query);
    if ($user = mysqli_fetch_assoc($execute)) {
        return $user;
    } else {
        return null;
    }
}

function Login_User() {
    if (isset($_SESSION["user_ID"])) {
        return true;
    }
}

function Confirm_Login_User() {
    if (!Login()) {
        Redirect_to("index.php");
    }
}

function Confirm_Admin() {
    if ($_SESSION["User_ID"] != 1) {
        Redirect_to("Dashboard.php");
    } 
}

?>