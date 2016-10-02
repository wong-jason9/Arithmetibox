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
                <form action='Arithmetibox.php?outil=cesa' method='post'>
                Alphabet : <input size='60' name='alphabet' type='text' value='ABCDEFGHIJKLMNOPQRSTUVWXYZ'><br>
                Message  : <textarea name='message'>62358-63351-235870-63054-124260-52854-43841</textarea><br>
                Paquet   : <input size='60' name='paquet' type='text'><br>
                Clef     : <input size='60' name='clef' type='text'><br>
                
                <input type='submit' value='Déchiffrer'>
                </form>
                </section>";
                echo "<section>";
                $nbcarac=strlen($_POST['alphabet'])-1;
                if(preg_match('#([0-9]*)(\-|\,|\.)([0-9]*)#',$_POST['message'])){
                    preg_match('#([0-9]*)(\-|\,|\.)([0-9]*)#',$_POST['message'],$caract);
                    $Amess = explode($caract[2], $_POST['message']);
                }
                
                
                
                $paquet = $_POST['paquet'];
                $mod = 0;
                for($i=0 ; $i<$paquet ; $i++) $mod = 100*$mod + $nbcarac;
                $mod=$mod+1;
                
                //$mod = 25252526
                if($_POST['paquet']!='' and $_POST['message']!=''){
                    if($_POST['clef']==''){
                        
                        for($clef = 0 ; $clef<$mod ; $clef++){
                            $test = true;
                            $decrypt = "";
                            //11h41
                            foreach($Amess as $x){
                                $y=(int)$x-$clef;
                                $y=$y%$mod;
                                if($y<0) $y=$y+$mod;
                                
                                $Y=array();
                                for($i=0 ; $i<$paquet and $test==true; $i++){
                                    $Y[$i] = $y%100;
                                    $y=($y - $Y[$i])/100;
                                    
                                    if($Y[$i]>$nbcarac) {
                                        $test=false;
                                        break;
                                    }
                                    
                                    $decrypt = $decrypt.$_POST['alphabet'][$Y[$i]];
                                }//Fin for sur les paquet
                                if($test==false) break;
                            }
                            if($test==false) continue;
                            
                            echo $clef." : <br>".$decrypt."<br>";
                            
                        }
                    }
                    elseif($_POST['clef']>=0 and $_POST['clef']<$mod){
                        
                        $test = true;
                        $decrypt = "";
                        //11h41
                        foreach($Amess as $x){
                            $y=(int)$x-$_POST['clef'];
                            $y=$y%$mod;
                            if($y<0) $y=$y+$mod;
                            
                            $Y=array();
                            for($i=0 ; $i<$paquet and $test==true; $i++){
                                $Y[$i] = $y%100;
                                $y=($y - $Y[$i])/100;
                                
                                if($Y[$i]>$nbcarac) {
                                    $test=false;
                                    echo "clef incorrecte";
                                    break;
                                }
                                
                                $decrypt = $decrypt.$_POST['alphabet'][$Y[$i]];
                            }//Fin for sur les paquet
                            if($test==false) break;
                        }
                        if($test!=false)
                            echo $_POST['clef']." : <br>".$decrypt."<br>";
                    }
                }
                
                echo "</section>";
                echo "</section>";
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
