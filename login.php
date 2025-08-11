<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login Page - Cars Theme</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="signup.css"> <!-- Using same CSS as signup for consistent theme -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="signup-container">
        <form method="POST" action="#" class="signup-form" autocomplete="off">
            <h2> Login</h2>
            <div class="input-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required placeholder="Enter your username">
            </div>
            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required placeholder="Enter your password">
            </div>
            <button type="submit" name="btnLogin">Login</button>
            <p class="login-link">Don't have an account? <a href="signup.php">Sign Up</a></p>
        </form>
    </div>
</body>
</html>
<?php 
error_reporting(0);
include("connection.php");
session_start();

if(isset($_POST["btnLogin"])){
    $user = $_POST["username"];
    $password = $_POST["password"];

    // Prepare SQL to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM users WHERE username=? AND password=?");
    $stmt->bind_param("ss", $user, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows == 1){
        ?>
        <meta http-equiv="refresh" content="2; url=http://localhost/My%20project/dashboard.php">
        <?php
        // Assuming you want to store user info in session
        $_SESSION['username'] = $user;
         echo '<script>Swal.fire({
  title: "Login successfully!",
  icon: "success"
});</script>';
}
else{
    echo '<script>Swal.fire({
  title: "Wrong Credentials",
  icon: "error"
});</script>';

}
    }
    
?>