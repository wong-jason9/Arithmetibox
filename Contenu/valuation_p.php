
<?php require('debut.php'); ?>
<form action="valuation_p.php" method="post">
<p> 
Entier n : <input type="text" name="entN"></br>
Puissance de n : <input type="text" value="1" name="puissance"/></br>
Valuation : <input type="text" name="mod"></br>
<input type="submit" value="Calculer"></p>
</form>

<?php

function val_p($n,$mod,$pui){
    $res=0;
    while($n%$mod==0){
        $res++;
        $n=$n/$mod;
    }
    return $res*$pui;
}
if(!empty($_POST['mod'])&&!empty($_POST['entN'])&&!empty($_POST['puissance'])){
    echo "\$\$";
    echo "\\text{V}";
    echo "_{".$_POST['mod'];
    echo "}("; 
    echo $_POST['entN']."^{".$_POST['puissance']."}";
    echo ")=";
    echo val_p($_POST['entN'],$_POST['mod'],$_POST['puissance']);
    echo "</br>";
    echo "\$\$";
}
?>