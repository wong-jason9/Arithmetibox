<?php require('debut.php');
    require('fonctions.php');?>
<h2 class="titreDansLaFonctions">Inverse matrice modulaire</h2>
<form action="Arithmetibox.php?outil=inverse_matrice_modulaire" method="POST">
	<p>Saisir votre matrice: <textarea name='matrice' class="matrice"></textarea><br><br></p>
	<p>Sasir le modulo: <input type="text" name="modulo"></p>
	<input type='submit' value='Calculer' style="margin-top: -50px;"  class="boutton_matrice">
	<p>Pour saisir la matrice:<br> Veuillez saisir le premier nombre ensuite espace, saisir le deuxième nombre, saut de ligne (touche "Entrée"), saisir le troisième nombre, espace, saisir le quatrième nombre. <br>Exemple:<img class="exemple_saisie_matrice" src="Contenu/exemple_saisie.png" alt="exemple_de_saisie_de_matrice"/></p>
</form>
 
<?php
   function inverseModulaire($a,$n,$m1,$m3,$m5,$m7){

	 //On créer de tableau pour stocker A B R Q U V
	$A=array();
	$B=array();
	$Q=array();
	$R=array();
	$U=array();
	$V=array();
	
	$i=0;
	$A[$i]=$a;
	$B[$i]=$n;
    $Q[$i]=(int)(gmp_div_q($A[$i], $B[$i])); //calcul du quotient
    $R[$i]=gmp_mod($A[$i], $B[$i]);         //calcul du reste

	while($R[$i]!=0){		//tant que le reste n'est pas égale a 0 on continue a calculer
		$i++;
		$A[$i] = $B[$i-1];
		$B[$i] = $R[$i-1];
        $Q[$i]=(int)(gmp_div_q($A[$i], $B[$i]));
        $R[$i]=gmp_mod($A[$i], $B[$i]);
	}
	
	//on initialise les deux première valeur de u et v a 0 et 1
	$U[$i]=0;
	$V[$i]=1;

	for($j=$i-1 ; $j>=0 ; $j--){	//calcul de u et v
		$U[$j] = $V[$j+1];
		$V[$j] = gmp_add(gmp_mul(gmp_neg($Q[$j]), $U[$j]), $U[$j+1]); //équivaut à  -$Q[$j]*$U[$j]+$U[$j+1]
	}
	
    echo "\$\$";
    if(!(PGCD($a,$n)==1 || PGCD($a,$n)==-1)){
    	 echo "\\begin{array}{c|c|c|c c}";
   		 echo "a&b&r&q\\\\\\hline";
    	 for($i=0; $i<count($A); $i++){
			echo $A[$i].'&'.$B[$i].'&'.$R[$i].'&'.$Q[$i].'&'.'</br>';
			echo "\\\\";
		}
    }else{
    	echo "\\begin{array}{c|c|c|c|c|c c}";
   		echo "a&b&r&q&u&v\\\\\\hline";
	    for($i=0; $i<count($A); $i++){
			echo $A[$i].'&'.$B[$i].'&'.$R[$i].'&'.$Q[$i].'&'.$U[$i].'&'.$V[$i].'&'.'</br>';
			echo "\\\\";
		}
	}
    echo"\\end{array}".'\\\\';
    echo "\$\$";
	
    if(!(PGCD($a,$n)==1 || PGCD($a,$n)==-1)){
		echo "\$\$ \\textrm{Le pgcd n'est pas égale a 1}\$\$";
		return 0;
	}

	echo "\$\$";
	echo $A[0].'\times'.$U[0].'+'.$B[0].'\times'.$V[0].'= ';
	echo gmp_add(gmp_mul($A[0], $U[0]), gmp_mul($B[0], $V[0]));
	echo "\$\$";

	$m3 = gmp_neg($m3);
	$m5 = gmp_neg($m5);

	echo "\$\$";
	echo "M^{-1}\\equiv_{26}$V[0]\\times ";
	echo "\\begin{pmatrix}";
	echo $m7.'&'.$m3.'\\\\';
	echo $m5.'&'.$m1;
	echo "\\end{pmatrix}";
	echo "\$\$";

	echo "\$\$";
	echo "\\begin{pmatrix}";
	echo gmp_mul($V[0], $m7).'&'.gmp_mul($V[0], $m3).'\\\\';
	echo gmp_mul($V[0], $m5).'&'.gmp_mul($V[0], $m1);
	echo "\\end{pmatrix}";
	echo "\$\$";

	echo "\$\$";
	echo "\\begin{pmatrix}";
	echo gmp_mod((gmp_mul($V[0], $m7)), 26).'&'.gmp_mod(gmp_mul($V[0], $m3), 26).'\\\\';
	echo gmp_mod((gmp_mul($V[0], $m5)), 26).'&'.gmp_mod(gmp_mul($V[0], $m1), 26);
	echo "\\end{pmatrix}";
	echo "\$\$";
}
	
	if(isset($_POST['matrice']) and trim($_POST['matrice'])!='' and isset($_POST['modulo']) and trim($_POST['modulo'])!=''){
    	if(preg_match('#^([-]?[0-9]*)(\ )([-]?[0-9]*)(\s*)([-]?[0-9]*)(\ )([-]?[0-9]*)#' , $_POST['matrice'], $res)){
	        echo "\$\$";
	        echo "M= ";
			echo "\\begin{pmatrix}";
			echo $res[1].'&'.$res[3].'\\\\';
			echo $res[5].'&'.$res[7];
			echo "\\end{pmatrix}";
			echo "\$\$";

	        $nb= gmp_sub(gmp_mul($res[1], $res[7]), gmp_mul($res[3], $res[5]));
	        echo "\$\$";
	        echo 'det(M)= '.$res[1].' \times  '.$res[7].' - '.$res[3].' \times  '.$res[5].'\\\\';
	        echo 'det(M)= '.gmp_mul($res[1], $res[7]).' - '.gmp_mul($res[3], $res[5]).'\\\\';
	        echo 'det(M)= '.$nb;
	        echo "\$\$";

	       inverseModulaire($_POST['modulo'], $nb, $res[1], $res[3], $res[5], $res[7]);
   		}
   		else{
   			echo "Erreur de saisie";
   		}
    }
    ?>
</body>
</html>