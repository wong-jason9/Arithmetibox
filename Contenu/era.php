<?php require('debut.php');
    require('fonctions.php'); ?>
<h2 class="titreDansLaFonctions">Erathostène</h2>
<form action="Arithmetibox.php?outil=era" method="post">
<p>
Liste des nombres premiers jusqu'a n : <input type="text" name="liste_primary"></br>
<input type="submit" value="Calculer" class="boutton"></p>
</form>

<?php
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