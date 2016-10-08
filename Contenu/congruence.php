
  <form action='Arithmetibox.php?outil=cong' method='post'>
    <h1>Congruence</h1>
    <p>
  		<input type="text" name='entierA'></input>
  		modulo
  		<input type="text" name='modulo'></input>
  		est congru à ...
  		<input type="submit"/>
  	</p>
  </form>
  <?php
  	if( isset($_POST['entierA']) and isset($_POST['modulo'])
  		and trim($_POST['entierA'])!='' and trim($_POST['modulo'])!=''
  		and preg_match('#^-?[0-9]+$#', $_POST['entierA']) and preg_match('#^-?[0-9]+$#', $_POST['modulo'])
  		) {
  		echo $_POST['entierA'].' modulo '.$_POST['modulo'].' = ';
  		echo $_POST['entierA']%$_POST['modulo'];
  	}
  	else
  		echo '<p>Vérifiez vos saisies</p>';
  ?>
 </body>
</html>