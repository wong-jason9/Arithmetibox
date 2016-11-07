<?php require('debut.php');
      require('fonctions.php');
?>
<h2 class="titreDansLaFonctions">Inverse modulaire</h2>
<form action="Arithmetibox.php?outil=inv_mod" method='post'>	<?php //A definir action ici + outil dans Arithmetibox.php?>
<p>
<p>Entier :<input type='text' name='entier'></br>
   Modulo :<input type='text' name='modulo'></br>
<input type='submit' value='Calculer' class="boutton"/>
</p>
</form>
<?php
      if(isset($_POST['entier']) and isset($_POST['modulo']) and
        trim($_POST['entier'])!='' and trim($_POST['modulo'])!='' and
        preg_match('#^[0-9]+$#', $_POST['entier']) and preg_match('#^[0-9]+$#', $_POST['modulo'])
        ){

        if(pgcd($_POST['entier'], $_POST['modulo']) != 1){
          echo '\[ PGCD('.$_POST['entier'].', '.$_POST['modulo'].') \ne 1\]';
          echo 'L\'inverse de '.$_POST['entier'].' modulo '.$_POST['modulo'].' n\'existe pas.';
        }
        else{
          
            $tab=euclEtendu($_POST['entier'],$_POST['modulo']);
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
          echo '\['.$_POST['entier'].'^{-1} \equiv_{'.$_POST['modulo'].'} '.$tab[0][5   ].'\]';


        }
        
      }
  	?>