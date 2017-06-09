<?php
session_start();
require( 'common.php' );
/*
Que veux dire "je suis connecté" ?
    Est-ce que mon couple identifiant/mot de passe existe en base de données ?
        1 - Je dois me connecter à ma base de données
        2 - Je dois effectuer une requête sur tous les utilisateurs avec comme critère identifiant + mot de passe
        3 - Récupèrer les données si il y a correspondance
    Si oui :
        Je m'enregistre comme connecté
*/
try { // On essaie de faire
    $_pdo = connectDB();

    if( isset( $_POST['login'] ) && isset( $_POST['pwd'] ) ) {
        if( $_POST['login']!='' && $_POST['pwd']!='' ) {
            if( ( $requete = $_pdo->prepare( '
SELECT `user`.`firstname`, `user`.`lastname`, `user`.`login`, `role`.*, GROUP_CONCAT( CONCAT( `capability`.`id`, ",", `capability`.`lbl`, ",", `capability`.`link` ) SEPARATOR ";" ) AS autorisations
FROM `user`
JOIN `role` ON `role_fk`=`role`.`id`
LEFT JOIN `rel_role_capability` ON `role`.`id`=`rel_role_capability`.`role`
LEFT JOIN `capability` ON `rel_role_capability`.`capability`=`capability`.`id`
WHERE `login`=:identifiant AND `pwd`=:pass' ) )!==false ) {
                if( $requete->bindValue( 'identifiant', htmlentities( $_POST['login'] ) ) && $requete->bindValue( 'pass', htmlentities( $_POST['pwd'] ) ) ) {
                    if( $requete->execute() ) {
                        $user = $requete->fetch( PDO::FETCH_ASSOC );
                        if( $user!==false ) {
                            $_SESSION['monappconnexion'] = $user;
                        }
                    }
                }
            }
        } else {
            redirect( 'login.php?error=vide' );
        }
    }
/*

Si je suis connecté :
*/
if( isset( $_SESSION['monappconnexion']['login'] ) && $_SESSION['monappconnexion']['login']!='' ) {
?><!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Espace d'administration "sécurisé"</title>
    </head>
    <body>
        <h1>Espace d'administration "sécurisé"</h1>
        <hr>
        <p>Bonjour <?php echo $_SESSION['monappconnexion']['firstname'] . ' ' . $_SESSION['monappconnexion']['lastname']; ?> et bienvenue sur votre espace d'administration "sécurisé"</p>
        <?php
        echo isset( $_GET['error'] ) ? manageError( $_GET['error'] ) : '';

        /*
        Ai-je le droit de faire des actions ?
            Quelles sont mes autorisations ?
                1 - Je dois me connecter à ma base de données
                2 - Je dois effectuer une requête sur tous les la relation entre moi et les autorisation avec comme critère mon role
                3 - Récupèrer les données si il y a correspondance
        */
        ?>
        <ul>
        <?php
        if( !is_null( $_SESSION['monappconnexion']['autorisations'] ) ) {
            $autorisations = explode( ';', $_SESSION['monappconnexion']['autorisations'] );
            if( isset( $autorisations ) && is_array( $autorisations ) && count( $autorisations )>0 ) {

                foreach( $autorisations as $value ) {
                    $autorisation = explode( ',', $value );
                    echo '<li><a href="' . $autorisation[2] . '" title="">' . $autorisation[1] . '</a></li>';
                }

            }
        }
        ?>
            <li><a href="login.php?deconnect" title="">Se déconnecter</a></li>
        </ul>
    </body>
</html>
<?php
    /*
    Sinon :
        Je renvoie l'utilisateur vers le formulaire de connexion
    */
    } else {
        redirect( 'login.php?error=connect' );
    }

} catch( PDOException $_e ) { // Dans le cas d'un échec, on récupère l'exception
    die( $_e->getMessage() ); // On tue le processus et affiche le message d'erreur.
}