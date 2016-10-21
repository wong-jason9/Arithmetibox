<?php require('debut.php'); ?>
<form action="nb_premier.php" method="post">
<p> 
Testez si un nombre est premier : <input type="text" name="test_primary"></br>
Liste des nombres premiers jusqu'a n : <input type="text" name="liste_primary"></br>
<input type="submit" value="Calculer"></p>
</form>

<?php

    function is_primary($n){
        for($i=2;$i<$n;$i++){
            if($n%$i==0) return false;
        }
        return true;
    }

function era($n){
    $sautDeLigne=0;
    $tab=array();
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
    echo "\$\$";
    echo "\\text{Nombre premier jusqu'à ".$_POST['liste_primary']."}\\\ " ;
    echo "\\begin{array}{|c|c|c|c|c|c|c|c|c|c}";
    for($i=1;$i<=$n;$i++){
        $sautDeLigne++;
            if($tab[$i] && $sautDeLigne%10!=0){
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
if(isset($_POST['test_primary'])&& !empty($_POST['test_primary'])){
    echo "\$\$";
    if(is_primary($_POST['test_primary'])==true){
        echo $_POST['test_primary']."\\text{ est premier</br>}";
    }
    else echo $_POST['test_primary']."\\text{ n'est pas premier</br>}";{
    }
    echo "\$\$";
}
if(isset($_POST['liste_primary'])&& !empty($_POST['liste_primary'])){
    era($_POST['liste_primary']);
}
?>