<?php
/**
 * Les tables du jeu s'installent automatiquement au premier lancement (cf. ChessManager) mais nécessite d'avoir au préalable créé la base de données (cf paramètre DB_NAME dans le fichier ini.php)
 *
 * Bien entendu, les méthodes de "reset" ne sont là que pour le développement et doivent impérativement être supprimées (sinon tout le monde peut réinitialiser la base de données et on perd tout)
 *
 * Pour information, le jeu utilise une police d'écriture pour les pièces mais l'encodage UTF-8 permet l'utilisation des symboles de la table ASCII (https://fr.wikipedia.org/wiki/Symboles_d%27%C3%A9checs_en_Unicode#Points_de_code_Unicode_et_HTML)
 * 
 * Pour compléter le jeu, il reste encore à faire :
 *  - Empêcher la suppression du Roi
 *  - Gérer le cas du Roi en échec
 *  - Gérer le cas du Roi "mat"
 *  - Gérer la récupération de pièce lorsqu'un Pion arrive sur la ligne adverse - Game::printLost($team) permet d'afficher les pièces dans une liste déroulante
 * 
 * Enfin, pour le multiposte ... il va falloir attendre le javascript (ou provoquer un refresh en html toutes les n secondes mais c'est moins ergonomique)
**/
require( 'ini.php' );
require( 'common.php' );
require( 'core/classes/SPDO.php' );

