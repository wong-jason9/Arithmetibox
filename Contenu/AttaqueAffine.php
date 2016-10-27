<?php require('debut.php');?>

<form action="Arithmetibox.php?outil=affi" method="post">
	<p>
		Crypter : <input type="radio" name="msgcode" value="crypter"/> 
		Decrypter : <input type="radio" name="msgcode" value="decrypter"/></br>
		clée (optionnel pour décrypter) : <input type="text" name="clee"></br>
		paquet de n : <input type="text" name="paquet"></br>
		alphabet : <input style="width:450px;" type="text" name="alphabet" value="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz. 0123456789"></br>
		Message :</br>
		Format Code <input type='radio' name='methode' value='code'>
		Format Alphabet <input type='radio' name='methode' value='alphabet'></br>
		<textarea name='message'></textarea></br>
		<!--02-01-11-23-03-->
		<!--28-27-37-49-29-->
		<!--cblxd-->
		<!--nsaiakpmoeecuocrrapo-->
		<!--CblxD-->
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
	
	$res = $U[0]%$n;
	if($res<0) return $res+$n;
	return $res;
}

if(isset($_POST['msgcode']) and isset($_POST['paquet']) and isset($_POST['alphabet']) and isset($_POST['methode']) and isset($_POST['message']) and trim($_POST['paquet'])!='' and trim($_POST['alphabet'])!='' and trim($_POST['message'])!=''){

	/*$mess = "7016634-23208201-3699473-3453232-20305608-9078134-17356537-3618266";*/
	/*$mess = "21-00-02-00-13-02-04-18";*/
	$mess = $_POST['message'];
	$paquet = $_POST['paquet'];
	$XYZ = $_POST['alphabet'];
	$nbcarac=strlen($_POST['alphabet']);

	if($_POST['alphabet']=="ABCDEFGHIJKLMNOPQRSTUVWXYZ")
		$nbcarac=$nbcarac-1;
	/*echo $XYZ.'</br>';
	echo $nbcarac;
	$test=explode('-',$XYZ);
	echo 'test:</br>';
	foreach ($test as $key => $value) {
		echo $key.'='.$value.'</br>';
	}
	$XYZ=$test;*/

	$AffL1=array(); //Pour stocker les lettres du message si ce n'est pas un code

	if($_POST['methode']=='alphabet'){
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

	if($_POST['msgcode']=='crypter' and isset($_POST['clee']) and trim($_POST['clee'])!=''){
		echo "je veut crypter le message";
	}

	if($_POST['msgcode']=='decrypter' and isset($_POST['clee']) and trim($_POST['clee'])!='')	//DECRYPTER SI CLEE EST PRESENTE
	{
		if(preg_match('#^([-]?[0-9]*)(\ )([-]?[0-9]*)$#' , $_POST['clee'], $res)){
			/*echo $res[0].'</br>';
			echo $res[1].'</br>';
			echo $res[2].'</br>';
			echo $res[3].'</br>';*/
			$clefa=$res[1];
			$clefb=$res[3];

			$mod = 0;
			for($i=0 ; $i<$paquet ; $i++) //calculer le modulo en fonction du paquet
				$mod = 100*$mod + $nbcarac;
			$mod=$mod+1;

			if(PGCD($clefa, $mod)!=1) //Si $clefa et $mod n'est pas une clee valide on passe
				echo "clee non valide";
			$clefa1 = inverseModulaire($clefa, $mod);
			if($clefa1==0)  //Si $clefa1 est égal à 0 on passe
				echo "clee non valide";
				
			$test = true;
			$decrypt = "";
				
			$AffL2=array();
			$AffL3=array();
			$AffL4=array();
			$AffL5=array();
			$AffL6=array();
	
			$cmpt = 0;
			foreach($Amess as $x){	//On parcour le message
				$AffL2[$cmpt]=$x;
				$y=(int)$x-$clefb;
				$AffL3[$cmpt]=$y;
				$y=$clefa1*$y; //clee a * (valeur - clee b)
				$AffL4[$cmpt]=$y;
				$y=$y%$mod;
				$AffL5[$cmpt]=$y;

				if($y<0) //si modulo negatif on le met en positif
					$y=$y+$mod;
					
				$Y=array();
                            for($i=0 ; $i<$paquet and $test==true; $i++){
                                $Y[$i] = $y%100;
                                $y=($y - $Y[$i])/100;
                                
                                if($Y[$i]>$nbcarac) {
                                    $test=false;
                                    echo "clef incorrecte";
                                    break;
                                }
                                
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
			
    		echo "\$\$";
    		echo "\\begin{array}";

			if($_POST['methode']=='alphabet'){
				for($i=-1; $i<$cmpt; $i++) {
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
			for($i=0; $i<$cmpt; $i++) {
				echo $AffL6[$i];
				if(($i+1)!=$cmpt) echo '&';
			}
			echo"\\end{array}".'\\\\';
			echo "\$\$";
		}
		else
		{
			echo "Saisie de la clee incorect";
			return 0;
		}
	}


	if($_POST['msgcode']=='decrypter' and $_POST['clee']=='')	//DECRYPTER SI PAS DE CLEE
	{
		$mod = 0;
		for($i=0 ; $i<$paquet ; $i++) //calculer le modulo en fonction du paquet (ex: paquet 1=26, paquet 2=2526)
			$mod = 100*$mod + $nbcarac;
		$mod=$mod+1;

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
				
				echo "<strong>a = ".$clefa."<br>a-&sup1 = ".$clefa1."<br>b = ".$clefb."</strong><br><br>";
				echo '<p>'.$decrypt.'</p>';
				echo "<hr>";
			
			}//Fin for sur clefb

			}//Fin for sur clefa
			/*$AffL2=array();
			$AffL3=array();
			$AffL4=array();
			$AffL5=array();
			$AffL6=array();
		$mod = 0;
		for($i=0 ; $i<$paquet ; $i++) //calculer le modulo en fonction du paquet (ex: paquet 1=26, paquet 2=2526)
			$mod = 100*$mod + $nbcarac;
		$mod=$mod+1;

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
					
if($clefa == 59 and $clefb == 53){

				$AffL2[]=$x;
				$y=(int)$x-$clefb;
				echo "clee b=".$clefb;
				$AffL3[]=$y;
				$y=$clefa1*$y; //clee a * (valeur - clee b)
				$AffL4[]=$y;
				$y=$y%$mod;
				$AffL5[]=$y;

				/*	$y=$clefa1*((int)$x-$clefb); //clee a * (valeur - clee b)
					$y=$y%$mod;*/
					/*if($y<0) //si modulo negatif on le met en positif
						$y=$y+$mod;
					
					$Y=array();
					for($i=0 ; $i<$paquet and $test==true; $i++){
						$Y[$i] = $y%100;
						$y=($y - $Y[$i])/100;

						if($Y[$i]>$nbcarac) {
							$test=false;
							break;
						}
						
						
					}//Fin for sur les paquet
                                if($test==false) break;
                                $Y=array_reverse($Y);
                                foreach($Y as $c => $v){
                                    $decrypt = $decrypt.$_POST['alphabet'][$Y[$c]];
                                }

				}//Fin for sur le message
				}
				
				if($test==false) 
					continue;

		if($clefa == 59 and $clefb == 53){	
echo "\$\$";
    		echo "\\begin{array}";

			
				foreach ($AffL1 as $key => $value) {
				echo $value;
				echo "\\\\\\hline";
			} 
			
				foreach ($AffL2 as $key => $value) {
				echo $value;
			}
			echo "\\\\\\hline"; 
				foreach ($AffL3 as $key => $value) {
				echo $value;
			}
			echo "\\\\\\hline";
				foreach ($AffL4 as $key => $value) {
				echo $value;
			}
			echo "\\\\\\hline";
				foreach ($AffL5 as $key => $value) {
				echo $value;
			}
			echo "\\\\\\hline ";
				foreach ($AffL6 as $key => $value) {
				echo $value;
			}
			echo"\\end{array}".'\\\\';
			echo "\$\$";
				echo "<strong>a = ".$clefa."<br>a-&sup1 = ".$clefa1."<br>b = ".$clefb."</strong><br><br>";
				echo '<p>'.$decrypt.'</p>';
				echo "<hr>";
			}
			}//Fin for sur clefb

			}//Fin for sur clefa*/
		}
	}
?>
</body>
</html>