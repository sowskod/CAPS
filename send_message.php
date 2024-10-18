<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'C:\xampp\htdocs\idrop\PHPMailer\src\Exception.php';
require 'C:\xampp\htdocs\idrop\PHPMailer\src\PHPMailer.php';
require 'C:\xampp\htdocs\idrop\PHPMailer\src\SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];


    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo '<script>alert("Invalid email address. Please provide a valid email address.");</script>';
        exit;
    }


    $to = "jayrsantos114@gmail.com";

    $subject = "Message from $name";

    $body = "Name: $name\n";
    $body .= "Email: $email\n\n";
    $body .= "Message:\n$message";

    $mail = new PHPMailer(true);

    try {

        $mail->SMTPDebug = SMTP::DEBUG_OFF;
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'dontdropassist@gmail.com';
        $mail->Password   = 'zzqz kqfl ijry wjec';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = 465;


        $mail->setFrom('dontdropassist@gmail.com', 'Notification Service');
        $mail->addAddress($to);


        $mail->isHTML(false);
        $mail->Subject = $subject;
        $mail->Body    = $body;

        $mail->send();
        echo '<script>alert("Your message has been sent. We will get back to you soon."); window.location.href = "contact.html";</script>';
    } catch (Exception $e) {
        echo '<script>alert("There was an error sending your message: ' . $mail->ErrorInfo . '"); window.location.href = "contact..html";</script>';
    }
}
