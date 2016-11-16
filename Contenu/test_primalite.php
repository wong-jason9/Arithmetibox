<?php require('debut.php');
    require('fonctions.php'); ?>
<h2 class="titreDansLaFonctions">Test primalité</h2>
<form action="Arithmetibox.php?outil=test_primalite" method="post">
<p>
Testez si un nombre est premier : <input type="text" name="test_primary"></br>
Liste des nombres premiers jusqu'a n : <input type="text" name="liste_primary"></br>
<input type="submit" value="Calculer" class="boutton"></p>
</form>

<?php
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
        $res=era($_POST['liste_primary']);
        echo "\$\$";
        echo "\\text{Nombre premier jusqu'à ".$_POST['liste_primary']." :}\\\ " ;
        echo "\\begin{array}{|c|c|c|c|c|c|c|c|c|c|c|c|c|c|c|c|c|c|c|c|c|c|c|c|c|c|c|c|c|c|c|c|c|c|c|c|c|c|c|c|c|c|c|c|c|c|c|c|c|c}";
        $i=0;
        gmp_init($i);
        foreach($res as $cle => $val){
            $i++;
            echo $val.'&';
            if(gmp_mod($i,20)==0) echo "\\\\";
        }
            echo"\\end{array}";
            echo "\$\$";
    }
    ?>
</body>
</html>