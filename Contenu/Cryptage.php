<?php require('debut.php');
    require('fonctions.php') ?>
<h2 class="titreDansLaFonctions">Cryptage</h2>
<form action='Arithmetibox.php?outil=crypte' method='post'>

<p><label>Cesar<input type='radio' name='fonction' value='cesa' checked='checked'></label>
<label>Affine<input type='radio' name='fonction' value='affi'></label>
<label>Hill<input type='radio' name='fonction' value='hill'></label></p>
Alphabet : <input size='50' name='alphabet' type='text' value='ABCDEFGHIJKLMNOPQRSTUVWXYZ'><br>
Paquet : <input size='50' name='paquet' type='text' ><br>
Clef : <input size='43' name='clef' type='text'><br>
<p>Message :<br>
<label>Format Alphabet<input type='radio' name='methode' value='alpha' checked='checked'></label><label>Format Code<input type='radio' name='methode' value='code'></label></p>
<textarea name='message'></textarea><br>
<input type='submit' value='Déchiffrer'  class="boutton">
</form>

<?php
    
    function cesar(){
        if(isset($_POST['alphabet']) and trim($_POST['alphabet'])!='' and isset($_POST['paquet']) and trim($_POST['paquet'])!='' and isset($_POST['message']) and trim($_POST['message'])!='' and isset($_POST['clef']) and trim($_POST['clef'])!='' and isset($_POST['methode'])){
            $Amess=array();
            $text=array();
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
            $nbcarac=gmp_sub(strlen($_POST['alphabet']),1);
            $mod = 0;
            for($i=0 ; $i<$_POST['paquet'] ; $i++) $mod = gmp_add(gmp_mul(100,$mod),$nbcarac);
            $mod=gmp_add($mod,1);
            if($_POST['fonction']=='cesa'){
                if($_POST['clef']>=0 and $_POST['clef']<$mod){
                    $res=array();
                    if($_POST['clef']==''){
                        echo "Clé nécessaire";
                    }
                    //Affichage pour une seule clé
                    elseif($_POST['clef']>=0 and $_POST['clef']<$mod){
                        foreach($Amess as $x){
                            $y=gmp_add($x,$_POST['clef']);
                            $y=gmp_mod($y,$mod);
                            $res[]=$y;
                            
                        }
                        echo $_POST['message']."<br><br>";
                        echo "Après cryptage : <br>";
                        $i=0;
                        foreach($res as $v){
                            echo $v;
                            $i++;
                            if($i<count($res))
                                echo "-";
                        }
                    }
                }
                
            }
        }
        else
            echo "Saisie incorrecte";
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

            if($_POST['paquet']==1 or ($_POST['paquet']>1 and $_POST['msgcode']!="crypter")) //Test pour savoir si on inclue la ligne
                echo "\\\\\\hline ";
            for($i=0; $i<count($AffL6); $i++) {

                if($_POST['paquet']==1){
                    echo $AffL6[$i];
                    if(($i+1)!=$cmpt) echo '&';
                }
                elseif($_POST['paquet']>1 and $_POST['msgcode']!="crypter"){
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
        if (isset($_POST['alphabet']) and trim($_POST['alphabet'])!='' and isset($_POST['paquet']) and trim($_POST['paquet'])!='' and isset($_POST['message']) and trim($_POST['message'])!='' and isset($_POST['clef']) and trim($_POST['clef'])!='' and isset($_POST['methode'])){

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
                $alphabet=str_split($_POST['alphabet']);
                $tab_message=str_split($_POST['message']);

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
            }
            if(preg_match('#^([-]?[0-9]*)(\ )([-]?[0-9]*)$#' , $_POST['clef'], $res)){
                $clefa=$res[1];
                $clefb=$res[3];

                $mod = calculeModulo($paquet, $nbcarac);

                if(PGCD($clefa, $mod)!=1){ //Si $clefa et $mod n'est pas une clee valide on passe
                    echo "clee ($clefa, $clefb) non valide (pgcd n'est pas égal à 1)";
                    return 0;
                }
                $clefa1 = inverseModulaire($clefa, $mod);
                if($clefa1==0){  //Si $clefa1 est égal à 0 on passe
                    echo "clee ($clefa, $clefb) non valide";
                    return 0;
                }

                $test = true;
                $decrypt = "";
                $cmpt = 0;

                for($j=0; $j<count($Amess); $j++){
                    $AffL2[$cmpt]=$Amess[$j];

                    $y=(int)gmp_mul($Amess[$j], $clefa);
                    $AffL3[$cmpt]=$y;
                    $y=gmp_add($y, $clefb); //clee a * (valeur - clee b)
                    $AffL4[$cmpt]=$y;
                    $y=gmp_mod($y, $mod);
                    $AffL5[$cmpt]=$y;

                    if($y<0) //si modulo negatif on le met en positif
                        $y=gmp_add($y, $mod);

                    $AffL5[$cmpt]=$y;
                        
                    $Y=array();
                    for($i=0 ; $i<$paquet and $test==true; $i++){
                        $Y[$i] = gmp_mod($y, 100);
                        $y=gmp_div_q(gmp_sub($y, $Y[$i]),100);

                        if($Y[$i]>$nbcarac and $paquet==1){
                            $test=false;
                            echo "clef incorrecte pour crypter";
                            break;
                        }
                                    
                    }

                    if($test==false) break;
                    $Y=array_reverse($Y);

                    if($paquet==1){ //Si paquet > 1 il ne faut pas traduire en lettre car sa ne veut rien dire
                        foreach($Y as $c => $v){
                            $Y[$c]=gmp_intval($v);
                            $decrypt = $decrypt.$_POST['alphabet'][$Y[$c]];
                         }
                    }
                    $cmpt++;
                }//Fin for sur le Message
                $AffL6=str_split($decrypt);

                echo "\$\$ \\textrm{clee= ($clefa, $clefb)} \$\$";
                echo "\$\$ \\textrm{par paquet de $paquet} \$\$";
                
                affGrille($cmpt, $AffL1, $AffL2, $AffL3, $AffL4, $AffL5, $AffL6);
            }
        }
    }

    if(isset($_POST['fonction'])){
    if($_POST['fonction']=='cesa')
        $cesa=cesar();
    if($_POST['fonction']=='affi')
        affine();
    }
    ?>
</body>
</html>
