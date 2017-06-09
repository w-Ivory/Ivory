<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0" />
        <title>Articles aléatoires | Les tableaux - Mise en pratique</title>

        <style type="text/css">
            <!--
            article {
                float:left;
                margin:0 .5%;
                width:30%;
            }
                h2 { margin-top:0; }
                figure~h2 { margin-top:0.83em; }
                figure {
                    display:block;
                    margin:0;
                    padding:0;
                }
                    img { width:100%; }
            -->
        </style>
    </head>
    <body>
    	<?php
        	include('solution.php');
    	?>
        <hr style="clear:both" />
        <h1>Articles aléatoires | Les tableaux - Mise en pratique</h1>
        <p>Dans cet exercice, nous souhaitons mettre en place un affichage de 3 articles aléatoires parmi 5. Nous allons donc devoir :</p>
        <ul>
            <li>créer une structure en PHP capable de stocker 5 articles, chaque article devant être composé :
                <ul>
                    <li>d'un titre</li>
                    <li>d'un texte</li>
                    <li>d'une adresse vers une image</li>
                </ul>
            </li>
            <li>déterminer aléatoirement 3 articles à afficher parmi les 5 stockés</li>
            <li>afficher chacun de ces articles selon une structure HTML différente :
                <ol>
                    <li>titre dans une balise h2, suivi de texte dans une balise p, suivi de image dans une balise img</li>
                    <li>titre dans une balise h2, suivi de image dans une balise img, suivi de texte dans une balise p</li>
                    <li>image dans une balise img, suivi de titre dans une balise h2, suivi de texte dans une balise p</li>
                </ol>
            </li>
        </ul>
        <hr />
        <h2>Un peu plus loin dans l'aléatoire</h2>
        <p>Nous allons faire le même exercice mais cette fois-ci, l'ordre d'affichage des éléments HTML sera lui aussi aléatoire.</p>
        <hr />
        <h2>De l'aléatoire ayant de la mémoire</h2>
        <p>Nous allons faire le même exercice mais cette fois-ci, nous ne voulons pas que le même article apparaisse plusieurs fois.</p>
    </body>
</html>