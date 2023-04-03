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

		return $query->fetchAll(PDO::FETCH_ASSOC);

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

header("Content-Type: application/json");

echo json_encode($servicios->getAllServicios());