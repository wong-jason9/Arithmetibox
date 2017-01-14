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
			and preg_match('#^-?[0-9]+$#', $_POST['modulo']) )
		{
			echo '\['.$_POST['entierA'].'\equiv_{'.$_POST['modulo'].'}'.gmp_mod($_POST['entierA'], $_POST['modulo']).'\]';
	  
			//Si reste existe
			if(preg_match('#^-?[1-9]+$#', gmp_div_r($_POST['entierA'], $_POST['modulo'])) ) {
				echo '\[ \lfloor \dfrac{'.$_POST['entierA'].'}{'.$_POST['modulo'].'} \rfloor = '.gmp_div_q($_POST['entierA'], $_POST['modulo']).'\]';
			}
			else{ 
				echo '\[\frac{'.$_POST['entierA'].'}{'.$_POST['modulo'].'} = '.gmp_div_q($_POST['entierA'], $_POST['modulo']).'\]';
			}
		  
			$entierAPos = gmp_mul($_POST['entierA'], -1);
			$restePos = gmp_mod($entierAPos, $_POST['modulo']);
			$quotient = gmp_sub(gmp_div_q($_POST['entierA'], $_POST['modulo']), 1);
		  
			if(preg_match('#^-|0#', gmp_div_q($_POST['entierA'], $_POST['modulo']))){
				echo '\['.$_POST['entierA'].' = ('.gmp_div_q($_POST['entierA'], $_POST['modulo']).' - 1) \times '.$_POST['modulo'].' + ( - '.$restePos.' + '.$_POST['modulo'].') \]';
				echo '\['.$_POST['entierA'].' = '.$quotient.' \times '.$_POST['modulo'].' + \boxed{'.gmp_mod($_POST['entierA'], $_POST['modulo']).'}\]';
			}
			else{
				echo '\['.$_POST['entierA'].' = '.gmp_div_q($_POST['entierA'], $_POST['modulo']).' \times '.$_POST['modulo'].' + \boxed{'.gmp_mod($_POST['entierA'], $_POST['modulo']).'} \]';
			}
		  
		}
		else{
			echo 'Saisie incorrecte';
		}
	}
    
    ?>
</body>
</html>