<?php
/******************SHOW ERROR MESSAGES************************/
$debug = true;

if ($debug) {

	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

}
/***********************************************************/

class Servicios
{

	public function getAllServicios()
	{

		$pdo = $this->db_connect();
		
		
		$sql = "SELECT * FROM servicios ORDER BY created_at DESC
		";

		$query = $pdo->prepare($sql);
		$query->execute();

		return $query->fetchAll();

	}



	public function saveServicios($data = array())
	{

		$nombres = $data['nombres'];
		$apellidos = $data['apellidos'];
		$email = $data['email'];
		$telefono = $data['telefono'];
		$mensaje = $data['mensaje'];
		

		$pdo = $this->db_connect();

		$sql = "INSERT INTO `servicios` (`nombres`, `apellidos`,`email`, `telefono`, `descripcion`) VALUES ('$nombres','$apellidos', '$email', '$telefono', '$mensaje')";
	
		$query = $pdo->prepare($sql);
		
		if ($query->execute()) {

			return true;
			
		} else {

			return false;
		}

	}

	//PDO Database Connection
	function db_connect() 
	{

        return new PDO(
            'mysql:host=us-cdbr-east-05.cleardb.net;dbname=heroku_ce5df5a1b6acb99', 
            'b4eb9c3f2e256a', 'eca42f8b', 
            array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, 
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
                )
            );
	
	}
}



$servicios = new Servicios();

if ($servicios->saveServicios($_REQUEST)) {
	//@sendMail($_REQUEST);
	echo "<script>alert('Mensaje Enviado Correctamente');window.location = 'index.php';</script>";

} else {
	echo "<script>alert('Error al tratar de enviar el mensaje.');window.location = 'index.php';</script>";
}


function sendMail($d) {

    require_once('class.phpmailer.php');
    require_once("class.smtp.php");

    $mail = new PHPMailer();

    //$body = eregi_replace("[\]",'',$body);

    $mail->IsSMTP(); // telling the class to use SMTP
    $mail->Host= "smtp.googlemail.com"; // SMTP server
    $mail->SMTPDebug  = 0;                     // enables SMTP debug information (for testing)
    // 1 = errors and messages
    // 2 = messages only
    $mail->SMTPAuth   = true;                  // enable SMTP authentication

    $mail->Port       = 465;                    // set the SMTP port for the GMAIL server
    $mail->Username   = ""; // SMTP account username
    $mail->Password   = "";        // SMTP account password
    
    
    $mail->Subject    = 'Solicitud de servicios';

    $message = $d["mensaje"] . "\n\n" . "Telefono: " . $d["telefono"];
   
    $mail->MsgHTML($message);
    $address = $d["email"];
    $mail->AddAddress($address, $d["nombres"] . " " . $d["apellidos"]);

    if(!$mail->Send()) {
        return false;
    } else {
        return true;
    }

}
