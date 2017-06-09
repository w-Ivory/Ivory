<?php
session_start(); // On autorise la page à accéder à la superglobale de session (http://php.net/manual/fr/function.session-start.php).

require_once( '09_-_Les_sessions_-_Tombola/settings.php' ); // On inclut les constantes.
require_once( '09_-_Les_sessions_-_Tombola/common.php' ); // On inclut les constantes et fonctions.

/**
 * On gère les nouveaux tirages OU la réinitialisation de l'ensemble du programme
 * Dans un cas réel, nous ne gérerions que le premier cas car nous ne redonnerions pas 500 euros à un utilisateur.
**/
if( isset( $_GET ) && array_key_exists( 'destroy', $_GET ) ) : // Si la clé "destroy" est passée en paramètre dans l'URL,
    switch( $_GET['destroy'] ) : // Selon le type de destruction que l'on souhaite faire,
        case 'tickets': // Cas d'un nouveau tirage
            unset( $_SESSION['lottery']['status'] ); // On détruit la session des tickets pour faire un nouveau tirage (http://php.net/manual/fr/function.unset.php).
            unset( $_SESSION['lottery']['tickets'] ); // On détruit la session des tickets pour faire un nouveau tirage (http://php.net/manual/fr/function.unset.php).
            break;
        case 'all': // Cas d'une réinitailisation totale
            unset( $_SESSION['lottery'] ); // On détruit la session pour tout recommencer (http://php.net/manual/fr/function.unset.php).
            break;
    endswitch;

    $page = $_SERVER['PHP_SELF']; // On utilise la superglobale "$_SERVER" pour récupérer le nom de la page en cours d'utilisation (http://php.net/manual/fr/reserved.variables.server.php).
    header( 'Location:' . $page ); // On utilise la fonction "header" pour rediriger vers une autre page (http://php.net/manual/fr/function.header.php).
    exit; // On s'assure que la suite du code ne soit pas exécutée une fois la redirection effectuée.
endif;

initLottery( $_SESSION['lottery'] ); // On initialise nos variables de jeu.

