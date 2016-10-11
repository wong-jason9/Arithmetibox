<script type="text/javascript" async
  src="https://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-MML-AM_CHTML">
</script>

<form action="Arithmetibox.php?outil=eucl" method="post">
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


euclide($_POST  ['nbA'],$_POST['nbB']);

?>


$$
\begin{array}{l | c | c |r}

\end{array}
$$


