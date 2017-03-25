<?php

$req = $_POST['ok'];
$message = $_POST['message'];
$tab = $_POST['tab'];			//tableau de l'alphabet (fréquence d'apparition et alphabet normal)

$reponse = array(
				"message" => $message,
				"tab" => $tab);

if($req){
	header('Content-type: application/json');
	echo json_encode($reponse);
}