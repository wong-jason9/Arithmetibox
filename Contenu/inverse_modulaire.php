<?php require("debut.php");?>
<form action="Arithmetibox.php?outil=inv_mod" method='post'>	<?php //A definir action ici + outil dans Arithmetibox.php?>
<p>
<p>Entier<input type='text' name='entier'/></br>
   Modulo<input type='text' name='modulo'/></br>
<input type='submit' value='Calculer'/>
</p>
</form>
<script type="text/javascript" async
src="https://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-MML-AM_CHTML">
</script>
<?php
      function partieEntiere($d){
        if(preg_match('#\.#', $d)){
            $tab = explode('.', $d);
            return $tab[0];
        }
        else
            return $d;
      }
      function pgcd($a, $b){
        while($b != 0){
          $r = $a%$b;
          $a = $b;
          $b = $r;
        }
        return $a;
      }
/****#############################*/
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
    if(!empty($_POST['entier'])&&!empty($_POST['modulo'])){
      $eucli=euclide($_POST['entier'],$_POST['modulo']);
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
/*###############################*/
      //*********

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
          echo '\['.$_POST['entier'].'^{-1} \equiv_{'.$_POST['modulo'].'} '.$v[0].'\]';

        }
        
      }
  	?>