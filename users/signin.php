<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
    <link rel="stylesheet" href="style/singin.css">
</head>
<body>
    <div class="signin-container">
        <form class="signin-form">
            <h2>Sign In</h2>
            <div class="input-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required>
            </div>
            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required>
            </div>
            <button type="submit" class="signin-btn">Sign In</button>
            <div class="extra-links">
                <a href="#">Forgot Password?</a>
                <a href="#">Create an Account</a>
            </div>
        </form>
    </div>
</body>
</html>
