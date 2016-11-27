<?php require('debut.php');
require('fonctions.php'); ?>

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

    function cesar(){
		if(isset($_FILES['messagecode']) and trim($_FILES['messagecode']['tmp_name'])!='')
			MessageDansFichier();
        if(isset($_POST['alphabet']) and trim($_POST['alphabet'])!='' and isset($_POST['paquet']) and trim($_POST['paquet'])!='' and preg_match('#[0-9]*#',$_POST['paquet']) and isset($_POST['message']) and trim($_POST['message'])!='' and isset($_POST['methode'])){
            $Amess=RenvoyerMessage();
			$dico=Dictionnaire();
			$maxoccurence=0;
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
    ********************AFFINE**********************
    ***********************************************/
    function calculeModulo($paquet, $nbcarac){
        $mod = 0;
        for($i=0 ; $i<$paquet ; $i++) //calculer le modulo en fonction du paquet
            $mod = gmp_add(gmp_mul(100, $mod), $nbcarac);
        $mod=gmp_add($mod, 1);
        return $mod;
    }

    function inverseModulaire($a,$n){
        if(pgcd($a,$n)!=1) return 0;
        
        $A=array();
        $B=array();
        $Q=array();
        $R=array();
        
        $U=array();
        $V=array();
        
        $i=0;
        $A[$i]=$a;
        $B[$i]=$n;
        $Q[$i]=(int)(gmp_div_q($A[$i], $B[$i]));
        $R[$i]=gmp_mod($A[$i], $B[$i]);
        
        while($R[$i]!=0){
            $i++;
            $A[$i] = $B[$i-1];
            $B[$i] = $R[$i-1];
            $Q[$i]=(int)(gmp_div_q($A[$i], $B[$i]));
            $R[$i]=gmp_mod($A[$i], $B[$i]);
        }
        
        $U[$i]=0;
        $V[$i]=1;
        
        for($j=$i-1 ; $j>=0 ; $j--){
            $U[$j] = $V[$j+1];
            $V[$j] = gmp_add(gmp_mul(gmp_neg($Q[$j]), $U[$j]), $U[$j+1]);   //équivaut à  -$Q[$j]*$U[$j]+$U[$j+1]
        }
        
        $res = gmp_mod($U[0], $n);
        if($res<0) return gmp_add($res, $n);
        return $res;
    }


    function affine(){
        if(isset($_POST['alphabet']) and trim($_POST['alphabet'])!='' and isset($_POST['paquet']) and trim($_POST['paquet'])!='' and isset($_POST['message']) and trim($_POST['message'])!='' and isset($_POST['methode'])){
          
          if(preg_match('#^([0-9]*)$#', $_POST['paquet'])){
              $mess = $_POST['message'];
              $paquet = $_POST['paquet'];
              $XYZ = $_POST['alphabet'];
              $nbcarac=gmp_sub(strlen($_POST['alphabet']), 1);
              $AffL1=array(); //Pour stocker les valeurs et afficher le tableau après
              $AffL2=array();  
              $AffL3=array();
              $AffL4=array();
              $AffL5=array();
              $AffL6=array();

              if($_POST['methode']=='alpha'){ //convertir alphabet au format code
                  $alphabet=str_split($_POST['alphabet']);  //convertir string en tableau
                  $tab_message=str_split($_POST['message']);

                  //Test si le message est contituer uniquement de caractère saisie dans l'alphabet
                foreach ($tab_message as $v) {
                  $test = false;
                  foreach($alphabet as $alphab){
                    if($v == $alphab)
                      $test = true;
                  }
                  if($test == false){
                    echo "Erreur: Le message saisie contient des caractères non présent dans l'alphabet saisie";
                    return 0;
                  }
                  $test = true;
                }

                  $i=0;
                  foreach ($tab_message as $key => $value){
                      $AffL1[$i]=$value;
                      $i++;
                  }

                  foreach($tab_message as $c => $v){
                      $tab_message[$c]=array_search($v,$alphabet);
                  }
                  
                  $i=gmp_sub($_POST['paquet'],1);
                  $codeMessage=0;
                  foreach($tab_message as $v){    
                      $codeMessage=gmp_add($codeMessage,gmp_mul($v,pow(10,(2*$i))));
                      $i=gmp_sub($i,1);
                      if($i<0){
                          $Amess[]=$codeMessage;
                          $codeMessage=0;
                          $i=gmp_sub($_POST['paquet'],1);
                      }
                  }
              }//FIN DU IF SI methode = alpha
              elseif($_POST['methode']=='code'){
                //enlever les tiret du message et stocker dans le TABLEAU Amess
                  $Amess = explode('-', $mess); 
                  $mess = implode("−", $Amess);
                  $Amess = explode('−', $mess);

                $messageCode = true;
                //Test si le message code est contituer uniquement de nombre
                foreach($Amess as $v){
                   if(!(preg_match('#^([-]?[0-9]*)$#' , $v)))
                    $messageCode = false;
                }
                if($messageCode == false){
                  echo "Erreur: se que vous avez saisie n'est pas au format code";
                  return 0;
                }
              }//FIN DU ELSEIF si methode = code
        
              $dico=[' le ','de ','des ',' que ',' elle ',' je ',' tu ',' il ',' un ',' ou ',' la ',' les ',' une ',' et ',' pour ',' par ', 'VOICI', 'voici'];
              $mod = calculeModulo($paquet, $nbcarac);
              $maxoccurence=0;
              $clefpossiblea= null;
              $clefpossiblea1= null;
              $clefpossibleb= null;
              $decryptpossible= null;
              $maxoccurence= null;

              for($clefa=0 ; $clefa<$mod ; $clefa++){ //On cherche la clee a
                if(PGCD($clefa, $mod)!=1) //Si $clefa et $mod n'est pas une clee valide on passe
                  continue;
                $clefa1 = inverseModulaire($clefa, $mod);
                if($clefa1==0)  //Si $clefa1 est égal à 0 on passe
                  continue;
                
                for($clefb = 0 ; $clefb<$mod ; $clefb++){ //On cherche la clee b
                  
                  $test = true;
                  $decrypt = "";
                  
                  foreach($Amess as $x){  //On parcour le message
                    $y=gmp_mul($clefa1, (gmp_sub((int)$x, $clefb))); //clee a * (valeur - clee b)
                    $y=gmp_mod($y, $mod);
                    if($y<0) //si modulo negatif on le met en positif
                      $y=gmp_add($y, $mod);
                    
                    $Y=array();
                    for($i=0 ; $i<$paquet and $test==true; $i++){
                      $Y[$i] = gmp_mod($y, 100);
                      $y=gmp_div_q(gmp_sub($y, $Y[$i]), 100);
                      if($Y[$i]>$nbcarac) {
                        $test=false;
                        break;
                      }
                    }//Fin for sur les paquet
                    if($test==false) 
                      break;
                    $Y=array_reverse($Y);
                    foreach($Y as $c => $v){
                      $Y[$c]=gmp_intval($v);
                      $decrypt = $decrypt.$_POST['alphabet'][$Y[$c]];
                    }
                  }//Fin for sur le message

                  if($test==false) 
                    continue;
                  
                  $occurence=0;
                  foreach($dico as $v){
                    $occurence=gmp_add($occurence,substr_count(strtolower($decrypt),$v));
                  }
                  if($occurence>$maxoccurence){
                    $clefpossiblea= $clefa;
                    $clefpossiblea1= $clefa1;
                    $clefpossibleb= $clefb;
                    $decryptpossible= $decrypt;
                    $maxoccurence= $occurence;
                  }
                }//Fin for sur clefb
              }//Fin for sur clefa

              echo "<p class='message' ><br>Message le plus probable est celui de la clé :<br> <strong>a =$clefpossiblea <br> a-&sup1 =$clefpossiblea1 <br> b =$clefpossibleb <br></strong><br> $decryptpossible</p>";
          }//FIN DU IF AVEC PREGMATCH
          else echo "Erreur: saisie du paquet incorrect";
        }//FIN DU IF AVEC ISSET ET TRIM...
    }//FIN DE LA FUNCTION

	/***********************************************
    *****************ATQ DE HILL********************
    ***********************************************/
	
	require('euclidehill.php');
/*function PGCD($a, $b)
{
   if ($a == 0)
      return $b;
   if ($b == 0)
      return $a;
   return (PGCD($b, $a % $b));
}*/

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
        if(in_array('affi',$_POST['fonction'])){
            affine();
        }
    }
    
    
    ?>
</body>
</html>

