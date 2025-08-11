<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Signup Page - Cars Theme</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="signup.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="signup-container">
        <form method="POST" action="" class="signup-form" autocomplete="off">
            <h2>Create Account</h2>
            <div class="input-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required placeholder="Enter your username">
            </div>
            <div class="input-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required placeholder="Enter your email">
            </div>
            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required placeholder="Enter your password">
            </div>
            <button type="submit" name="btn1">Sign Up</button>
            <p class="login-link">Already have an account? <a href="login.php">Login</a></p>
        </form>
    </div>
    
</body>
</html>
<?php 
error_reporting(0);
include("connection.php");

if(isset($_POST["btn1"])){
    $user = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Check if username or email already exists
    $checkQuery = "SELECT * FROM users WHERE username = '$user' OR email = '$email'";
    $checkResult = mysqli_query($conn, $checkQuery);

    if(mysqli_num_rows($checkResult) > 0){
        echo '<script>Swal.fire({
            title: "Username or Email already exists!",
            icon: "warning"
        });</script>';
    } else {
        // Insert new user
        $insertQuery = "INSERT INTO users VALUES('', '$user', '$email', '$password')";
        $query = mysqli_query($conn, $insertQuery);

        if($query){
            echo '<script>Swal.fire({
                title: "Signup successfully!",
                icon: "success"
            });</script>';
            echo '<meta http-equiv="refresh" content="2; url=http://localhost/My%20project/login.php">';
        } else {
            echo '<script>Swal.fire({
                title: "Something went wrong!",
                icon: "error"
            });</script>';
        }
    }
}
?>
