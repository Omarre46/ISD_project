<?php

function emptyInputRegister($name, $username, $email, $password, $repeatPassword)
{
    $result = false;
    if (empty($name) || empty($username) || empty($email) || empty($password) || empty($repeatPassword)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function invalidUsername($username)
{
    $result = false;
    if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function invalidName($name)
{
    $result = false;
    if (!preg_match("/^[a-zA-Z-' ]*$/", $name)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function invalidEmail($email)
{
    $result = false;
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function passwordsMatch($password, $repeatPassword)
{
    $result = false;
    if ($password !== $repeatPassword) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}
 
function usernameExists($con, $username, $email)
{
    $sql = "select * from guest where username = ? or Email =?;";
    $stmt = mysqli_stmt_init($con);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../users/register.php?error=stmtfails");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "ss", $username, $email);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row;
    } else {
        $result = false;
        return $result;
    }
    mysqli_stmt_close($stmt);
}

function createUser($con, $name, $username, $email, $password)
{
    $sql = "insert into guest (name, email, username, password) values (?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($con);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../users/register.php?error=stmtfails");
        exit();
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $username, $hashedPassword);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("Location: ../client_side/home.php?error=none");
    exit();
}
function emptyInputSignIn($username, $password)
{
    $result = false;
    if (empty($username) || empty($password)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function signIn($con, $username, $password)
{
    $userNameExists =  usernameExists($con, $username, $username);

    if ($userNameExists === false) {
        header("Location: ../users/login.php?error=wrongsignin");
        exit();
    }

    $passwordHashed = $userNameExists["Password"];
    $checkPassword = password_verify($password, $passwordHashed);
    if ($checkPassword === false) {
        header("Location: ../users/login.php?error=wrongsignin");
        exit();
    } else if ($checkPassword === true) {
        session_start();
        $_SESSION["userid"] = $userNameExists["ID"];
        $_SESSION["username"] = $userNameExists["username"];
        if ($_SESSION["userid"] == "1") {
            header("location: ../admin/add_room.php");
            exit();
        } else {
            header("location: ../client_side/home.php");
            exit();
        }
    }
}
