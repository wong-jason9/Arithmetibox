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
    
    //Congruence
    function partieEntiere($d){
        if(preg_match('#\.#', $d)){
            $tab = explode('.', $d);
            return $tab[0];
        }
        else
            return $d;
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
    
    //Valuation p-adique
    function val_p($n,$mod,$pui){
        $res=0;
        while($n%$mod==0){
            $res++;
            $n=$n/$mod;
        }
        return $res*$pui;
    }
?>