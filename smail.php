<?php require 'include/init.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
//require_once('PHPMailer5.2/PHPMailerAutoload.php');

$email = '';
$subject = '';
$message = '';
$sent = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$email = $_POST['email'];
	$subject = $_POST['subject'];
	$message = $_POST['message'];

	$errors = [];

	if(filter_var($email, FILTER_VALIDATE_EMAIL) === false){
		$errors[] = 'Please enter a valid email address';
	}

	if ($subject == '') {
		$errors[] = 'Please enter subject';
	}

	if ($message == '') {
		$errors[] = 'Please enter a message';
	}

	if (empty($errors)) {

		$mail = new PHPMailer(true);
		try
		{
			$mail = new PHPMailer(); // create a new object
			$mail->IsSMTP(); // enable SMTP
			$mail->CharSet = 'UTF-8';
			$mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
			$mail->SMTPAuth = true; // authentication enabled
			$mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
			$mail->Host =  SMTP_HOST; //"smtp.gmail.com";
			$mail->Port = 465; // 465 or 587
			$mail->IsHTML(true);
			$mail->Username =  SMTP_USER; // "somporn5913unapasita@gmail.com";
			$mail->Password =  SMTP_PASS; //"FECC463811";
			$mail->SetFrom("somporn5913unapasita@gmail.com");
			$mail->Subject = $subject; //"testtest";
			$mail->Body = $message; //"test";
			$mail->AddAddress($email);  //  // SMTP_ADDRESS  // somporn5913unapasita@gmail.com
			//$mail->addReplyTo($email);  // // gamblings2019.sharenow@blogger.com



			$mail->send();

			$sent = true;
		}
		catch(Exception $e)
		{
			$errors[] = $mail->ErrorInfo;
		}

	}
}

?>


<?php require 'include/header.php'; ?>

<h2>Send</h2>

<?php if($sent) : ?>
    <p>Message sent.</p>
	<button class="btn btn-primary">New send.</button>
<?php else: ?>

    <?php if (!empty($errors)) : ?>
        <ul>
            <?php foreach ($errors as $error) : ?>
                <li><?= $error ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form method="post" id="formContact">

        <div class="form-group">
            <label for="email">Your email</label>
            <input class="form-control" name="email" id="email" type="email" placeholder="Your email" value="<?= htmlspecialchars($email) ?>">
        </div>

        <div class="form-group">
            <label for="subject">Subject</label>
            <input class="form-control" name="subject" id="subject" placeholder="Subject" value="<?= htmlspecialchars($subject) ?>">
        </div>

        <div class="form-group">
            <label for="message">Message</label>
            <textarea class="form-control" name="message" id="message" placeholder="Message"><?= htmlspecialchars($message) ?></textarea>
        </div>

        <button class="btn">Send</button>

    </form>

<?php endif; ?>


<?php require 'include/footer.php'; ?>
