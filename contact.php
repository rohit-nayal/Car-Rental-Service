<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Contact Us - Car Rental Service</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="contact.css">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600;700&family=Roboto:wght@400;500&display=swap" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
  <div class="contact-bg-overlay"></div>
  <nav class="navbar">
    <img id="logo" src="logo.png" alt="logo" height="160">
    <ul class="nav-list">
      <li><a href="dashboard.php">Home</a></li>
      <li><a href="all cars.html">All Cars</a></li>
      <li><a href="about.html">About Us</a></li>
      <li><a href="contact.php" class="active">Contact</a></li>
    </ul>
  </nav>
  <main class="contact-content">
    <section class="contact-details">
      <h1>Contact Us</h1>
      <p>
        <b>Mobile:</b> <a href="tel:+917417608362">+91 7417608362</a><br>
        <b>Email:</b> <a href="mailto:thealphamotors12@gmail.com">thealphamotors12@gmail.com</a><br>
        <b>LinkedIn:</b> <a href="https://www.linkedin.com/in/rohit-nayal" target="_blank">linkedin.com/in/rohit-nayal</a>
      </p>
    </section>
    <section class="feedback-corner">
      <h2>Feedback Corner</h2>
      <form class="feedback-form" method="post" action="" autocomplete="off">
        <label for="name">Your Name</label>
        <input type="text" id="name" name="name" required placeholder="Enter your name">

        <label for="email">Your Email</label>
        <input type="email" id="email" name="email" required placeholder="Enter your email">

        <label for="message">Your Feedback</label>
        <textarea id="message" name="message" rows="5" required placeholder="Type your feedback"></textarea>

        <button type="submit" name="btn">Submit Feedback</button>
      </form>
    </section>
</main>
</body>
</html>
<?php 
include("connection.php");
if (isset( $_POST["btn"])){
  $name=$_POST['name'];
  $email=$_POST['email'];
  $message=$_POST['message'];
  $data = "INSERT INTO feeback VALUES('','$name','$email','$message')";
  $query = mysqli_query($conn, $data);
  if ($query){
          echo '<script>Swal.fire({
  title: "Feedback submitted!",
  icon: "success"
});</script>';
}
else{
    echo '<script>Swal.fire({
  title: "Alert!",
  icon: "error"
});</script>';

}
}
?>