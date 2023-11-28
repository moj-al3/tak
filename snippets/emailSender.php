<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include 'PHPMailer/src/Exception.php';
include 'PHPMailer/src/PHPMailer.php';
include 'PHPMailer/src/SMTP.php';

$EMAIL = 'ghadoorabbas1422@gmail.com';
$PASSWORD = "nzqb entp kyhn wvin";
$ADMIN_EMAIL = "mojtaba1430@gmail.com";

function sendEmail($receiver, $subject, $body)
{
    global $EMAIL;
    global $PASSWORD;

    $email_sender = $EMAIL;
    $email_password = $PASSWORD;

    $mail = new PHPMailer(true);

    try {
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

        $mail->send();
        return true;
    } catch (Exception $e) {
        die('Mailer Error: ' . $mail->ErrorInfo);
    }
}

function sendPasswordResetEmail($receiver, $token)
{
    $subject = 'Password Reset Request';
    $url = $_SERVER['HTTP_HOST'];

    $body = "
    Dear user,

    You have requested to reset your password. Please click the following link to reset your password:
    
    Reset Password: https://$url/auth/reset-password.php?token=$token
    
    If you did not request this, please ignore this email.

    Regards,
    TARKEEN Team
    ";

    return sendEmail($receiver, $subject, $body);
}

function sendTicketEmail($receiver, $ticket_id)
{
    $subject = 'Ticket Information';
    $url = $_SERVER['HTTP_HOST'];

    $body = "
    Dear user,

    Your ticket #$ticket_id has been created successfully. You can view the details by clicking the link below:
    
    Ticket Details: https://$url/reservations/show.php?reservation_id=$ticket_id
    
    If you have any questions or concerns, please contact our support team.

    Regards,
    TARKEEN Team
    ";

    return sendEmail($receiver, $subject, $body);
}


function sendContactUsEmail($name, $email, $message)
{
    global $ADMIN_EMAIL;

    $subject = 'Contact Us Form Submission';

    $body = "
    Dear Admin,

    You have received a new message from the contact us form:

    Name: $name
    Email: $email
    Message: $message

    Regards,
    TARKEEN Team
    ";

    return sendEmail($ADMIN_EMAIL, $subject, $body);
}