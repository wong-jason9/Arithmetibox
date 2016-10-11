<?php require('debut.php'); ?>
<form action="Arithmetibox.php?outil=inverse_matrice_modulaire" method="POST">
<p>Saisir votre matrice :</p>
<textarea name='matrice' class="matrice"></textarea><br>
<input type='submit' value='Calculer'  class="boutton">
</form>

$$
\begin{array}{l | c | c |r}
\end{array}
$$
 
<?php
    function pgcd($a, $b) {
        while ($b!=0){
            $t=$a%$b;
            $a=$b;
            $b=$t;
        }
        return $a;
    }

   function inverseModulaire($a,$n,$m1,$m3,$m5,$m7){

	if(!(PGCD($a,$n)==1 || PGCD($a,$n)==-1)){
		echo "echo le pgcd n'est pas égal a 1";
		return 0;
	}
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
	$Q[$i]=(int)($A[$i]/$B[$i]);	//calcul du quotient
	$R[$i]=$A[$i]%$B[$i];			//calcul du reste

	while($R[$i]!=0){		//tant que le reste n'est pas égale a 0 on continue a calculer
		$i++;
		$A[$i] = $B[$i-1];
		$B[$i] = $R[$i-1];
		$Q[$i]=(int)($A[$i]/$B[$i]);
		$R[$i]=$A[$i]%$B[$i];
	}
	
	//on initialise les deux première valeur de u et v a 0 et 1
	$U[$i]=0;
	$V[$i]=1;

	for($j=$i-1 ; $j>=0 ; $j--){	//calcul de u et v
		$U[$j] = $V[$j+1];
		$V[$j] = -$Q[$j]*$U[$j]+$U[$j+1];
	}
	

	/*$res = $U[0]%$n;
	if($res<0) return $res+$n; //si u inférieur à 0 on retourne u+n
	*/

	for($i=0; $i<count($A); $i++){
		echo $A[$i].' '.$B[$i].' '.$Q[$i].' '.$R[$i].' '.$U[$i].' '.$V[$i].'</br>';
	}

	echo '</br>'.$A[0].'*'.$U[0].'+'.$B[0].'*'.$V[0].'= ';
	echo ($A[0]*$U[0])+($B[0]*$V[0]).'</br></br>';

	echo '&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp('.$m7.' '.-($m3).')'.'</br>';
	echo 'M-&sup1=26 '.$V[0].'('.-($m5).' '.$m1.')</br></br>';

	echo $V[0]*$m7.' '.$V[0]*(-$m3).'</br>';
	echo $V[0]*$m5.' '.$V[0]*(-$m1).'</br></br>';

	echo (($V[0]*$m7)%26).' '.(($V[0]*(-$m3))%26).'</br>';
	echo (($V[0]*$m5)%26).' '.(($V[0]*(-$m1))%26).'</br>';

	/*return $res;*/
}

    preg_match('#^([-]?[0-9]*)(\ )([-]?[0-9]*)(\ )([-]?[0-9]*)(\ )([-]?[0-9]*)#' , $_POST['matrice'], $res);
        /*echo $res[0]."<br/>"; //sa affiche la totaliter du resultat
        echo 'res 1: '.$res[1]."<br/>"; //sa afiche le premier rejex
        echo $res[2]."<br/>";
        echo 'res 3: '.$res[3]."<br/>";
        echo $res[4]."<br/>";
        echo 'res 5: '.$res[5]."<br/>";
        echo $res[6]."<br/>";
        echo 'res 7: '.$res[7]."<br/>";*/

        $nb= ($res[1]*$res[7]) - ($res[3]*$res[5]);
        echo 'dit(M)= '.$res[1].' * '.$res[7].' - '.$res[3].' * '.$res[5].'</br>';
        echo 'dit(M)= '.($res[1]*$res[7]).' - '.($res[3]*$res[5]).'</br>';
        echo 'dit(M)= '.$nb.'</br></br>';

       inverseModulaire(26, $nb, $res[1], $res[3], $res[5], $res[7]);
    ?>
</body>
</html>