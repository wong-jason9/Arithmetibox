<?php require('debut.php');
    require('fonctions.php'); ?>
<h2 class="titreDansLaFonctions">PGCD</h2>
<form action="Arithmetibox.php?outil=pgcd" method="post">
<p>Pour calculer le PGCD nous avons besoin de : </br>
Un nombre a :<input type="text" name="nbA"/></br>
Un nombre b :<input type="text" name="nbB"/></br>
<input type="submit" value="Calculer" class="boutton"></p>
</form>
<?php
    if(isset($_POST['nbA']) and isset($_POST['nbB']) and trim($_POST['nbB']) and trim($_POST['nbA'])){
        if(preg_match('#^([-]?[0-9]*)$#' , $_POST['nbA']) && preg_match('#^([-]?[0-9]*)$#' , $_POST['nbB'])){
            echo 'PGCD('.$_POST['nbA'].','.$_POST['nbB'].')=';
            echo pgcd($_POST['nbA'],$_POST['nbB']);
        }
        else{
            echo "Erreur de saisie";
        }
    }
    ?>
</body>
</html>				
