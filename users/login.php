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
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($email) || empty($password)) {
        $error = "Please fill all the fields.";
    } else {
        // Check if email matches the admin credentials
        if ($email === 'admin123@gmail.com' && $password === 'admin123') {
            // Set session variables for admin
            $_SESSION['loggedin'] = true;
            $_SESSION['name'] = 'admin123'; // Admin name can be a placeholder
            $_SESSION['email'] = $email;

            // Redirect to admin dashboard
            header("Location: ../admin/client_sec.php"); // Assuming your admin page is 'admin_dashboard.php'
            exit();
        }

        // First, check if the email exists in the guest table
        $stmt = $conn->prepare("SELECT * FROM guest WHERE Email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            // Verify hashed password for guest
            if (password_verify($password, $row['Password'])) {
                // Valid login, set session variables for guest
                $_SESSION['loggedin'] = true;
                $_SESSION['name'] = htmlspecialchars($row['Name'], ENT_QUOTES, 'UTF-8');
                $_SESSION['email'] = htmlspecialchars($row['Email'], ENT_QUOTES, 'UTF-8');
                $_SESSION['guest_id'] = htmlspecialchars($row['ID'], ENT_QUOTES, 'UTF-8');

                // Redirect to client home page
                header("Location: ../client_side/home.php");
                exit();
            } else {
                $error = "Invalid Email or Password.";
            }
        } else {
            // If email is not found in guest table, check the employee table
            $stmt = $conn->prepare("SELECT * FROM employees WHERE Email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($row = $result->fetch_assoc()) {
                // Verify hashed password for employee
                if (password_verify($password, $row['Password'])) {
                    // Valid login, set session variables for employee
                    $_SESSION['loggedin'] = true;
                    $_SESSION['employee_name'] = htmlspecialchars($row['Name'], ENT_QUOTES, 'UTF-8');
                    $_SESSION['employee_email'] = htmlspecialchars($row['Email'], ENT_QUOTES, 'UTF-8');
                    $_SESSION['employee_id'] = htmlspecialchars($row['ID'], ENT_QUOTES, 'UTF-8');

                    // Redirect to employee dashboard
                    header("Location: ../admin/employee_page.php"); // Assuming the employee dashboard is here
                    exit();
                } else {
                    $error = "Invalid Email or Password.";
                }
            } else {
                $error = "Invalid Email or Password.";
            }
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
