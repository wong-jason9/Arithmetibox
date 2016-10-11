<?php require('debut.php'); ?>
<form action="euclide.php">
	<p>
	Un nombre a :<input type="text" name="nbA" value=""/></br>
	Un nombre b :<input type="text" name="nbB" value=""/></br>
	<input type="submit" value="Calculer"></p>
</form>
<?php

    function euclide($a, $b) {
        while ($b!=0){
            $t=$a%$b;
            echo $a.' | '.$b.' | '.$t.' | '.(int)($a/$b).'</br>';
            $a=$b;
            $b=$t;
        }
        return $a;
    }


euclide($_GET['nbA'],$_GET['nbB']);

?>
</body>
</html>


