<?php require('debut.php'); ?>
<form action="Arithmetibox.php?outil=cong" method="post">
<p>
<input type="text" name='entierA'></input>
modulo
<input type="text" name='modulo'></input>
est congru à ...
<input type="submit"/>
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
        //  \[\equiv \mod{}\]
        echo '\['.$_POST['entierA'].'\equiv'."_{$_POST['modulo']}".$_POST['entierA']%$_POST['modulo'].'\]';
        
    }
    else
  		echo '<p>Vérifiez vos saisies</p>';
    /*  \[\frac{numerateur}{denominateur}\] */
    
    //si division a/mod contient un '.', partie entiere
    if(preg_match('#\.#', $_POST['entierA']/$_POST['modulo'])){
        echo '\[ \lfloor \dfrac{'.$_POST['entierA'].'}{'.$_POST['modulo'].'} \rfloor = '.partieEntiere($_GET['entierA']/$_POST['modulo']).'\]';
    }
    else{
        echo '\[\frac{'.$_POST['entierA'].'}{'.$_POST['modulo'].'} = '.$_POST['entierA']/$_POST['modulo'].'\]';
    }
    
    echo '\['.$_POST['entierA'].' = '.partieEntiere($_POST['entierA']/$_POST['modulo']).' \times '.$_POST['modulo'].' + \boxed{'.$_POST['entierA']%$_POST['modulo'].'} \]';
    
    
    ?>
</body>
</html>