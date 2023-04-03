<?php
require 'settings.class.php';


function sendMail($_REQUEST) {

    require_once('class.phpmailer.php');
    include("class.smtp.php");

    $mail = new PHPMailer();

    //$body = eregi_replace("[\]",'',$body);

    $mail->IsSMTP(); // telling the class to use SMTP
    $mail->Host       = "ssl://smtp.googlemail.com"; // SMTP server
    $mail->SMTPDebug  = 0;                     // enables SMTP debug information (for testing)
    // 1 = errors and messages
    // 2 = messages only
    $mail->SMTPAuth   = true;                  // enable SMTP authentication

    $mail->Port       = 465;                    // set the SMTP port for the GMAIL server
    $mail->Username   = "natiums83@gmail.com"; // SMTP account username
    $mail->Password   = "nsm6111840";        // SMTP account password
    
    
    $mail->Subject    = 'Solicitud de servicios';

    $message = $_REQUEST["mensaje"] . "\n\n" . "Telefono: " . $_REQUEST["telefono"];
   
    $mail->MsgHTML($message);
    $address = $_REQUEST["email"];
    $mail->AddAddress($address, $_REQUEST["nombres"] . " " . $_REQUEST["apellidos"]);

    if(!$mail->Send()) {
        return false;
    } else {
        return true;
    }

}


