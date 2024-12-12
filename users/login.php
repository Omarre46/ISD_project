 <?php
require '../includes/connection.php';
session_start();

// Secure session settings
 
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // CSRF Token Validation
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("Invalid CSRF token.");
    }

    // Get and sanitize user inputs
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($password)) {
        $error = "Please fill all the fields.";
    } else {
        // SQL Injection prevention using prepared statements
        $stmt = $conn->prepare("SELECT * FROM guest WHERE Username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            // Verify hashed password
            if (password_verify($password, $row['Password'])) {
                // Valid login, set session variables
                $_SESSION['loggedin'] = true;
                $_SESSION['name'] = htmlspecialchars($username, ENT_QUOTES, 'UTF-8');
                $_SESSION['email'] = htmlspecialchars($row['Email'], ENT_QUOTES, 'UTF-8');

                // Redirect to client home page
                header("Location: ../client_side/home.php");
                exit();
            } else {
                $error = "Invalid Username or Password.";
            }
        } elseif ($username === 'admin123' && $password === 'admin123') {
            // Admin login
            $_SESSION['loggedin'] = true;
            $_SESSION['name'] = htmlspecialchars($username, ENT_QUOTES, 'UTF-8');

            header("Location: ../admin/client_sec.php");
            exit();
        } else {
            $error = "Invalid Username or Password.";
        }
    }
}
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style/login.css">
</head>

<body>

    <div class="container">
        <div class="box">
            <a href="#" id="back-home" class="login"><img id="x_button" src="./img/x-solid.svg" alt=""></a>

            <h1>Sign in</h1>

            <form action="login.php" method="post" >
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8'); ?>">
                
                <label>Username</label>
                <div>
                    <i class="fa-solid fa-user"></i>
                    <input id="username" type="text" name="username" placeholder="Enter Username">
                </div>
                <label>Password</label>
                <div>
                    <i class="fa-solid fa-lock"></i>
                    <input id="password" type="password" name="password" placeholder="Enter Password">
                </div>
                <a href="#" class="forgot">Forgot Password?</a>
                <input type="submit" name="submit" value="Sign in">
                <span style="color: red;font-weight:bold;"><?php echo $error ?></span>
            </form>
            <a href="register.php" class="register">Register</a>

            <script>
                const previousPage = document.referrer;
                const backHomeButton = document.getElementById('back-home');

                if (previousPage && previousPage != window.location.href) {
                    backHomeButton.href = previousPage;
                } else {
                    backHomeButton.href = '/ISD_project_ongit/ISD_project/client_side/home.php';
                }
            </script>


            
        </div>
    </div>
</body>

</html>