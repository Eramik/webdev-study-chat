<?php 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if($_POST["mode"] == "Get history"){
			echo file_get_contents("log.json");
		}
		else if($_POST["mode"] == "New message") {
			$log = json_decode(file_get_contents("log.json"), true);
			
			$log["msgs"][] = array("nick" =>  inputSequrity($_POST["name"]), "message" =>  inputSequrity($_POST["message"]) );
			file_put_contents("log.json", json_encode($log));
		}
}

function inputSequrity($data) {
			$data = trim($data);
			$data = stripslashes($data);
			$data = htmlspecialchars($data);
			return $data;
		}

?>