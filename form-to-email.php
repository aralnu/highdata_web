<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require "./PHPMAILER/src/PHPMailer.php";
require "./PHPMAILER/src/Exception.php";
require "./PHPMAILER/src/SMTP.php";

if(!isset($_POST['submit']))
{
	//This page should not be accessed directly. Need to submit the form.
	echo "<h1>error: you need to submit the form!</h1>";
} 


$name = $_POST['name'];
$visitor_email = $_POST['email'];
$phone = $_POST['phone'];
$message = $_POST['message'];
//Validate first
if(empty($name)||empty($visitor_email)||empty($phone)||empty($message)) 
{
    echo "No debes dejar ningún campo vacío!";
    exit;
}
if(IsInjected($visitor_email))
{
    echo "Valores corruptos!";
    exit;
}
//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings                    //Enable verbose debug output
    $mail->isSMTP();     
    $mail->CharSet = 'UTF-8';                                  //Send using SMTP
    $mail->Host       = 'smtppro.zoho.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'contacto@highdatamx.com';                     //SMTP username
    $mail->Password   = 'LgNSxUbkJjPR';                               //SMTP password
    $mail->SMTPSecure = 'ssl';            //Enable implicit TLS encryption
    $mail->Port       = '465';                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('contacto@highdatamx.com', 'HIGHDATA WEB FORM');
    $mail->addAddress("contacto@highdatamx.com");     //Add a recipient              //Name is optional

    //Content
    //$mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Nuevo contacto de la página';
    $mail->Body    = "Nuevo mensaje recibido del formulario de la pagina Web.<br><br>
    Nombre: $name<br>
    Telefono: $phone<br>
    Correo electronico: $visitor_email<br>
    Mensaje: <br><br> 
    $message<br>";
    $mail->AltBody = "Nuevo mensaje recibido del formulario de la pagina Web";
    
    
    
    if(!$mail->send()){
      header("Location:index.html#fail_popup");
      exit;
    }
    // Remove previous recipients
    $mail->ClearAllRecipients();
    $mail->addAddress("$visitor_email");
    $mail->Subject = 'Confirmación de mensaje';
    $mail->AltBody = "Nuevo mensaje de confirmación";
    $mail->msgHTML(file_get_contents('./emails/thanks.html'), __DIR__);
    $mail->AddEmbeddedImage('./src/img/logo.png', 'logo');
    $mail->AddEmbeddedImage('./src/img/facebook-white.png', 'facebook-img');
    $mail->AddEmbeddedImage('./src/img/instagram-white.png', 'instagram-img');
    if(!$mail->send()){
      header("Location:index.html#fail_popup");
      exit;
    }
    header("Location:index.html#thanks_popup");
    
} catch (Exception $e) {
    echo 'Error: ', $mail->ErrorInfo;
    header("Location:index.html#fail_popup");
}

// Function to validate against any email injection attempts
function IsInjected($str)
{
  $injections = array('(\n+)',
              '(\r+)',
              '(\t+)',
              '(%0A+)',
              '(%0D+)',
              '(%08+)',
              '(%09+)'
              );
  $inject = join('|', $injections);
  $inject = "/$inject/i";
  if(preg_match($inject,$str))
    {
    return true;
  }
  else
    {
    return false;
  }
}
?> 


