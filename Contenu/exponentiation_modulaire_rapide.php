<?php
	require("debut.php");
	require("fonctions.php");
?> 	
	<form action="Arithmetibox.php?outil=expo_mod_rapide" method="post">
 		<p>
 			Entier : <input type="text" name="entier"><br>
 			Puissance : <input type="text" name="puissance"><br>
 			Modulo : <input type="text" name="modulo"><br>
 			<input type='submit' class='boutton' value="Calculer">
 		</p>
 	</form>
 
 	<?php
 	
 		if(isset($_POST['entier']) and isset($_POST['puissance']) and isset($_POST['modulo']) and
 			trim($_POST['entier'])!='' and trim($_POST['puissance'])!='' and trim($_POST['modulo'])!=''and
 			preg_match("#^[0-9]+$#", $_POST['entier']) and preg_match("#^[0-9]+$#", $_POST['puissance']) and preg_match('#^[0-9]+$#', $_POST['modulo'])
 			)
 		{

 			$bin = decbin($_POST['puissance']);
 			$taille = strlen($bin);

 			$tab_entier = array();
 			$tab_mod = array();
 			
 			$tab_entier[0] = $_POST['entier'];
 			$tab_mod[0] = gmp_mod($_POST['entier'], $_POST['modulo']);

 			for($i=1; $i<$taille; $i++){
 				$tab_entier[$i] = carre($tab_mod[$i-1]);
 				$tab_mod[$i] = gmp_mod($tab_entier[$i], $_POST['modulo']);
 			}

 			echo "\["; 			
 			echo "\\begin{array}{|c|";
 			for($i=0; $i<$taille-1; $i++)
 				echo "c ";
 			
 			echo " |}";

			echo '\\hline\\\\'; 			

 			echo "k&";
 			for($i=0; $i<$taille; $i++)
 				echo $i.'&';

 			echo '\\\\';
 			echo '\\hline';

 			echo '2^{2^{k}}&';	
 			for($i=0; $i<$taille; $i++)
 				echo $tab_entier[$i].'&';

 			echo '\\\\';
 			echo '\\hline';
 			echo '\equiv_{'.$_POST['modulo'].'}&';
 			for($i=0; $i<$taille; $i++)
 				echo $tab_mod[$i].'&';

 			echo '\\\\\\hline';

 			echo "\\end{array}";
 			echo "\]";

 			echo '\['.$_POST['puissance'].'='.$bin.'_{(2)}\]';

 			$res = array();
 			for($i=0; $i<$taille; $i++){
 				if($bin[$taille-$i-1] == 1)
 					$res[] = $tab_mod[$i];
 			}

 			echo '\['.$_POST['entier'].'^{'.$_POST['puissance'].'} \equiv_{'.$_POST['modulo'].'}';
 			$t = count($res);
 			echo $res[0];
 			for($i = 1; $i<$t; $i++){
 				echo ' \times '.$res[$i];
 			}
 			echo '\equiv_{'.$_POST['modulo'].'}'.expoModRapide($_POST['entier'], $_POST['puissance'], $_POST['modulo']);
 			echo '\]';
 					
 		}
 	?>
 </body>
</html>