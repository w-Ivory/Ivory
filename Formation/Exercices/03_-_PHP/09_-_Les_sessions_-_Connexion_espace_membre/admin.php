<?php
session_start(); // On autorise la page à accéder à la superglobale de session (http://php.net/manual/fr/function.session-start.php).

$page = '../09_-_Les_sessions_-_Connexion_espace_membre.php';

if( isset( $_GET ) && array_key_exists( 'destroy', $_GET ) ) : // Si la clé "destroy" est passée en paramètre dans l'URL,
    unset( $_SESSION['connexion'] ); // On détruit la session pour vider l'historique (http://php.net/manual/fr/function.session-destroy.php).
    header( 'Location: ' . $page ); // On utilise la fonction "header" pour rediriger vers la racine du code en cours (http://php.net/manual/fr/function.header.php).
    exit();
endif;

$tabUsers = [ // On construit le tableau de données utilisateurs.
    [ 'login'=>'su', 'pwd'=>'su@pwd', 'nom'=>'Objectif 3W', 'pnom'=>'Webmaster', 'role'=>'superadmin' ],
    [ 'login'=>'admin', 'pwd'=>'admin@pwd', 'nom'=>'Nebuchadnezzar', 'pnom'=>'Morpheus', 'role'=>'admin' ],
    [ 'login'=>'user', 'pwd'=>'user@pwd', 'nom'=>'Anderson', 'pnom'=>'Thomas A.', 'role'=>'invite' ]
];

/**
 * userExist - Parcours un tableau pour tester l'existence des données à des clés spécifiques
 * @param   array $needle
 * @param   array $haystack
 * @return  mixed (array / bool)
**/
function userExist( $needle, $haystack ) {
    foreach( $haystack as $item ) : // Pour chaque utilisateur du tableau,
        if( $needle['login']==$item['login'] && $needle['pwd']==$item['pwd'] ) return $item; // Si le couple identifiant/mot de passe correspond, on attribue l'utilisateur courant.
    endforeach;

    return false;
}

if( isset( $_POST ) && count( $_POST )>0 ) : // Si on a soumis des données via notre formulaire,
    unset( $_SESSION['connexion'] ); // On détruit la session de connexion.

    if( array_key_exists( 'login', $_POST ) && $_POST['login']!='' && array_key_exists( 'pwd', $_POST ) && $_POST['pwd']!='' ) : // Si le couple identifiant/mot de passe est renseigné,
        $user = userExist( $_POST, $tabUsers ); // On teste l'existence du couple identifiant/mot de passe saisi.
        
        if( $user!==false ) : // Si l'utilisateur existe,
            $_SESSION['connexion'] = array( '_err'=>array( 'code'=>'connecte', 'msg'=>'<span style="background-color:green;color:white;display:block;margin:10px 0;padding:4px 7px;">Vous êtes connecté !</span>' ), 'nom'=>$user['nom'], 'pnom'=>$user['pnom'], 'role'=>$user['role'] ); // On stocke en session les informations qui nous intéressent.
        else : // Sinon,
            $_SESSION['connexion'] = array( '_err'=>array( 'code'=>'all', 'msg'=>'<span style="background-color:orange;color:white;display:block;margin:10px 0;padding:4px 7px;">Mauvais identifiant/mot de passe !</span>' ), 'login'=>$_POST['login'] ); // On stocke en session les données d'erreur.
            header( 'Location: ' . $page ); // On utilise la fonction "header" pour rediriger vers la racine du code en cours (http://php.net/manual/fr/function.header.php).
            exit();
        endif;
    else :
        $_SESSION['connexion']['_err'] = array( 'code'=>'all', 'msg'=>'<span style="background-color:red;color:white;display:block;margin:10px 0;padding:4px 7px;">Vous devez saisir un identifiant et un mot de passe !</span>' );

        if( array_key_exists( 'login', $_POST ) && $_POST['login']!='' ) // Si un login est saisi mais pas de mot de passe,
            $_SESSION['connexion'] = array( '_err'=>array( 'code'=>'pwd', 'msg'=>'<span style="background-color:red;color:white;display:block;margin:10px 0;padding:4px 7px;">Vous devez saisir un mot de passe !</span>' ), 'login'=>$_POST['login'] );

        if( array_key_exists( 'pwd', $_POST ) && $_POST['pwd']!='' ) // Si un mot de passe est saisi mais pas l'identifiant,
            $_SESSION['connexion']['_err'] = array( 'code'=>'login', 'msg'=>'<span style="background-color:red;color:white;display:block;margin:10px 0;padding:4px 7px;">Vous devez saisir un identifiant !</span>' );

        header( 'Location: ' . $page ); // On utilise la fonction "header" pour rediriger vers la racine du code en cours (http://php.net/manual/fr/function.header.php).
        exit();
    endif;
else :
    if( !( isset( $_SESSION ) && array_key_exists( 'connexion', $_SESSION ) && ( array_key_exists( 'pnom', $_SESSION['connexion'] ) || array_key_exists( 'nom', $_SESSION['connexion'] ) ) ) ) :
        header( 'Location: ' . $page ); // On utilise la fonction "header" pour rediriger vers la racine du code en cours (http://php.net/manual/fr/function.header.php).
        exit();
    endif;
endif;
?><!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0" />
        <title>Connexion à un espace membre | Les sessions - Mise en pratique</title>
    </head>
    <body>
        <h1>Espace membre</h1>
        <hr />
        <?php if( isset( $_SESSION ) && array_key_exists( 'connexion', $_SESSION ) ) : // Si la session de connexion existe, ?>
        <?php if( array_key_exists( 'pnom', $_SESSION['connexion'] ) || array_key_exists( 'nom', $_SESSION['connexion'] ) ) : // Si elle contient un nom et/ou un prénom, ?>
        <h2>Bonjour<?php echo array_key_exists( 'pnom', $_SESSION['connexion'] ) ? ' ' . $_SESSION['connexion']['pnom'] . ( array_key_exists( 'nom', $_SESSION['connexion'] ) ? ' ' . $_SESSION['connexion']['nom'] : '' ) : ( array_key_exists( 'nom', $_SESSION['connexion'] ) ? ' ' . $_SESSION['connexion']['nom'] : '' ); ?> !</h2>
        <?php endif; ?>
        <br />
        <ul>
            <li><a href="<?php echo $page; ?>" title="">Accueil</a></li>
            <?php
            if( array_key_exists( 'role', $_SESSION['connexion'] ) ) :
                switch( $_SESSION['connexion']['role'] ) :
                    case 'superadmin':
            ?>
            <li><a href="https://www.google.fr/webhp?sourceid=chrome-instant&ion=1&espv=2&ie=UTF-8#q=super%20administrateur" target="_blank" title="">Super Administrateur</a></li>
            <?php
                        break;
                    case 'admin':
            ?>
            <li><a href="https://www.google.fr/webhp?sourceid=chrome-instant&ion=1&espv=2&ie=UTF-8#q=administrateur" target="_blank" title="">Administrateur</a></li>
            <?php
                        break;
                    default :
            ?>
            <li><a href="https://www.google.fr/webhp?sourceid=chrome-instant&ion=1&espv=2&ie=UTF-8#q=ne+sert+%C3%A0+rien" target="_blank" title="">Lien qui ne sert à rien</a></li>
            <?php
                endswitch;
            endif;
            ?>
            <li><a href="?destroy" title="">Se déconnecter</a></li>
        </ul>
        <?php endif; ?>
    </body>
</html>