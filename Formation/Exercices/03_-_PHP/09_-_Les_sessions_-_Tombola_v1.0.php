<?php
session_start(); // On autorise la page à accéder à la superglobale de session (http://php.net/manual/fr/function.session-start.php).

if( isset( $_GET ) && array_key_exists( 'destroy', $_GET ) ) : // Si la clé "destroy" est passée en paramètre dans l'URL,
    switch( $_GET['destroy'] ) : // Selon le type de destruction que l'on souhaite faire,
        case 'tickets': // Cas d'un nouveau tirage
            unset( $_SESSION['lottery']['tickets'] ); // On détruit la session des tickets pour faire un nouveau tirage (http://php.net/manual/fr/function.unset.php).
            break;
        case 'all': // Cas d'une réinitailisation totale
            unset( $_SESSION['lottery'] ); // On détruit la session pour tout recommencer (http://php.net/manual/fr/function.unset.php).
            break;
    endswitch;
    $page = $_SERVER['PHP_SELF']; // On utilise la superglobale "$_SERVER" pour récupérer le nom de la page en cours d'utilisation (http://php.net/manual/fr/reserved.variables.server.php).
    header( 'Location:' . $page ); // On utilise la fonction "header" pour rediriger vers une autre page (http://php.net/manual/fr/function.header.php).
endif;

/**
 * Définition des constantes du jeu.
**/
define( 'initialJackpot', 500 ); // On définit le montant par défaut de la cagnotte.
define( 'priceTicket', 2 ); // On définit le prix de chaque ticket.
define( 'maxTickets', 100 ); // On définit le nombre maximum de tickets par tirage.
define( 'gains', array( 100, 50, 20 ) ); // On définit les prix du tirage au sort.
/** **/

if( !isset( $_SESSION['lottery']['jackpot'] ) ) : // Si la cagnotte n'existe pas,
    $_SESSION['lottery']['jackpot'] = initialJackpot; // On la crée avec la cagnotte par défaut.
endif;

if( !isset( $_SESSION['lottery']['tickets']['available'] ) ) : // Si la liste des tickets valables n'existe pas,
    for( $i=1; $i<=maxTickets; $i++ ) : // Pour un nombre allant de 0 au nombre maximum de tickets,
        $_SESSION['lottery']['tickets']['available'][] = $i; // On ajoute le numéro de ticket.
    endfor;
endif;

if( !isset( $_SESSION['lottery']['tickets']['bought'] ) ) : // Si la liste des tickets achetés n'existe pas,
    $_SESSION['lottery']['tickets']['bought'] = array(); // On crée une liste vide.
