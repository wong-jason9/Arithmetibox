<?php require('debut.php');
    require('fonctions.php') ?>
<h2 class="titreDansLaFonctions">Décryptage</h2>
<form action='Arithmetibox.php?outil=decrypte' method='post' enctype="multipart/form-data">
<input type="hidden" name="MAX_FILE_SIZE" value="1048576" />
<p><label>Cesar<input type='radio' name='fonction' value='cesa' checked='checked'></label>
<label>Affine<input type='radio' name='fonction' value='affi'></label>
<label>Hill<input type='radio' name='fonction' value='hill'></label>
<label>Substitution<input type="radio" name="fonction" value="subs"></label></p>
Alphabet : <input size='50' name='alphabet' type='text' value='ABCDEFGHIJKLMNOPQRSTUVWXYZ'><br>
Paquet : <input size='50' name='paquet' type='text' ><br>
Clef : <input size='43' name='clef' type='text'><br>
<p>Message :<br>
<label>Format Alphabet<input type='radio' name='methode' value='alpha' checked='checked'></label><label>Format Code<input type='radio' name='methode' value='code'></label></p>
<textarea name='message'></textarea><br>
Ou choisir un fichier contenant le message codé : <input type="file" name="messagecode"><br>
<input type='submit' value='Déchiffrer'  class="boutton">
</form>

