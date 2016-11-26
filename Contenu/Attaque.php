<?php require('debut.php'); ?>

<h2 class="titreDansLaFonctions">Attaque</h2>
<form action='Arithmetibox.php?outil=attaque' method='post' enctype="multipart/form-data">
<input type="hidden" name="MAX_FILE_SIZE" value="1048576" />
<p><label>Cesar<input type='checkbox' name='fonction[]' value='cesa' checked='checked'></label>
<label>Affine<input type='checkbox' name='fonction[]' value='affi' checked='checked'></label>
<label>Hill<input type='checkbox' name='fonction[]' value='hill' checked='checked'></label></p>
Alphabet : <input size='50' name='alphabet' type='text' value='ABCDEFGHIJKLMNOPQRSTUVWXYZ'><br>
Paquet : <input size='50' name='paquet' type='text' ><br>
<p>Message :<br>
<label>Format Alphabet<input type='radio' name='methode' value='alpha' checked='checked'></label><label>Format Code<input type='radio' name='methode' value='code'></label></p>
<textarea name='message'></textarea><br>
Ou choisir un fichier contenant le message codé : <input type="file" name="messagecode"><br>
<input type='submit' value='Attaquer'  class="boutton">
</form>

<?php
    function RenvoyerMessage(){
		if(isset($_POST['alphabet']) and trim($_POST['alphabet'])!='' and isset($_POST['paquet']) and trim($_POST['paquet'])!='' and preg_match('#[0-9]*#',$_POST['paquet']) and isset($_POST['message']) and trim($_POST['message'])!='' and isset($_POST['methode'])){
            $Amess=array();
            $alphabet=str_split($_POST['alphabet']);
            if($_POST['methode']=='code'){
                if(preg_match('#([0-9]*)(\-|\,|\.)([0-9]*)#',$_POST['message'])){
                    preg_match('#([0-9]*)(\-|\,|\.)([0-9]*)#',$_POST['message'],$caract);
                    $Amess = explode($caract[2], $_POST['message']);
                }
            }
            elseif($_POST['methode']=='alpha'){
                $tab_message=str_split($_POST['message']);
                foreach($tab_message as $c => $v){
                    $tab_message[$c]=array_search($v,$alphabet);
                }
                $i=$_POST['paquet']-1;
                $codeMessage=0;
                foreach($tab_message as $v){
                    
                    $codeMessage=gmp_add($codeMessage,gmp_mul($v,pow(10,(2*$i))));
                    $i=$i-1;
                    if($i<0){
                        $Amess[]=$codeMessage;
                        $codeMessage=0;
                        $i=$_POST['paquet']-1;
                    }
                }
            }
		}
		return $Amess;
	}
    function cesar(){
		$extensions_valides = array('txt');
		$extension_upload = strtolower(  substr(  strrchr($_FILES['messagecode']['name'], '.')  ,1)  );
		if(isset($_FILES['messagecode'])){
			if ($_FILES['messagecode']['error'] > 0) echo "Erreur lors du transfert";
			elseif($_FILES['messagecode']['size'] > $_POST['MAX_FILE_SIZE']) echo "Le fichier est trop gros";
			elseif( !in_array($extension_upload,$extensions_valides)) echo "Extension incorrecte";
			else{
				$fichiercode=fopen($_FILES['messagecode']['tmp_name'],"r+");
				$messagefichier=fgets($fichiercode);
				$_POST['message']=$messagefichier;
			}
		}

        /*
		$dico=array();
		$monfichier=fopen("Contenu/Dictionnaire.txt","r+");
		while(FALSE !== ($ligne = fgets($monfichier)))
			$dico[]=trim($ligne);
		fclose($monfichier);
		*/
        $dico=['le','de','des','que','elle','je','tu','il','un','ou','la','les','une','et','pour','par'];
        if(isset($_POST['alphabet']) and trim($_POST['alphabet'])!='' and isset($_POST['paquet']) and trim($_POST['paquet'])!='' and preg_match('#[0-9]*#',$_POST['paquet']) and isset($_POST['message']) and trim($_POST['message'])!='' and isset($_POST['methode'])){
            $Amess=RenvoyerMessage();
			$maxoccurence=0;
          //  $text=array();
            $alphabet=str_split($_POST['alphabet']);
            $nbcarac=strlen($_POST['alphabet'])-1;
            $mod = 0;
            for($i=0 ; $i<$_POST['paquet'] ; $i++) $mod = gmp_add(gmp_mul(100,$mod),$nbcarac);
            $mod=gmp_add($mod,1);
            for($clef = 0 ; $clef<$mod ; $clef++){
                $test = true;
                $decrypt = "";
                foreach($Amess as $x){
                    $y=gmp_sub($x,$clef);
                    $y=gmp_mod($y,$mod);
                    if($y<0) $y=gmp_add($y,$mod);
                    
                    $Y=array();
                    for($i=0 ; $i<$_POST['paquet'] and $test==true; $i++){
                        $Y[$i] = gmp_mod($y,100);
                        $y=gmp_div(gmp_sub($y,$Y[$i]),100);
                        
                        if($Y[$i]>$nbcarac) {
                            $test=false;
                            break;
                        }
                    }
                    if($test==false) break;
                    $Y=array_reverse($Y);
                    foreach($Y as $c => $v){
                        $Y[$c]=gmp_intval($v);
                        $decrypt = $decrypt.$_POST['alphabet'][$Y[$c]];
                    }
                }
                if($test==false) continue;
                $occurence=0;
               // $text[$clef]=$decrypt;
                foreach($dico as $v){
                    $occurence=gmp_add($occurence,substr_count(strtolower($decrypt),$v));
                }
                if($occurence>$maxoccurence){
                    $clefpossible= $clef;
                    $decryptpossible=$decrypt;
                    $maxoccurence=$occurence;
                }
            }
            echo "<p class='message'><br>Message en César le plus probable est celui de la clé : $clefpossible <br> $decryptpossible</p>";
        }
    }
	
	/***********************************************
    *****************ATQ DE HILL********************
    ***********************************************/
	
	require('euclidehill.php');
