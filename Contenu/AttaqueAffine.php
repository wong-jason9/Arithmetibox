<?php require('debut.php');?>

<form action="Arithmetibox.php?outil=affi" method="post">
	<p>
		Crypter : <input type="radio" name="msgcode" value="crypter"> 
		Decrypter : <input type="radio" name="msgcode" value="decrypter"></br>
		clée (optionnel pour décrypter) : <input type="text" name="clee"></br>
		Attaque par dictionnaire <input type='radio' name='opt_attaque' value='Avec_dico'>
		Attaque sans dictionnaire <input type='radio' name='opt_attaque' value='Sans_dico'></br>
		paquet de n : <input type="text" name="paquet"></br>
		alphabet : <input style="width:450px;" type="text" name="alphabet" value="ABCDEFGHIJKLMNOPQRSTUVWXYZ"></br>
		<!--ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz. 0123456789-->
		Message :</br>
		Format Code <input type='radio' name='methode' value='code'>
		Format Alphabet <input type='radio' name='methode' value='alphabet'></br>
		<textarea name='message'></textarea></br>
		<!--VALEUR DE TEST:
			02-01-11-23-03-->
		<!--28-27-37-49-29-->
		<!--cblxd-->
		<!--nsaiakpmoeecuocrrapo-->
		<!--NSAIA-->
		<!--CblxD-->
		<!--VOICI-->
		<!--21-00-02-00-13-02-04-18-->
		<!--687-1691-117-1369-->
		<input type="submit" class="boutton">
	</p>
</form>

<?php
function PGCD($a,$b){
	if($a==0) return $b;
	if($b==0) return $a;
	
	return(PGCD($b, $a%$b));
}

function inverseModulaire($a,$n){
	if(PGCD($a,$n)!=1) return 0;
	
	$A=array();
	$B=array();
	$Q=array();
	$R=array();
	
	$U=array();
	$V=array();
	
	$i=0;
	$A[$i]=$a;
	$B[$i]=$n;
	$Q[$i]=(int)($A[$i]/$B[$i]);
	$R[$i]=$A[$i]%$B[$i];
	
	while($R[$i]!=0){
		$i++;
		$A[$i] = $B[$i-1];
		$B[$i] = $R[$i-1];
		$Q[$i]=(int)($A[$i]/$B[$i]);
		$R[$i]=$A[$i]%$B[$i];
	}
	
	$U[$i]=0;
	$V[$i]=1;
	
	for($j=$i-1 ; $j>=0 ; $j--){
		$U[$j] = $V[$j+1];
		$V[$j] = -$Q[$j]*$U[$j]+$U[$j+1];
	}
	
   /*echo "\$\$";
    echo "\\begin{array}{c|c|c|c|c|c c}";
    echo "a&b&r&q&u&v\\\\\\hline";        
    for($i=0; $i<count($A); $i++){
		echo $A[$i].'&'.$B[$i].'&'.$R[$i].'&'.$Q[$i].'&'.$U[$i].'&'.$V[$i].'&'.'</br>';
		echo "\\\\";
	}
    echo"\\end{array}".'\\\\';
    echo "\$\$";*/

	$res = $U[0]%$n;
	if($res<0) return $res+$n;
	return $res;
}

