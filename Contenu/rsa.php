<?php require('debut.php'); ?>
<h2 class="titreDansLaFonctions">RSA</h2>
<form action='Arithmetibox.php?outil=rsa' method='post'>
<label>Décryptage<input type='radio' name='fonction' value='decrypt' checked='checked'></label>
<label>Cryptage<input type='radio' name='fonction' value='crypt'></label></p>
Alphabet : <input size='50' name='alphabet' type='text' value='ABCDEFGHIJKLMNOPQRSTUVWXYZ'><br>
Clef : <input size='43' name='clef' type='text'><br>
<p>Message :<br>
</p>
<textarea name='message'></textarea><br>
<input type='submit' value='Déchiffrer'  class="boutton">
</form>

<?php
if(isset($_POST['alphabet']) and isset($_POST['message']) and isset($_POST['clef']) and $_POST['method']='crypt'){
	$alphabet=str_split($_POST['alphabet']);
	$clef=explode(' ',$_POST['clef']);
	$mess=explode(' ',$_POST['message']);
	$messCrypter=array();
	$i=0;
	/*$primaryclef=algo_de_facto($clef[0]);
	$phi=(primaryclef[0]-1)*(primaryclef[1]-1);
	if(pgcd($phi,$cmef[1])==1)echo "Clef valide";
	foreach($mess as $val){
		$messCrypter[$i]=resExpoRapide($val,$clef[1],clef[0]);
	}
	foreach($messCrypter as $val){
		echo $val;
	}
	elseif(isset($_POST['alphabet']) and isset($_POST['message']) and isset($_POST['clef']) and $_POST['method']='decrypt'){ 
		// en supposant que l'utilisateur connaisse la clé publique sinon utilisé la clé publique pour la retrouvé
		$alphabet=str_split($_POST['alphabet']);
		$clef=explode(' ',$_POST['clef']);
		$mess=explode(' ',$_POST['message']);
		$messDecrypter=array();
		$phi=(primaryclef[0]-1)*(primaryclef[1]-1);
		if(pgcd($phi,$cmef[1])==1)echo "Clef valide";
		foreach($mess as $val){
			$messDecrypter[$i]=resExpoRapide($val,$clef[1],clef[0]);
		}
		foreach($messDecrypter as $val){
		echo $val;
		}	
	}

	elseif(isset($_POST['alphabet']) and isset($_POST['message']) and isset($_POST['clef']) and $_POST['method']='decrypt'){ 
		//sinon utilisé la clé publique pour la retrouvé
		$alphabet=str_split($_POST['alphabet']);
		$clef=explode(' ',$_POST['clef']);
		$mess=explode(' ',$_POST['message']);
		$messDecrypter=array();
		$phi=(primaryclef[0]-1)*(primaryclef[1]-1);
		$resEuclEtendu=euclEtendu($phi,$clef[1]);
		echo "clé privée ("clef[0].",".$resEuclEtendu[v].")\n";
		if(pgcd($phi,$cmef[1])==1)echo "Clef valide";
		foreach($mess as $val){
			$messCrypter[$i]=resExpoRapide($val,$resEuclEtendu[v],clef[0]);
		}
		foreach($messDecrypter as $val){
		echo $val;
		}
	}

	*/
}
    ?>
</body>
</html>