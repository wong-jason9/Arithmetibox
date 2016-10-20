<?php require('debut.php'); ?>
<form action="Arithmetibox.php?outil=eucl_etendue" method="POST">
  <p>
    Un nombre a :<input type="text" name="nbA"/></br>
    Un nombre b :<input type="text" name="nbB"/></br>
    <input type="submit" value="Calculer">
  </p>
</form>

<?php
  function euclideEtendue($a,$n){
       //On créer de tableau pour stocker A B R Q U V
      $A=array();
      $B=array();
      $Q=array();
      $R=array();
      $U=array();
      $V=array();
      
      $i=0;
      $A[$i]=$a;
      $B[$i]=$n;
      $Q[$i]=(int)($A[$i]/$B[$i]);  //calcul du quotient
      $R[$i]=$A[$i]%$B[$i];     //calcul du reste

      while($R[$i]!=0){   //tant que le reste n'est pas égale a 0 on continue a calculer
        $i++;
        $A[$i] = $B[$i-1];
        $B[$i] = $R[$i-1];
        $Q[$i]=(int)($A[$i]/$B[$i]);
        $R[$i]=$A[$i]%$B[$i];
      }
      
      //on initialise les deux première valeur de u et v a 0 et 1
      $U[$i]=0;
      $V[$i]=1;

      for($j=$i-1 ; $j>=0 ; $j--){  //calcul de u et v
        $U[$j] = $V[$j+1];
        $V[$j] = -$Q[$j]*$U[$j]+$U[$j+1];
      }
      
        echo "\$\$";
        echo "\\begin{array}{c|c|c|c|c|c c}";
        echo "a&b&r&q&u&v\\\\\\hline";        
        for($i=0; $i<count($A); $i++){
        echo $A[$i].'&'.$B[$i].'&'.$Q[$i].'&'.$R[$i].'&'.$U[$i].'&'.$V[$i].'&'.'</br>';
        echo "\\\\";
      }
      echo"\\end{array}".'\\\\';
      echo "\$\$";
  }

  if(isset($_POST['nbA']) and isset($_POST['nbB'])){
    	euclideEtendue($_POST['nbA'],$_POST['nbB']);
  }
?>