<?php

    
    function cesar(){
        if(isset($_FILES['messagecode']) and trim($_FILES['messagecode']['tmp_name'])!='')
            MessageDansFichier();
        if(isset($_POST['alphabet']) and trim($_POST['alphabet'])!='' and isset($_POST['paquet']) and trim($_POST['paquet'])!='' and preg_match('#^[0-9]*$#',$_POST['paquet']) and isset($_POST['message']) and trim($_POST['message'])!='' and isset($_POST['clef']) and trim($_POST['clef'])!='' and preg_match('#^[0-9]*$#',$_POST['clef']) and isset($_POST['methode'])){
            $Amess=RenvoyerMessage();
            if($Amess!=null){
                $alphabet=str_split($_POST['alphabet']);
                $nbcarac=gmp_sub(strlen($_POST['alphabet']),1);
                $mod = 0;
                for($i=0 ; $i<$_POST['paquet'] ; $i++) $mod = gmp_add(gmp_mul(100,$mod),$nbcarac);
                $mod=gmp_add($mod,1);
                if($_POST['fonction']=='cesa'){
                    if($_POST['clef']>=0 and $_POST['clef']<$mod){
                        $test = true;
                        $decrypt = "";
                        foreach($Amess as $x){
                            $res[]=$x;
                            $y=gmp_sub($x,$_POST['clef']);
                            $res1[]=$y;
                            $y=gmp_mod($y,$mod);
                        
                            if($y<0) $y=gmp_add($y,$mod);
                            $res2[]=$y;
                            $Y=array();
                            for($i=0 ; $i<$_POST['paquet'] and $test==true; $i++){
                                $Y[$i] = gmp_mod($y,100);
                                $y=gmp_div(gmp_sub($y ,$Y[$i]),100);
                            
                                if($Y[$i]>$nbcarac) {
                                    $test=false;
                                    echo "Données incorrectes";
                                    break;
                                }
                            
                            }
                            if($test==false) break;
                            $Y=array_reverse($Y);
                            foreach($Y as $c => $v){
                                $Y[$c]=gmp_intval($v);
                                $res3[]=$v;
                                $res4[]=$_POST['alphabet'][$Y[$c]];
                                $decrypt = $decrypt.$_POST['alphabet'][$Y[$c]];
                            }
                        }
                        if($test!=false){
                            echo "<p class='message'>".$decrypt."</p><br>";
                            if(isset($res) and isset($res1) and isset($res2) and isset($res3) and isset($res4) ){
                                $tab[]=$res;
                                $tab[]=$res1;
                                $tab[]=$res2;
                                $tab[]=$res3;
                                $tab[]=$res4;
                            }
                        }
                    }
                    
                }
            }
        }
        if(isset($tab))
            return $tab;
        
    }
    
    function affichageCesar($tab){
            echo "<p class='message'>\$\$";
            echo "\\begin{array}{c|c}";
            foreach($tab as $c=>$v){
                switch($c){
                    case 0:
                        echo " &";
                        break;
                    case 1:
                        echo " clef&";
                        break;
                    case 2:
                        echo " modulo&";
                        break;
                    case 3:
                        echo " paquetage&";
                        break;
                    case 4:
                        echo " résultat&";
                        break;
                }
                if($c==0 or $c==1 or $c==2){
                    
                    if($_POST['paquet']%2==0){
                        foreach($v as $r){
                            for($i=0; $i<(int)($_POST['paquet']/2);$i++){
                                echo "&";
                            }
                            echo $r.'&';
                            for($i=0; $i<(int)($_POST['paquet']/2)-1;$i++){
                                echo "&";
                            }
                        }
                    }
                    elseif($_POST['paquet']%2==1 and $_POST['paquet']!=1){
                        foreach($v as $r){
                            for($i=0; $i<(int)($_POST['paquet']/2);$i++){
                                echo "&";
                            }
                            echo "$r&";
                            for($i=0; $i<(int)($_POST['paquet']/2);$i++){
                                echo "&";
                            }
                        }
                    }
                    else{
                        foreach($v as $r){
                            echo "$r&";
                        }
                    }
                    
                }
                else{
                    foreach($v as $r){
                        echo "$r&";
                    }
                }
                
                echo "\\\\\\hline";
            }
            echo"\\end{array}";
            echo "\$\$</p>";
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
    function affGrille($cmpt, $AffL1, $AffL2, $AffL3, $AffL4, $AffL5, $AffL6){
            echo "\$\$";
            echo "\\begin{array}";

            if($_POST['methode']=='alphabet'){
                if($_POST['paquet']==1){
                    echo $AffL1[1];
                    for($i=0; $i<$cmpt; $i++){
                        echo $AffL1[$i];
                        if(($i+1)!=$cmpt) echo '&';
                    }
                }else{
                    echo $AffL1[0];
                    for($i=0; $i<$cmpt*$_POST['paquet']; $i++){
                        $j=0;
                        while($j<$_POST['paquet']){ //A MODIFIER POUR D'AUTRE PAQUET (SUPERIEUR à 2)
                            echo $AffL1[$j+$i];
                            $j++;
                        }
                        $i=$i+$j-1;
                        echo '&';
                    }
                }
                echo "\\\\\\hline";
            }
            if($_POST['methode']!='alphabet') echo '.'; //Corige le beug d'affichage de du caractère au début qui ne s'affiche pas
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
            for($i=0; $i<count($AffL6); $i++){
                if($_POST['paquet']==1){
                    echo $AffL6[$i];
                    if(($i+1)!=$cmpt) echo '&';
                }
                else{ //si les paquet sont supérieur à 1
                    $j=0;
                    while($j!=($_POST['paquet'])){ //A MODIFIER POUR D'AUTRE PAQUET (SUPERIEUR à 2)
                        echo $AffL6[$j+$i];
                        $j++;
                    }
                    $i=$i+$j-1;
                    echo '&';
                }
            }
            echo"\\end{array}".'\\\\';
            echo "\$\$";
    }

    function affine(){
        if(isset($_POST['alphabet']) and trim($_POST['alphabet'])!='' and isset($_POST['paquet']) and trim($_POST['paquet'])!='' and isset($_POST['message']) and trim($_POST['message'])!='' and isset($_POST['clef']) and trim($_POST['clef'])!='' and isset($_POST['methode'])){
            
            if((preg_match('#^([-]?[0-9]*)(\ )([-]?[0-9]*)$#' , $_POST['clef'], $res)) and (preg_match('#^([0-9]*)$#', $_POST['paquet']))){
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
                    $alphabet=str_split($_POST['alphabet']);    //convertir string en tableau
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
                }
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
                }
        
                $clefa=$res[1];
                $clefb=$res[3];

                $mod = calculeModulo($paquet, $nbcarac);

                if(PGCD($clefa, $mod)!=1){ //Si $clefa et $mod n'est pas une clee valide on passe
                    echo "Erreur: clee ($clefa, $clefb) non valide (le pgcd n'est pas égal à 1)";
                    return 0;
                }

                $clefa1 = inverseModulaire($clefa, $mod);
                if($clefa1==0){  //Si $clefa1 est égal à 0 on passe
                    echo "Erreur: clee ($clefa, $clefb) non valide";
                    return 0;
                }

                $test = true;
                $decrypt = "";
                $cmpt = 0;
                $i=1;

                foreach($Amess as $x){  //On parcour le message
                    $AffL2[$cmpt]=$x;
                    $y=(int)gmp_sub($x, $clefb);
                    $AffL3[$cmpt]=$y;
                    $y=gmp_mul($clefa1, $y); //clee a * (valeur - clee b)
                    $AffL4[$cmpt]=$y;
                    $y=gmp_mod($y, $mod);
                    
                    if($y<0) //si modulo negatif on le met en positif
                        $y=gmp_add($y, $mod);

                    $AffL5[$cmpt]=$y;
                        
                    $Y=array();
                    for($i=0 ; $i<$paquet and $test==true; $i++){
                        $Y[$i] = gmp_mod($y, 100);
                        $y= gmp_div_q(gmp_sub($y, $Y[$i]), 100);    
                    }
                        $Y=array_reverse($Y);
                        foreach($Y as $c => $v){
                            $Y[$c]=gmp_intval($v);
                            $decrypt = $decrypt.$_POST['alphabet'][$Y[$c]];
                        }
                    $cmpt++;
                }//Fin for sur le message       
                $AffL6=str_split($decrypt);

                echo "\$\$ \\textrm{clee= ($clefa, $clefb)} \$\$";
                echo "\$\$ \\textrm{par paquet de $paquet} \$\$";

                affGrille($cmpt, $AffL1, $AffL2, $AffL3, $AffL4, $AffL5, $AffL6);
            }//FIN IF PREGMATCH
            else echo "Saisie incorrecte";
        }//FIN DU PREMIER IF ISSET TRIM...
    }//FIN DE LA FUNCTION


    /***********************************************
    ********************HILL************************
    ***********************************************/
    /*require('euclidehill.php');
    
    function dhill(){
    
    $tab_res_dcode = array();
   
    $ccod          = $_POST['clef'];
   
   if (preg_match('#^([-]?[0-9]*)(\ )([-]?[0-9]*)(\s*)([-]?[0-9]*)(\ )([-]?[0-9]*)#', $_POST['clef'], $Accod)) {
      
      $melema   = $Accod[1]; //Matrice element a 
      $melemb   = $Accod[3]; //Matrice element b
      $melemc   = $Accod[5]; //Matrice element c
      $melemd   = $Accod[7]; //Matrice element d
      //$alphabet = array();
      $alphabet = str_split($_POST['alphabet']);
      $modulo   = count($alphabet);
      $Gamma    = (($melema * $melemd) - ($melemc * $melemb)); //Calcul de det(A) avec Gamma
      //verifier si cle valide XO
      $mod      = $Gamma % $modulo; //Mod en fonction de lalphabet
      
      if ($mod < 0)
         $mod = $mod + $modulo;
         
      echo "\$\$ \\Large det(A) = (($melema \\times $melemd)-($melemc \\times $melemb)) <br>\$\$";
      echo "\$\$ \\Large det(A) = $Gamma <br>\$\$";
      echo "\$\$ \\Large det(A) \\equiv_{ $modulo } $mod <br>\$\$";
      
      if ($Gamma != 0)
         euclid($modulo, $mod);
      $pgcd = PGCD($modulo, $mod); // Calcul du PGCD
      
      echo "\$\$ \\Large PGCD($modulo,$mod) = $pgcd <br>\$\$";
      
      if ($pgcd == 1) {
         $invmod = inverseModulaire($mod, $modulo);
         echo "\$\$ \\Large \\text{Cle valide} <br>\$\$";
      }
   }
   
   if ($pgcd != 1)
      echo "\$\$ \\Large \\text{Cle non valide} <br>\$\$";
      
   if ($pgcd == 1) {
      
      if (isset($_POST['message']) and trim($_POST['message']) != '') { //Pour decoder 
      
         
            $imelema = ($invmod * $Accod[7]) % $modulo; //Matrice Inverse element a 
            $imelemb = ($invmod * (-$Accod[3])) % $modulo; //Matrice Inverse element b
            $imelemc = ($invmod * (-$Accod[5])) % $modulo; //Matrice Inverse element c
            $imelemd = ($invmod * $Accod[1]) % $modulo; //Matrice Inverse element d
            $msgdc   = $_POST['message'];
            $Amdccod = str_split($msgdc);
            $dcompt  = count($Amdccod);
            echo "\$\$    \\Large A^{-1} \\equiv_{ $modulo } \\begin{pmatrix}";
            echo "$imelema&$imelemb \\\\ $imelemc&$imelemd \\end{pmatrix} \$\$";
            
            if ($dcompt % 2 != 0) {
               $Amdcod   = $Amdccod;
               $Amdcod[] = 'A';
               $dcompt++;
            } else
               $Amdcod = $Amdccod;
            echo '<br>';
            $tab_res_dcode[] = $Amdccod;
            foreach ($Amdcod as $c => $v) {
               $Amdcod[$c] = array_search($v, $alphabet);
            }
            $codeMessage = 0;
            foreach ($Amdcod as $v) {
               $codeMessage += $v;
            }
            echo '<br>';
            $tab_res_dcode[] = $Amdcod;
            
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
            
            $tab_res_dcode[] = $Amdcod;
            $decrypt         = "";
            foreach ($Amdcod as $cle => $val) {
               $decrypt = $decrypt.$_POST['alphabet'][$Amdcod[$cle]];
            }
            $Amdcod          = str_split($decrypt);
            $tab_res_dcode[] = $Amdcod;
            
            //Affichage LateX pour DCoder
            echo "<p>\$\$";
            echo "\\begin{array}{c||c}"; // collone //
            foreach ($tab_res_dcode as $c => $v) {
               switch ($c) {
                  case 0:
                     echo " Texte& ";
                     foreach ($tab_res_dcode[$c] as $val) {
                        echo " $val& ";
                     }
                     break;
                  case 1:
                     echo " Codage&";
                     foreach ($tab_res_dcode[$c] as $val) {
                        echo " $val& ";
                     }
                     break;
                  case 2:
                     echo " A^{-1}.X&";
                     foreach ($tab_res_dcode[$c] as $val) {
                        echo " $val& ";
                     }
                     break;
                  case 3:
                     echo " Decodage&";
                     foreach ($tab_res_dcode[$c] as $val) {
                        echo " $val& ";
                     }
                     break;
               }
               echo "\\\\\\hline";
            }
            echo "\\end{array}";
            echo "\$\$</p>";
            echo "<br>Decodage : $decrypt "; //Affiche le message coder
                
         }
      }
   }*/
    
    /***********************************************
    *****************FIN DE HILL********************
    ***********************************************/

    /*********************************************

                    SUBSTITUTION

    **********************************************/

    function alphabetOK($abc){
        $_alphabet = str_split($abc);

        if(!preg_match("#^[A-Za-z]{26}$#", $abc)){
            return false;
        }
        else{
            foreach($_alphabet as $v){
                if(substr_count($abc, $v) != 1)
                    return false;
            }
        }
        return true;
    }

    function substitution(){
        $AlphabetNorm = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";

        if(isset($_FILES['messagecode']) and trim($_FILES['messagecode']['tmp_name'])!='')
            MessageDansFichier();

        if(isset($_POST['clef']) and isset($_POST['message'])){

            if(trim($_POST['clef'])!='' and trim($_POST['message'])!=''){

                $_POST['message'] = preg_replace("#\n|\r|\t|\040#", "", $_POST['message']);
                if(preg_match("#^[A-Za-z]+$#", $_POST['message']) and alphabetOK($_POST['clef']) ){
        
                    $AlphabetCustom = strtoupper($_POST['clef']);
                    $message = mb_strtoupper($_POST['message'], "utf-8");

                    $_AlphabetCustom = str_split($AlphabetCustom);
                    $_AlphabetNorm = str_split($AlphabetNorm);

                    $_message = str_split($message);

                    foreach($_message as $v){
                        for($i=0; $i<26; $i++){
                            if($v == $_AlphabetCustom[$i]){
                                $_messageDecrypt[] = $_AlphabetNorm[$i];
                            }
                        }
                    }

                    $messageDecrypt = implode($_messageDecrypt);
                    echo "Message décrypté : <br>";
                    echo '<p class="message">'.$messageDecrypt.'</p>';
                }
                else
                    echo "Saisie incorrecte";
            }
            else
                echo "Saisie incorrecte";
        }
    }

    /**********************************************

                FIN DE SUBSTITUTION

    **********************************************/

    if(isset($_POST['fonction']) and $_POST['fonction']=='cesa'){
        $tab=cesar();
        if(isset($tab))
            affichageCesar($tab);
    }
    elseif(isset($_POST['fonction']) and $_POST['fonction']=='affi'){
        affine();
    }
    elseif(isset($_POST['fonction']) and $_POST['fonction']=='hill'){
        dhill();
    }
    elseif(isset($_POST['fonction']) and $_POST['fonction']=='subs'){
        substitution();
    }
    
    ?>
</body>
</html>

