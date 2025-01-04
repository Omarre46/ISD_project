<?php
require '../includes/connection.php';
session_start();

if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (htmlspecialchars(!isset($_POST['csrf_token'])) || htmlspecialchars($_POST['csrf_token']) !== htmlspecialchars($_SESSION['csrf_token'])) {
        die("Invalid CSRF token.");
    }
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($email) || empty($password)) {
        $error = "Please fill all the fields.";
    } else {
        try {
            if ($email === 'admin123@gmail.com' && $password === 'admin123') {
                $_SESSION['loggedin'] = true;
                $_SESSION['name'] = 'admin123';
                $_SESSION['email'] = $email;

                header("Location: ../admin/client_sec.php");
                exit();
            }

            $stmt = $pdo->prepare("SELECT * FROM guest WHERE Email = :email");
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();
            $guest = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($guest) {
                if (password_verify($password, $guest['Password'])) {
                    $_SESSION['loggedin'] = true;
                    $_SESSION['name'] = htmlspecialchars($guest['Name'], ENT_QUOTES, 'UTF-8');
                    $_SESSION['email'] = htmlspecialchars($guest['Email'], ENT_QUOTES, 'UTF-8');
                    $_SESSION['guest_id'] = htmlspecialchars($guest['ID'], ENT_QUOTES, 'UTF-8');

                    header("Location: ../client_side/home.php");
                    exit();
                } else {
                    $error = "Invalid Email or Password.";
                }
            } else {
                $stmt = $pdo->prepare("SELECT * FROM employees WHERE Email = :email");
                $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                $stmt->execute();
                $employee = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($employee) {
                    if (password_verify($password, $employee['Password'])) {
                        $_SESSION['loggedin'] = true;
                        $_SESSION['employee_name'] = htmlspecialchars($employee['Name'], ENT_QUOTES, 'UTF-8');
                        $_SESSION['employee_email'] = htmlspecialchars($employee['Email'], ENT_QUOTES, 'UTF-8');
                        $_SESSION['employee_id'] = htmlspecialchars($employee['ID'], ENT_QUOTES, 'UTF-8');

                        header("Location: ../admin/employee_page.php");
                        exit();
                    } else {
                        $error = "Invalid Email or Password.";
                    }
                } else {
                    $error = "Invalid Email or Password.";
                }
            }
        } catch (PDOException $e) {
            $error = "Database error: " . htmlspecialchars($e->getMessage());
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style/login.css">
</head>

<body>

    <div class="container">
        <div class="box">
            <a href="#" id="back-home" class="login"><img id="x_button" src="./img/x-solid.svg" alt=""></a>

            <h1>Sign in</h1>

            <form action="login.php" method="post">
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8'); ?>">

                <label>Email</label>
                <div>
                    <i class="fa-solid fa-user"></i>
                    <input id="email" type="email" name="email" placeholder="Enter Email" required>
                </div>

                <label>Password</label>
                <div>
                    <i class="fa-solid fa-lock"></i>
                    <input id="password" type="password" name="password" placeholder="Enter Password" required>
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
