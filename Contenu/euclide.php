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
            
            $res['0']=$a;
            $res['1']=$b;
            $res['2']=$t;
            $res['3']=(int)($a/$b);
            $tab[]=$res;
            $a=$b;
            $b=$t;
        }
        return $tab;
    }
    
    
    $eucli=euclide($_POST  ['nbA'],$_POST['nbB']);
    
    ?>
<?php
    if($eucli!=NULL){
        
        echo "\$\$";
        echo "\\begin{array}{c|c|c|c c}";
        echo "a&b&r&q\\\\\\hline";
        
        foreach($eucli as $v){
            foreach($v as $r){
                echo "$r&";
            }
            echo "\\\\";
            
        }
        
        echo"\\end{array}";
        echo "\$\$";
    }
    ?>
