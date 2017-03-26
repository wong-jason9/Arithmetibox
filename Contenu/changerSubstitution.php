<?php

$req = $_POST['ok'];
$message = $_POST['message'];
$tab = $_POST['tab'];			//tableau de l'alphabet (fréquence d'apparition et alphabet normal)
$alphabet = $_POST['alphabet_freq'];

	function generate($factoriel, $k, $list_E, &$listResults){
		$rank = sizeof($list_E);

		// fin de recursion
		if($rank == 0){
			return $listResults;
		}

		// division euclidienne
		$quotient = intval($k/$factoriel[$rank-1]);
		$reste = $k % $factoriel[$rank-1];

		// retire un element "x" de l'ensemble E		
		$x = $list_E[$quotient];
		$list_buff = array();
		for($i=0; $i < $rank; $i++){
			if($x != $list_E[$i])
				array_push($list_buff, $list_E[$i]);
		}

		array_push($listResults, $x);

		// appel recursif sur l'ensemble E\{x}
		generate($factoriel, $reste, $list_buff, $listResults);
	}

		// l'ensemble de départ
		$list = str_split($alphabet);
		// n = longueur de l'ensemble
		$n = sizeof($list);
		// variable global: précalcul des factoriels
		$factoriel = array();
		// pré-calcul des factoriel de 0 à n
		$factoriel[0] = 1;
		for($i=1; $i<=$n; $i++){
			$factoriel[$i] = $i*$factoriel[$i-1];
		}

		//calcul factoriel
		$max = 1;
		$i = $n;
		do{
			$max = $max * $i;
			$i = $i - 1;
		}while($i > 1);

		$res_permutations = array();
		// genere toutes les permutations
		for($k=0; $k<$max; $k++){
			// copie de travail de la liste originale
			$original = $list;	//Pas sûr
			// initialise la liste qui contiendra le resultat
			$result = array();
			// construit la permutation #k;
			generate($factoriel, $k, $original, $result);

			if($max-1 == $k)
				$res_permutations = $result;
		}





$reponse = array(
				"message" => $message,
				"tab" => $tab,
				"test" => $res_permutations
				);

if($req){
	header('Content-type: application/json');
	echo json_encode($reponse);
}