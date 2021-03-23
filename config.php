<?php

/**
* Configuration Settings
**/

define('DB_HOST', 'localhost');
define('DB_NAME', 'zblog');
define('DB_USER', 'root');
define('DB_PASS', '');
// angachai4512bboonrod@gmail.com	1Rw0QboCWV
// karn06vsosaw4991@gmail.com	IRTG764307
define('SMTP_HOST', 'smtp.gmail.com');  // "mail.gmail.com"@S
define('SMTP_SECURE', 'tls'); // ssl tls

define('SMTP_USER', 'angachai4512bboonrod@gmail.com');
define('SMTP_SETFROM', 'angachai4512bboonrod@gmail.com');
define('SMTP_PASS', '1Rw0QboCWV');

define('SMTP_PORT', '857');  // 465; // 465 or 587
define('SMTP_EMAILADDRESS', "goodwide.thaimiz1111@blogger.com");  // gamblings2019.sharenow@blogger.com
define('SMTP_EMAILADDRESS2', "goodwide.truer1111@blogger.com");  // gamblings2019.sharenow@blogger.com
define('SMTP_EMAILADDRESS3', "goodwide.jooxpost@blogger.com"); 

define('SMTP_EMAILREPLYTO','goodwide@gmail.com');

//angachai4512bboonrod@gmail.com	1Rw0QboCWV
//goodwide.thaimiz1111@blogger.com

define('SHOW_ERROR_DETAIL', true);

date_default_timezone_set("Asia/Bangkok");
//define("PATH","/pbnblogger");
//define("WEB","/pbnblogger");
define("POSFIX","ThaiMix");



// $mail = new PHPMailer(); // create a new object
// $mail->IsSMTP(); // enable SMTP
// $mail->CharSet = 'UTF-8';
// $mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
// $mail->SMTPAuth = true; // authentication enabled
// $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
// //$mail->SMTPSecure = 'tls';
// //$mail->Host = "ssl://smtp.gmail.com"; 
// $mail->Host = "smtp.gmail.com";
// $mail->Port = 465; // 465 or 587
// $mail->IsHTML(true);
// $mail->Username = "somporn5913unapasita@gmail.com";
// $mail->Password = "FECC463811";
// $mail->SetFrom("somporn5913unapasita@gmail.com");
// $mail->Subject = "testtest";
// $mail->Body = "test";
// $mail->AddAddress("gamblings2019.sharenow@blogger.com");