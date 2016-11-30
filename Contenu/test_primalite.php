<?php require('debut.php');
    require('fonctions.php'); ?>
<h2 class="titreDansLaFonctions">Test primalité</h2>
<form action="Arithmetibox.php?outil=test_primalite" method="post">
<p>
Testez si un nombre est premier : <input type="text" name="test_primary"></br>
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
    ?>
</body>
</html>