 
<?php
session_start();
require "../includes/connection.php";
$error="";
$nerror="";
 
if($_SERVER["REQUEST_METHOD"]=="POST"){
     
    $name=$_POST['name'];
    $username=$_POST['username'];
    $email=$_POST['email'];
    $password=$_POST['password'];
    
    if (empty($name) || empty($username) || empty($email) || empty($password) ) {
        $error = "Please fill all the fields";
    } 
     
    else {

    $duplicateFound = false;

        $sqlQueries = [
            "SELECT Password FROM guest WHERE Password='$password' OR Username='$username'",
            "SELECT Email FROM guest WHERE Email='$email'"
        ];

        foreach ($sqlQueries as $sql) {
            $res = mysqli_query($conn, $sql);
            if (mysqli_num_rows($res) > 0) {
                $duplicateFound = true;
                break;
            }
        }

        if ($duplicateFound) {
            $error= "Username or Password or Email already exists ";
        }

    else{
        
        $_SESSION['loggedin']=true;
        $_SESSION['name']=$name;
        $_SESSION['email']=$email;
       
        $sql="insert into guest VALUES(NULL,'$name','$username','$email','$password')";
        $res=mysqli_query($conn,$sql);

        if($res){
            
             
            header("Location: ../client_side/home.php");
            exit();
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
    <title>Sign In</title>
    <link rel="stylesheet" href="style/register.css">
    <link rel="stylesheet" href="../includes/style/navbar.css">
    <link rel="stylesheet" href="../includes/style/footer.css">
</head>

<body>
    <div class="container">
        <div class="box">
            <a href="#" id="back-home" class="signin"><img id="x_button" src="./img/x-solid.svg" alt=""></a>

            <h1>Register</h1>
            <form action="register.php" method="post">
                <label>Full Name</label>
                <div>
                    <i class="fa-solid fa-user"></i>
                    <input type="text" name="name" placeholder="Enter Full Name">
                </div>

                <label>Username</label>
                <div>
                    <i class="fa-solid fa-user"></i>
                    <input type="text" name="username" placeholder="Enter Username">
                </div>

                <label>Email</label>
                <div>
                    <i class="fa-solid fa-user"></i>
                    <input id="email" type="text" name="email" placeholder="Enter Email">
                </div>

                <label>Password</label>
                <div>
                    <i class="fa-solid fa-lock"></i>
                    <input type="password" name="password" placeholder="Enter Password">
                </div>

                 
                <span><?php echo $error; ?></span>
                <a href="#"><input type="submit" name="submit" value="Register"></a>
              
            </form>
            <h6>Already have an account?</h6>
            <a href="login.php" class="signin">Sign in</a>


            <script>
                const previousPage = document.referrer;
                const backHomeButton = document.getElementById('back-home');

                if (previousPage && previousPage !== window.location.href) {
                    backHomeButton.href = previousPage;
                } else {
                    backHomeButton.href = '/ISD_project_ongit/ISD_project/client_side/home.php';
                }
            </script>

           
        </div>
    </div>
</body>

</html>