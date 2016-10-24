<?php require('debut.php');
    require('fonctions.php'); ?>
<form action="Arithmetibox.php?outil=eucl_etendue" method="POST">
  <p>
  Un nombre a :<input type="text" name="nbA"/></br>
  Un nombre b :<input type="text" name="nbB"/></br>
  <input type="submit" value="Calculer" class="boutton">
  </p>
</form>

<?php
  if(isset($_POST['nbA']) and isset($_POST['nbB'])){
      $tab=euclEtendu($_POST['nbA'],$_POST['nbB']);
      echo "\$\$";
      echo "\\begin{array}{c|c|c|c|c|c c}";
      echo "a&b&r&q&u&v\\\\\\hline";
      foreach($tab as $tab2){
          foreach($tab2 as $v){
            echo $v.'&';
              
          }
          echo '</br>';
          echo "\\\\";
      }
      echo"\\end{array}".'\\\\';
      echo "\$\$";
  }
?>