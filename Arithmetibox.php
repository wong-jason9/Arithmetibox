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
            <h1 id="titre">Arithmetibox</h1>
        </header>
        <main>
            <div id="MenuFonction">
                <h2 id="titreFonctions">Fonctions</h2>
                <nav>
                    <ul>
                        <li><a class="listeF" href="Arithmetibox.php?outil=pgcd">PGCD</a></li>
                        <li><a class="listeF" href="Arithmetibox.php?outil=cesa">Cesar</a></li>
                        <li><a class="listeF" href="Arithmetibox.php?outil=affi">Méthode Affine</a></li>
                        <li><a class="listeF" href="Arithmetibox.php?outil=cong">Congruence</a></li>
                        <li><a class="listeF" href="Arithmetibox.php?outil=pgcd">???</a></li>
                        <li><a class="listeF" href="Arithmetibox.php?outil=cesa">???</a></li>
                        <li><a class="listeF" href="Arithmetibox.php?outil=affi">???</a></li>
                        <li><a class="listeF" href="Arithmetibox.php?outil=cong">???</a></li>
                    </ul>
                </nav>
            </div>
            <div id="affichage">
                <section>
                <?php
                    if(isset($_GET['outil'])){
                        switch ($_GET['outil']){
                            case 'pgcd':
                            echo "<section>
                                <section>
                                <?-- Input -->
                                PGCD
                                </section>
                                <section>
                                Résultat
                                <?-- Affichage résultat -->
                                </section>
                            </section>";
                        break;
                        
                        case 'cesa':
                            echo "<section>
                            <section>
                            <?-- Input -->
                            Cesar
                            </section>
                            <section>
                            Résultat
                            <?-- Affichage résultat -->
                            </section>
                            </section>";
                        break;
                        
                        case 'affi':
                            echo "<section>
                            <section>
                            <?-- Input -->
                            Affine
                            </section>
                            <section>
                            Résultat
                            <?-- Affichage résultat -->
                            </section>
                            </section>";
                            break;
                        case 'cong':
                            echo "<section>
                            <section>
                            <?-- Input -->
                            Congruence
                            </section>
                            <section>
                            Résultat
                            <?-- Affichage résultat -->
                            </section>
                            </section>";
                        break;
                        case 'base':
                            echo "<section>
                            <section>
                            <?-- Input -->
                            Fonction
                            </section>
                            <section>
                            Résultat
                            <?-- Affichage résultat -->
                            </section>
                            </section>";
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
    </body>
    <footer>
        <p id="texte_footer"> Projet réalisées par : Jason Wong, Jeremy Dos Santos, Jack Kaing, Quentin Rat, Fahath Mougammadouaribou || Copyright © 2016/2017</p>
    </footer>
</html>
