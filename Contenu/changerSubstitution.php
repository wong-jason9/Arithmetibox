<?php

$req = $_POST['ok'];
$message = $_POST['message'];
$tab = $_POST['tab'];			//tableau de l'alphabet (fréquence d'apparition et alphabet normal)

if($req){
	json_encode($message);
	echo 'test'.$message;
}