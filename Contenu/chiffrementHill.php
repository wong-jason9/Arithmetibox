 <?php
require('debut.php');
?>
<h2 class="titreDansLaFonctions">Chiffrement de Hill</h2>
<form action="Arithmetibox.php?outil=hill" method = "post">
<p>Crypter : <input type="radio" name="msgcode" value="optcode"/> Decrypter : <input type="radio" name="msgcode" value="optdcode"/></p>
<p>Alphabet : <input size='50' name='alphabet' type='text' value='ABCDEFGHIJKLMNOPQRSTUVWXYZ'><br>
<p>Message :</br><textarea name='msg'></textarea></p>

<p>Cle : <textarea name='clecode' class="matrice"></textarea></p>
<p></br>Pour saisir la matrice:<br> Veuillez saisir le premier nombre ensuite espace, saisir le deuxième nombre, saut de ligne (touche "Entrée"), saisir le troisième nombre, espace, saisir le quatrième nombre. <br>Exemple:<img class="exemple_saisie_matrice" src="Contenu/exemple_saisie.png" alt="exemple_de_saisie_de_matrice"/></p>
<p> <input type="submit" name="chiffrer" value="Crypter/Decrypter" class="boutton_matrice"/></p>
</form>


<?php
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
?>

<?php

// Chiffrement De Hill

if (!empty($_POST)) {
   $tab_res_code  = array();
   $tab_res_dcode = array();
   
   $ccod          = $_POST['clecode'];
   
   if (preg_match('#^([-]?[0-9]*)(\ )([-]?[0-9]*)(\s*)([-]?[0-9]*)(\ )([-]?[0-9]*)#', $_POST['clecode'], $Accod)) {
      
	  $melema   = $Accod[1]; //Matrice element a 
      $melemb   = $Accod[3]; //Matrice element b
      $melemc   = $Accod[5]; //Matrice element c
      $melemd   = $Accod[7]; //Matrice element d
      //$alphabet = array();
	  $alphabet = str_split($_POST['alphabet']);
      $modulo   = count($alphabet);
      $Gamma    = (($melema * $melemd) - ($melemc * $melemb)); //Calcul de det(A) avec Gamma
      //verifier si cle valide XO
      $mod      = $Gamma % $modulo; //Mod en fonction de lalphabet
      
      if ($mod < 0)
         $mod = $mod + $modulo;
         
      echo "\$\$ \\Large det(A) = (($melema \\times $melemd)-($melemc \\times $melemb)) <br>\$\$";
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
      
   else {
   
      if (isset($_POST['msg']) and trim($_POST['msg']) != '') { //Pour coder 
      
         if (strcmp($_POST['msgcode'], 'optcode') == 0) {
            echo "\$\$    \\Large Cle = \\begin{pmatrix}";
            echo "$melema&$melemb \\\\ $melemc&$melemd \\end{pmatrix} \$\$";
            $msgc   = $_POST['msg'];
            $Amccod = str_split($msgc); // Tableu de caractere qui recupere le msg
            $compt  = count($Amccod);
            
            if ($compt % 2 != 0) { //Ajout du caractere A
               $Amcod   = $Amccod;
               $Amcod[] = 'A';
               $compt++;
            } else
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
            
            if ($compt % 2 == 0) { //Crypte le msg
               for ($i = 0; $i < count($Amcod); $i++) {
                  if ($i % 2 == 0) {
                     $val       = $Amcod[$i];
                     $Amcod[$i] = (($Amcod[$i] * $melema) + ($Amcod[$i + 1] * $melemb)) % $modulo;
                     if ($Amcod[$i] < 0) {
                        $Amcod[$i] = $Amcod[$i] + $modulo;
                     }
                  } else {
                     $Amcod[$i] = (($val * $melemc) + ($Amcod[$i] * $melemd)) % $modulo;
                     if ($Amcod[$i] < 0) {
                        $Amcod[$i] = $Amcod[$i] + $modulo;
                     }
                  }
               }
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
         
            $imelema = ($invmod * $Accod[7]) % $modulo; //Matrice Inverse element a 
            $imelemb = ($invmod * (-$Accod[3])) % $modulo; //Matrice Inverse element b
            $imelemc = ($invmod * (-$Accod[5])) % $modulo; //Matrice Inverse element c
            $imelemd = ($invmod * $Accod[1]) % $modulo; //Matrice Inverse element d
            $msgdc   = $_POST['msg'];
            $Amdccod = str_split($msgdc);
            $dcompt  = count($Amdccod);
            echo "\$\$    \\Large A^{-1} \\equiv_{ $modulo } \\begin{pmatrix}";
            echo "$imelema&$imelemb \\\\ $imelemc&$imelemd \\end{pmatrix} \$\$";
            
            if ($dcompt % 2 != 0) {
               $Amdcod   = $Amdccod;
               $Amdcod[] = 'A';
               $dcompt++;
            } else
               $Amdcod = $Amdccod;
            echo '<br>';
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
            
            if ($dcompt % 2 == 0) { //Decrypte le msg
               for ($i = 0; $i < $dcompt; $i++) {
                  if ($i % 2 == 0) {
                     $val        = $Amdcod[$i];
                     $Amdcod[$i] = (($Amdcod[$i] * $imelema) + ($Amdcod[$i + 1] * $imelemb)) % $modulo;
                     if ($Amdcod[$i] < 0) {
                        $Amdcod[$i] = $Amdcod[$i] + $modulo;
                     }
                  } else {
                     $Amdcod[$i] = (($val * $imelemc) + ($Amdcod[$i] * $imelemd)) % $modulo;
                     if ($Amdcod[$i] < 0) {
                        $Amdcod[$i] = $Amdcod[$i] + $modulo;
                     }
                  }
               }
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