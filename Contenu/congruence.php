<?php require('debut.php');
     ?>
<h2 class="titreDansLaFonctions">Congruence</h2>
<form action="Arithmetibox.php?outil=cong" method="post">
  <p>
  Entier :<input type="text" name='entierA'><br>
  Modulo :<input type="text" name='modulo'><br>
  <input type="submit" value="Calculer "class="boutton"/>
  </p>
</form>
<?php
    if( isset($_POST['entierA']) and isset($_POST['modulo']) ){
		
		if( trim($_POST['entierA'])!='' and trim($_POST['modulo'])!='' and preg_match('#^-?[0-9]+$#', $_POST['entierA']) 
			and preg_match('#^[0-9]+$#', $_POST['modulo']) )
		{
			$_POST['entierA'] = preg_replace('#^[0]*#', '', $_POST['entierA']);
			$_POST['modulo'] = preg_replace('#^[0]*#', '', $_POST['modulo']);
			
			echo '\['.$_POST['entierA'].'\equiv_{'.$_POST['modulo'].'}'.gmp_mod($_POST['entierA'], $_POST['modulo']).'\]';
	  			
			if(preg_match('#^-#', $_POST['entierA'])){
				
				//Si quotient entier non nul, donc reste = 0
				if(preg_match('#^0$#', gmp_div_r($_POST['entierA'], $_POST['modulo'])) ){
					echo '\[ \frac{'.$_POST['entierA'].'}{'.$_POST['modulo'].'} = '.gmp_div_q($_POST['entierA'], $_POST['modulo']).'\]';
					$quotient = gmp_div_q($_POST['entierA'], $_POST['modulo']);
					echo '\['.$_POST['entierA'].'+ (-1) \times ('.$quotient.') \times'.$_POST['modulo'].' = \boxed{'.gmp_mod($_POST['entierA'], $_POST['modulo']).'}\]';
				}
				else{
					echo '\[ \lfloor \frac{'.$_POST['entierA'].'}{'.$_POST['modulo'].'} \rfloor = '.gmp_add(gmp_div_q($_POST['entierA'], $_POST['modulo']), -1).'\]';
					$quotient = gmp_add(gmp_div_q($_POST['entierA'], $_POST['modulo']), -1);
					echo '\['.$_POST['entierA'].'+ (-1) \times ('.$quotient.') \times'.$_POST['modulo'].' = \boxed{'.gmp_mod($_POST['entierA'], $_POST['modulo']).'}\]';
				}
				echo '\['.$_POST['entierA'].'+'.gmp_mul($quotient, -1).'\times'.$_POST['modulo'].'= \boxed{'.gmp_mod($_POST['entierA'], $_POST['modulo']).'}\]';
			}
			//Si entier1 positif
			else{
				//Si reste nul
				if(preg_match('#^0$#', gmp_div_r($_POST['entierA'], $_POST['modulo']))){
					echo '\[ \frac{'.$_POST['entierA'].'}{'.$_POST['modulo'].'} = '.gmp_div_q($_POST['entierA'], $_POST['modulo']).'\]';
				}
				else{
					echo '\[ \lfloor \frac{'.$_POST['entierA'].'}{'.$_POST['modulo'].'} \rfloor = '.gmp_div_q($_POST['entierA'], $_POST['modulo']).'\]';
				}
				echo '\['.$_POST['entierA'].' = '.$_POST['modulo'].'\times'.gmp_div_q($_POST['entierA'], $_POST['modulo']).'+\boxed{'.gmp_mod($_POST['entierA'], $_POST['modulo']).'} \]';
			}
		  
		}
		else{
			echo 'Saisie incorrecte';
		}
	}
    
    ?>
</body>
</html>