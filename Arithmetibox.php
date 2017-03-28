<!DOCTYPE html>
<html>
<head>
    <link type="text/css" rel="stylesheet" href="Contenu/Arithmetibox.css"/>
    <meta charset="utf-8"/>
    <title> Arithmetibox </title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>
<body>
    <header>
        <a href="Arithmetibox.php"><img id="logo_Arithmetibox" src="Contenu/logo.svg" alt="logo_Arithmetibox"/>
        <h1 id="titre">ArithmetiBox</h1></a>
    </header>
    <main>
        <div id="MenuFonction">
            <nav>
				<h2 class="titreFonctions">Cryptanalyse</h2>
                <ul> 
                    <li><a class="listeF texte_court" href="Arithmetibox.php?outil=rsa">RSA</a></li> 
                    <li><a class="listeF texte_court" href="Arithmetibox.php?outil=hill">Chiffrement de Hill</a></li>
					<li><a class="listeF texte_court" href="Arithmetibox.php?outil=attaque">Attaquer</a></li>
                    <li><a class="listeF texte_court" href="Arithmetibox.php?outil=decrypte">Décrypter</a></li>  
                    <li><a class="listeF texte_court" href="Arithmetibox.php?outil=crypte">Crypter</a></li>
                </ul>   
                <h2 class="titreFonctions">Math</h2>
                <ul>
                    <li><a class="listeF texte_court" href="Arithmetibox.php?outil=pgcd">PGCD</a></li>
                    <li><a class="listeF texte_court" href="Arithmetibox.php?outil=eucl">Euclide</a></li>
                    <li><a class="listeF" href="Arithmetibox.php?outil=eucl_etendue">Algorithme d'Euclide étendu</a></li>
                    <li><a class="listeF texte_court" href="Arithmetibox.php?outil=cong">Congruence</a></li>
                    <li><a class="listeF texte_court" href="Arithmetibox.php?outil=inv_mod">Inverse modulaire</a></li>
                    <li><a class="listeF" href="Arithmetibox.php?outil=inverse_matrice_modulaire">Inverse matrice modulaire</a></li>
                    <li><a class="listeF texte_court" href="Arithmetibox.php?outil=test_primalite">Test de primalité</a></li>
                    <li><a class="listeF texte_court" href="Arithmetibox.php?outil=era">Erathostène</a></li>
                    <li><a class="listeF texte_court" href="Arithmetibox.php?outil=val_p_adique">Valuation p-adique</a></li>
                    <li><a class="listeF" href="Arithmetibox.php?outil=deco">Décomposition d'un nombre</a></li>
                    <li><a class="listeF" href="Arithmetibox.php?outil=expo_mod_rapide">Exponentiation modulaire rapide</a></li>
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
                case 'cong':
                    echo "<section>";
                    include("Contenu/congruence.php");
                    echo "</section>";
                    break;
                case 'deco':
                    echo "<section>";
                    include("Contenu/Decomposition.php");
                    echo "</section>";
                    break;
                case 'eucl':
                    echo "<section>";
                    include("Contenu/euclide.php");
                    echo "</section>";
                    break;
                case 'rsa':
                    echo '<section>';
                    include("Contenu/rsa.php");
                    echo '</section>';
                    break;
                case 'era':
                    echo '<section>';
                    include("Contenu/era.php");
                    echo '</section>';
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
				case 'attaque':
                    echo '<section>';
                    include("Contenu/Attaque.php");
                    echo '</section>';
                    break;
				case 'decrypte':
                    echo '<section>';
                    include("Contenu/Decryptage.php");
                    echo '</section>';
                    break;
				case 'crypte':
                    echo '<section>';
                    include("Contenu/Cryptage.php");
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
        <p> Ce site a été développé dans le cadre d'un projet universitaire du semestre 3 du DUT informatique. Il est réalisé par cinq étudiants du groupe A1 de l'année 2016/2017. La page web est développée dans les langages HTML, CSS, PHP et LaTeX, elle a pour but de créer une boîte à outils d’arithmétique qui est intégrée à Ataraxy, les différents outils développés sont des algorithmes étudiés en cours de S3 d'arithmétique et de cryptanalyse, cours qui est encadré par David Hébert, Docteur et professeur agrégé de mathématiques à l'université de Paris XIII Villetaneuse.
        </p>
    </section>
</body>
<footer>
    <p id="texte_footer"> Projet réalisé par : Jason Wong, Jeremy Dos Santos, Jack Kaing, Quentin Rat, Fahath Mougammadou || Copyright © 2016/2017</p>
</footer>
</html>
