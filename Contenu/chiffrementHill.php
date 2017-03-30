<?php
require('debut.php');
?>
<h2 class="titreDansLaFonctions">Chiffrement de Hill</h2>
<form action="Arithmetibox.php?outil=hill" method = "post">
<p>Crypter : <input type="radio" name="msgcode" value="optcode"/> Decrypter : <input type="radio" name="msgcode" value="optdcode"/></p>
<p>Alphabet : <input size='50' name='alphabet' type='text' value='ABCDEFGHIJKLMNOPQRSTUVWXYZ'><br>
<p>Message :</br><textarea name='msg'></textarea></p>
<p>Dimension : <input size='10' name='taillem' type='text'><br>
<p>Pour saisir la matrice:<br> Pour la première ligne, veuillez saisir chaque coefficient de cette ligne separé par un espace, une fois au bout appuye sur la touche entre pour passer à la ligne suivante. Ainsi de suite.<br>Exemple pour matrice dimension 2:<br><img class="exemple_saisie_matrice" src="Contenu/exemple_saisie.png" alt="exemple_de_saisie_de_matrice"/></p>
<p>Cle : <textarea name='matrice' class="matrice"></textarea></p>
<p> <input type="submit" name="chiffrer" value="Crypter/Decrypter" class="boutton_matrice"/></p>
</form> 

<?php //Les fonctions utilisés pour Hill
require('euclidehill.php');
function PGCD($a, $b)
{
   if ($a == 0)
      return $b;
   if ($b == 0)
      return $a;
   return (PGCD($b, $a % $b));
}
function inverseModulaire($a, $n)
{
   if (PGCD($a, $n) != 1)
      return 0;
   $A     = array();
   $B     = array();
   $Q     = array();
   $R     = array();
   $U     = array();
   $V     = array();
   $i     = 0;
   $A[$i] = $a;
   $B[$i] = $n;
   $Q[$i] = (int) ($A[$i] / $B[$i]);
   $R[$i] = $A[$i] % $B[$i];
   while ($R[$i] != 0) {
      $i++;
      $A[$i] = $B[$i - 1];
      $B[$i] = $R[$i - 1];
      $Q[$i] = (int) ($A[$i] / $B[$i]);
      $R[$i] = $A[$i] % $B[$i];
   }
   $U[$i] = 0;
   $V[$i] = 1;
   for ($j = $i - 1; $j >= 0; $j--) {
      $U[$j] = $V[$j + 1];
      $V[$j] = -$Q[$j] * $U[$j] + $U[$j + 1];
   }
   $resu = $U[0] % $n;
   if ($resu < 0)
      return $resu + $n;
   return $resu;
}

function det($matNN,$taillem)
{
    $smat=array(array());
    $d=0;
    if ($taillem == 2)
        return $d=(($matNN[0][0] * $matNN[1][1]) - ($matNN[1][0] * $matNN[0][1]));
    else
    {
        for ($k = 0; $k < $taillem; $k++)
        {
            $smati = 0; //submatrix's i value
            for ($i = 1; $i < $taillem; $i++)
            {
                $smatj = 0;
                for ($j = 0; $j < $taillem; $j++)
                {
                    if ($j == $k)
                        continue;
                    $smat[$smati][$smatj] = $matNN[$i][$j];
                    $smatj++;
                }
                $smati++;
            }
            $d = $d + (pow(-1, $k) * $matNN[0][$k] * det($smat,$taillem-1));
            // $k=i+j $smat= Matrice N-1
        }
    }
    return $d;

}
function cof($num,$f)
{
  $b=array(array());
  $fac=array(array());
  

   for ($q=0;$q<$f;$q++)
   {
   for ($p=0;$p<$f;$p++)
    {
     $m=0;
     $n=0;
     for ($i=0;$i<$f;$i++)
     {
       for ($j=0;$j<$f;$j++)
        {
          if ($i != $q && $j != $p)
          {
            $b[$m][$n]=$num[$i][$j];
            if ($n<($f-2))
             $n++;
            else
             {
               $n=0;
               $m++;
               }
            }
        }
      }
      $fac[$q][$p]=pow(-1,$q + $p) * det($b,$f-1);
    }
  }
  return transpose($num,$fac,$f);
}

function transpose($num,$fac,$r)
{
  $b=array(array());
  $inverse=array(array());
  for ($i=0;$i<$r;$i++)
    {
     for ($j=0;$j<$r;$j++)
       {
         $b[$i][$j]=$fac[$j][$i];
        }
    }
  $d=det($num,$r);
  for ($i=0;$i<$r;$i++)
    {
     for ($j=0;$j<$r;$j++)
       {
        $inverse[$i][$j]=$b[$i][$j] / $d;
        }
    }
return $inverse;
}

?>


<?php



