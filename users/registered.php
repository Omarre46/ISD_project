<?php

include "../includes/connection.php";
include "../includes/login-register-functions.php";

if (isset($_POST["submit"])) {

    $name = $_POST["name"];
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $repeatPassword = $_POST["repeatPassword"];

    if (emptyInputRegister($name, $username, $email, $password, $repeatPassword) !== false) {
        header("Location: ../users/register.php?error=emptyinput");
        exit();
    }
    if (invalidUsername($username) !== false) {
        header("Location: ../users/register.php?error=invalidusername");
        exit();
    }
    if (invalidName($name) !== false) {
        header("Location: ../users/register.php?error=invalidname");
        exit();
    }
    if (invalidEmail($email) !== false) {
        header("Location: ../users/register.php?error=invalidemail");
        exit();
    }
    if (passwordsMatch($password, $repeatPassword) !== false) {
        header("Location: ../users/register.php?error=passwordsdontmatch");
        exit();
    }
    if (usernameExists($con, $username, $email) !== false) {
        header("Location: ../users/register.php?error=usernametaken");
        exit();
    }
    createUser($con, $name, $username, $email, $password);
}