try {
    $chessmanager = new ChessManager();

    /**
     * --------------------------------------------------
     * RESET
     * --------------------------------------------------
    **/
    if( isset( $_GET['destroy'] ) ) :
        if( defined( 'APP_TAG' ) )
            if( empty( $_GET['destroy'] ) ) :
                unset( $_SESSION[APP_TAG] );
                $chessmanager->reset();
            else :
                switch( $_GET['destroy'] ) :
                    case Board::TEAM_WHITE:
                    case Board::TEAM_BLACK:
                        unset( $_SESSION[APP_TAG]['players'][$_GET['destroy']] );
                        unset( $_SESSION[APP_TAG]['game'] );
                        break;
                    default:
                        unset( $_SESSION[APP_TAG][$_GET['destroy']] );
                endswitch;
            endif;

        header( 'Location: .' );
        exit();
    endif;

    /**
     * --------------------------------------------------
     * REFRESH PAGE
     * --------------------------------------------------
    **/
    if( isset( $_GET['piece'] ) && isset( $_GET['moveto'] ) && isset( $_SESSION[APP_TAG]['last_move'] ) && $_SESSION[APP_TAG]['last_move']==$_GET ) :
        header( 'Location: .' ); // Prevent refreshing
        exit();
    else :
        $_SESSION[APP_TAG]['last_move'] = $_GET; // Stores last move
    endif;

    /**
     * ---------------------------------------------------------------------------
     * RECOVERY OF GAME IN SESSION OR CREATING A NEW GAME
     * ---------------------------------------------------------------------------
    **/
    if( isset( $_SESSION[APP_TAG]['game'] ) ) :
        $game = unserialize( $_SESSION[APP_TAG]['game'] ); // Initializes the board with the session. To store an object in session, we were forced to serialize (make linear); So we must do the reverse operation to exploit it as an object. To do so, we use the function "unserialize" (http://php.net/manual/fr/language.oop5.serialization.php)
        /**
         * --------------------------------------------------
         * ABANDON
         * --------------------------------------------------
        **/
        if( isset( $_GET['abandon'] ) ) :
            if( defined( 'APP_TAG' ) )
                if( count( $game->getPlayer() )==2 ) : // If we count two opponents,
                    $chessmanager->finish( $game, ( $_GET['abandon']==Board::TEAM_WHITE ? $game->getPlayer( Board::TEAM_BLACK ) : $game->getPlayer( Board::TEAM_WHITE ) ) );
                    
                    $tmp_players = $game->getPlayer(); // Saves the actual players

                    unset( $game ); // Destroys the actual game
                    $game = new Game( $_app_settings ); // Initializes a new game with optional parameters
                    $game->setId( $chessmanager->create() ); // Creates a game in database
                    $game->setPlayer( Board::TEAM_WHITE, $tmp_players[Board::TEAM_WHITE] ); // Retrieves player one
                    $game->setPlayer( Board::TEAM_BLACK, $tmp_players[Board::TEAM_BLACK] ); // Retrieves player two
                    
                    $chessmanager->join( $game->getId(), $game->getPlayer( Board::TEAM_WHITE ), $game->getPlayer( Board::TEAM_BLACK ) ); // Joins players and game in database
                    
                    unset( $_SESSION[APP_TAG]['game'] ); // Destroys the game in session
                    $_SESSION[APP_TAG]['game'] = serialize( $game ); // Stores the game in session
                endif;
            
            header( 'Location: .' );
            exit();
        endif;
        /** **/
    else :
        $game = new Game( $_app_settings ); // Initializes a new board with optional parameters
        /**
         * ---------------------------------------------------------------------------
         * RECOVERY OF PLAYERS IN SESSION
         * ---------------------------------------------------------------------------
        **/
        if( isset( $_SESSION[APP_TAG]['players'] ) )
            foreach( $_SESSION[APP_TAG]['players'] as $key => $value ) :
                $tmp = unserialize( $value );
                if( is_object( $tmp ) && get_class( $tmp )=='Player' )
                    $game->setPlayer( $key, array(
                        'email'                 => $tmp->getEmail(),
                        'nickname'              => $tmp->getNickname(),
                        'date_account_creation' => $tmp->getDateAccountCreation()
                    ) ); // Sets stored player for his team in game

            endforeach;
        /** **/
    endif;
    /** **/

    /**
     * ---------------------------------------------------------------------------
     * LOGIN
     * ---------------------------------------------------------------------------
    **/
    if( isset( $_POST['submit' . ucwords( Board::TEAM_WHITE )] ) || isset( $_POST['submit' . ucwords( Board::TEAM_BLACK )] ) ) :
        if( isset( $_POST['email'] ) && isset( $_POST['password'] ) ) :
            if( $chessmanager->getPlayerManager()->record_exists( $_POST['email'] ) ) : // If the player is already registered,
                if( ( $player = $chessmanager->getPlayerManager()->get( $_POST['email'] ) )!==false && $player->getPassword()===$_POST['password'] ) :
                    $game->setPlayer( ( isset( $_POST['submit' . ucwords( Board::TEAM_BLACK )] ) ? Board::TEAM_BLACK : Board::TEAM_WHITE ), $chessmanager->getPlayerManager()->get( $_POST['email'] ) ); // Restores the player
                else :
                    $_err_connect = '<span style="background-color:red;color:white;display:block;padding:4px 7px;">Mauvais identifiant ou mot de passe</span>';
                endif;
            else :
                $game->setPlayer( ( isset( $_POST['submit' . ucwords( Board::TEAM_BLACK )] ) ? Board::TEAM_BLACK : Board::TEAM_WHITE ), array(
                    'email'     => htmlentities( $_POST['email'] ),
                    'password'  => htmlentities( $_POST['password'] ),
                    'nickname'  => ( !empty( $_POST['nickname'] ) ? htmlentities( $_POST['nickname'] ) : 'Invité' )
                ) ); // Sets a new player in game

                $chessmanager->getPlayerManager()->add( $game->getPlayer( ( isset( $_POST['submit' . ucwords( Board::TEAM_BLACK )] ) ? Board::TEAM_BLACK : Board::TEAM_WHITE ) ) ); // Stores player in database
            endif;

            $_SESSION[APP_TAG]['players'][( isset( $_POST['submit' . ucwords( Board::TEAM_BLACK )] ) ? Board::TEAM_BLACK : Board::TEAM_WHITE )] = serialize( $game->getPlayer( ( isset( $_POST['submit' . ucwords( Board::TEAM_BLACK )] ) ? Board::TEAM_BLACK : Board::TEAM_WHITE ) ) ); // Stores player in session
        endif;
    endif;
    /** **/

    /**
     * ---------------------------------------------------------------------------
     * RECOVERY OF GAME
     * ---------------------------------------------------------------------------
    **/
    if( isset( $game ) && is_object( $game ) && get_class( $game )=='Game' )
        if( count( $game->getPlayer() )==2 ) // If we count two opponents,
            if( $chessmanager->game_exists( $game->getPlayer( Board::TEAM_WHITE ), $game->getPlayer( Board::TEAM_BLACK ) ) ) : // If a non finished game exists for these two players,
                $tmp = $chessmanager->recovery( $game->getPlayer( Board::TEAM_WHITE ), $game->getPlayer( Board::TEAM_BLACK ) ); // Recovers a game in database
                if( is_object( $tmp ) && get_class( $tmp )=='Game' ) :
                    $game = $tmp;
                endif;
            else :
                $game->setId( $chessmanager->create() ); // Creates a game
                $chessmanager->join( $game->getId(), $game->getPlayer( Board::TEAM_WHITE ), $game->getPlayer( Board::TEAM_BLACK ) ); // Joins player and game in database
            endif;
    /** **/
} catch( ChessException $e ) {
    die( $e );
} catch( Exception $e ) {
    die( $e->getMessage() );
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0" />
        <title>&#9818; <?php echo ( isset( $sitename ) ? $sitename . ( defined( 'TITLE_SEPARATOR' ) ? TITLE_SEPARATOR : '' ) : '' ) . ( defined( 'SITE_TITLE' ) ? SITE_TITLE : '' ); ?></title>
        
        <style type="text/css">
            <!--
            @import url(style.css);
            -->
        </style>
    </head>
    <body>
        <header role="banner">
            <h1><span style="color:rgb(148,141,125);display:inline-block;margin:-10px -10px 0 0 ;margin:-1rem -1rem 0 0;text-transform:lowercase;vertical-align:top;transform:rotateZ(-45deg);">&#9812;</span><?php echo ( isset( $sitename ) ? $sitename . ( defined( 'TITLE_SEPARATOR' ) ? TITLE_SEPARATOR : '' ) : '' ) . ( defined( 'SITE_TITLE' ) ? SITE_TITLE : '' ); ?></h1>
            <hr />
            <p><em>Pour cet exercice : nous allons recréer un jeu d'échecs simplifié, via des objets.</em></p>
            <p><em>La partie ne peut débuter que lorsque deux joueurs sont connectés.<br />Une partie peut être interrompue en cours de jeu. Vous devez donc proposer un moyen de la reprendre lorsque les deux mêmes joueurs sont à nouveau connectés.<br />Tout au cours de la partie, nous devons disposer de l'historique des coups.</em></p>
            <p><em>Nous ne nous servirons que de quatre types de pièce différents en simplifiant leurs mouvements :</em></p>
            <ul style="font-style:italic;">
                <li><strong>le Roi</strong> : au nombre d'1 pièce par équipe, il peut se déplacer d'1 seule case. Le déplacement peut être soit horizontal soit vertical, en avant ou en arrière. Cette pièce ne peut pas sauter par dessus une autre.</li>
                <li><strong>la Reine</strong> : au nombre d'1 pièce par équipe, elle peut se déplacer d'un nombre de case illimité. Le déplacement peut être soit horizontal soit vertical, en avant ou en arrière. Cette pièce peut sauter par dessus une autre de sa propre couleur mais pas par dessus une pièce adverse.</li>
                <li><strong>les Cavaliers</strong> : au nombre de 2 pièces par équipe, ils peuvent se déplacer de 3 cases. Le déplacement peut être soit horizontal soit vertical, en avant ou en arrière. Cette pièce peut sauter par dessus une autre.</li>
                <li><strong>les Pions</strong> : au nombre de 4 pièces par équipe, ils peuvent se déplacer de 1 case seulement. Le déplacement ne peut être qu'horizontal vers l'avant. Cette pièce ne peut pas sauter par dessus une autre. Une fois arrivée sur la ligne adverse (en bout de plateau), elle permet de récupérer une pièce "mangée" (autre qu'un Pion) en ce changeant en cette dernière.</li>
            </ul>
            <p><em>Comme aux échecs classiques, on joue au tour par tour : honneur aux blancs !<br />Une pièce touchée est une pièce jouée (on ne peut donc pas déselectionner une pièce).<br />La partie s'arrête lorsque l'un des Rois est "Échec et Mat"; à savoir qu'il ne peut plus se déplacer sans risquer d'être "mangé" par une pièce adverse.</em></p>
        </header>
        <section id="easy-chess" role="main">
            <aside id="player-one" role="complementary">
                <fieldset>
                    <legend>Joueur blanc</legend>
                    
                    <?php
                    /** RESTE A FAIRE DANS LE CAS DU MULTIPOSTE **/
                    // Empêcher de se connecter en tant qu'adversaire de soi-même et donc ne pas proposer le deuxième formulaire de connexion si on a choisi une couleur
                    // N'afficher la déconnexion que pour nous, pas pour notre adversaire
                    /** **/

                    if( isset( $_err_connect ) && isset( $_POST['submit' . ucwords( Board::TEAM_WHITE )] ) )
                        echo $_err_connect;

                    $team = Board::TEAM_WHITE;
                    if( isset( $_SESSION[APP_TAG]['players'][$team] ) && $game->getPlayer( $team )!==null ) :
                        $game->getPlayer( $team )->show( ( defined( 'LOCALE_STRING' ) ? LOCALE_STRING : '' ) );
                    ?>
                    <a class="button" href="?abandon=<?php echo $team; ?>" title="">Abandonner la partie</a>
                    <a class="button" href="?destroy=<?php echo $team; ?>" title="">Se déconnecter</a>
                    <?php
                    else : include( 'inc/frm/connect.php' );
                    endif;
                    ?>
                </fieldset>
            </aside>
            <aside id="player-two" role="complementary">
                <fieldset>
                    <legend>Joueur noir</legend>
                    
                    <?php
                    /** RESTE A FAIRE DANS LE CAS DU MULTIPOSTE **/
                    // Empêcher de se connecter en tant qu'adversaire de soi-même et donc ne pas proposer le deuxième formulaire de connexion si on a choisi une couleur
                    // N'afficher la déconnexion que pour nous, pas pour notre adversaire
                    /** **/

                    if( isset( $_err_connect ) && isset( $_POST['submit' . ucwords( Board::TEAM_BLACK )] ) )
                        echo $_err_connect;

                    $team = Board::TEAM_BLACK;
                    if( isset( $_SESSION[APP_TAG]['players'][$team] ) && $game->getPlayer( $team )!==null ) :
                        $game->getPlayer( $team )->show( ( defined( 'LOCALE_STRING' ) ? LOCALE_STRING : '' ) );
                    ?>
                    <a class="button" href="?abandon=<?php echo $team; ?>" title="">Abandonner la partie</a>
                    <a class="button" href="?destroy=<?php echo $team; ?>" title="">Se déconnecter</a>
                    <?php
                    else : include( 'inc/frm/connect.php' );
                    endif;
                    ?>
                </fieldset>
            </aside>
            <article id="board" role="article">
                <?php
                /**
                 * ---------------------------------------------------------------------------
                 * PLAYING THE GAME
                 * ---------------------------------------------------------------------------
                **/
                $_err = $game->play( ( isset( $_GET['piece'] ) ? unserialize( $_GET['piece'] ) : null ), ( isset( $_GET['moveto'] ) ? unserialize( $_GET['moveto'] ) : null ) ); // Display chessboard with pieces
                ?>
            </article>
            <aside id="result" role="complementary">
                <?php if( isset( $_err['code'] ) && is_string( $_err['code'] ) && $_err['code']=='mat' ) : var_dump($_err['code']); ?>
                <a class="button" href="?destroy=game" title="">Nouvelle partie</a>
                <?php endif; ?>
                <hr />
                <h2>Console</h2>
                <div class="result">
                <?php
                /**
                 * ---------------------------------------------------------------------------
                 * INDICATIONS ON THE GAME
                 * ---------------------------------------------------------------------------
                **/
                echo ( isset( $_err['msg'] ) ? $_err['msg'] : '' ); // Display error messages if applicable
                echo ( $game->getHistoric()!==false && !empty( $game->getHistoric() ) ? $game : '' ); // Display history
                ?>
                </div>
            </aside>
        </section>
        <footer role="contentinfo">
            <a class="button" href="?destroy" title="">Réinitialiser tout (mode développement uniquement)</a>
            <span><?php echo date( 'Y' ); ?><sup>&copy;</sup> Tous droits réservés<?php echo ( defined( 'AUTHOR_NAME' ) ? ' - ' . AUTHOR_NAME : '' ); ?></span>
        </footer>
    </body>
</html>
<?php
/**
 * ---------------------------------------------------------------------------
 * BACKUP OF GAME
 * ---------------------------------------------------------------------------
**/
if( isset( $game ) ) :
    $_SESSION[APP_TAG]['game'] = serialize( $game ); // Stores the game in session
    
    if( count( $game->getPlayer() )==2 ) // If we count two opponents,
        $chessmanager->backup( $game ); // Saves the game
endif;