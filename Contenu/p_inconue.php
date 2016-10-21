<?php
	echo "Ceci est un programme inconue</br>";
	$n=493;
	$M=1421;
	$mod=2581;
	$bin=decbin($n);
	echo "n=$n m=$M mod=$mod</br>";
	$taille_tab=strlen($bin);
	$TAB=array();
	for($i=0 ; $i<$taille_tab; $i++){
		if($i==0)
			$TAB[0]=$M%$mod;
		else
			$TAB[$i]=$TAB[$i-1]*$TAB[$i-1]%$mod;
	}
	var_dump($TAB);
	$res=1;
	for($i=0; $i<$taille_tab; $i++){
		if($bin[$taille_tab-$i-1]==1)
			$res=$res*$TAB[$i]%$mod;
	}
	echo $res;
?>