if (!empty($_POST)) {
  
  
  //Partie pour recuperer la cle et pour calculer le determinant 
  $m=$_POST['taillem']; //Taille de la matrice 
  $mat=$_POST['matrice']; //La matrice/cle
  $matN=array();
  $matN=explode("\\n", $mat);
  $ch = str_replace("\n"," ", $matN[0]);
  $matN=explode(" ",$ch);
  $alphabet = str_split($_POST['alphabet']);
  $modulo   = count($alphabet);
  if (preg_match('#^([-]?[0-9]*)(\ )([-]?[0-9]*)(\s*)([-]?[0-9]*)(\ )([-]?[0-9]*)#', $_POST['matrice'], $mat)) {
  
  $cptm=0;
  for($i=0;$i<=$m-1;$i++)
  {
	 for($j=0;$j<=$m-1;$j++)
	 { 
		$matNN[$i][$j]=(int)$matN[$cptm];
		$cptm++;
	 }
  }
  
  $Gamma    = det($matNN,$m);
  //Fin de la partie pour recuper la cle et le calcul du determinant
  //Verifier si la cle est valide 

  $mod      = $Gamma % $modulo; //Mod en fonction de lalphabet
      
  if($mod < 0){
    $mod = $mod + $modulo; //Rend le modulo positive
  }

  echo "\$\$ \\Large {\displaystyle \det(A)=\sum _{j=1}^{$m}a_{i;j}(-1)^{i+j}\det(A_{i,j})} <br>\$\$";
  echo "\$\$ \\Large det(A) = $Gamma <br>\$\$";
  echo "\$\$ \\Large det(A) \\equiv_{ $modulo } $mod <br>\$\$";
  if ($Gamma != 0)
    euclid($modulo, $mod);
    $pgcd = PGCD($modulo, $mod); // Calcul du PGCD
    
    echo "\$\$ \\Large PGCD($modulo,$mod) = $pgcd <br>\$\$";
      
    if ($pgcd == 1) {
      $invmod = inverseModulaire($mod, $modulo);
      echo "\$\$ \\Large \\text{Cle valide} <br>\$\$";
    }
  }
  if ($pgcd != 1)
      echo "\$\$ \\Large \\text{Cle non valide} <br>\$\$";
  //Fin de la verfication
  else {
   
      if (isset($_POST['msg']) and trim($_POST['msg']) != '') { //Pour coder 
      
         if (strcmp($_POST['msgcode'], 'optcode') == 0) {
            echo "\$\$    \\Large Cle = \\begin{pmatrix}";
            $cpt=0;$vide="";
            for($i=0;$i<=$m-1;$i++)
            {
              for($j=0;$j<=$m-1;$j++)
              { 
                echo "$matN[$cpt]&";
                $cpt++;
              }
              echo "\\\\";
            }
            echo "\\end{pmatrix} \$\$";
            $msgc   = $_POST['msg'];
            $Amccod = str_split($msgc); // Tableu de caractere qui recupere le msg
            $compt  = count($Amccod);
            
            if ($compt % $m != 0){
              $Amcod   = $Amccod;
             while ($compt % $m != 0) { //Ajout du caractere A
               $Amcod[] = 'A';
               $compt++;
             } 
            }
            else
            $Amcod = $Amccod;
            $tab_res_code[] = $Amccod;
            foreach ($Amcod as $c => $v) { //Convertie les lettres en chiffres
               $Amcod[$c] = array_search($v, $alphabet);
            }
            
            $codeMessage = 0;
            foreach ($Amcod as $v) {
               $codeMessage += $v * pow(10, (2 * 0));
            }
            
            $tab_res_code[] = $Amcod;
            
            if ($compt % $m == 0) { //Crypte le msg

            //produit de matrice !!!
            $sum=0;$cpt=0;
            for ($i=0;$i<$compt;$i=$i+$m){

              for ( $c = 0 ; $c < $m ; $c++ ){

                  for ( $k = 0 ; $k < $m ; $k++ ){

                  $sum = ($sum + $matNN[$c][$k]*$Amcod[$k+$i])%$modulo;
                  if ($sum < 0) 
                        $sum=$sum+$modulo;
                  }
                  
                  $mul[$cpt] = $sum;
                  $cpt++;
                  $sum = 0;
                }

            }
            //Fin produit de matrice
            $Amcod=$mul;


            }



            $tab_res_code[] = $Amcod;
            $decrypte       = "";
            foreach ($Amcod as $val) {
               $decrypte = $decrypte . $alphabet[$val];
            }
            $Amcod          = str_split($decrypte);
            $tab_res_code[] = $Amcod;
            
            //Affichage LateX pour Coder
            echo "<p>\$\$";
            echo "\\begin{array}{c||c}"; // collone //
            foreach ($tab_res_code as $c => $v) {
               switch ($c) {
                  case 0:
                     echo " Texte& ";
                     foreach ($tab_res_code[$c] as $val) {
                        echo " $val& ";
                     }
                     break;
                  case 1:
                     echo " Codage&";
                     foreach ($tab_res_code[$c] as $val) {
                        echo " $val& ";
                     }
                     break;
                  case 2:
                     echo " A.X&";
                     foreach ($tab_res_code[$c] as $val) {
                        echo " $val& ";
                     }
                     break;
                  case 3:
                     echo " Decodage&";
                     foreach ($tab_res_code[$c] as $val) {
                        echo " $val& ";
                     }
                     break;
               }
               echo "\\\\\\hline";
            }
            echo "\\end{array}";
            echo "\$\$</p>";
            //Fin affichage LateX pour Coder
            
            echo "<br>Decodage : $decrypte "; //Affiche le message coder 
         }
      }
      
      if (isset($_POST['msg']) and trim($_POST['msg']) != '') { //Pour decoder 
      
         if (strcmp($_POST['msgcode'], 'optdcode') == 0) {
            
            $InvmatNN=array(array());
            if($m==2){
            $InvmatNN[0][0]=($invmod * (int)$matN[3]) % $modulo;
            $InvmatNN[0][1]=($invmod * (-(int)$matN[1])) % $modulo;
            $InvmatNN[1][0]=($invmod * (-(int)$matN[2])) % $modulo;
            $InvmatNN[1][1]=($invmod * (int)$matN[0]) % $modulo;
            }
            else{
            
            $InvmatNN=cof($matNN,$m);
            for ($i=0;$i<$m;$i++)
            {
              for ($j=0;$j<$m;$j++)
              {
                $InvmatNN[$i][$j]=($InvmatNN[$i][$j]*$invmod)%$modulo;
              }
            }
            }
            $InvmatN=array();
            $compteur=0;
            for($i=0;$i<$m;$i++)
            {
              for($j=0;$j<$m;$j++)
              { 
                $InvmatN[$compteur]=$InvmatNN[$i][$j];
                $compteur++;
              }
            }

            $msgdc   = $_POST['msg'];
            $Amdccod = str_split($msgdc);
            $dcompt  = count($Amdccod);
            echo "\$\$    \\Large Cle = \\begin{pmatrix}";
            $compteur=0;
            for($i=0;$i<$m;$i++)
            {
              for($j=0;$j<$m;$j++)
              { 
                echo "$InvmatN[$compteur]&";
                 $compteur++;
              }
              echo "\\\\";
            }
            echo "\\end{pmatrix} \$\$";

            
            if ($dcompt % $m != 0) {
              $Amdcod   = $Amdccod;
              while ($dcompt % $m != 0) {
               
               $Amdcod[] = 'A';
               $dcompt++;
              }
               
            } else
               $Amdcod = $Amdccod;
            $tab_res_dcode[] = $Amdccod;
            foreach ($Amdcod as $c => $v) {
               $Amdcod[$c] = array_search($v, $alphabet);
            }
            $codeMessage = 0;
            foreach ($Amdcod as $v) {
               $codeMessage += $v;
            }
            echo '<br>';
            $tab_res_dcode[] = $Amdcod;

            if ($dcompt % $m == 0) {
            $sum=0;$cpt=0;
            for ($i=0;$i<$dcompt;$i=$i+$m){

              for ( $c = 0 ; $c < $m ; $c++ ){

                  for ( $k = 0 ; $k < $m ; $k++ ){

                  $sum = ($sum + $InvmatNN[$c][$k]*$Amdcod[$k+$i])%$modulo;
                  if ($sum < 0) 
                        $sum=$sum+$modulo;
                  }
                  
                  $mul[$cpt] = $sum;
                  $cpt++;
                  $sum = 0;
                }

            }
            //Fin produit de matrice
            $Amdcod=$mul;

          }

            $tab_res_dcode[] = $Amdcod;
            $decrypt         = "";
            foreach ($Amdcod as $val) {
               $decrypt = $decrypt . $alphabet[$val];
            }
            $Amdcod          = str_split($decrypt);
            $tab_res_dcode[] = $Amdcod;
            
            //Affichage LateX pour DCoder
            echo "<p>\$\$";
            echo "\\begin{array}{c||c}"; // collone //
            foreach ($tab_res_dcode as $c => $v) {
               switch ($c) {
                  case 0:
                     echo " Texte& ";
                     foreach ($tab_res_dcode[$c] as $val) {
                        echo " $val& ";
                     }
                     break;
                  case 1:
                     echo " Codage&";
                     foreach ($tab_res_dcode[$c] as $val) {
                        echo " $val& ";
                     }
                     break;
                  case 2:
                     echo " A^{-1}.X&";
                     foreach ($tab_res_dcode[$c] as $val) {
                        echo " $val& ";
                     }
                     break;
                  case 3:
                     echo " Decodage&";
                     foreach ($tab_res_dcode[$c] as $val) {
                        echo " $val& ";
                     }
                     break;
               }
               echo "\\\\\\hline";
            }
            echo "\\end{array}";
            echo "\$\$</p>";
            echo "<br>Decodage : $decrypt "; //Affiche le message coder
                
         }
      }
   }
}

?>