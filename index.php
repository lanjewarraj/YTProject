<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

  <div class="container">
    <h3>Subscribe to our Newsletter</h3>
      <form action="index.php" method="POST">
        <input type="text" name="email" placeholder="Hi Subscribe here">
        <button type="submit" name="sbt">Subscribe</button>
      </form>
  </div>

  <?php  
  if(isset($_POST['sbt'])){
    $connection = mysqli_connect('localhost','root','','example');
    $email = $_POST['email'];
    $query = "INSERT INTO send_mail(email) VALUES('$email')";

    $run = mysqli_query($connection,$query);

    if($run){
      echo "success";
    }
    else{
      echo "erro".mysql_error($connection);
    }
  }
  
  ?>



<?php
require("phpmailer/PHPMailerAutoload.php");
require("phpmailer/PHPMailer.php");
require("phpmailer/SMTP.php");

require("credentials.php");

$mail=new PHPMailer(true);
	$mail->isSMTP();
	$mail->Host="smtp.gmail.com";
	$mail->Port=587;
	$mail->SMTPSecure="tls";
	$mail->SMTPAuth=true;
	$mail->Username=EMAIL;
	$mail->Password=PASSWORD;                              // SMTP password


//Recipients
$mail->setFrom(EMAIL, 'Mailer');

$connection = mysqli_connect('localhost','root','','example');
$q = "SELECT * FROM send_mail";
$r = mysqli_query($connection,$q);
if(mysqli_num_rows($r) > 0){
  while($row = mysqli_fetch_array($r)){
    $email = $row['email'];

    $mail->addBCC($email);     // Add a recipient

$mail->addReplyTo(EMAIL, 'Information');


// Attachments
//$mail->addAttachment('background.jpg');         // Add attachments


// Content
$mail->isHTML(true);                                  // Set email format to HTML
$mail->Subject = 'Here is the subject';
$mail->Body    = 'This is the HTML message body <b>in bold!</b>';
$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

if($mail->send()){
  echo "SENT";
}
else{
  echo "error";
}

}
}
?>
</body>
</html>