endif;
?><!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0" />
        <title>Tombola | Les sessions - Mise en pratique</title>

        <link rel="stylesheet" type="text/css" href="../../_assets/css/style.css">

        <!-- // highlight.js : Coloration syntaxique du code -->
        <link rel="stylesheet" type="text/css" href="../../_assets/plugins/highlight/styles/monokai_sublime.css">
        <script type="text/javascript" src="../../_assets/plugins/highlight/highlight.pack.js"></script>
        <script type="text/javascript">
            hljs.initHighlightingOnLoad();
        </script>
        <!-- // -->

        <style type="text/css">
            <!--
                ol > li { padding-bottom:10px;  }

            .bloc {
                display:block;
                padding:4px 7px;
            }
                .error {
                    background-color:red;
                    color:white;
                }
            .win {
                background-color:green;
                color:white;
                text-align:center;
            }
            .lost {
                background-color:red;
                color:white;
                text-align:center;
            }
            -->
        </style>
    </head>
    <body>
        <h1>Tombola | Les sessions - Mise en pratique</h1>
        <p>Pour cet exercice :</p>
        <p>Nous allons créer un système de tombola, avec suivi de l'argent du joueur et achat d'un nombre arbitraire de tickets.</p>
        <ul>
            <li>Le joueur pourra :
                <ul>
                    <li>rentrer le nombre de tickets qu'il veut acheter (<em style="font-size:smaller;">s'il ne reste plus assez de tickets ou s'il n'a plus assez d'argent, il en achetera le maximum possible</em>),</li>
                    <li>voir les tickets (les numéros) qu'il a déjà acheté,</li>
                    <li>redémarrer la partie,</li>
                    <li>lancer directement le tirage (<em style="font-size:smaller;">à condition d'avoir au moins un ticket</em>).</li>
                </ul>
            </li>
            <li>Chaque ticket acheté aura un numéro <strong>aléatoire</strong> et <strong>unique</strong>.</li>
            <li>Au moment du tirage, 3 numéros <strong>aléatoire</strong> et <strong>unique</strong> seront tirés et seront donc les trois numéros gagnants.<br />Le joueur gagnera un prix pour chaque ticket gagnant qu'il possède.</li>
            <li>À l'issue du tirage, le joueur peut retourner sur la page d'achat de tickets pour le tirage suivant.</li>
        </ul>
        <p>Valeurs données :</p>
        <ul>
            <li><strong>Argent de départ</strong> : 500€</li>
            <li><strong>Prix d'un ticket</strong> : 2€</li>
            <li><strong>Nombre de tickets disponible par tirage</strong> : 100 (allant du numéro 1 au numéro 100)</li>
            <li><strong>Gains du tirage</strong> :
                <ul>
                    <li><strong>1<sup style="font-size:smaller;">er</sup> prix</strong> : 100€</li>
                    <li><strong>2<sup style="font-size:smaller;">ème</sup> prix</strong> : 50€</li>
                    <li><strong>3<sup style="font-size:smaller;">ème</sup> prix</strong> : 20€</li>
                </ul>
            </li>
        </ul>

        <hr />
        <h2>Tombola</h2>
        <a href="?destroy=all" title="">Réinitialiser</a>
        <?php
        if( !isset( $_GET['tirage'] ) ) : // Si on ne procède pas encore à un tirage,

        if( isset( $_POST['tickets'] ) ) : // Si on soumet une valeur pour le nombre de tickets à acheter,
            if( is_numeric( $_POST['tickets'] ) ) : // Si cette valeur est numérique,
                if( $_POST['tickets']>=0 ) : // Si on précise un nombre de tickets,
                    $nbTickets = $_POST['tickets']; // On récupère le nombre de tickets demandés pour l'achat.

                    /**
                     * On détermine si la cagnotte est suffisante pour l'achat des tickets.
                     * Sinon on calcule le nombre de tickets maximal avec cette cagnotte.
                    **/
                    if( ( $_POST['tickets'] * priceTicket )>$_SESSION['lottery']['jackpot'] ) : // Si le coût d'achat du nombre de tickets saisi est supérieur au montant restant dans la cagnotte,
                        $nbTickets = floor( $_SESSION['lottery']['jackpot'] / priceTicket ); // On calcule le nombre de tickets possibles avec la cagnotte restante - la fonction "floor" arrondit à l'entier inférieur (http://php.net/manual/fr/function.floor.php).
                        echo '<div class="bloc error"><p>Votre cagnotte d\'un montant de <strong>' . $_SESSION['lottery']['jackpot'] . ' euros</strong> ne vous a permis d\'acheter que <strong>' . $nbTickets . '</strong> tickets à <strong>' . priceTicket . ' euros</strong> le ticket !<br />Vous ne pouvez plus acheter de ticket.</p></div>'; // On affiche une erreur sur le nombre de tickets que l'on peut acheter.
                    endif;

                    /**
                     * On détermine si le nombre de tickets disponibles est suffisant pour l'achat des tickets.
                     * Sinon on calcule le nombre de tickets maximal disponible.
                    **/
                    if( $_POST['tickets']>count( array_diff( $_SESSION['lottery']['tickets']['available'], $_SESSION['lottery']['tickets']['bought'] ) ) ) : // Si le nombre de tickets demandés est supérieur au nombre de tickets disponibles, soit à la différence entre les tickets disponibles et les tickets achetés (http://php.net/manual/fr/function.array-diff.php),
                        $nbTickets = count( array_diff( $_SESSION['lottery']['tickets']['available'], $_SESSION['lottery']['tickets']['bought'] ) ); // On calcule le nombre de tickets disponible.
                        echo '<div class="bloc error"><p>Il ne restait que <strong>' . count( array_diff( $_SESSION['lottery']['tickets']['available'], $_SESSION['lottery']['tickets']['bought'] ) ) . '</strong> tickets disponibles !<br />Seul ces tickets ont été déduits de votre cagnotte, soit un coût de <strong>' . ( count( array_diff( $_SESSION['lottery']['tickets']['available'], $_SESSION['lottery']['tickets']['bought'] ) ) * priceTicket ) . ' euros</strong>.<br />Vous ne pouvez plus acheter de ticket.</p></div>'; // On affiche le nombre de tickets finalement achetés.
                    endif;

                    $_arr_randKeys = (array)array_rand( array_diff( $_SESSION['lottery']['tickets']['available'], $_SESSION['lottery']['tickets']['bought'] ), $nbTickets ); // On sélectionne au hasard dans un tableau autant de tickets que saisit et retourne la ou les clés de ces valeurs. La fonction "array_rand" pouvant retourner un entier, on s'assure de toujours avoir un tableau avec le transtypage "(array)".
                    // if( is_int( $_arr_randKeys ) ) {
                    //     $_arr_randKeys = array( $_arr_randKeys );
                    // }
                    
                    foreach( $_arr_randKeys as $key ) : // Pour chacune des clés tirées aléatoirement,
                        $_SESSION['lottery']['jackpot'] -= priceTicket; // On soustrait de la cagnotte le prix du ticket.
                        
                        $_SESSION['lottery']['tickets']['bought'][] = $_SESSION['lottery']['tickets']['available'][$key]; // On ajoute le ticket correspondant dans le tableau des tickets achetés.
                        
                        // unset( $_SESSION['lottery']['tickets']['available'][$key] ); // On supprime l'entrée dans le tableau des tickets disponibles.
                    endforeach;

                    sort( $_SESSION['lottery']['tickets']['bought'] ); // On trie les tickets achetés par ordre croissant.
                else : // Sinon
                    echo '<div class="bloc error"><p>Veuillez saisir une valeur entre 0 et ' . count( array_diff( $_SESSION['lottery']['tickets']['available'], $_SESSION['lottery']['tickets']['bought'] ) ) . ' !</p></div>'; // On affiche une erreur de saisie (compris entre 0 et le nombre de tickets disponibles).
                endif;
            else : // Sinon
                echo '<div class="bloc error"><p>Veuillez saisir une valeur numérique !</p></div>'; // On affiche une erreur de saisie non numérique.
            endif;
        endif;
        ?>
        <div style="float:right;width:45%;">
            <form action="" method="POST">
                <label for="txt-tickets">Nombre de ticket(s) à acheter (<em style="font-size:smaller;">coût par ticket : <?php echo priceTicket; ?> euros</em>)</label><br />
                <input<?php if( count( array_diff( $_SESSION['lottery']['tickets']['available'], $_SESSION['lottery']['tickets']['bought'] ) )<1 || $_SESSION['lottery']['jackpot']<=0 ) echo ' disabled'; ?> id="txt-tickets" min="0" max="<?php echo count( array_diff( $_SESSION['lottery']['tickets']['available'], $_SESSION['lottery']['tickets']['bought'] ) ); ?>" name="tickets" placeholder="0/<?php echo count( array_diff( $_SESSION['lottery']['tickets']['available'], $_SESSION['lottery']['tickets']['bought'] ) ); ?>"" type="number" />

                <input<?php if( count( array_diff( $_SESSION['lottery']['tickets']['available'], $_SESSION['lottery']['tickets']['bought'] ) )<1 || $_SESSION['lottery']['jackpot']<=0 ) echo ' disabled'; ?> type="submit" value="Acheter" />
            </form>
            <?php if( count( $_SESSION['lottery']['tickets']['bought'] )>0 ) : // Si on a acheté au moins 1 ticket, ?>
            <p>
                <strong>Ticket(s) acheté(s)</strong> (<em style="font-size:smaller;"><?php echo count( $_SESSION['lottery']['tickets']['bought'] ) . '/' . maxTickets; ?></em>) :<br />
                <em>
                <?php
                foreach( $_SESSION['lottery']['tickets']['bought'] as $ticket ) : // Pour chaque ticket acheté,
                    echo '<span style="display:inline-block;text-align:center;width:40px;">' . ( strlen( $ticket )<3 ? '0' . ( strlen( $ticket )<2 ? '0' : '' ) : '' ) . $ticket . '</span> | '; // On affiche le numéro.
                endforeach;
                // echo '<span style="display:inline-block;text-align:center;width:40px;">' . implode( '</span> | <span style="display:inline-block;text-align:center;width:40px;">', $_SESSION['lottery']['tickets']['bought'] ) . '</span>'; // On crée une chaîne de caractères depuis un tableau, chaque éléments étant séparés par une chaîne de caractères donnée (http://php.net/manual/fr/function.implode.php).
                ?>
                </em>
            </p>
            <a href="?tirage" title="">Lancer la tombola</a>
            <?php endif; ?>
        </div>
        <div style="width:45%;">
            <p>
                <strong style="display:inline-block;width:130px;">Cagnotte initiale :</strong> <em style="display:inline-block;text-align:right;width:70px;"><?php echo initialJackpot; ?> euros</em><br />
                <strong style="display:inline-block;width:130px;">Cagnotte actuelle :</strong> <em style="display:inline-block;text-align:right;width:70px;"><?php echo $_SESSION['lottery']['jackpot']; ?> euros</em>
            </p>
            <p>
                <strong>Numéro(s) de ticket(s) disponible(s)</strong> (<em style="font-size:smaller;"><?php echo count( array_diff( $_SESSION['lottery']['tickets']['available'], $_SESSION['lottery']['tickets']['bought'] ) ) . '/' . maxTickets; ?></em>) :<br />
                <em>
                <?php
                foreach( array_diff( $_SESSION['lottery']['tickets']['available'], $_SESSION['lottery']['tickets']['bought'] ) as $ticket ) : // Pour chaque ticket restant,
                    echo '<span style="display:inline-block;text-align:center;width:40px;">' . ( strlen( $ticket )<3 ? '0' . ( strlen( $ticket )<2 ? '0' : '' ) : '' ) . $ticket . '</span> | '; // On affiche le numéro.
                endforeach;
                // echo '<span style="display:inline-block;text-align:center;width:40px;">' . implode( '</span> | <span style="display:inline-block;text-align:center;width:40px;">', $_SESSION['lottery']['tickets']['available'] ) . '</span>'; // On crée une chaîne de caractères depuis un tableau, chaque éléments étant séparés par une chaîne de caractères donnée (http://php.net/manual/fr/function.implode.php).
                ?>
                </em>
            </p>
        </div>
        <?php
        else :
            $_arr_wins = array( 'tickets'=>array(), 'gains'=>0 );
            $_arr_randKeys = (array)array_rand( $_SESSION['lottery']['tickets']['available'], count( gains ) ); // On sélectionne au hasard dans un tableau autant de tickets que le nombre de gains et retourne la ou les clés de ces valeurs. La fonction "array_rand" pouvant retourner un entier, on s'assure de toujours avoir un tableau avec le transtypage "(array)".
            shuffle( $_arr_randKeys ); // On mélange les tickets tirés gagnants au sort.

            foreach( $_arr_randKeys as $key ) : // Pour chacune des clés tirées aléatoirement,
                $_arr_wins['tickets'][] = $_SESSION['lottery']['tickets']['available'][$key]; // On récupère les tickets gagnants.
            endforeach;
        ?>
        <div style="float:right;width:45%;">
            <h3>Résultat du tirage</h3>
            <ul>
                <?php foreach( gains as $key => $gain ) : // Pour chaque prix accordé, ?>
                <li><strong><?php echo ( $key + 1 ); ?><sup style="font-size:smaller;"><?php echo $key===0 ? 'er' : 'ème'; ?></sup> prix</strong> : <?php echo $gain; ?> euros attribués au ticket "<strong><?php echo ( strlen( $_SESSION['lottery']['tickets']['available'][$_arr_randKeys[$key]] )<3 ? '0' . ( strlen( $_SESSION['lottery']['tickets']['available'][$_arr_randKeys[$key]] )<2 ? '0' : '' ) : '' ) . $_SESSION['lottery']['tickets']['available'][$_arr_randKeys[$key]]; ?></strong>"</li>
                <?php
                    if( in_array( $_SESSION['lottery']['tickets']['available'][$_arr_randKeys[$key]], $_SESSION['lottery']['tickets']['bought'] ) ) : // Si le ticket gagnant est parmi les tickets achetés,
                        $_arr_wins['gains'] += $gain;
                        $_SESSION['lottery']['jackpot'] += $gain; // On ajoute le gain à la cagnotte.
                    endif;
                endforeach;
                ?>
            </ul>

            <?php if( isset( $_GET['tirage'] ) || count( $_SESSION['lottery']['tickets']['bought'] )<=0 ) : ?><a href="?destroy=tickets" title="">Nouveau tirage</a><?php endif; ?>
        </div>
        <div style="width:45%;">
            <h3>Rappel de vos tickets</h3>
            <p>
                <em>
                <?php
                foreach( $_SESSION['lottery']['tickets']['bought'] as $ticket ) : // Pour chaque ticket acheté,
                    echo '<span style="' . ( in_array( $ticket, $_arr_wins['tickets'] ) ? 'background-color:green;color:white;' : '' ) . 'display:inline-block;text-align:center;width:40px;">' . ( strlen( $ticket )<3 ? '0' . ( strlen( $ticket )<2 ? '0' : '' ) : '' ) . $ticket . '</span> | '; // On affiche le numéro.
                endforeach;
                // echo '<span style="display:inline-block;text-align:center;width:40px;">' . implode( '</span> | <span style="display:inline-block;text-align:center;width:40px;">', $_SESSION['lottery']['tickets']['bought'] ) . '</span>'; // On crée une chaîne de caractères depuis un tableau, chaque éléments étant séparés par une chaîne de caractères donnée (http://php.net/manual/fr/function.implode.php).
                ?>
                </em>
            </p>
            <p class="<?php echo $_arr_wins['gains']>0 ? 'win' : 'lost'; ?>"><?php echo $_arr_wins['gains']>0 ? 'Vous avez gagné ' . $_arr_wins['gains'] . ' euros !' : 'Vous avez perdu'; ?></p>
        </div>
        <?php endif; ?>
    </body>
</html>