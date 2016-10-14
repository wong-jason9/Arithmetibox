<?php require('debut.php'); ?>
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
    if(!empty($_POST  ['nbA'])&&!empty($_POST  ['nbB'])){
    	$eucli=euclide($_POST  ['nbA'],$_POST['nbB']);
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
}
    ?>
