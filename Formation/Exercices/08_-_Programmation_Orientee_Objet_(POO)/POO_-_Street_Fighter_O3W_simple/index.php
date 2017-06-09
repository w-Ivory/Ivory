<?php
require( 'ini.php' );
require( 'common.php' );

$manager = new CharacterManager( DB_SCHEME, DB_HOST, DB_NAME, DB_LOGIN, DB_PWD );

if( isset( $_GET['destroy'] ) ) :
    unset( $_SESSION['moi'] );
    $manager->reset();
    header( 'Location: ' . $_SERVER['PHP_SELF'] );
    exit();
endif;

if( isset( $_POST['submitCreate'] ) && isset( $_POST['name'] ) && !empty( $_POST['name'] ) ) : // si je soumets le formulaire de création et que j'ai soumis un nom valide
    if( !$manager->record_exists( $_POST['name'] ) ) : // si le personnage n'existe pas déjà dans la base de données
        $perso = new Character( $_POST['name'], Character::DAMAGE_INIT ); // je dois instancier un nouveau personnage
        if( $manager->add( $perso ) ) : // si je l'ajoute en base de données
            $msg = 'Personnage ' . $_POST['name'] . ' ajouté';
            unset( $perso );
        else :
            $msg = 'Erreur pendant la création du personnage' . $_POST['name'];
        endif;
    else :
        $msg = 'Utilisateur ' . $_POST['name'] . ' existe déjà';
    endif;
endif;

if( isset( $_SESSION['moi'] ) )
    $moi = unserialize( $_SESSION['moi'] );

if( isset( $_POST['submitUse'] ) && isset( $_POST['name'] ) && !empty( $_POST['name'] ) ) : // si je soumets le formulaire de sélection et que j'ai soumis un nom valide
    if( $manager->record_exists( $_POST['name'] ) ) : // si le personnage existe dans la base de données
        if( ( $perso = $manager->getUniq( $_POST['name'] ) )!==false ) : // je récupère ses informations pour le manipuler sur l'arène de combat
            $moi = new Character( $perso['name'], $perso['damages'] );
        endif;
    else :
        $msg = 'Utilisateur ' . $_POST['name'] . ' n\'existe pas';
    endif;
endif;

if( isset( $_GET['hit'] ) ) : // si je frappe un personnage
    if( isset( $moi ) ) : // si un personnage attaquant est sélectionné
        if( $manager->record_exists( $_GET['hit'] ) ) : // si le personnage existe dans la base de données
            if( ( $perso = $manager->getUniq( $_GET['hit'] ) )!==false ) : // je récupère ses informations pour le manipuler sur l'arène de combat
                $autre = new Character( $perso['name'], $perso['damages'] ); // je dois instancier un nouveau personnage

                $result = $moi->hit( $autre ); // je frappe l'autre personnage
                switch( $result ) :
                    case 'KO':
                        if( $manager->delete( $autre->getName() ) ) // je supprime le personnage frappé dans la base de données
                            $msg = $result . '<br />Le personnage est supprimé';
                        break;
                    case 'Frappe sur moi-même':
                        $msg = $result . '<br />Aucun dégât';
                        break;
                    default:
                        if( $manager->update( $autre ) ) // je mets à jour le personnage frappé dans la base de données
                            $msg = $result . '<br />Le personnage est modifié';
                endswitch;
            endif;
        else :
            $msg = 'Utilisateur ' . $_GET['hit'] . ' n\'existe pas';
        endif;
    else :
        $msg = 'Veuillez choisir en premier un personnage a incarné';
    endif;
endif;

$list = $manager->getAll( 'object' );
        
?><!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0" />
        <title>Street Fighter</title>
    </head>
    <body>
        <!--
        /**
         * --------------------------------------------------
         * CRÉATION DE PERSONNAGE
         * --------------------------------------------------
        **/
        -->
        <fieldset>
            <legend>Créez votre combattant</legend>
            <?php
            if( isset( $msg ) ) echo $msg;
            ?>

            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <label for="txt-name">Saisissez le nom d'un personnage pour le créer</label>
                <input id="txt-name" maxlength="50" name="name" required="required" type="text">

                <input name="submitCreate" type="submit" value="Créer ce personnage">
            </form>
        </fieldset>
        <!-- // -------------------------------------------------- -->

        <?php if( isset( $list ) && count( $list )>0 ) : ?>
        <?php if( count( $list )>1 ) : ?>
        <!--
        /**
         * --------------------------------------------------
         * SÉLECTION DU PERSONNAGE ACTIF
         * --------------------------------------------------
        
         Récupérer mes personnages pour les afficher
         - Interroger la bdd
         - Récupérer le jeu de résultat
         - Pour chaque personnage : l'afficher dans la liste
        **/
        -->
        <fieldset>
            <legend>Choisissez votre combattant parmis les <?php echo Character::getCount(); ?></legend>

            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <label for="list-name">Quel personnage voulez-vous incarner ?</label>
                <select id="list-name" name="name" required="required">
                    <?php foreach( $list as $character ) : ?>
                    <option<?php if( isset( $moi ) && $character->getName()==$moi->getName() ) { echo ' selected'; } ?> value="<?php echo $character->getName(); ?>"><?php echo $character->getOrder() . ' - ' . $character->getName(); ?></option>
                    <?php endforeach; ?>
                </select>
                <input name="submitUse" type="submit" value="Utiliser ce personnage">
            </form>
        </fieldset>
        <!-- // -------------------------------------------------- -->
        <?php endif; ?>
        
        <!--
        /**
         * --------------------------------------------------
         * SÉLECTION DU PERSONNAGE CIBLÉ
         * --------------------------------------------------
        **/
        -->
        <fieldset>
            <legend>Aire de combat</legend>

            <?php foreach( $list as $character ) : ?>
            <a href="?hit=<?php echo $character->getName(); ?>"><?php echo $character->getOrder() . '/' . $character->getCount() . ' - ' . $character->getName(); ?></a> (dégâts : <?php echo $character->getDamages(); ?>)<br />
            <?php endforeach; ?>
        </fieldset>
        <!-- // -------------------------------------------------- -->
        <?php endif; ?>

        <!--
        /**
         * --------------------------------------------------
         * NOUVELLE PARTIE (RÉINITIALISATION)
         * --------------------------------------------------
        **/
        -->
        <a href="?destroy" title="">Nouvelle partie</a>
        <!-- // -------------------------------------------------- -->
    </body>
</html>
<?php
if( isset( $moi ) )
    $_SESSION['moi'] = serialize( $moi );