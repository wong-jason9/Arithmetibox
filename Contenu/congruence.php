<?php require('debut.php'); ?>
<form action="Arithmetibox.php?outil=cong" method="post">
  <p>
  <input type="text" name='entierA'></input>
  modulo
  <input type="text" name='modulo'></input>
  est congru à ...
  <input type="submit" class="boutton"/>
  </p>
</form>
<?php
    function partieEntiere($d){
        if(preg_match('#\.#', $d)){
            $tab = explode('.', $d);
            return $tab[0];
        }
        else
            return $d;
    }
    
    if( isset($_POST['entierA']) and isset($_POST['modulo'])
        and trim($_POST['entierA'])!='' and trim($_POST['modulo'])!=''
        and preg_match('#^-?[0-9]+$#', $_POST['entierA']) and preg_match('#^-?[0-9]+$#', $_POST['modulo']) 
        ) {
      //  \[\equiv _{indice}\]
      echo '\['.$_POST['entierA'].'\equiv_{'.$_POST['modulo'].'}'.$_POST['entierA']%$_POST['modulo'].'\]';

      //si division a/mod contient un '.', partie entiere
      if(preg_match('#\.#', $_POST['entierA']/$_POST['modulo']) ){
        echo '\[ \lfloor \dfrac{'.$_POST['entierA'].'}{'.$_POST['modulo'].'} \rfloor = '.partieEntiere($_POST['entierA']/$_POST['modulo']).'\]';
      }
      else{ /*  \[\frac{numerateur}{denominateur}\] */
        echo '\[\frac{'.$_POST['entierA'].'}{'.$_POST['modulo'].'} = '.$_POST['entierA']/$_POST['modulo'].'\]';
      }
      echo '\['.$_POST['entierA'].' = '.partieEntiere($_POST['entierA']/$_POST['modulo']).' \times '.$_POST['modulo'].' + \boxed{'.$_POST['entierA']%$_POST['modulo'].'} \]';
    }
    
    ?>
</body>
</html>