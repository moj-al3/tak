<?php

use PHPMailer\PHPMailer\PHPMailer;

include '../PHPMailer/src/Exception.php';
include '../PHPMailer/src/PHPMailer.php';
include '../PHPMailer/src/SMTP.php';


function sendPasswordResetEmail($receiver, $token)
{
    $email_sender = 'YOUR_EMAIL';
    $email_password = 'YOUR_PASSWORD';
    $subject = 'Password Reset Request';

    $body = "
    Dear user,

    You have requested to reset your password. Please click the following link to reset your password:
    
    Reset Password: http://localhost/auth/reset-password.php?token=$token
    
    If you did not request this, please ignore this email.

    Regards,
    TARKEEN Team
    ";

    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 465;
    $mail->SMTPSecure = 'ssl';
    $mail->SMTPAuth = true;
    $mail->Username = $email_sender;
    $mail->Password = $email_password;
    $mail->setFrom($email_sender, 'TARKEEN Team');
    $mail->addAddress($receiver);
    $mail->Subject = $subject;
    $mail->Body = $body;

    if ($mail->send()) {
        return true;
    } else {
        die('Mailer Error: ' . $mail->ErrorInfo);
    }
}