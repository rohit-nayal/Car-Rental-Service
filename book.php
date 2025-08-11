<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

// Car list (replace this with DB call if needed)
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

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $name = $_POST['user_name'];
  $email = $_POST['user_email'];
  $phone = $_POST['user_phone'];
  $address = $_POST['user_address'];
  $city = $_POST['user_city'];
  $state = $_POST['user_state'];
  $car = $_POST['car_name'];
  $rate = $_POST['rate'];
  $hours = $_POST['hours'];
  $payment = $_POST['payment_method'];
  $total_amount = $rate * $hours;

  $mail = new PHPMailer(true);

  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['status'] = 'invalid_email';
    header("Location: " . $_SERVER['PHP_SELF'] . "?car=" . urlencode($carKey));
    exit();
  }

  try {
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'thealphamotors12@gmail.com';
    $mail->Password   = 'gmdkudvmgkysbvdo'; // Use app-specific password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    $mail->setFrom('thealphamotors12@gmail.com', 'Alpha Motors');
    $mail->addAddress($email);
    $mail->addCC('thealphamotors12@gmail.com', 'Admin');

    $mail->isHTML(true);
    $mail->Subject = 'Car Booking Confirmation';
    $mail->Body = "
      <h3>Booking Confirmed!</h3>
      <p><strong>Name:</strong> $name</p>
      <p><strong>Email:</strong> $email</p>
      <p><strong>Phone:</strong> $phone</p>
      <p><strong>Address:</strong> $address</p>
      <p><strong>City:</strong> $city</p>
      <p><strong>State:</strong> $state</p>
      <p><strong>Car:</strong> $car</p>
      <p><strong>Hours:</strong> $hours</p>
      <p><strong>Payment Method:</strong> $payment</p>
      <p><strong>Total Amount:</strong> ₹$total_amount</p>
      <br><p>Thank you for booking with Alpha Motors!</p>
    ";

    $mail->send();
    $_SESSION['status'] = 'success';
  } catch (Exception $e) {
    $_SESSION['status'] = 'error';
    $_SESSION['error_message'] = $mail->ErrorInfo;
  }

  header("Location: " . $_SERVER['PHP_SELF'] . "?car=" . urlencode($carKey));
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Book Car - <?php echo $selectedCar['name']; ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    body {
      background: url('https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?q=80&w=1283') no-repeat center center fixed;
      background-size: cover;
      font-family: 'Segoe UI', sans-serif;
    }
    .booking-card {
      background-color: rgba(255, 255, 255, 0.95);
      border-radius: 15px;
      padding: 30px;
      max-width: 700px;
      margin: 80px auto;
      box-shadow: 0 0 25px rgba(0, 0, 0, 0.3);
    }
    .form-label { font-weight: 600; }
    .qr-code {
      max-width: 200px;
      display: block;
      margin: 15px auto;
    }
    .total-box {
      background-color: #f8f9fa;
      border: 2px dashed #6c757d;
      padding: 15px;
      text-align: center;
      font-size: 20px;
      font-weight: bold;
      border-radius: 10px;
      margin-bottom: 20px;
    }
    .btn-primary { width: 100%; }
  </style>
</head>
<body>

<div class="container">
  <div class="booking-card">
    <h2 class="text-center mb-4">Book: <?php echo $selectedCar['name']; ?></h2>

    <form method="POST">
      <input type="hidden" name="car_name" value="<?php echo $selectedCar['name']; ?>">
      <input type="hidden" id="rate" name="rate" value="<?php echo $selectedCar['rate']; ?>">

      <div class="mb-3">
        <label class="form-label">Your Name</label>
        <input type="text" class="form-control" name="user_name" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" class="form-control" name="user_email" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Phone Number</label>
        <input type="tel" class="form-control" name="user_phone" required maxlength="10">
      </div>

      <div class="mb-3">
        <label class="form-label">Address</label>
        <input type="text" class="form-control" name="user_address" required>
      </div>

      <div class="mb-3">
        <label class="form-label">City</label>
        <input type="text" class="form-control" name="user_city" required>
      </div>

      <div class="mb-3">
        <label class="form-label">State</label>
        <input type="text" class="form-control" name="user_state" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Number of Hours</label>
        <input type="number" class="form-control" name="hours" id="hours" min="1" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Payment Method</label>
        <select class="form-select" name="payment_method" id="paymentSelect" required>
          <option value="">-- Select Payment Method --</option>
          <option value="UPI">UPI</option>
          <option value="Cash on Delivery">Cash on Delivery</option>
        </select>
      </div>

      <div class="total-box" id="totalAmountBox">Total Amount: ₹0</div>

      <div id="qrBox" style="display: none;">
        <h5 class="text-center">Scan to Pay (UPI)</h5>
        <img src="QR.jpg" alt="QR Code" class="qr-code">
        <p class="text-center text-muted mb-4">Use any UPI app to pay the total amount</p>
      </div>

      <button type="submit" class="btn btn-primary">Submit Booking</button>
    </form>
  </div>
</div>

<!-- JavaScript Section -->
<script>
  const hoursInput = document.getElementById("hours");
  const rate = parseInt(document.getElementById("rate").value);
  const totalBox = document.getElementById("totalAmountBox");
  const paymentSelect = document.getElementById("paymentSelect");
  const qrBox = document.getElementById("qrBox");

  hoursInput.addEventListener("input", updateTotal);
  paymentSelect.addEventListener("change", function () {
    qrBox.style.display = this.value === "UPI" ? "block" : "none";
  });

  function updateTotal() {
    const hours = parseInt(hoursInput.value);
    const total = isNaN(hours) ? 0 : hours * rate;
    totalBox.innerText = `Total Amount: ₹${total}`;
  }

  // SweetAlert trigger from PHP session
  <?php if (isset($_SESSION['status'])): ?>
    <?php if ($_SESSION['status'] === 'success'): ?>
      Swal.fire({
        title: 'Booking Successful!',
        text: 'We\'ll contact you soon.',
        icon: 'success'
      });
    <?php elseif ($_SESSION['status'] === 'error'): ?>
      Swal.fire({
        title: 'Email Error!',
        text: '<?= addslashes($_SESSION['error_message']) ?>',
        icon: 'error'
      });
    <?php elseif ($_SESSION['status'] === 'invalid_email'): ?>
      Swal.fire({
        title: 'Invalid Email!',
        text: 'Please enter a valid email address.',
        icon: 'error'
      });
    <?php endif; ?>
    <?php unset($_SESSION['status'], $_SESSION['error_message']); ?>
  <?php endif; ?>
</script>
</body>
</html>
