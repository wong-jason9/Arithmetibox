<?php require('debut.php');
    require('fonctions.php');?>
<form action="Arithmetibox.php?outil=algo_factorisation" method="POST">
Nombre : <input size='30' name='nombre' type='text'><br>
<input type='submit' value='Calculer'  class="boutton">
</form>

<?php
    if(isset($_POST['nombre']) and trim($_POST['nombre'])!=''){
        if(preg_match('#^[0-9]*$#',$_POST['nombre']) and $_POST['nombre']!=NULL){
			$_POST['nombre']=gmp_init($_POST['nombre']);
            echo "Les diviseurs de ".$_POST['nombre']." sont : ";
            for($i=1; $i<=$_POST['nombre'];$i++){
                if(gmp_mod($_POST['nombre'],$i)==0){
                    echo $i." | ";
                }
            }
            echo "</br>";
            for($i=1; $i<=gmp_sqrt($_POST['nombre']);$i++){
                if(gmp_mod($_POST['nombre'],$i)==0){
                    echo $i." x ".gmp_div($_POST['nombre'],$i);
                    echo "</br>";
                }
            }
            
            echo "</br>";
            echo "Décomposition en produits de nombres premiers : </br>";
            $tabPremiers=era($_POST['nombre']);
            $nombre = $_POST['nombre'];
            while($nombre!=1){
                foreach($tabPremiers as $v){
                    if(gmp_mod($nombre,$v)==0){
                        $nombre=gmp_div($nombre,$v);
                        echo $v;
                        if($nombre !=1) echo " x ";
                        break;
                    }
                }
            }
        }
        else
            echo "Saisie incorrecte.";
    }
    
    ?>
</body>
</html>