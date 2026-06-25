<?php
require_once("class.phpmailer.php");


$to = "rizkylaleur1988@yahoo.com";
$from = "info@insw.go.id";
$from_name = "no reply";
$subject = "subject";
$body = "ini adalah bodynya";


//$mail = new phpmailer();


smtpmailer($to, $from, $from_name, $subject, $body);

function smtpmailer($to, $from, $from_name, $subject, $body) { 
	global $error;
	$mail = new PHPMailer();  // create a new object
	$mail->IsSMTP(); // enable SMTP
	$mail->SMTPDebug = 0;  // debugging: 1 = errors and messages, 2 = messages only
	$mail->SMTPAuth = false;  // authentication enabled
	//$mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
	$mail->Host = 'mail.insw.go.id';
	$mail->Port = 25; 
	//$mail->Username = "rizki";  
	//$mail->Password = GPWD;           
	$mail->AddBCC("rizki@edi-indonesia.co.id", "Mochamad Rizki");
	$mail->AddBCC("rizkylaleur1988@gmail.com", "Rizki");
	$mail->SetFrom($from, $from_name);
	$mail->Subject = $subject;
	$mail->Body = $body;
	$mail->AddAddress($to);
	if(!$mail->Send()) {
		$error = 'Mail error: '.$mail->ErrorInfo; echo $error;
		return false;
	} else {
		$error = 'Message sent!';echo $error;
		return true;
	}
}



?>