<?php require('debut.php'); ?>
<form action="Affine.php" method="post">
	<p>
	clée: <input type="text" name="clee"></br>
	paquet de n : <input type="text" name="paquet"></br>
	alphabet : <input type="text" name="alphabet" value="ABCDEFGHIJKLMNOPQRSTUVWXYZ"></br>
	Taper le message : <textarea name='message'></textarea>
	<input type="submit" value="Décrypter"></p>
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

$clee = $_POST['clee'];
$alphabet = $_POST['alphabet'];
$message = $_POST['message'];
$paquet = $_POST['paquet'];

echo 'clee: '.$_POST['clee'].'</br>';
echo 'alphabet: '.$_POST['alphabet'].'</br>';
echo 'message: '.$_POST['message'].'</br>';
echo 'paquet: '.$_POST['paquet'].'</br>';

if(isset($_POST['clee']) and isset($_POST['alphabet']) and isset($_POST['message']) and isset($_POST['paquet']) and trim($_POST['clee'])!='' and trim($_POST['alphabet'])!='' and trim($_POST['message'])!='' and trim($_POST['paquet'])!='')
{
	echo "saisie corecte</br>";
	if(preg_match('#^([-]?[0-9]*)(\ )([-]?[0-9]*)$#' , $_POST['clee'], $res))
	{
		echo "saisie clee corecte";
	}
	else
		echo "saisie de la clee incorect";
}
else
	echo "saisie incorect";

/*$Amess = explode('-', $mess);


$mod = 0;

for($i=0 ; $i<$paquet ; $i++) $mod = 100*$mod + 25;
$mod=$mod+1;
//$mod = 25252526 

echo "DECRYPTAGE AFFINE<br><hr>";

for($clefa=0 ; $clefa<$mod ; $clefa++){
	
	if(PGCD($clefa, $mod)!=1) //si PGCD n'est pas égale à 1
		continue;
	$clefa1 = inverseModulaire($clefa, $mod); 
	if($clefa1==0)  
		continue;
	
	for($clefb = 0 ; $clefb<$mod ; $clefb++){
		
		$test = true;
		$decrypt = "";
		
		//11h41
		foreach($Amess as $x){
			$y=$clefa1*((int)$x-$clefb);
			$y=$y%$mod;
			if($y<0) $y=$y+$mod;
			
			$Y=array();
			for($i=0 ; $i<$paquet and $test==true; $i++){
				$Y[$i] = $y%100;
				$y=($y - $Y[$i])/100;
				
				if($Y[$i]>25) {
					$test=false;
					break;
				}
				
				$decrypt = $decrypt.$alpahebet[$Y[$i]];
			}//Fin for sur les paquet
			if($test==false) break;
		}//Fin for sur le message
		
		
		if($test==false) continue;
		
		echo "<strong>a = ".$clefa."<br>a^(-1) = ".$clefa1."<br>b = ".$clefb."</strong><br><br>".$decrypt."<hr>";
	
	}//Fin for sur clefb

}//Fin for sur clefa*/
?>
</body>
</html>