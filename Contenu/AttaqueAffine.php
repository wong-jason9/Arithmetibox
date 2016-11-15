<?php require('debut.php');
    require('fonctions.php'); ?>
<h2 class="titreDansLaFonctions">Affine</h2>
<form action="Arithmetibox.php?outil=affi" method="post">
	<p>
		Décryptage : <input type="radio" name="msgcode" value="decrypter">
		Cryptage : <input type="radio" name="msgcode" value="crypter"></br></br>
		Alphabet : <input style="width:450px;" type="text" name="alphabet" value="ABCDEFGHIJKLMNOPQRSTUVWXYZ"></br>
		Paquet: <input type="text" name="paquet"></br>
		Clef (optionnel pour le decryptage) : <input type="text" name="clee"></br>
		Attaque par dictionnaire <input type='radio' name='opt_attaque' value='Avec_dico'>
		Attaque sans dictionnaire <input type='radio' name='opt_attaque' value='Sans_dico'></br>
		Message :</br>
		Format Code <input type='radio' name='methode' value='code'>
		Format Alphabet <input type='radio' name='methode' value='alphabet'></br>
		<textarea name='message'></textarea></br>
		<!--VALEUR DE TEST: -->
		<!--21-00-02-00-13-02-04-18-->
		<!--687-1691-117-1369-->
		<!-- 1620-803-12 -->
		<!-- 1956-1260-2046 -->
		<!--ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz. 0123456789-->
		<input type="submit" class="boutton">
	</p>
</form>

<?php
/*function PGCD($a,$b){
	if($a==0) return $b;
	if($b==0) return $a;
	
	return(PGCD($b, gmp_mod($a, $b)));
}*/
function affGrille($cmpt, $AffL1, $AffL2, $AffL3, $AffL4, $AffL5, $AffL6){
            echo "\$\$";
            echo "\\begin{array}";

            if($_POST['methode']=='alphabet'){
                if($_POST['paquet']==1){
                    echo $AffL1[1];
                    for($i=0; $i<$cmpt; $i++){
                        echo $AffL1[$i];
                        if(($i+1)!=$cmpt) echo '&';
                    }
                }else{
                    echo $AffL1[0];
                    for($i=0; $i<$cmpt*$_POST['paquet']; $i++){
                        $j=0;
                        while($j<$_POST['paquet']){ //A MODIFIER POUR D'AUTRE PAQUET (SUPERIEUR à 2)
                            echo $AffL1[$j+$i];
                            $j++;
                        }
                        $i=$i+$j-1;
                        echo '&';
                    }
                }
                echo "\\\\\\hline";
            }
            if($_POST['methode']!='alphabet') echo '.'; //Corige le beug d'affichage de du caractère au début qui ne s'affiche pas
            for($i=0; $i<$cmpt; $i++) {
                echo $AffL2[$i];
                if(($i+1)!=$cmpt) echo '&';
            }
            echo "\\\\\\hline"; 
            for($i=0; $i<$cmpt; $i++) {
                echo $AffL3[$i];
                if(($i+1)!=$cmpt) echo '&';
            }
            echo "\\\\\\hline";
            for($i=0; $i<$cmpt; $i++) {
                echo $AffL4[$i];
                if(($i+1)!=$cmpt) echo '&';
            }
            echo "\\\\\\hline";
            for($i=0; $i<$cmpt; $i++) {
                echo $AffL5[$i];
                if(($i+1)!=$cmpt) echo '&';
            }

            if($_POST['paquet']==1 or ($_POST['paquet']>1 and $_POST['msgcode']!="crypter")) //Test pour savoir si on inclue la ligne
                echo "\\\\\\hline ";
            for($i=0; $i<count($AffL6); $i++) {

                if($_POST['paquet']==1){
                    echo $AffL6[$i];
                    if(($i+1)!=$cmpt) echo '&';
                }
                elseif($_POST['paquet']>1 and $_POST['msgcode']!="crypter"){
                    $j=0;
                    while($j!=($_POST['paquet'])){ //A MODIFIER POUR D'AUTRE PAQUET (SUPERIEUR à 2)
                        echo $AffL6[$j+$i];
                        $j++;
                    }
                    $i=$i+$j-1;
                    echo '&';
                }
            }
            echo"\\end{array}".'\\\\';
            echo "\$\$";
    }