function affGrille($cmpt, $AffL1, $AffL2, $AffL3, $AffL4, $AffL5, $AffL6){
	echo "\$\$";
    		echo "\\begin{array}";

			if($_POST['methode']=='alphabet'){
				for($i=-1; $i<$cmpt; $i++){
					echo $AffL1[$i];
					if(($i+1)!=$cmpt) echo '&';
				}
				echo "\\\\\\hline";
			} 
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
			echo "\\\\\\hline ";
			for($i=0; $i<count($AffL6); $i++) {
				if($_POST['paquet']==1 and $_POST['msgcode']=="crypter"){
					echo $AffL6[$i];
					if(($i+1)!=$cmpt) echo '&';
				}
				else{
					$j=0;
					while($j!=($_POST['paquet'])){ //A MODIFIER POUR D'AUTRE PAQUET
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

function calculeModulo($paquet, $nbcarac){
	$mod = 0;
	for($i=0 ; $i<$paquet ; $i++) //calculer le modulo en fonction du paquet
		$mod = 100*$mod + $nbcarac;
	$mod=$mod+1;
	return $mod;
}

if(isset($_POST['msgcode']) and isset($_POST['paquet']) and isset($_POST['alphabet']) and isset($_POST['methode']) and isset($_POST['message']) and trim($_POST['paquet'])!='' and trim($_POST['alphabet'])!='' and trim($_POST['message'])!=''){

	$mess = $_POST['message'];
	$paquet = $_POST['paquet'];
	$XYZ = $_POST['alphabet'];
	$nbcarac=strlen($_POST['alphabet'])-1;
	$AffL1=array(); //Pour stocker les lettres du message si ce n'est pas un code
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

        $i=$_POST['paquet']-1;
        $codeMessage=0;
        foreach($tab_message as $v){
        	$codeMessage+=$v*pow(10,(2*$i));
       		$i--;
       		if($i<0){
                $Amess[]=$codeMessage;
                $codeMessage=0;
                $i=$_POST['paquet']-1;
            }
        }
	}
	elseif($_POST['methode']=='code'){
		$Amess = explode('-', $mess); //enlever les tiret du message et stocker dans le TABLEAU Amess
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
			/*foreach($Amess as $key => $x){	//On parcour le message
				echo "clee=$key valeur=$x</br>";*/
				$AffL2[$cmpt]=$Amess[$j];
				

				if(((($j+1)%$paquet)==0) and $paquet!=1){
					if($Amess[$j]=='00') $y = (int)($Amess[$j-1]*$clefa.$Amess[$j]);
					else $y = (int)($Amess[$j-1]*$clefa.($Amess[$j]*$clefa));
				}
				else $y=(int)$Amess[$j]*$clefa;

				$AffL3[$cmpt]=$y;
				$y=$y+$clefb; //clee a * (valeur - clee b)
				$AffL4[$cmpt]=$y;
				$y=$y%$mod;
				$AffL5[$cmpt]=$y;

				if($y<0) //si modulo negatif on le met en positif
					$y=$y+$mod;
					
				$Y=array();
                for($i=0 ; $i<$paquet and $test==true; $i++){
                    $Y[$i] = $y%100;
                    $y=($y - $Y[$i])/100;

	                if($Y[$i]>$nbcarac and $paquet==1){
	                	echo $Y[$i]; //A SUPRIMMER
                    	$test=false;
                    	echo "clef incorrecte pour crypter";
                    	break;
                    }
                                
                }

                if($test==false) break;
                $Y=array_reverse($Y);
                foreach($Y as $c => $v){
                    $decrypt = $decrypt.$_POST['alphabet'][$Y[$c]];
                }

				$cmpt++;
			}//Fin for sur le Message
			$AffL6=str_split($decrypt);
			echo "\$\$ \\textrm{clee= ($clefa, $clefb)} \$\$";
			echo "\$\$ \\textrm{par paquet de $paquet} \$\$";
			

			if($paquet>1){
				echo "\$\$ \\textrm{";
				for($i=0; $i<$cmpt; $i++) {
					if((($i+1)%$paquet)==0) echo $AffL5[$i];
					if((($i+1)%$paquet)==0 and $i+1!=$cmpt) echo '-';
				}
				echo "}";
				echo "\$\$";
			}
			else
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
			foreach($Amess as $x){	//On parcour le message
				$AffL2[$cmpt]=$x;
				$y=(int)$x-$clefb;
				$AffL3[$cmpt]=$y;
				$y=$clefa1*$y; //clee a * (valeur - clee b)
				$AffL4[$cmpt]=$y;
				$y=$y%$mod;
				
				if($y<0) //si modulo negatif on le met en positif
					$y=$y+$mod;

				$AffL5[$cmpt]=$y;
					
				$Y=array();
                for($i=0 ; $i<$paquet and $test==true; $i++){
                    $Y[$i] = $y%100;
                    $y=($y - $Y[$i])/100;
                                
                    /*if($Y[$i]>$nbcarac) {
                        $test=false;
                        echo "clef incorrecte";
                        break;
                     }*/
                                
                }
                if($test==false) break;
                    $Y=array_reverse($Y);
                    foreach($Y as $c => $v){
                        $decrypt = $decrypt.$_POST['alphabet'][$Y[$c]];
                    }
				$cmpt++;
			}//Fin for sur le message		
			/*if($test==false) 
				continue;*/
			$AffL6=str_split($decrypt);

			echo "\$\$ \\textrm{clee= ($clefa, $clefb)} \$\$";
			echo "\$\$ \\textrm{par paquet de $paquet} \$\$";
			
    		affGrille($cmpt, $AffL1, $AffL2, $AffL3, $AffL4, $AffL5, $AffL6);
		}
	}

	if($_POST['msgcode']=='decrypter' and $_POST['clee']=='' and isset($_POST['opt_attaque']) and trim($_POST['opt_attaque'])!='')	//DECRYPTER SI PAS DE CLEE
	{
        $dico=[' le ','de ','des ',' que ',' elle ',' je ',' tu ',' il ',' un ',' ou ',' la ',' les ',' une ',' et ',' pour ',' par '];
		$mod = calculeModulo($paquet, $nbcarac);
		$maxoccurence=0;

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
					$y=$clefa1*((int)$x-$clefb); //clee a * (valeur - clee b)
					$y=$y%$mod;
					if($y<0) //si modulo negatif on le met en positif
						$y=$y+$mod;
					
					$Y=array();
					for($i=0 ; $i<$paquet and $test==true; $i++){
						$Y[$i] = $y%100;
						$y=($y - $Y[$i])/100;
						if($Y[$i]>$nbcarac) {
							$test=false;
							break;
						}
						
						$decrypt = $decrypt.$XYZ[$Y[$i]];
					}//Fin for sur les paquet
					if($test==false) 
						break;
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
	                    $occurence+=substr_count(strtolower($decrypt),$v);
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