function PGCD($a, $b)
{
   if ($a == 0)
      return $b;
   if ($b == 0)
      return $a;
   return (PGCD($b, $a % $b));
}
function inverseModulaire($a, $n)
{
   if (PGCD($a, $n) != 1)
      return 0;
   $A     = array();
   $B     = array();
   $Q     = array();
   $R     = array();
   $U     = array();
   $V     = array();
   $i     = 0;
   $A[$i] = $a;
   $B[$i] = $n;
   $Q[$i] = (int) ($A[$i] / $B[$i]);
   $R[$i] = $A[$i] % $B[$i];
   while ($R[$i] != 0) {
      $i++;
      $A[$i] = $B[$i - 1];
      $B[$i] = $R[$i - 1];
      $Q[$i] = (int) ($A[$i] / $B[$i]);
      $R[$i] = $A[$i] % $B[$i];
   }
   $U[$i] = 0;
   $V[$i] = 1;
   for ($j = $i - 1; $j >= 0; $j--) {
      $U[$j] = $V[$j + 1];
      $V[$j] = -$Q[$j] * $U[$j] + $U[$j + 1];
   }
   $res = $U[0] % $n;
   if ($res < 0)
      return $res + $n;
   return $res;
}

function ahill(){

$alphabet = str_split($_POST['alphabet']);
   $modulo   = count($alphabet); 
 
   for ($a = 0; $a <$modulo ; $a++) {
   	for ($b = 0; $b <$modulo ; $b++) {
    		for ($c = 0; $c <$modulo ; $c++) {
    			for ($d = 0; $d <$modulo ; $d++) {
				
				$melema   = $a; //Matrice element a 
      			$melemb   = $b; //Matrice element b
      			$melemc   = $c; //Matrice element c
      			$melemd   = $d; //Matrice element d
      
      			$Gamma    = (($melema * $melemd) - ($melemc * $melemb)); //Calcul de det(A) avec Gamma
      			//verifier si clé valide XO
      			$mod      = $Gamma % $modulo; //Mod en fonction de lalphabet
      
      			if ($mod < 0) $mod = $mod + $modulo;
      
      			$pgcd = PGCD($modulo, $mod); // Calcul du PGCD
				
				
				if ($pgcd == 1){ 
      			$invmod = inverseModulaire($mod, $modulo);				
				$imelema = ($invmod * $d) % $modulo; //Matrice Inverse element a 
				$imelemb = ($invmod * (-$b)) % $modulo; //Matrice Inverse element b
				$imelemc = ($invmod * (-$c)) % $modulo; //Matrice Inverse element c
				$imelemd = ($invmod * $a) % $modulo; //Matrice Inverse element d
				$msgdc   = $_POST['message'];
				$Amdccod = str_split($msgdc);
				$dcompt  = count($Amdccod);
            
				if ($dcompt % 2 != 0) {
					$Amdcod   = $Amdccod;
					$Amdcod[] = 'A';
					$dcompt++;
				} else
					$Amdcod = $Amdccod;
				
				foreach ($Amdcod as $cle => $v) {
					$Amdcod[$cle] = array_search($v, $alphabet);
				}
				$codeMessage = 0;
				foreach ($Amdcod as $v) {
					$codeMessage += $v;
				}
            
				if ($dcompt % 2 == 0) { //Decrypte le msg
					for ($i = 0; $i < $dcompt; $i++) {
						if ($i % 2 == 0) {
							$val        = $Amdcod[$i];
							$Amdcod[$i] = (($Amdcod[$i] * $imelema) + ($Amdcod[$i + 1] * $imelemb)) % $modulo;
							if ($Amdcod[$i] < 0) {
								$Amdcod[$i] = $Amdcod[$i] + $modulo;
							}
						} else {
							$Amdcod[$i] = (($val * $imelemc) + ($Amdcod[$i] * $imelemd)) % $modulo;
							if ($Amdcod[$i] < 0) {
								$Amdcod[$i] = $Amdcod[$i] + $modulo;
							}
						}
					}
				}	
            
				$decrypt         = "";
				foreach ($Amdcod as $val) {
					$decrypt = $decrypt . $alphabet[$val];
				}
				echo "Clef $a $b $c $d : $decrypt<br>";
				
				
				
         		
				
				} //Fin if pgcd==1
				
				} //Fin boucle for d
   			} //Fin boucle for c
   		} //Fin boucle for b		 
   	} //Fin boucle for a 

}
	
	
	
	/***********************************************
    *****************FIN DE HILL********************
    ***********************************************/
	
    if(isset($_POST['fonction'])){
        if(in_array('cesa',$_POST['fonction'])){
            cesar();
        }
		if(in_array('hill',$_POST['fonction'])){
            ahill();
        }
    }
    
    
    ?>
</body>
</html>

