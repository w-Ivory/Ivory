<?php
require( 'ini.php' );
require( 'common.php' );

try { // On essaie de faire,
    $obj_characterManager = new CharacterManager( DB_HOST, DB_NAME, DB_LOGIN, DB_PWD ); // On instancie un objet de classe CharacterManager
    
    /**
     * --------------------------------------------------
     * NOUVELLE PARTIE
     * --------------------------------------------------
    **/
    if( isset( $_GET['destroy'] ) ) : // Si la clé "destroy" est passée en paramètre dans l'URL,
        if( defined( 'APP_TAG' ) )
            unset( $_SESSION[APP_TAG] ); // On détruit la session pour vider l'historique

        $obj_characterManager->reset(); // On détruit la table des personnages
        header( 'Location: .' ); // On utilise la fonction "header" pour rediriger vers la racine du code en cours
    endif;
    /** **/

    /**
     * --------------------------------------------------
     * CRÉATION DE PERSONNAGE
     * --------------------------------------------------
    **/
    if( isset( $_POST['submitCreate'] ) ) : // Si on soumet un nouveau participant,
        $obj_character = new Character( array( // On instancie un nouvel objet de la classe Character
            'name'      => ( isset( $_POST['name'] ) && str_replace( "\x20", '', $_POST['name'] )!='' ? $_POST['name'] : 'Inconnu' ),
            'damages'   => ( defined( 'Character::LIFE_MIN' ) ? Character::LIFE_MIN : 0 ),
            'css'   => ( isset( $_POST['css'] ) && str_replace( "\x20", '', $_POST['css'] )!='' ? $_POST['css'] : ( defined( 'DEFAULT_AVATAR_CSS' ) ? DEFAULT_AVATAR_CSS : '' ) )
        ) );
        if( !$obj_characterManager->record_exists( $obj_character->getName() ) ) // Si le personnage n'existe pas déjà,
            $obj_characterManager->add( $obj_character ); // On utilise le manager pour l'ajouter dans la table correspondante
    endif;
    /** **/

    /**
     * --------------------------------------------------
     * SÉLECTION DE PERSONNAGE
     * --------------------------------------------------
    **/
    if( isset( $_SESSION[APP_TAG]['character'] ) ) // Si la session "character" existe,
        $obj_character = unserialize( $_SESSION[APP_TAG]['character'] ); // On restaure l'objet

    if( isset( $_POST['submitUse'] ) && isset( $_POST['name'] ) && $obj_characterManager->record_exists( $_POST['name'] ) ) // Si on choisit un nouveau participant déjà existant,
        $obj_character = $obj_characterManager->get( $_POST['name'] ); // On remplace le participant actif avec les données du manager
    /** **/

    /**
     * --------------------------------------------------
     * MISE À JOUR DE PERSONNAGE
     * --------------------------------------------------
    **/
    if( isset( $_GET['hit'] ) && isset( $obj_character ) && $obj_characterManager->record_exists( $_GET['hit'] ) ) : // Si la clé "hit" est passée en paramètre dans l'URL et que le personnage existe,
        $obj_ai = $obj_characterManager->get( $_GET['hit'] ); // On instancie le combattant géré par l'IA

        switch( $obj_character->hit( $obj_ai ) ) : // Selon les erreurs possibles,
            case Character::MYSELF : // Cas "le personnage se frappe lui-même":
                $_err = 'Tu es plus con que nature à vouloir te frapper toi-même non ???<br />Je te rassure tu n\'as pris aucun dégâts, débile !';
                break;
            case Character::AVOID : // Cas "le personnage esquive l'attaque":
                $_err = $obj_ai->getName() . ' a réussi à esquiver !'; // On prépare le message de retour
                break;
            case Character::ESCAPE : // Cas "le personnage fuit le combat":
                if( $obj_characterManager->update( $obj_ai ) ) // Si on met à jour le personnage frappé
                    $_err = $obj_ai->getName() . ' a fuit le combat !<br />Vous pouvez toujours retenter de l\'attaquer à nouveau mais il risque de s\'être soigné entre temps.'; // On prépare le message de retour
                else
                    $_err = 'Erreur de traitement';
                break;
            case Character::BLOCK : // Cas "le personnage pare l'attaque":
                if( $obj_characterManager->update( $obj_ai ) ) // On met à jour le personnage frappé
                    $_err = $obj_ai->getName() . ' pare l\'attaque !<br />Ses dégâts sont diminués par ' . Character::BLOCK_BONUS; // On prépare le message de retour
                else
                    $_err = 'Erreur de traitement';
                break;
            case Character::HIT : // Cas "l'attaque du personnage porte":
                if( $obj_characterManager->update( $obj_ai ) ) // On met à jour le personnage frappé
                    $_err = $obj_ai->getName() . ' a bien été frappé !'; // On prépare le message de retour
                else
                    $_err = 'Erreur de traitement';
                break;
            case Character::KO : // Cas "le personnage est mis K.O.":
                if( $obj_characterManager->delete( $_GET['hit'] ) ) // On supprime l'enregistrement du personnage éliminé
                    $_err = $obj_ai->getName() . ' a été mis K.O. !'; // On prépare le message de retour
                else
                    $_err = 'Erreur de traitement';
                break;
        endswitch;
    endif;
    /** **/

    $list = $obj_characterManager->getList();
} catch( CharacterException $e ) {
    die( $e );
} catch( PDOException $e ) {
    die( $e->getMessage() );
} catch( Exception $e ) {
    die( $e->getMessage() );
}
?><!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0" />
        <title><?php echo ( isset( $sitename ) ? $sitename . ( defined( 'TITLE_SEPARATOR' ) ? TITLE_SEPARATOR : '' ) : '' ) . ( defined( 'SITE_TITLE' ) ? SITE_TITLE : '' ); ?></title>
        
        <style type="text/css">
            <!--
            @import url(style.css);
            -->
        </style>
    </head>
    <body class="background">
        <header role="banner">
            <img alt="" id="logo" src="<?php echo ( defined( 'ASSETSURL' ) ? ASSETSURL : '' ) . 'images/logo_streetfighterO3W.png'; ?>" />
        </header>
        <aside role="complementary">
            <p><em></em></p>
            <a class="button" href="?destroy" title="">&otimes; Nouvelle partie</a>
            <div class="grid-wrapper">
                <div class="grid12 x6">
                    <fieldset>
                        <legend>Créez votre combattant</legend>

                        <form action="<?php echo dirname( $_SERVER['PHP_SELF'] ) . '/'; ?>" data-role="formulaire" method="post">
                            <span data-role="wrapper">
                                <label class="required" data-role="label" for="txt-name">Saisissez le nom d'un personnage pour le créer</label>
                                <input id="txt-name" maxlength="50" name="name" required="required" type="text" value="" />
                            </span>
                            <span data-role="wrapper">
                                <label data-role="label">Personnalisez le CSS de votre personnage avec un box-shadow en pixel art</label>
                                <span>Hauteur max. : 240px</span>
                                <textarea id="txt-css-thumb" name="css"><?php echo ( defined( 'DEFAULT_AVATAR_CSS' ) ? DEFAULT_AVATAR_CSS : '' ); ?></textarea>
                            </span>
                            <input class="button" name="submitCreate" type="submit" value="Créer ce personnage" />
                        </form>
                    </fieldset>
                </div>
                <?php if( !empty( $list ) ) : // S'il existe des personnages déjà créés, ?>
                <div class="grid12 x3">
                    <fieldset>
                        <legend>Choisissez un combattant existant</legend>

                        <form action="<?php echo dirname( $_SERVER['PHP_SELF'] ) . '/'; ?>#street-fighter" data-role="formulaire" method="post">
                            <label class="required" data-role="label" for="list-name">Quel personnage voulez-vous incarner ?</label>
                            <span data-role="wrapper">
                                <select id="list-name" name="name" required="required">
                                    <?php /* <option selected="selected" disabled="disabled"><?php echo htmlspecialchars( $o_perso->getName() ) . ' (dégâts : ' . $o_perso->getDamages() . ')'; ?></option> */ ?>
                                    <?php foreach( $list as $row ) : // Pour chaque ligne du jeu de résultat, ?>
                                    <option<?php if( isset( $obj_character ) && $obj_character->getName()==$row->getName() ) : echo ' selected="selected"'; endif; ?> value="<?php echo $row->getName(); ?>"><?php echo htmlspecialchars( $row->getName() ) . ' (dégâts : ' . $row->getDamages() . ')'; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </span>
                            <input data-role="submit" name="submitUse" type="submit" value="Utiliser ce personnage" />
                            <br /><span class="text-quote">(*) Champs requis</span>
                            <?php /* ?>
                            <div style="clear:both;">
                                <?php foreach( $list as $row ) : // Pour chaque ligne du jeu de résultat, ?>
                                <div style="display:inline-block;vertical-align:top;">
                                    <span class="title"><?php echo htmlspecialchars( $row->getName() ); ?></span>
                                    <p class="text"><?php echo 'Points de vie : ' . ( Character::LIFE_MAX - $row->getDamages() ) . '/' . Character::LIFE_MAX; ?></p>
                                    <div class="avatar"<?php $row->displayCss(); ?>></div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                            <?php */ ?>
                        </form>
                    </fieldset>
                </div>
                <?php endif; ?>
                <?php if( isset( $obj_character ) ) : ?>
                <div class="grid12 x3">
                    <fieldset>
                        <legend>Mes informations</legend>

                        <?php echo $obj_character; ?>
                    </fieldset>
                </div>
                <?php endif; ?>
            </div>
        </aside>
        <section id="street-fighter" role="main">
            <?php if( isset( $obj_character ) ) : ?>
            <fieldset>
                <legend class="center">Combat VS.</legend>
                <?php
                if( isset( $_err ) ) // S'il y a des messages de retour et/ou d'erreur,
                    echo '<p class="alert">' . $_err . '</p>';
                ?>
                <ul class="list">
                    <?php foreach( $list as $row ) : // Pour chaque ligne du jeu de résultat, ?>
                    <li class="item <?php echo ( count( $list )%5===0 ? 'x5' : ( count( $list )%3===0 ? 'x3' : 'x2' ) ); ?>">
                        <a class="link" href="?hit=<?php echo $row->getName(); ?>#street-fighter" title="<?php echo htmlspecialchars( $row->getName() ); ?>">
                            <span class="title"><?php echo htmlspecialchars( $row->getName() ); ?></span>
                            <p class="text"><?php echo 'Points de vie : ' . ( Character::LIFE_MAX - $row->getDamages() ) . '/' . Character::LIFE_MAX; ?></p>
                            <div class="avatar"<?php $row->displayCss(); ?>></div>
                        </a>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </fieldset>
            <?php endif; ?>
        </section>
        <footer role="contentinfo">
            <span>&copy;<?php echo date( 'Y' ) . ( defined( 'AUTHOR_NAME' ) ? ' ' . AUTHOR_NAME : '' ); ?> - Tous droits réservés</span>
        </footer>
    </body>
</html>
<?php
if( isset( $obj_character ) ) // Si on utilise un personnage,
    $_SESSION[APP_TAG]['character'] = serialize( $obj_character ); // On le stocke dans une variable session afin d'économiser une requête SQL