function inverseModulaire($a,$n){
	if(pgcd($a,$n)!=1) return 0;
	
	$A=array();
	$B=array();
	$Q=array();
	$R=array();
	
	$U=array();
	$V=array();
	
	$i=0;
	$A[$i]=$a;
	$B[$i]=$n;
    $Q[$i]=(int)(gmp_div_q($A[$i], $B[$i]));
    $R[$i]=gmp_mod($A[$i], $B[$i]);
	
	while($R[$i]!=0){
		$i++;
		$A[$i] = $B[$i-1];
		$B[$i] = $R[$i-1];
        $Q[$i]=(int)(gmp_div_q($A[$i], $B[$i]));
        $R[$i]=gmp_mod($A[$i], $B[$i]);
	}
	
	$U[$i]=0;
	$V[$i]=1;
	
	for($j=$i-1 ; $j>=0 ; $j--){
		$U[$j] = $V[$j+1];
		$V[$j] = gmp_add(gmp_mul(gmp_neg($Q[$j]), $U[$j]), $U[$j+1]);   //équivaut à  -$Q[$j]*$U[$j]+$U[$j+1]
	}
	
	$res = gmp_mod($U[0], $n);
	if($res<0) return gmp_add($res, $n);
	return $res;
}

function calculeModulo($paquet, $nbcarac){
	$mod = 0;
	for($i=0 ; $i<$paquet ; $i++) //calculer le modulo en fonction du paquet
		$mod = gmp_add(gmp_mul(100, $mod), $nbcarac);
	$mod=gmp_add($mod, 1);
	return $mod;
}

