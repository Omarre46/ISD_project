<?php

include "../includes/connection.php";
include "../includes/login-register-functions.php";

if (isset($_POST["submit"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];
    if (emptyInputSignIn($username, $password) !== false) {
        header("Location: ../users/login.php?error=emptyinput");
        exit();
    }
    signIn($con, $username, $password);
} else {
    header("location: ../client_side/home.php");
    exit();
}
