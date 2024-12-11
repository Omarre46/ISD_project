<?php


require '../includes/connection.php';
 

$error="";
$username="";

if($_SERVER["REQUEST_METHOD"]=="POST"){
    $username=$_POST['username'];
    $pass=$_POST['password'];
    $found=false;

    if(empty($username)||empty($pass)){
        $error="Please fill all the fields";
    }

   

    else{

    $sql='select * from guest';
    $res=mysqli_query($conn,$sql);
     

 
    while ($row=mysqli_fetch_array($res)){
        

        if($username=='admin123' && $pass=='admin123'){
            $found=true;
            $_SESSION['loggedin']=true;
            $_SESSION['name']=$username;
            if($found){
            header("Location:../admin/client_sec.php");
        }
    }

        if($username==$row['Username'] && $pass==$row['Password']){
            $found=true;
            $_SESSION['loggedin']=true;
            $_SESSION['name']=$username;
            $_SESSION['email']=$row['Email'];
            

            if($found){
            header("Location:../client_side/home.php");
        }
        }


        
        else{
            if(!$found){
            $error="Invalid Name or Password";
        }
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
    <title>Document</title>
    <link rel="stylesheet" href="style/login.css">
</head>

<body>

    <div class="container">
        <div class="box">
            <a href="#" id="back-home" class="login"><img id="x_button" src="./img/x-solid.svg" alt=""></a>

            <h1>Sign in</h1>

            <form action="login.php" method="post" >
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