<?php require('debut.php'); ?>
<h2 class="titreDansLaFonctions">RSA</h2>
<form action='Arithmetibox.php?outil=rsa' method='post'>
<label>Décryptage<input type='radio' name='fonction' value='decrypt'></label>
<label>Cryptage<input type='radio' name='fonction' value='crypt'></label></p>
Alphabet : <input size='50' name='alphabet' type='text' value='ABCDEFGHIJKLMNOPQRSTUVWXYZ'><br>
Clef: <input size='43' name='clef' type='text'><br>
<p>Message :<br>
</p>
<textarea name='message'></textarea><br>
<input type='submit' value='Déchiffrer'  class="boutton">
</form>

<?php
require('fonctions.php');

function size($var){
	$i=0;
	foreach($var as $v) $i++;
	return $i;
}
    

if(isset($_POST['alphabet']) and isset($_POST['message']) and isset($_POST['clef']) and $_POST['fonction']='decrypt'){ 
	$alphabet=str_split($_POST['alphabet']);
	$clef=explode(' ',$_POST['clef']);
	$mess=explode(' ',$_POST['message']);
    $mess=str_split($_POST['message']);
    // Tester la clef

    // Transformer mess grace a l'indice du tableaux et le reconvertir a la fin

    // Decomposition clef a
    $tabPremiers=era($clef[0]);
    $res=decomposition($clef[0]);
    $res[1]=gmp_div($clef[0],$res[0]);
    echo "le nombre ".$clef[0]." est compose de ".$res[0]." x ".$res[1]."<br/>";
    // calcul de phi
    $phi=($res[0]-1)*($res[1]-1);
    if(($res[0]-1)<($res[1]-1) && pgcd($phi,$clef[1]==1)) echo "Clef de cryptage valide";
    echo "phi=".$phi."</br>";
    echo "Le message crypter est : ";
    // Expo rapide + affichage
    echo "\$\$";
    echo "\\begin{array}{";
    for($compt=0;$compt<size($mess);$compt++) echo "|c";
    echo "}";
        for($j=0;$j<size($mess);$j++){
            echo $mess[$j].'&';
        for($k=0;$k<size($alphabet);$k++){
            if($mess[$j]==$alphabet[$k]){
                $messConv[$j]=$k;
                $valIndice[$j]=$k;
            }
        }
    }
    echo "\\\\\\hline";
    for($z=0;$z<size($valIndice);$z++){
        echo $valIndice[$z]."&";
    }
    echo "\\\\\\hline";
    for($i=0;$i<size($messConv);$i++){
        $resExpoRap[$i]=expoModRapide($messConv[$i],$clef[1],$clef[0]);
        echo $resExpoRap[$i]."&" ;
    }
    echo "\\\\";
    echo"\\end{array}".'\\\\';
    echo "\$\$";
   /*     for($j=0;$j<size($resExpoRap);$j++){
            for($k=0;$k<size($alphabet);$k++){
                if($resExpoRap[$j]==$k){
                    $messLettre[$j]=$alphabet[$k];
            }
        }
    }*/ // Fonctionne quand l'expo rapide retombe sur une lettre de l'alphabet
}
elseif(isset($_POST['alphabet']) and isset($_POST['message']) and isset($_POST['clef']) and $_POST['fonction']='crypt'){ // PB du reduire les conditons
        $alphabet=str_split($_POST['alphabet']);
    $clef=explode(' ',$_POST['clef']);
    $mess=explode(' ',$_POST['message']);
    $mess=str_split($_POST['message']);
    // Tester la clef

    // Transformer mess grace a l'indice du tableaux et le reconvertir a la fin
    for($j=0;$j<size($mess);$j++){
        for($k=0;$k<size($alphabet);$k++){
            if($mess[$j]==$alphabet[$k]){
                $messConv[$j]=$k;
            }
        }
    }
    // Decomposition clef a
    $tabPremiers=era($clef[0]);
    $res=decomposition($clef[0]);
    $res[1]=gmp_div($clef[0],$res[0]);
    echo "le nombre ".$clef[0]." est compose de ".$res[0]." x ".$res[1]."<br/>";
    // calcul de phi
    $phi=($res[0]-1)*($res[1]-1);
    // Calcul d'inverse pour clé privée
    $invClef=gmp_gcdext($phi,$clef[1]);
    var_dump($invClef);
    if(($res[0]-1)<($res[1]-1) && pgcd($phi,$clef[1]==1)) echo "Clef de cryptage valide";
    echo "phi=".$phi."</br>";
    echo "Le message decrypter est : </br>";
    // Expo rapide
    for($i=0;$i<size($messConv);$i++){
        $resExpoRap[$i]=expoModRapide($messConv[$i],$invClef[$v],$clef[0]);
        echo $resExpoRap[$i]." " ;
    }
}   

    ?>
</body>
</html>