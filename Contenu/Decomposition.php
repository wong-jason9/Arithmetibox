<?php require('debut.php');
    require('fonctions.php');?>
<h2>Décomposition d'un nombre</h2>
<form action="Arithmetibox.php?outil=algo_factorisation" method="POST">
Nombre : <input size='30' name='nombre' type='text'><br>
<input type='submit' value='Calculer'  class="boutton">
</form>

<?php
    if(isset($_POST['nombre']) and trim($_POST['nombre'])!=''){
        if(preg_match('#^[0-9]*$#',$_POST['nombre']) and $_POST['nombre']!=NULL){

            echo "Les diviseurs de ".$_POST['nombre']." sont : ";
            for($i=1; $i<=$_POST['nombre'];$i++){
                if(gmp_mod($_POST['nombre'],$i)==0){
                    echo $i." , ";
                }
            }
            echo "</br>";
            echo "Décomposition en produits de nombres premiers : </br>";
            $tabPremiers=era($_POST['nombre']);
            $nombre = $_POST['nombre'];
			echo "\$\$";
            while($nombre!=1){
                foreach($tabPremiers as $v){
					
					if(gmp_mod($nombre,$v)==0){
						$diviseur=val_p($nombre,$v,"1");
						echo $v;
						$nombre=gmp_div($nombre,gmp_pow($v,gmp_intval($diviseur)));
						if($diviseur>1) echo "^{ $diviseur }";
						if($nombre!=1) echo "\\times";
						
						break;
					}
                }
            }
			echo "\$\$";
        }
        else
            echo "Saisie incorrecte.";
    }
    
    ?>
</body>
</html>