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
        <a href="Arithmetibox.php"><img id="logo_Arithmetibox" src="Contenu/logo.svg" alt="logo_Arithmetibox"/>
        <h1 id="titre">ArithmetiBox</h1></a>
        <a href="http://www.ataraxy.info/Accueil">
        <p>Lien vers Ataraxy<img id="img_ataraxy" src="Contenu/ataraxysvg.svg" alt="logo_ataraxy"/></a>
    </header>
    <main>
        <div id="MenuFonction">
            <h2 id="titreFonctions">Fonctions</h2>
            <nav>
                <ul>
                    <li><a class="listeF" href="Arithmetibox.php?outil=eucl_etendue">Algorithme d'Euclide étendu (Quentin)</a></li>
                    <li><a class="listeF texte_court" href="Arithmetibox.php?outil=eucl">Euclide (Jeremy)</a></li>
                    <li><a class="listeF texte_court" href="Arithmetibox.php?outil=inv_mod">Inverse modulaire (Jack)</a></li>
                    <li><a class="listeF texte_court" href="Arithmetibox.php?outil=">Matrice modulaire(?)</a></li>
                    <li><a class="listeF" href="Arithmetibox.php?outil=algo_factorisation">Algorithme de factorisation(Qui la fait ?)</a></li>
                    <li><a class="listeF" href="Arithmetibox.php?outil=expo_mod_rapide">Exponentiation modulaire rapide(Jack)</a></li>
                    <li><a class="listeF" href="Arithmetibox.php?outil=inverse_matrice_modulaire">Inverse matrice modulaire(Quentin)</a></li>
                    <li><a class="listeF texte_court" href="Arithmetibox.php?outil=test_primalite">Test de primalité(Jeremy)</a></li>
                    <li><a class="listeF texte_court" href="Arithmetibox.php?outil=val_p_adique">Valuation p-adique(Quentin)</a></li>
                    <li><a class="listeF" href="Arithmetibox.php?outil=">Matrice de changement de base(?)</a></li>
                    <li><a class="listeF texte_court" href="Arithmetibox.php?outil=pgcd">PGCD(Jeremy)</a></li>
                    <li><a class="listeF texte_court" href="Arithmetibox.php?outil=cesa">Cesar(Jason)</a></li>
                    <li><a class="listeF texte_court" href="Arithmetibox.php?outil=affi">Méthode Affine(Quentin)</a></li>
                    <li><a class="listeF texte_court" href="Arithmetibox.php?outil=cong">Congruence(Jack)</a></li>
                    <li><a class="listeF texte_court" href="Arithmetibox.php?outil=hill">Chiffrement de Hill(Fahath)</a></li>
                </ul>
            </nav>
        </div>
        <div id="affichage">
        <section id="msg_fonctionnalité">
    <?php
        if(isset($_GET['outil'])){
            switch ($_GET['outil']){
                case 'eucl_etendue':
                    echo "<section>";
                    include("Contenu/euclide_etendue.php");
                    echo "</section>";
                    break;
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
                    echo "<section>";
                    include("Contenu/AttaqueAffine.php");
                    echo "</section>";
                    break;
                case 'cong':
                    echo "<section>";
                    include("Contenu/congruence.php");
                    echo "</section>";
                    break;
                case 'algo_factorisation':
                    echo "<section>";
                    include("Contenu/algo_factorisation.php");
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
                case 'inv_mod':
                    echo '<section>';
                    include("Contenu/inverse_modulaire.php");
                    echo "</section>";
                    break;
                case 'val_p_adique':
                    echo '<section>';
                    include("Contenu/valuation_p_adique.php");
                    echo "</section>";
                    break;
                case 'test_primalite':
                    echo '<section>';
                    include("Contenu/test_primalite.php");
                    echo "</section>";
                    break;
                case 'expo_mod_rapide':
                    echo '<section>';
                    include("Contenu/exponentiation_modulaire_rapide.php");
                    echo '</section>';
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
        <h2>À propos</h2>
        <p> Ce site a été développé dans le cadre d'un projet universitaire du semestre 3 du DUT informatique. Il est réalisé par cinq étudiants du groupa A1 de l'année 2016/2017. La page web est développée dans les languages HTML, CSS, PHP et LaTeX, il a pour but de créer une boîte à outils d’arithmétique qui est intégrée à Ataraxy, les différents outils développés sont des algorithmes étudiés en cours de S3 d'arithmétique et de cryptanalyse, cours qui est encadré par David Hébert, Docteur et professeur agrégé de mathématiques à l'université de Paris XIII d'Épinay Villetaneuse.
        </p>
    </section>
</body>
<footer>
    <p id="texte_footer"> Projet réalisés par : Jason Wong, Jeremy Dos Santos, Jack Kaing, Quentin Rat, Fahath Mougammadou || Copyright © 2016/2017</p>
</footer>
</html>
