<!--hebert.iut@gmail.com
davidulle@gmail.com-->
<!DOCTYPE html>
<html>
<head>
<link type="text/css" rel="stylesheet" href="Contenu/Arithmetibox.css"/>
<meta charset="utf-8"/>
<title> Arithmetibox </title>
</head>
<body>
<header>
<img id="logo_Arithmetibox" src="Contenu/logo.svg" alt="logo_Arithmetibox"/>
<h1 id="titre">ArithmetiBox</h1>
<a href="http://www.ataraxy.info/Accueil">
<p>Lien vers Ataraxy<img id="img_ataraxy" src="Contenu/ataraxysvg.svg" alt="logo_ataraxy"/></a>
</header>
<main>
<div id="MenuFonction">
<h2 id="titreFonctions">Fonctions</h2>
<nav>
<ul>
<li><a class="listeF" href="Arithmetibox.php?outil=">Algorithme d'Euclide étendu</a></li>
<li><a class="listeF texte_court" href="Arithmetibox.php?outil=eucl">Euclide</a></li>
<li><a class="listeF texte_court" href="Arithmetibox.php?outil=">Inverse modulaire</a></li>
<li><a class="listeF texte_court" href="Arithmetibox.php?outil=">Matrice modulaire</a></li>
<li><a class="listeF" href="Arithmetibox.php?outil=divi">Algorithme de factorisation</a></li>
<li><a class="listeF" href="Arithmetibox.php?outil=">Exponentiation modulaire rapide</a></li>
<li><a class="listeF" href="Arithmetibox.php?outil=inverse_matrice_modulaire">Inverse matrice modulaire</a></li>
<li><a class="listeF texte_court" href="Arithmetibox.php?outil=">Test de primalité</a></li>
<li><a class="listeF" href="Arithmetibox.php?outil=">Matrice de changement de base</a></li>
<li><a class="listeF texte_court" href="Arithmetibox.php?outil=pgcd">PGCD</a></li>
<li><a class="listeF texte_court" href="Arithmetibox.php?outil=cesa">Cesar</a></li>
<li><a class="listeF texte_court" href="Arithmetibox.php?outil=affi">Méthode Affine</a></li>
<li><a class="listeF texte_court" href="Arithmetibox.php?outil=cong">Congruence</a></li>
<<<<<<< HEAD
<li><a class="listeF texte_court" href="Arithmetibox.php?outil=Ch_Hill">Chiffrement de Hill</a></li>
=======
<li><a class="listeF texte_court" href="Arithmetibox.php?outil=hill">Chiffrement de Hill</a></li>
>>>>>>> d2bb7022dbab5183b0d36f40faec1d29f250a0cf

</ul>
</nav>
</div>
<div id="affichage">
<section id="msg_fonctionnalité">
<?php
    if(isset($_GET['outil'])){
        switch ($_GET['outil']){
            case 'hill':
                echo "<section>";
                include("Contenu/chiffrementHill.php");
                echo "</section>";
                break;
            case 'pgcd':
                echo "<section>";
                include("Contenu/pgcd.php");
                echo "</section>";
                break;
                
            case 'cesa':
                echo "<section>";
                include("Contenu/AttaqueCesar.php");
                echo "</section>";
                break;
                
            case 'affi':
                break;
            case 'cong':
                echo "<section>";
                include("Contenu/congruence.php");
                echo "</section>";
                break;
            case 'divi':
                echo "<section>";
                include("Contenu/diviseur.php");
                echo "</section>";
                break;
            case 'eucl':
                echo "<section>";
                include("Contenu/euclide.php");
                echo "</section>";
                break;
            case 'inverse_matrice_modulaire':
                echo "<section>";
                include("Contenu/inverse_matrice_modulaire.php");
                echo "</section>";
                break;
            case 'Ch_Hill':
                echo "<section>";
                include("Contenu/chiffrementHill.php");
                echo "</section>";
                break;
            default :
                echo "<section>
                Bienvenue sur la page dédié au projet tutoré de 2016-2017</br>
                </section>";
                break;
        }
    }
    ?>
</section>
</div>
</main>
<section id="texte_a_propos">
<h2>A propos</h2>
<p> Se site à été dévelloper dans le cadre d'un projet universitaire du semestre 3 du DUT informatique. Il est réalisé par cinq étudiant du groupa A1 de l'année 2016/2017. La page web est développer dans les languages HTML, CSS, PHP et LaTeX, il a pour but de créer une boite à outils d’arithmétique qui est intégrer à Ataraxy, les différent outils developper sont des algorithmes vue en cour de S3 d'arithmétique et de cryptanalyse, cour qui est encadrer par David Hébert, Docteur et professeur agrégé de mathématiques à l'université de Paris XIII d'épinay Villetaneuse.
</p>
</section>
</body>
<footer>
<p id="texte_footer"> Projet réalisées par : Jason Wong, Jeremy Dos Santos, Jack Kaing, Quentin Rat, Fahath Mougammadou || Copyright © 2016/2017</p>
</footer>
</html>
