<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

/* ---------------- CAR LIST ---------------- */
$carRates = [
  "swift" => ["name" => "Maruti Suzuki Swift", "rate" => 2500],
  "i20" => ["name" => "Hyundai i20", "rate" => 2200],
  "nexon" => ["name" => "Tata Nexon", "rate" => 3200],
  "xuv300" => ["name" => "Mahindra XUV300", "rate" => 3000],
  "city" => ["name" => "Honda City", "rate" => 3500],
  "innova" => ["name" => "Toyota Innova", "rate" => 4000],
  "seltos" => ["name" => "Kia Seltos", "rate" => 3700],
  "hector" => ["name" => "MG Hector", "rate" => 3800],
  "rapid" => ["name" => "Skoda Rapid", "rate" => 3400],
  "kwid" => ["name" => "Renault Kwid", "rate" => 2100],
  "gurkha" => ["name" => "Force Gurkha", "rate" => 4100],
  "compass" => ["name" => "Jeep Compass", "rate" => 3900]
];

$carKey = $_GET['car'] ?? 'swift';
$selectedCar = $carRates[$carKey] ?? $carRates['swift'];

/* ---------------- FORM SUBMIT ---------------- */
if ($_SERVER["REQUEST_METHOD"] === "POST") {

  $name = htmlspecialchars($_POST['user_name'] ?? '');
  $email = htmlspecialchars($_POST['user_email'] ?? '');
  $phone = htmlspecialchars($_POST['user_phone'] ?? '');
  $address = htmlspecialchars($_POST['user_address'] ?? '');
  $city = htmlspecialchars($_POST['user_city'] ?? '');
  $state = htmlspecialchars($_POST['user_state'] ?? '');
  $car = htmlspecialchars($_POST['car_name'] ?? '');
  $rate = isset($_POST['rate']) ? (int)$_POST['rate'] : 0;
  $hours = isset($_POST['hours']) ? (int)$_POST['hours'] : 0;
  $payment = htmlspecialchars($_POST['payment_method'] ?? '');

  $total_amount = $rate * $hours;

  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['status'] = 'invalid_email';
    header("Location: ".$_SERVER['PHP_SELF']."?car=".urlencode($carKey));
    exit();
  }

  $mail = new PHPMailer(true);

  try {
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'thealphamotors12@gmail.com';  // change this
    $mail->Password   = 'ymsdvmszwywyhjyz';     // change this
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    $mail->setFrom('thealphamotors12@gmail.com', 'Alpha Motors');
    $mail->addAddress($email);
    $mail->addCC('thealphamotors12@gmail.com');

    $mail->isHTML(true);
    $mail->Subject = 'Car Booking Confirmation - Alpha Motors';

    $mail->Body = "
      <h2 style='color:#0072ff;'>Booking Confirmed!</h2>
      <p><strong>Name:</strong> $name</p>
      <p><strong>Email:</strong> $email</p>
      <p><strong>Phone:</strong> $phone</p>
      <p><strong>Address:</strong> $address</p>
      <p><strong>City:</strong> $city</p>
      <p><strong>State:</strong> $state</p>
      <p><strong>Car:</strong> $car</p>
      <p><strong>Hours:</strong> $hours</p>
      <p><strong>Payment Method:</strong> $payment</p>
      <h3>Total Amount: ₹$total_amount</h3>
      <br>
      <p>Thank you for choosing <b>Alpha Motors</b> 🚗</p>
    ";

    $mail->send();
    $_SESSION['status'] = 'success';

  } catch (Exception $e) {
    $_SESSION['status'] = 'error';
    $_SESSION['error_message'] = $mail->ErrorInfo;
  }

  header("Location: ".$_SERVER['PHP_SELF']."?car=".urlencode($carKey));
  exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Book Car - <?php echo $selectedCar['name']; ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
body {
  background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)),
  url('https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?q=80&w=1283')
  no-repeat center center fixed;
  background-size: cover;
  font-family: Arial;
}

.booking-card {
  background: rgba(255,255,255,0.1);
  backdrop-filter: blur(15px);
  border-radius: 20px;
  padding: 40px;
  max-width: 750px;
  margin: 60px auto;
  box-shadow: 0 15px 40px rgba(0,0,0,0.6);
  color: white;
}

.total-box {
  background: linear-gradient(45deg,#00c6ff,#0072ff);
  padding: 15px;
  border-radius: 10px;
  text-align:center;
  font-size:20px;
  font-weight:bold;
  margin-bottom:20px;
}

.qr-code {
  max-width:200px;
  display:block;
  margin:15px auto;
}
</style>
</head>

<body>

<div class="booking-card">

<h2 class="text-center">🚗 Book Your Ride: <?php echo $selectedCar['name']; ?></h2>

<div class="text-center mb-3">
<span class="badge bg-warning text-dark px-3 py-2">
Rate: ₹<?php echo $selectedCar['rate']; ?> / Hour
</span>
</div>

<form method="POST">

<input type="hidden" name="car_name" value="<?php echo $selectedCar['name']; ?>">
<input type="hidden" id="rate" name="rate" value="<?php echo $selectedCar['rate']; ?>">

<input class="form-control mb-3" name="user_name" placeholder="Your Name" required>
<input class="form-control mb-3" type="email" name="user_email" placeholder="Email" required>
<input class="form-control mb-3" name="user_phone" placeholder="Phone" required>
<textarea class="form-control mb-3" name="user_address" placeholder="Address" required></textarea>
<input class="form-control mb-3" name="user_city" placeholder="City" required>
<input class="form-control mb-3" name="user_state" placeholder="State" required>
<input class="form-control mb-3" type="number" name="hours" id="hours" placeholder="Number of Hours" min="1" required>

<select class="form-select mb-3" name="payment_method" id="paymentSelect" required>
<option value="">Select Payment</option>
<option value="UPI">UPI</option>
<option value="Cash on Delivery">Cash on Delivery</option>
</select>

<div class="total-box" id="totalAmountBox">
Total Amount: ₹0
</div>

<div id="qrBox" style="display:none;">
<h5 class="text-center">Scan to Pay</h5>
<img src="QR.jpg" class="qr-code">
</div>

<button class="btn btn-primary w-100">Confirm Booking</button>

</form>
</div>

<script>
const hoursInput = document.getElementById("hours");
const rate = parseInt(document.getElementById("rate").value);
const totalBox = document.getElementById("totalAmountBox");
const paymentSelect = document.getElementById("paymentSelect");
const qrBox = document.getElementById("qrBox");

hoursInput.addEventListener("input", function(){
  const hours = parseInt(this.value);
  const total = isNaN(hours) ? 0 : hours * rate;
  totalBox.innerText = `Total Amount: ₹${total}`;
});

paymentSelect.addEventListener("change", function(){
  qrBox.style.display = this.value === "UPI" ? "block" : "none";
});
</script>

<?php if(isset($_SESSION['status'])): ?>
<script>
<?php if($_SESSION['status']=="success"): ?>
Swal.fire("Success!","Booking Confirmed 🚗","success");
<?php elseif($_SESSION['status']=="error"): ?>
Swal.fire("Error!","<?= addslashes($_SESSION['error_message']) ?>","error");
<?php elseif($_SESSION['status']=="invalid_email"): ?>
Swal.fire("Invalid Email!","Please enter valid email.","error");
<?php endif; ?>
</script>
<?php unset($_SESSION['status'], $_SESSION['error_message']); endif; ?>

</body>
</html>
