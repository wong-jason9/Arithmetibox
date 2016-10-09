<!doctype html>
<html>
<head>
<link type="text/css" rel="stylesheet" href="Contenu/Arithmetibox.css"/>
<meta charset="utf-8"/>
</head>
<body>

<form action="Arithmetibox.php?outil=divi" method="POST">

Nombre : <input size='30' name='nombre' type='text'><br>
<input type='submit' value='Déchiffrer'  class="boutton">

</form>

<?php
    if(isset($_POST['nombre'])){
        echo "Les diviseurs de ".$_POST['nombre']." sont : ";
        for($i=1; $i<$_POST['nombre'];$i++){
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
    ?>
</body>
</html>