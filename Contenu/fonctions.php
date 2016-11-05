<?php
    //PGCD
    function pgcd($a, $b) {
        
        while ($b!=0){
            $t=$a%$b;
            $a=$b;
            $b=$t;
        }
        return $a;
    }
    
    //Test de primalité
    function is_primary($n){
        for($i=2;$i<$n;$i++){
            if($n%$i==0) return false;
        }
        return true;
    }
    
    function era($n){
        $sautDeLigne=0;
        $tab=array();
        $tabPremiers=array();
        for($i=0;$i<=$n;$i++) $tab[$i]=true;
        $tab[0]=false;
        $tab[1]=false;
        
        for($i=2;$i<=$n;$i++){
            if($tab[$i]){
                for($j=$i+$i;$j<$n;$j=$j+$i){
                    $tab[$j]=false;
                }
            }
        }
        for($i=1;$i<=$n;$i++){
            if($tab[$i]){
                $tabPremiers[]=$i;
            }
        }
        return $tabPremiers;
    }
    
    function affera($n){
        $sautDeLigne=0;
        $tabPrem=era($n);
        echo "\$\$";
        echo "\\text{Nombre premier jusqu'à ".$_POST['liste_primary']."}\\\ " ;
        echo "\\begin{array}{|c|c|c|c|c|c|c|c|c|c}";
        for($i=1;$i<=$n;$i++){
            $sautDeLigne++;
            if(in_array($i,$tabPrem) && $sautDeLigne%10!=0){
                echo '\boxed{'.$i.'}&';
            }
            elseif($sautDeLigne%10==0 ){
                echo "$i&\\\\";
            }
            else
                echo $i.'&';
        }
        echo"\\end{array}";
        echo "\$\$";
    }
    
    
    //Euclide
    function euclide($a, $b) {
        while ($b!=0){
            $t=$a%$b;
            
            $res['0']=$a;
            $res['1']=$b;
            $res['2']=$t;
            $res['3']=(int)($a/$b);
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
                $tab[0] = $entier%$modulo;
            else
                $tab[$i] = $tab[$i-1]*$tab[$i-1]%$modulo;
        }
        $res = 1;
        for($i=0; $i<$taille; $i++){
            if($bin[$taille-$i-1] == 1)
                $res = $res*$tab[$i]%$modulo;
        }
            
        return $res;
    }

    function carre($x){
        return $x*$x;
    }
?>