if(isset($_POST['msgcode']) and isset($_POST['paquet']) and isset($_POST['alphabet']) and isset($_POST['methode']) and isset($_POST['message']) and trim($_POST['paquet'])!='' and trim($_POST['alphabet'])!='' and trim($_POST['message'])!=''){

	$mess = $_POST['message'];
	$paquet = $_POST['paquet'];
	$XYZ = $_POST['alphabet'];
	$nbcarac=gmp_sub(strlen($_POST['alphabet']), 1);
	$AffL1=array(); //Pour stocker les valeurs et afficher le tableau après
	$AffL2=array();  
	$AffL3=array();
	$AffL4=array();
	$AffL5=array();
	$AffL6=array();


	if($_POST['methode']=='alphabet'){ //convertir alphabet au format code
		$alphabet=str_split($_POST['alphabet']);
        $tab_message=str_split($_POST['message']);

        $i=0;
		foreach ($tab_message as $key => $value){
			$AffL1[$i]=$value;
			$i++;
		}

        foreach($tab_message as $c => $v){
        	$tab_message[$c]=array_search($v,$alphabet);
        }
 		
 		$i=gmp_sub($_POST['paquet'],1);
        $codeMessage=0;
        foreach($tab_message as $v){	
	        $codeMessage=gmp_add($codeMessage,gmp_mul($v,pow(10,(2*$i))));
	        $i=gmp_sub($i,1);
	        if($i<0){
	            $Amess[]=$codeMessage;
	            $codeMessage=0;
	            $i=gmp_sub($_POST['paquet'],1);
	    	}
        }
	}
	elseif($_POST['methode']=='code'){
		//enlever les tiret du message et stocker dans le TABLEAU Amess
		$Amess = explode('-', $mess); 
		$mess = implode("−", $Amess);
		$Amess = explode('−', $mess);
	}

	if($_POST['msgcode']=='crypter' and isset($_POST['clee']) and trim($_POST['clee'])!=''){ //CRYPTER
		if(preg_match('#^([-]?[0-9]*)(\ )([-]?[0-9]*)$#' , $_POST['clee'], $res)){
			$clefa=$res[1];
			$clefb=$res[3];

			$mod = calculeModulo($paquet, $nbcarac);

			if(PGCD($clefa, $mod)!=1){ //Si $clefa et $mod n'est pas une clee valide on passe
				echo "clee ($clefa, $clefb) non valide (pgcd n'est pas égal à 1)";
				return 0;
			}
			$clefa1 = inverseModulaire($clefa, $mod);
			if($clefa1==0){  //Si $clefa1 est égal à 0 on passe
				echo "clee ($clefa, $clefb) non valide";
				return 0;
			}

			$test = true;
			$decrypt = "";
			$cmpt = 0;

			for($j=0; $j<count($Amess); $j++){
				$AffL2[$cmpt]=$Amess[$j];

				$y=(int)gmp_mul($Amess[$j], $clefa);
				$AffL3[$cmpt]=$y;
				$y=gmp_add($y, $clefb); //clee a * (valeur - clee b)
				$AffL4[$cmpt]=$y;
				$y=gmp_mod($y, $mod);
				$AffL5[$cmpt]=$y;

				if($y<0) //si modulo negatif on le met en positif
					$y=gmp_add($y, $mod);

				$AffL5[$cmpt]=$y;
					
				$Y=array();
                for($i=0 ; $i<$paquet and $test==true; $i++){
                    $Y[$i] = gmp_mod($y, 100);
                    $y=gmp_div_q(gmp_sub($y, $Y[$i]),100);

	                if($Y[$i]>$nbcarac and $paquet==1){
                    	$test=false;
                    	echo "clef incorrecte pour crypter";
                    	break;
                    }
                                
                }

                if($test==false) break;
                $Y=array_reverse($Y);

                if($paquet==1){	//Si paquet > 1 il ne faut pas traduire en lettre car sa ne veut rien dire
                	foreach($Y as $c => $v){
                		$Y[$c]=gmp_intval($v);
                   	 	$decrypt = $decrypt.$_POST['alphabet'][$Y[$c]];
                   	 }
             	}
				$cmpt++;
			}//Fin for sur le Message
			$AffL6=str_split($decrypt);

			echo "\$\$ \\textrm{clee= ($clefa, $clefb)} \$\$";
			echo "\$\$ \\textrm{par paquet de $paquet} \$\$";
			
			affGrille($cmpt, $AffL1, $AffL2, $AffL3, $AffL4, $AffL5, $AffL6);
		}
	}

	if($_POST['msgcode']=='decrypter' and isset($_POST['clee']) and trim($_POST['clee'])!='')	//DECRYPTER SI CLEE EST PRESENTE
	{
		if(preg_match('#^([-]?[0-9]*)(\ )([-]?[0-9]*)$#' , $_POST['clee'], $res)){
			$clefa=$res[1];
			$clefb=$res[3];

			$mod = calculeModulo($paquet, $nbcarac);

			if(PGCD($clefa, $mod)!=1){ //Si $clefa et $mod n'est pas une clee valide on passe
				echo "clee ($clefa, $clefb) non valide (pgcd n'est pas égal à 1)";
				return 0;
			}

			$clefa1 = inverseModulaire($clefa, $mod);
			if($clefa1==0){  //Si $clefa1 est égal à 0 on passe
				echo "clee ($clefa, $clefb) non valide";
				return 0;
			}

			$test = true;
			$decrypt = "";
			$cmpt = 0;
			$i=1;

			foreach($Amess as $x){	//On parcour le message
				$AffL2[$cmpt]=$x;
				$y=(int)gmp_sub($x, $clefb);
				$AffL3[$cmpt]=$y;
				$y=gmp_mul($clefa1, $y); //clee a * (valeur - clee b)
				$AffL4[$cmpt]=$y;
				$y=gmp_mod($y, $mod);
				
				if($y<0) //si modulo negatif on le met en positif
					$y=gmp_add($y, $mod);

				$AffL5[$cmpt]=$y;
					
				$Y=array();
                for($i=0 ; $i<$paquet and $test==true; $i++){
                    $Y[$i] = gmp_mod($y, 100);
                    $y= gmp_div_q(gmp_sub($y, $Y[$i]), 100);
                                
                    if($Y[$i]>$nbcarac) {
                        $test=false;
                        echo "clef incorrecte";
                        break;
                     }             
                }
                if($test==false) break;
                    $Y=array_reverse($Y);
                    foreach($Y as $c => $v){
                    	$Y[$c]=gmp_intval($v);
                        $decrypt = $decrypt.$_POST['alphabet'][$Y[$c]];
                    }
				$cmpt++;
			}//Fin for sur le message		
			if($test==false) 
				continue;
			$AffL6=str_split($decrypt);

			echo "\$\$ \\textrm{clee= ($clefa, $clefb)} \$\$";
			echo "\$\$ \\textrm{par paquet de $paquet} \$\$";

    		affGrille($cmpt, $AffL1, $AffL2, $AffL3, $AffL4, $AffL5, $AffL6);
		}
	}

	if($_POST['msgcode']=='decrypter' and $_POST['clee']=='' and isset($_POST['opt_attaque']) and trim($_POST['opt_attaque'])!='')	//DECRYPTER SI PAS DE CLEE
	{
        $dico=[' le ','de ','des ',' que ',' elle ',' je ',' tu ',' il ',' un ',' ou ',' la ',' les ',' une ',' et ',' pour ',' par ', 'VOICI', 'voici'];
		$mod = calculeModulo($paquet, $nbcarac);
		$maxoccurence=0;
		$clefpossiblea= null;
	    $clefpossiblea1= null;
	    $clefpossibleb= null;
	    $decryptpossible= null;
	    $maxoccurence= null;

		for($clefa=0 ; $clefa<$mod ; $clefa++){	//On cherche la clee a
			if(PGCD($clefa, $mod)!=1) //Si $clefa et $mod n'est pas une clee valide on passe
				continue;
			$clefa1 = inverseModulaire($clefa, $mod);
			if($clefa1==0)  //Si $clefa1 est égal à 0 on passe
				continue;
			
			for($clefb = 0 ; $clefb<$mod ; $clefb++){	//On cherche la clee b
				
				$test = true;
				$decrypt = "";
				
				foreach($Amess as $x){	//On parcour le message
					$y=gmp_mul($clefa1, (gmp_sub((int)$x, $clefb))); //clee a * (valeur - clee b)
					$y=gmp_mod($y, $mod);
					if($y<0) //si modulo negatif on le met en positif
						$y=gmp_add($y, $mod);
					
					$Y=array();
					for($i=0 ; $i<$paquet and $test==true; $i++){
						$Y[$i] = gmp_mod($y, 100);
						$y=gmp_div_q(gmp_sub($y, $Y[$i]), 100);
						if($Y[$i]>$nbcarac) {
							$test=false;
							break;
						}
					}//Fin for sur les paquet
					if($test==false) 
						break;
					$Y=array_reverse($Y);
                    foreach($Y as $c => $v){
                    	$Y[$c]=gmp_intval($v);
                        $decrypt = $decrypt.$_POST['alphabet'][$Y[$c]];
                    }
				}//Fin for sur le message
				if($test==false) 
					continue;
				
				if($_POST['opt_attaque']=='Sans_dico'){
					echo "<strong>a = ".$clefa."<br>a-&sup1 = ".$clefa1."<br>b = ".$clefb."</strong></br>";
					echo '<p class=\'message\'>'.$decrypt.'</p></br>';
					echo "<hr>";
				}
				else{
					$occurence=0;
	                /*$text[$clef]=$decrypt;*/
	                foreach($dico as $v){
	                	 $occurence=gmp_add($occurence,substr_count(strtolower($decrypt),$v));
	                }
	                if($occurence>$maxoccurence){
	                    $clefpossiblea= $clefa;
	                    $clefpossiblea1= $clefa1;
	                    $clefpossibleb= $clefb;
	                    $decryptpossible= $decrypt;
	                    $maxoccurence= $occurence;
	                }
	            }
			}//Fin for sur clefb

			}//Fin for sur clefa
			if($_POST['opt_attaque']=='Avec_dico'){
				echo "<p class='message' ><br>Message le plus probable est celui de la clé :<br> <strong>a =$clefpossiblea <br> a-&sup1 =$clefpossiblea1 <br> b =$clefpossibleb <br></strong><br> $decryptpossible</p>";
			}
            /*foreach($text as $cl => $te){
                echo "<p>".$cl." : <br>".$te."<br></p>";
            }*/
		}//FIN DU IF POUR DECRYPTER SI PAS DE CLEE
	}
?>
</body>
</html>