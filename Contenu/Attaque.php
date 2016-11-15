<?php require('debut.php'); ?>
<h2 class="titreDansLaFonctions">Attaque</h2>
<form action='Arithmetibox.php?outil=attaque' method='post'>
<p><label>Cesar<input type='checkbox' name='fonction[]' value='cesa' checked='checked'></label>
<label>Affine<input type='checkbox' name='fonction[]' value='affi' checked='checked'></label>
<label>Hill<input type='checkbox' name='fonction[]' value='hill' checked='checked'></label></p>
Alphabet : <input size='50' name='alphabet' type='text' value='ABCDEFGHIJKLMNOPQRSTUVWXYZ'><br>
Paquet : <input size='50' name='paquet' type='text' ><br>
<p>Message :<br>
<label>Format Alphabet<input type='radio' name='methode' value='alpha' checked='checked'></label><label>Format Code<input type='radio' name='methode' value='code'></label></p>
<textarea name='message'></textarea><br>
<input type='submit' value='Déchiffrer'  class="boutton">
</form>

<?php
    
    function cesar(){
        
        $dico=['le','de','des','que','elle','je','tu','il','un','ou','la','les','une','et','pour','par'];
        if(isset($_POST['alphabet']) and trim($_POST['alphabet'])!='' and isset($_POST['paquet']) and trim($_POST['paquet'])!='' and isset($_POST['message']) and trim($_POST['message'])!='' and isset($_POST['methode'])){
            $maxoccurence=0;
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
                $text[$clef]=$decrypt;
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
    if(isset($_POST['fonction'])){
        if(in_array('cesa',$_POST['fonction'])){
            cesar();
        }
    }
    
    
    ?>
</body>
</html>

