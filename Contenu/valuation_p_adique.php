<?php require('debut.php');
    require('fonctions.php');?>
<h2 class="titreDansLaFonctions">Valuation p-adique</h2>
<form action="Arithmetibox.php?outil=val_p_adique" method="post">
    <p> 
    Entier n : <input type="text" name="entN"></br>
    Puissance de n : <input type="text" value="1" name="puissance"/></br>
    Valuation : <input type="text" name="mod"></br>
    <input type="submit" value="Calculer" class="boutton"></p>
</form>

<?php
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
</body>
</html>