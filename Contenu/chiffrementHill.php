<<<<<<< HEAD
<?php require('debut.php'); ?>
<form action="Arithmetibox.php?outil=Ch_Hill" method = "post">
<p>Message à chiffrer : <input type="text" name="msgcode"/></p>
<p>Message à dechiffrer : <input type="text" name="msgdcode"/></p>
<p>Cle de chiffrement : <input type="text" name="clecode"/></p>
<p> <input type="submit" name="chiffrer"/></p>
</form>
=======
<script type="text/javascript" async
  src="https://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-MML-AM_CHTML">
</script>

>>>>>>> d2bb7022dbab5183b0d36f40faec1d29f250a0cf
<?php

function PGCD($a,$b){ //Fonction a remplacer par celle des autres !!

	if($a==0) return $b;
	if($b==0) return $a;
	
	return(PGCD($b, $a%$b));
}

function inverseModulaire($a,$n){ //Fonction a remplacer par celle des autres !!

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

function aton($a){ //Fonction qui transforme les lettres en chiffre
	if(strcmp($a,'A') == 0) return 0;
	if(strcmp($a,'B') == 0) return 1;
	if(strcmp($a,'C') == 0) return 2;
	if(strcmp($a,'D') == 0) return 3;
	if(strcmp($a,'E') == 0) return 4;
	if(strcmp($a,'F') == 0) return 5;
	if(strcmp($a,'G') == 0) return 6;
	if(strcmp($a,'H') == 0) return 7;
	if(strcmp($a,'I') == 0) return 8;
	if(strcmp($a,'J') == 0) return 9;
	if(strcmp($a,'K') == 0) return 10;
	if(strcmp($a,'L') == 0) return 11;
	if(strcmp($a,'M') == 0) return 12;
	if(strcmp($a,'N') == 0) return 13;
	if(strcmp($a,'O') == 0) return 14;
	if(strcmp($a,'P') == 0) return 15;
	if(strcmp($a,'Q') == 0) return 16;
	if(strcmp($a,'R') == 0) return 17;
	if(strcmp($a,'S') == 0) return 18;
	if(strcmp($a,'T') == 0) return 19;
	if(strcmp($a,'U') == 0) return 20;
	if(strcmp($a,'V') == 0) return 21;
	if(strcmp($a,'W') == 0) return 22;
	if(strcmp($a,'X') == 0) return 23;
	if(strcmp($a,'Y') == 0) return 24;
	if(strcmp($a,'Z') == 0) return 25;
}

function ntoa($a){ //Fonction qui transforme les chifres en lettre
	if($a == 0) return 'A';
	if($a == 1) return 'B';
	if($a == 2) return 'C';
	if($a == 3) return 'D';
	if($a == 4) return 'E';
	if($a == 5) return 'F';
	if($a == 6) return 'G';
	if($a == 7) return 'H';
	if($a == 8) return 'I';
	if($a == 9) return 'J';
	if($a == 10) return 'K';
	if($a == 11) return 'L';
	if($a == 12) return 'M';
	if($a == 13) return 'N';
	if($a == 14) return 'O';
	if($a == 15) return 'P';
	if($a == 16) return 'Q';
	if($a == 17) return 'R';
	if($a == 18) return 'S';
	if($a == 19) return 'T';
	if($a == 20) return 'U';
	if($a == 21) return 'V';
	if($a == 22) return 'W';
	if($a == 23) return 'X';
	if($a == 24) return 'Y';
	if($a == 25) return 'Z';	
}

?>

<?php

// Chiffrement De Hill
if(!empty($_POST)){
$ccod = $_POST['clecode'];
$Accod = explode(' ', $ccod);

$melema = $Accod[0]; //Matrice element a 
$melemb = $Accod[1]; //Matrice element b
$melemc = $Accod[2]; //Matrice element c
$melemd = $Accod[3]; //Matrice element d

$Gamma = (($melema*$melemd)-($melemc*$melemb)); //Calcul de det(A) avec Gamma

//verifier si cle valide XO
$mod=$Gamma%26; //Mod26
if ($mod<0) $mod=$mod+26;
$pgcd=PGCD(26,$mod); // Calcul du PGCD
$invmod = inverseModulaire($mod,26);
if($pgcd!=1)  echo 'cle non valide';

else {
	
	if(isset($_POST['msgcode'])and trim($_POST['msgcode'])!=''){ //Pour coder 
		$msgc = $_POST['msgcode'];
<<<<<<< HEAD
		$Amccod = str_split(strtoupper($msgc));
		$compt=count($Amccod);

		if ($compt%2!=0) {
			$Amcod[$compt+1]; 
			$Amcod=$Amccod;
			$Amcod[$compt+1]=0;
		}

		else $Amcod=$Amccod;

=======
		$Amcod = str_split(strtoupper($msgc));
		$compt=count($Amcod);		
>>>>>>> d2bb7022dbab5183b0d36f40faec1d29f250a0cf
		foreach($Amcod as $element){ //Afiche les lettres a chiffrer
			echo $element.'<br>';
		}
		echo '<br>';		
		
		for($i=0;$i<$compt;$i++){ //Convertie les lettres en chiffres et les affichent
			$Amcod[$i]=aton($Amcod[$i]);
			echo $Amcod[$i].'<br>';
		} 	
		echo '<br>';
		
		if ($compt%2==0){ //Crypte le msg
			for($i=0;$i<$compt;$i++){
				if($i%2==0){
					$val=$Amcod[$i];
					$Amcod[$i]=(($Amcod[$i]*$melema)+($Amcod[$i+1]*$melemb))%26;
					if($Amcod[$i]<0){
						$Amcod[$i]=$Amcod[$i]+26;
					}
				}
				else{
					$Amcod[$i]=(($val*$melemc)+($Amcod[$i]*$melemd))%26;
					if($Amcod[$i]<0){
						$Amcod[$i]=$Amcod[$i]+26;
					}
				}			
			}
		}
		echo '<br>';
		
		foreach($Amcod as $element){ //Affiche A.X
			echo $element.'<br>';
		}
		echo '<br>';		
		
		for($i=0;$i<$compt;$i++){ //Convertie les chiffres en lettres et les affichent
			$Amcod[$i]=ntoa($Amcod[$i]);
			echo $Amcod[$i].'<br>';
		}
		echo '<br>'; 		
	}

	if(isset($_POST['msgdcode'])and trim($_POST['msgdcode'])!=''){ //Pour decoder 
		
		
		$imelema = $invmod*$Accod[3]; //Matrice Inverse element a 
		$imelemb = $invmod*(-$Accod[1]); //Matrice Inverse element b
		$imelemc = $invmod*(-$Accod[2]); //Matrice Inverse element c
		$imelemd = $invmod*$Accod[0]; //Matrice Inverse element d
		$msgdc = $_POST['msgdcode'];
<<<<<<< HEAD
		$Amdccod = str_split(strtoupper($msgdc));
		$dcompt=count($Amdccod);

		if ($compt%2!=0) {
			$Amdcod[$compt+1]; 
			$Amdcod=$Amdccod;
			$Amdcod[$compt+1]=0;
		}

		else $Amdcod=$Amdccod;

=======
		$Amdcod = str_split(strtoupper($msgdc));
		$dcompt=count($Amdcod);
>>>>>>> d2bb7022dbab5183b0d36f40faec1d29f250a0cf
		echo '<br>';		
		
		foreach($Amdcod as $element){ //Afiche les lettres a chiffrer
			echo $element.'<br>';
		}
		echo '<br>';		
		
		for($i=0;$i<$dcompt;$i++){ //Convertie les lettres en chiffres et les affichent
			$Amdcod[$i]=aton($Amdcod[$i]);
			echo $Amdcod[$i].'<br>';
		} 	
		echo '<br>';
		
		if ($dcompt%2==0){ //Decrypte le msg
			for($i=0;$i<$dcompt;$i++){
				if($i%2==0){
					$val=$Amdcod[$i];
					$Amdcod[$i]=(($Amdcod[$i]*$imelema)+($Amdcod[$i+1]*$imelemb))%26;
					if($Amdcod[$i]<0){
						$Amdcod[$i]=$Amdcod[$i]+26;
					}
				}
				else{
					$Amdcod[$i]=(($val*$imelemc)+($Amdcod[$i]*$imelemd))%26;
					if($Amdcod[$i]<0){
						$Amdcod[$i]=$Amdcod[$i]+26;
					}
				}			
			}
		}
		echo '<br>';
		
		foreach($Amdcod as $element){ //Affiche A.X
			echo $element.'<br>';
		}
		echo '<br>';		
		
		for($i=0;$i<$dcompt;$i++){ //Convertie les chiffres en lettres et les affichent
			$Amdcod[$i]=ntoa($Amdcod[$i]);
			echo $Amdcod[$i].'<br>';
		}
		echo '<br>'; 		
	}

}


/*echo '\$\$	
\\LARGE cle = \\begin{pmatrix}'
.$melema.'\&'.$melemb.'<br>'.$melemc.'\&'.$melemd.'\end{pmatrix}<br>'
\LARGE det(A) = <?php echo ' ('.$melema.''?> \times <?php echo $melemd.') - ('.$melemc?> \times <?php echo $melemb.') = '.$Gamma ?>\\
\LARGE det(A) \equiv_{26} <?php echo $mod ?> \\
\LARGE PGCD(26,<?php echo $mod ?>)=<?php echo $pgcd ?>\\

\LARGE	A^{-1} \equiv_{26} \begin{pmatrix}
<?php echo $imelema%26 ?>&<?php echo $imelemb%26 ?> \\
<?php echo $imelemc%26 ?>&<?php echo $imelemd%26 ?>
\end{pmatrix} \\
\$\$'; */

echo "\$\$ \\LARGE det(A) \\equiv_{26} $mod <br>\$\$";
<<<<<<< HEAD
}
?>
=======




}



?>


<form action="Arithmetibox.php?outil=hill" method = "post">
<p>Message à chiffrer : <input type="text" name="msgcode"/></p>
<p>Message à dechiffrer : <input type="text" name="msgdcode"/></p>
<p>Cle de chiffrement : <input type="text" name="clecode"/></p>
<p> <input type="submit" name="chiffrer"/></p>
</form>


>>>>>>> d2bb7022dbab5183b0d36f40faec1d29f250a0cf
