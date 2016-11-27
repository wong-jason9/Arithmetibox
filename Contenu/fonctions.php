<?php
	//fonction cryptanalyse
    function RenvoyerMessage(){
		if(isset($_POST['alphabet']) and trim($_POST['alphabet'])!='' and isset($_POST['paquet']) and trim($_POST['paquet'])!='' and preg_match('#[0-9]*#',$_POST['paquet']) and isset($_POST['message']) and trim($_POST['message'])!='' and isset($_POST['methode'])){
            $Amess=array();
            $alphabet=str_split($_POST['alphabet']);
            if($_POST['methode']=='code'){
                if(preg_match('#^([0-9]*)(\-|\,|\.)([0-9]*)#',$_POST['message'])){
                    preg_match('#^([0-9]*)(\-|\,|\.)([0-9]*)#',$_POST['message'],$caract);
                    $Amess = explode($caract[2], $_POST['message']);
                }
				else return null;
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
	
	function Dictionnaire(){
		/*        
		$dico=array();
		$monfichier=fopen("Contenu/Dictionnaire.txt","r+");
		while(FALSE !== ($ligne = fgets($monfichier)))
			$dico[]=trim($ligne);
		fclose($monfichier);
		*/
		$dico=['le','de','des','que','elle','je','tu','il','un','ou','la','les','une','et','pour','par'];
		return $dico;
	}
	
	function MessageDansFichier(){
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
	}
    //PGCD
 function pgcd($a, $b) {
        while ($b!=0){
            $t=(gmp_mod($a , $b));
            $a=$b;
            $b=$t;
        }
        return $a;
    }
    
    //Test de primalité
   function is_primary($n){
        for($i=2;$i<$n;$i++){
            if(gmp_mod($n,$i)==0) return false;
        }
        return true;
    }
    
function era($n){ 
        $sautDeLigne=1;
        gmp_init($sautDeLigne);
        echo "\$\$";
        echo "\\text{Nombre premier jusqu'à ".$_POST['liste_primary']." :}\\\ " ;
        echo "\\begin{array}{|c|c|c|c|c|c|c|c|c|c|c|c|c|c|c|c|c|c|c|c|c|c|c|c|c|c|c|c|c|c|c|c|c|c|c|c|c|c|c|c|c|c|c|c|c|c|c|c|c|c}";
        $i=1;
        gmp_init($i);
        $compare=gmp_cmp($i,$n);
        for($i; $compare<0;$i++){
            if((is_primary($i))==true){
                echo $i.'&';
                $sautDeLigne++;
            }   
            if(gmp_mod($sautDeLigne,20)==0) {
                echo "\\\\";
                $sautDeLigne++;
            }
            $compare=gmp_cmp($i,$n);
       }
        echo"\\end{array}";
        echo "\$\$";
    }
    
   
    
    
    //Euclide
  function euclide($a, $b) {
        while ($b!=0){
            $t=(gmp_mod($a , $b));
            
            $res['0']=$a;
            $res['1']=$b;
            $res['2']=$t;
            $res['3']=(int)(gmp_div_q($a,$b));
            $tab[]=$res;
            $a=$b;
            $b=$t;
        }
        return $tab;
    }
    
    function euclEtendu($a, $b){
        $i = 0;
        $A[$i] = $a;
        $B[$i] = $b;
        $Q[$i]=(int)(gmp_div_q($A[$i], $B[$i])); //calcul du quotient
         $R[$i]=gmp_mod($A[$i], $B[$i]);         //calcul du reste
        while($R[$i]!=0){
            $i++;
            $A[$i] = $B[$i-1];
            $B[$i] = $R[$i-1];
            $Q[$i]=(int)(gmp_div_q($A[$i], $B[$i]));
            $R[$i]=gmp_mod($A[$i], $B[$i]);
        }
        $U[$i] = 0;
        $V[$i] = 1;
        for($j = $i-1; $j>=0; $j--){
            $U[$j] = $V[$j+1];
            $V[$j] = gmp_add(gmp_mul(gmp_neg($Q[$j]), $U[$j]), $U[$j+1]);   //équivaut à  -$Q[$j]*$U[$j]+$U[$j+1]
        }
        $tab;
        for($cpt=0; $cpt<=$i; $cpt++){
            $tab[$cpt] = [$A[$cpt], $B[$cpt], $R[$cpt], $Q[$cpt], $U[$cpt], $V[$cpt]];
        }
        return $tab;
    }
    
    //Valuation p-adique
    function val_p($n,$mod,$pui){
        $res=0;
        while(gmp_mod($n, $mod)==0){
            $res++;
            $n=gmp_div_q($n, $mod);
        }
        return gmp_mul($res, $pui);
    }


    //Exponentiation modulaire rapide

    function expoModRapide($entier, $puissance, $modulo){
        $bin = decbin($puissance);
        $taille = strlen($bin);
        $tab = array();
        for($i=0; $i < $taille; $i++){
            if($i == 0)
                $tab[0] = gmp_mod($entier, $modulo);
            else
                $tab[$i] = gmp_mod(gmp_mul($tab[$i-1], $tab[$i-1]), $modulo);
        }
        $res = 1;
        for($i=0; $i<$taille; $i++){
            if($bin[$taille-$i-1] == 1)
                $res = gmp_mod(gmp_mul($res, $tab[$i]), $modulo);
        }
            
        return $res;
    }

    function carre($x){
        return $x*$x;
    }
?>