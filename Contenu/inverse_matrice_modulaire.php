<!doctype html>
<html>
<head>
<link type="text/css" rel="stylesheet" href="Contenu/Arithmetibox.css"/>
<meta charset="utf-8"/>
</head>
<body>

<form action="Arithmetibox.php?outil=inverse_matrice_modulaire" method="POST">
<p>Saisir votre matrice :</p>
<textarea name='matrice' class="matrice"></textarea><br>
<input type='submit' value='Calculer'  class="boutton">

</form>

<?php
    $tab[]=0;   /*le tableau vas stocker le quotient*/
    $taille_tab=0;
    function pgcd($a, $b, &$tab) {
        $i=0;
        while ($b!=0){
            $t=$a%$b;
            echo $a.' | '.$b.' | '.$t.' | '.(int)($a/$b).'</br>';
            $tab[$i]=(int)($a/$b);
            $i++;
            $taille_tab++;
            echo 'taille_tab= '.$taille_tab.'</br>';
            $a=$b;
            $b=$t;
        }
        echo 'la taille du tableau est: '.sizeof($tab);
        return $a;
    }

    function calcul_u_v(){
        echo 'on rentre dans la fonction</br>';
        echo 'le tableau mesure: '.sizeof($tab);
        while($taille_tab!=0){
            echo '$tab[taille_t]</br>';
            $taille_tab--;
        }
    }

    preg_match('#^([-]?[0-9]*)(\ )([-]?[0-9]*)(\ )([-]?[0-9]*)(\ )([-]?[0-9]*)#' , $_POST['matrice'], $res);
        /*echo $res[0]."<br/>"; //sa affiche la totaliter du resultat
        echo 'res 1: '.$res[1]."<br/>"; //sa afiche le premier rejex
        echo $res[2]."<br/>";
        echo 'res 3: '.$res[3]."<br/>";
        echo $res[4]."<br/>";
        echo 'res 5: '.$res[5]."<br/>";
        echo $res[6]."<br/>";
        echo 'res 7: '.$res[7]."<br/>";*/

        $nb= ($res[1]*$res[7]) - ($res[3]*$res[5]);
        echo 'dit(M)= '.$res[1].' * '.$res[7].' - '.$res[3].' * '.$res[5].'</br>';
        echo 'dit(M)= '.($res[1]*$res[7]).' - '.($res[3]*$res[5]).'</br>';
        echo 'dit(M)= '.$nb.'</br></br>';

        $pgcd=pgcd(26, $nb);
         echo 'la taille du tableau est: '.sizeof($tab);
     echo '</br>Le pgcd est: '.$pgcd.'</br>';

     if($pgcd!=1)
        echo "imposible de calculer car le pgcd n'est pas égale a 1</br>";
    else
    {
        echo $taille_tab;
        calcul_u_v();
    }
    ?>
</body>
</html>