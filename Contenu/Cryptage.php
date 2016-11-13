<?php require('debut.php'); ?>
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
	if(isset($_POST['fonction']))
		if($_POST['fonction']=='cesa')
			$cesa=cesar();
		
    ?>
</body>
</html>