/**
 * On gère le cas où l'utilisateur clique sur actualiser OU page précédente/ page suivante.
**/
if( !isset( $_GET['tirage'] ) && $_SESSION['lottery']['status'] ) : // Si on ne procède pas à un tirage mais que la variable de tirage en cours est toujours active (cas du clic sur page précédente dans le navigateur),
    $page = $_SERVER['PHP_SELF']; // On utilise la superglobale "$_SERVER" pour récupérer le nom de la page en cours d'utilisation (http://php.net/manual/fr/reserved.variables.server.php).
    header( 'Location:' . $page . '?destroy=tickets' ); // On utilise la fonction "header" pour rediriger vers une autre page avec une instruction de destruction des variables du tirage (http://php.net/manual/fr/function.header.php).
    exit; // On s'assure que la suite du code ne soit pas exécutée une fois la redirection effectuée.
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

        <link rel="stylesheet" type="text/css" href="09_-_Les_sessions_-_Tombola/style.css">
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
                        $nbTickets = manageTicketsNumber( $_POST['tickets'], PRICETICKET, $_SESSION['lottery'] ); // On récupère le nombre de tickets demandés pour l'achat.

                        if( $nbTickets!=$_POST['tickets'] ) :
                            echo '<div class="bloc error"><p>Votre cagnotte ou le nombre de tickets encore disponibles à la vente n\'a permis que l\'achat de ' . $nbTickets . ' à ' . PRICETICKET . '€/ticket, soit : ' . ( $nbTickets*PRICETICKET ) . '€ en moins dans votre cagnotte</p></div>'; // On affiche le nombre de tickets finalement achetés.
                        endif;

                        if( $nbTickets>0 ) :
                            buyTickets( $_SESSION['lottery'], $nbTickets ); // On achète des tickets.
                        endif;
                    else : // Sinon
                        echo '<div class="bloc error"><p>Veuillez saisir une valeur entre 0 et ' . count( availableTickets( $_SESSION['lottery'] ) ) . ' !</p></div>'; // On affiche une erreur de saisie (compris entre 0 et le nombre de tickets disponibles).
                    endif;
                else : // Sinon
                    echo '<div class="bloc error"><p>Veuillez saisir une valeur numérique !</p></div>'; // On affiche une erreur de saisie non numérique.
                endif;
            endif;
        ?>
        <div style="float:right;width:45%;">
            <form action="" method="POST">
                <label for="txt-tickets">Nombre de ticket(s) à acheter (<em style="font-size:smaller;">coût par ticket : <?php echo PRICETICKET; ?> euros</em>)</label><br />
                <input<?php if( count( availableTickets( $_SESSION['lottery'] ) )<1 || $_SESSION['lottery']['jackpot']<PRICETICKET ) echo ' disabled'; ?> id="txt-tickets" min="0" max="<?php echo count( availableTickets( $_SESSION['lottery'] ) ); ?>" name="tickets" placeholder="0/<?php echo count( availableTickets( $_SESSION['lottery'] ) ); ?>"" type="number" />

                <input<?php if( count( availableTickets( $_SESSION['lottery'] ) )<1 || $_SESSION['lottery']['jackpot']<PRICETICKET ) echo ' disabled'; ?> type="submit" value="Acheter" />
            </form>
            <?php if( count( $_SESSION['lottery']['tickets']['bought'] )>0 ) : // Si on a acheté au moins 1 ticket, ?>
            <p>
                <strong>Ticket(s) acheté(s)</strong> (<em style="font-size:smaller;"><?php echo count( $_SESSION['lottery']['tickets']['bought'] ) . '/' . MAXTICKETS; ?></em>) :<br />
                <em>
                <?php
                foreach( $_SESSION['lottery']['tickets']['bought'] as $ticket ) : // Pour chaque ticket acheté,
                    echo '<span style="display:inline-block;text-align:center;width:40px;">' .( strlen( $ticket )<3 ? '0' . ( strlen( $ticket )<2 ? '0' : '' ) : '' ) . $ticket . '</span> | '; // On affiche le numéro.
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
                <strong style="display:inline-block;width:130px;">Cagnotte initiale :</strong> <em style="display:inline-block;text-align:right;width:70px;"><?php echo INITIALJACKPOT; ?> euros</em><br />
                <strong style="display:inline-block;width:130px;">Cagnotte actuelle :</strong> <em style="display:inline-block;text-align:right;width:70px;"><?php echo $_SESSION['lottery']['jackpot']; ?> euros</em>
            </p>
            <p>
                <strong>Numéro(s) de ticket(s) disponible(s)</strong> (<em style="font-size:smaller;"><?php echo count( availableTickets( $_SESSION['lottery'] ) ) . '/' . MAXTICKETS; ?></em>) :<br />
                <em>
                <?php
                foreach( availableTickets( $_SESSION['lottery'] ) as $ticket ) : // Pour chaque ticket restant,
                    echo '<span style="display:inline-block;text-align:center;width:40px;">' . ( strlen( $ticket )<3 ? '0' . ( strlen( $ticket )<2 ? '0' : '' ) : '' ) . $ticket . '</span> | '; // On affiche le numéro.
                endforeach;
                // echo '<span style="display:inline-block;text-align:center;width:40px;">' . implode( '</span> | <span style="display:inline-block;text-align:center;width:40px;">', $_SESSION['lottery']['tickets']['available'] ) . '</span>'; // On crée une chaîne de caractères depuis un tableau, chaque éléments étant séparés par une chaîne de caractères donnée (http://php.net/manual/fr/function.implode.php).
                ?>
                </em>
            </p>
        </div>
        <?php
        else :
            /**
             * On gère le cas où l'utilisateur clique sur actualiser la page.
             * Dans ce cas, on ne relance pas le tirage pour ne pas modifier les tickets gagnants.
            **/
            if( $_SESSION['lottery']['status'] == false ) : // Si un tirage n'était pas déjà en cours,
                $_SESSION['lottery']['tickets']['gains'] = 0;
                $_SESSION['lottery']['tickets']['wins'] = lottery( $_SESSION['lottery'] ); // On tire au sort aléatoirement les tickets gagnants.
            endif;
        ?>
        <div style="float:right;width:45%;">
            <h3>Résultat du tirage</h3>
            <ul>
                <?php foreach( GAINS as $key => $gain ) : // Pour chaque prix accordé, ?>
                <li><strong><?php echo ( $key + 1 ); ?><sup style="font-size:smaller;"><?php echo $key===0 ? 'er' : 'ème'; ?></sup> prix</strong> : <?php echo $gain; ?> euros attribués au ticket "<strong><?php echo ( strlen( $_SESSION['lottery']['tickets']['available'][$_SESSION['lottery']['tickets']['rand'][$key]] )<3 ? '0' . ( strlen( $_SESSION['lottery']['tickets']['available'][$_SESSION['lottery']['tickets']['rand'][$key]] )<2 ? '0' : '' ) : '' ) . $_SESSION['lottery']['tickets']['available'][$_SESSION['lottery']['tickets']['rand'][$key]]; ?></strong>"</li>
                <?php
                    /**
                     * On gère le cas où l'utilisateur clique sur actualiser la page : !$_SESSION['lottery']['status'].
                     * Dans ce cas, on ne relance pas le tirage pour ne pas lui réattribuer les gains une deuxième fois.
                    **/
                    if( in_array( $_SESSION['lottery']['tickets']['available'][$_SESSION['lottery']['tickets']['rand'][$key]], $_SESSION['lottery']['tickets']['bought'] ) && !$_SESSION['lottery']['status'] ) : // Si le ticket gagnant est parmi les tickets achetés,
                        $_SESSION['lottery']['tickets']['gains'] += $gain;
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
                    echo '<span style="' . ( in_array( $ticket, $_SESSION['lottery']['tickets']['wins'] ) ? 'background-color:green;color:white;' : '' ) . 'display:inline-block;text-align:center;width:40px;">' . ( strlen( $ticket )<3 ? '0' . ( strlen( $ticket )<2 ? '0' : '' ) : '' ) . $ticket . '</span> | '; // On affiche le numéro.
                endforeach;
                // echo '<span style="display:inline-block;text-align:center;width:40px;">' . implode( '</span> | <span style="display:inline-block;text-align:center;width:40px;">', $_SESSION['lottery']['tickets']['bought'] ) . '</span>'; // On crée une chaîne de caractères depuis un tableau, chaque éléments étant séparés par une chaîne de caractères donnée (http://php.net/manual/fr/function.implode.php).
                ?>
                </em>
            </p>
            <p class="<?php echo $_SESSION['lottery']['tickets']['gains']>0 ? 'win' : 'lost'; ?>"><?php echo $_SESSION['lottery']['tickets']['gains']>0 ? 'Vous avez gagné ' . $_SESSION['lottery']['tickets']['gains'] . ' euros !' : 'Vous avez perdu'; ?></p>
        </div>
        <?php
            /**
             * On gère le cas où l'utilisateur clique sur actualiser la page.
            **/
            if( $_SESSION['lottery']['status'] == false ) : // S'il s'agit du premier lancement du tirage,
                $_SESSION['lottery']['status'] = true; // On indique qu'un tirage est en cours afin d'empêcher un deuxième tirage si on actualise la page.
            endif;
        endif;
        ?>
    </body>
</html>