<?php require('debut.php'); ?>
<h2 class="titreDansLaFonctions">Décryptage</h2>
<form action='Arithmetibox.php?outil=decrypte' method='post'>

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
                                echo "clef incorrecte";
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
                        $tab[]=$res;
                        $tab[]=$res1;
                        $tab[]=$res2;
                        $tab[]=$res3;
                        $tab[]=$res4;
                    }
                }
                
            }
        }
        if(isset($tab))
            return $tab;
        
    }
    if($_POST['fonction']=='cesa'){
        $cesa=cesar();
        if($cesa!=NULL){
            echo "<p class='message'>\$\$";
            echo "\\begin{array}{c|c}";
            foreach($cesa as $c=>$v){
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
    }
    elseif($_POST['fonction']=='affi'){
        
    }
    elseif($_POST['fonction']=='hill'){
        
    }
    
    ?>
</body>
</html>

