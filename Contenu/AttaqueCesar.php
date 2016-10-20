<?php require('debut.php'); ?>

<form action='Arithmetibox.php?outil=cesa' method='post'>
Alphabet : <input size='50' name='alphabet' type='text' value='ABCDEFGHIJKLMNOPQRSTUVWXYZ'><br>
Paquet : <input size='50' name='paquet' type='text' ><br>
Clef (optionnel) : <input size='43' name='clef' type='text'><br>
<p>Message :<br>
<label>Format Code<input type='radio' name='methode' value='code'></label><label>Format Alphabet<input type='radio' name='methode' value='alpha'></label></p>
<textarea name='message'></textarea><br>
<input type='submit' value='Déchiffrer'  class="boutton">
</form>

<?php
    
    function cesar(){
        if(isset($_POST['alphabet']) and trim($_POST['alphabet'])!='' and isset($_POST['paquet']) and trim($_POST['paquet'])!='' and isset($_POST['message']) and trim($_POST['message'])!='' and isset($_POST['methode'])){
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
                    $codeMessage+=$v*pow(10,(2*$i));
                    $i--;
                    if($i<0){
                        $Amess[]=$codeMessage;
                        $codeMessage=0;
                        $i=$_POST['paquet']-1;
                    }
                }
            }
            
            $nbcarac=strlen($_POST['alphabet'])-1;
            $mod = 0;
            for($i=0 ; $i<$_POST['paquet'] ; $i++) $mod = 100*$mod + $nbcarac;
            $mod=$mod+1;
            
            //$mod = 25252526
            if($_POST['paquet']!='' and $_POST['message']!=''){
                if($_POST['clef']==''){
                    
                    for($clef = 0 ; $clef<$mod ; $clef++){
                        $test = true;
                        $decrypt = "";
                        //11h41
                        foreach($Amess as $x){
                            $y=(int)$x-$clef;
                            $y=$y%$mod;
                            if($y<0) $y=$y+$mod;
                            
                            $Y=array();
                            for($i=0 ; $i<$_POST['paquet'] and $test==true; $i++){
                                $Y[$i] = $y%100;
                                $y=($y - $Y[$i])/100;
                                
                                if($Y[$i]>$nbcarac) {
                                    $test=false;
                                    break;
                                }
                                
                                
                            }//Fin for sur les paquet
                            if($test==false) break;
                            $Y=array_reverse($Y);
                            foreach($Y as $c => $v){
                                $decrypt = $decrypt.$_POST['alphabet'][$Y[$c]];
                            }
                        }
                        if($test==false) continue;
                        
                        echo $clef." : <br>".$decrypt."<br>";
                        
                    }
                }
                elseif($_POST['clef']>=0 and $_POST['clef']<$mod){
                    
                    $test = true;
                    $decrypt = "";
                    //11h41
                    foreach($Amess as $x){
                        $res[]=$x;
                        $y=(int)$x-$_POST['clef'];
                        $res1[]=$y;
                        $y=$y%$mod;
                        
                        if($y<0) $y=$y+$mod;
                        $res2[]=$y;
                        $Y=array();
                        for($i=0 ; $i<$_POST['paquet'] and $test==true; $i++){
                            $Y[$i] = $y%100;
                            $y=($y - $Y[$i])/100;
                            
                            if($Y[$i]>$nbcarac) {
                                $test=false;
                                echo "clef incorrecte";
                                break;
                            }
                            
                        }//Fin for sur les paquet
                        if($test==false) break;
                        $Y=array_reverse($Y);
                        foreach($Y as $c => $v){
                            $res3[]=$v;
                            $res4[]=$_POST['alphabet'][$Y[$c]];
                            $decrypt = $decrypt.$_POST['alphabet'][$Y[$c]];
                        }
                    }
                    if($test!=false){
                        $tab[]=$res;
                        $tab[]=$res1;
                        $tab[]=$res2;
                        $tab[]=$res3;
                        $tab[]=$res4;
                    }
                }
            }
        }
        
        return $tab;
        
    }
    
    $cesa=cesar();
    if($cesa!=NULL){
        
        echo "\$\$";
        echo "\\begin{array}{c|c}";
        foreach($cesa as $c=>$v){
            switch($c){
                case 0:
                    echo " &";
                    break;
                case 1:
                    echo " - clef&";
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
        echo "\$\$";
        
    }
    
    ?>
</body>
</html>

