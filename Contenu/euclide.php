<?php require('debut.php');
    require('fonctions.php');?>
<form action="Arithmetibox.php?outil=eucl" method="post">
  <p>
  Un nombre a :<input type="text" name="nbA" value=""/></br>
  Un nombre b :<input type="text" name="nbB" value=""/></br>
  <input type="submit" value="Calculer" class="boutton">
  </p>
</form>

<?php
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
