<?php
header('Content-Type: application/json');
ini_set('display_errors', 0); // Change to 1 for debugging only
error_reporting(0);           // Change to E_ALL for debugging only


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

$data = json_decode(file_get_contents("php://input"), true);

$mail = new PHPMailer(true);

try {
    // SMTP config
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'rohitnayal2005@gmail.com';
    $mail->Password   = 'gyyebetkoexmjfms';       // Admin
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    $mail->setFrom('rohitnayal2005@gmail.com', 'Car Rental');

    // Send to user
    $mail->addAddress($data['email'], $data['name']);   // App password from Google
    $mail->addCC('divyanshunegi1435@gmail.com', 'Admin');

    // Content
    $mail->isHTML(true);
    $mail->Subject = 'Your Car Booking Confirmation';
    $mail->Body    = "
      <h2>Booking Details</h2>
      <p><strong>Name:</strong> {$data['name']}</p>
      <p><strong>Phone:</strong> {$data['phone']}</p>
      <p><strong>Email:</strong> {$data['email']}</p>
      <p><strong>Car:</strong> {$data['car']}</p>
      <p><strong>Hours:</strong> {$data['hours']}</p>
      <p><strong>Payment Method:</strong> {$data['paymentMethod']}</p>
      <p><strong>Total Paid:</strong> ₹{$data['amount']}</p>
      <br><p>Thank you for booking with us!</p>
    ";

    $mail->send();

    echo json_encode(["success" => true]);
} catch (Exception $e) {
    echo json_encode(["success" => false, "message" => $mail->ErrorInfo]);
}
?>
