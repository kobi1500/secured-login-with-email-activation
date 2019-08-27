<?php

require_once "vendor/autoload.php";

use PHPMailer\PHPMailer\PHPMailer;

$mail = new PHPMailer();

$mail->isSMTP();
$mail->SMTPAuth = true;
$mail->Host = "smtp.gmail.com";
$mail->Port = "465";
$mail->SMTPSecure = "ssl";

$mail->Username = "";
$mail->Password = "";

$mail->setFrom("kobi6255@gmail.com");
$mail->addReplyTo("kobi6255@gmail.com");

// recipient

$mail->addAddress("");
$mail->isHTML();
$mail->Subject = "sending from localhost";
$mail->Body = "
        <div style='color:blue;font-size:20px;background-color:grey;'>
            Thank you buddy
        </div>
";

if ($mail->send()) {
    echo "Email sent";
} else {
    echo "Sorry something went wrong";
}
