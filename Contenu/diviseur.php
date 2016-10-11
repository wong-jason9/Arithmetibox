<?php require('debut.php'); ?>
<form action="Arithmetibox.php?outil=divi" method="POST">
Nombre : <input size='30' name='nombre' type='text'><br>
<input type='submit' value='Calculer'  class="boutton">
</form>

<?php
    if(isset($_POST['nombre'])){
        if(preg_match('#^[0-9]*$#',$_POST['nombre']) and $_POST['nombre']!=NULL){
            echo "Les diviseurs de ".$_POST['nombre']." sont : ";
            for($i=1; $i<=$_POST['nombre'];$i++){
                if($_POST['nombre']%$i==0){
                    echo $i." | ";
                }
            }
            echo "</br>";
            for($i=1; $i<=sqrt($_POST['nombre']);$i++){
                if($_POST['nombre']%$i==0){
                    echo $i." x ".($_POST['nombre']/$i);
                    echo "</br>";
                }
            }
        }
        else
            echo "Saisie incorrecte.";
    }
    ?>
</body>
</html>