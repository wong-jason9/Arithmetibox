<?php require("debut.php");
      require("fonctions.php");
?>
<form action="Arithmetibox.php?outil=inv_mod" method='post'>	<?php //A definir action ici + outil dans Arithmetibox.php?>
<p>
<p>Entier :<input type='text' name='entier'/></br>
   Modulo :<input type='text' name='modulo'/></br>
<input type='submit' value='Calculer' class="boutton"/>
</p>
</form>
<script type="text/javascript" async
src="https://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-MML-AM_CHTML">
</script>
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
            echo $A[$i].'&'.$B[$i].'&'.$R[$i].'&'.$Q[$i].'&'.$U[$i].'&'.$V[$i].'&'.'</br>';
            echo "\\\\";
          }
          echo"\\end{array}".'\\\\';
          echo "\$\$";
      }


      if(isset($_POST['entier']) and isset($_POST['modulo']) and
        trim($_POST['entier'])!='' and trim($_POST['modulo'])!='' and
        preg_match('#^[0-9]+$#', $_POST['entier']) and preg_match('#^[0-9]+$#', $_POST['modulo'])
        ){

        if(pgcd($_POST['entier'], $_POST['modulo']) != 1){
          echo '\[ PGCD('.$_POST['entier'].', '.$_POST['modulo'].') \ne 1\]';
          echo 'L\'inverse de '.$_POST['entier'].' modulo '.$_POST['modulo'].' n\'existe pas.';
        }
        else{
          $a = array();
          $b = array();
          $r = array();
          $q = array();
          $u = array();
          $v = array();

          $a[0] = $_POST['entier'];
          $b[0] = $_POST['modulo'];
          $r[0] = $a[0]%$b[0];
          $q[0] = partieEntiere($_POST['entier']/$_POST['modulo']);
          
          $i = 0;
          while($r[$i] != 0){
            $i++;
            $a[$i] = $b[$i-1];
            $b[$i] = $r[$i-1];
            $r[$i] = $a[$i]%$b[$i];
            $q[$i] = partieEntiere($a[$i]/$b[$i]);
          }

          $u[$i] = 0;
          $v[$i] = 1;
          for($j = $i-1; $j>=0; $j--){
            $u[$j] = $v[$j+1];
            $v[$j] = -$q[$j]*$u[$j]+$u[$j+1];
          }

          euclideEtendue($_POST['entier'], $_POST['modulo']);
          echo '\['.$_POST['entier'].'^{-1} \equiv_{'.$_POST['modulo'].'} '.$v[0].'\]';


        }
        
      }
  	?>