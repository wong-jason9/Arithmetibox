<?php
$message = $_POST['message'];
$tab = $_POST['tab'];			//tableau de l'alphabet (fréquence d'apparition et alphabet normal)
$alphabet = array_reverse($_POST['alphabet_freq']);
$repeter_n = $_POST['repeter_n'];

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
		$list = $alphabet;
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
		for($k=0; $k<$repeter_n; $k++){
			// copie de travail de la liste originale
			$original = $list;	//Pas sûr
			// initialise la liste qui contiendra le resultat
			$result = array();
			// construit la permutation #k;
			generate($factoriel, $k, $original, $result);

			$res_permutations = $result;
		}

		$res_permutations = array_reverse($res_permutations);


		$test1 = array();
		for($i=0; $i<3*26; $i++){
			$i = $i + 2;
			array_push($test1, $tab[$i]);
		}

		$aInverser = array();
		$aInverserAvec = array();
		for($i=0; $i<26; $i++){
			if($tab[$i*3+2] != $res_permutations[$i]){
				array_push($aInverser, $res_permutations[$i]);
				array_push($aInverserAvec, $tab[$i*3+2]);
			}
		}

		$message = str_split($message);
		$bool = false;
		for($i=0; $i<sizeof($message); $i++){	//parcoure chaque cractère du message
			for($j=0; $j<sizeof($aInverser); $j++){
				if($aInverser[$j] === $message[$i]){
					$message[$i] = strtoupper($aInverserAvec[$j]);
					$bool =true;
				}
				/*if('a' === $message[$i]){
					$message[$i] = 'e';
					$bool =true;
				}*/
			}
			//preg_replace($res_permutations, $test1, $message);
		}

		for($i=0; $i<sizeof($message); $i++)
			$message[$i] = strtolower($message[$i]);
		
		$message = implode($message);

		//$message = preg_replace($aInverser, $aInverserAvec, $message);




$reponse = array(
				"message" => $message,
				//"tab" => $tab,
				"bool" => $bool,							//Pour tester
				"test1" => $aInverser,						//Pour tester
				"alphabet_actuel" => $test1,				//Pour tester
				"test2" => $aInverserAvec,					//Pour tester
				"resultat_alphabet" => $res_permutations	
				);


header('Content-type: application/json');
echo json_encode($reponse);