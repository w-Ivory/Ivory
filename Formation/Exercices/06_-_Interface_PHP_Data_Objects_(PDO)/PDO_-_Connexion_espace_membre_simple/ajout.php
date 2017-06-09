<?php
session_start();
require( 'common.php' );
/*
Si je suis connecté :
*/
if( isset( $_SESSION['monappconnexion']['login'] ) && $_SESSION['monappconnexion']['login']!='' ) {
if( !is_null( $_SESSION['monappconnexion']['autorisations'] ) ) {
    $autorisations = explode( ';', $_SESSION['monappconnexion']['autorisations'] );
    if( isset( $autorisations ) && is_array( $autorisations ) && count( $autorisations )>0 ) {
        $quiALeDroit = false;
        foreach( $autorisations as $value ) {
            $autorisation = explode( ',', $value );
            if( $autorisation[0] == 2 ) {
                $quiALeDroit = true;
                break;
            }
        }

        if( !$quiALeDroit ) {
            redirect( 'admin.php?error=cap' );
        }
    }



    try { // On essaie de faire
        $_pdo = connectDB();

?><!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Ajouter un utilisateur</title>
    </head>
    <body>
        <h1>Ajouter un utilisateur</h1>
        <a href="login.php?deconnect" title="">Se déconnecter</a>
        <hr>
        <?php
        if( isset( $_POST['create'] ) ) {
            if( isset( $_POST['login'] ) && !empty( $_POST['login'] ) && isset( $_POST['pwd'] ) && !empty( $_POST['pwd'] ) && isset( $_POST['lastname'] ) && !empty( $_POST['lastname'] ) && isset( $_POST['firstname'] ) && !empty( $_POST['firstname'] ) && isset( $_POST['role'] ) && $_POST['role']!=='' ) {
                
                if( ( $requete = $_pdo->prepare( 'SELECT `power` FROM `role` WHERE `id`=:role' ) )!==false ) {
                    if( $requete->bindValue( 'role', htmlentities( $_POST['role'] ) ) ) {
                        if( $requete->execute() ) {
                            $power = $requete->fetch( PDO::FETCH_ASSOC );
                            if( $power!==false ) {
                                var_dump($power);var_dump($_SESSION['monappconnexion']['power']);
                                if( $_SESSION['monappconnexion']['power']>=$power['power'] ) {
                                    $role = $_SESSION['monappconnexion']['id'];
                                } else {
                                    $role = htmlentities( $_POST['role'] );
                                }


                                if( ( $requete = $_pdo->prepare( 'INSERT INTO `user` (`login`, `pwd`, `lastname`, `firstname`, `role_fk`) VALUES (:login, :pwd, :lastname, :firstname, :role)' ) )!==false ) {
                                    if( $requete->bindValue( 'login', htmlentities( $_POST['login'] ) )
                                    && $requete->bindValue( 'pwd', htmlentities( $_POST['pwd'] ) )
                                    && $requete->bindValue( 'lastname', htmlentities( $_POST['lastname'] ) )
                                    && $requete->bindValue( 'firstname', htmlentities( $_POST['firstname'] ) )
                                    && $requete->bindValue( 'role', $role ) ) {
                                        if( $requete->execute() ) {
                                            echo 'Utilisateur ajouté';
                                        } else {
                                            echo 'Une erreur est survenue';
                                        }
                                    } else {
                                        echo 'Une erreur est survenue';
                                    }
                                } else {
                                    echo 'Une erreur est survenue';
                                }
                            } else {
                                echo 'Une erreur est survenue';
                            }
                        } else {
                            echo 'Une erreur est survenue';
                        }
                    } else {
                        echo 'Une erreur est survenue';
                    }
                } else {
                    echo 'Une erreur est survenue';
                }
            } else {
                echo 'Veuillez compléter entièrement le formulaire';
            }
        }
        ?>
        <form method="post">
            <label for="txt-login">Login</label>
            <input id="txt-login" name="login" type="text">
            <label for="txt-pwd">Mot de passe</label>
            <input id="txt-pwd" name="pwd" type="password">
            <label for="txt-lastname">Nom</label>
            <input id="txt-lastname" name="lastname" type="text">
            <label for="txt-firstname">Prénom</label>
            <input id="txt-firstname" name="firstname" type="text">
            <label for="list-role">Rôle</label>
            <select id="list-role" name="role">
            <?php
            if( ( $requete = $_pdo->prepare( 'SELECT * FROM `role` WHERE `power`>=:mapuissance ORDER BY `power` ASC' ) )!==false ) {
                if( $requete->bindValue( 'mapuissance', htmlentities( $_SESSION['monappconnexion']['power'] ) ) ) {
                    if( $requete->execute() ) {
                        while( ( $role = $requete->fetch( PDO::FETCH_ASSOC ) )!==false ) {
                            echo '<option value="' . $role['id'] . '">' . $role['lbl'] . '</option>';
                        }
                        
                    }
                }
            }
            ?>
            </select>

            <input type="submit" name="create">
        </form>
    </body>
</html>
<?php
    } catch( PDOException $_e ) { // Dans le cas d'un échec, on récupère l'exception
        die( $_e->getMessage() ); // On tue le processus et affiche le message d'erreur.
    }
} else {
    redirect( 'admin.php?error=cap' );
}
/*
Sinon :
    Je renvoie l'utilisateur vers le formulaire de connexion
*/
} else {
    redirect( 'login.php?error=connect' );
}