<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Interface PHP Data Objects (PDO)</title>
    </head>
    <body>
        <h1>Interface PHP Data Objects (PDO)</h1>
        <hr />
        <form method="post">
            <label>Rang</label>
            <select name="rang">
                <option>super</option>
                <option>admin</option>
                <option>none</option>
            </select>

            <label>Année</label>
            <input type="text" name="annee">

            <input type="submit" value="Envoyer">
        </form>
        <?php
        try {
            $maConnexion = new PDO( 'mysql:host=localhost;dbname=cours_forum;charset=utf8', 'root', '', array(
                PDO::MYSQL_ATTR_INIT_COMMAND    => 'SET NAMES utf8 COLLATE utf8_general_ci',
                PDO::ATTR_ERRMODE               => PDO::ERRMODE_EXCEPTION
            ) );
            if( isset( $_POST['rang'] ) ) {
                // if( ( $etat = $maConnexion->query( 'SELECT * FROM `user`' ) )!==false ) {
                //     // echo '
                //     // <table border="1">
                //     //     <thead>
                //     //     <tr>
                //     //         <th>Nom</th>
                //     //         <th>Prenom</th>
                //     //         <th>Login</th>
                //     //     </tr>
                //     //     </thead>
                //     //     <tbody>';
                //     // while( ( $resultats = $etat->fetch( PDO::FETCH_ASSOC ) )!==false ) {
                //     //     echo '
                //     //     <tr>
                //     //         <td>' . $resultats['u_nom'] . '</td>
                //     //         <td>' . $resultats['u_prenom'] . '</td>
                //     //         <td>' . $resultats['u_login'] . '</td>
                //     //     </tr>';
                //     // }
                //     // echo '
                //     //     </tbody>
                //     // </table>';

                //     $resultats = $etat->fetchAll( PDO::FETCH_ASSOC );
                //     if( count( $resultats )>0 ) {
                //     echo '
                //     <table border="1">
                //         <thead>
                //         <tr>
                //             <th>Nom</th>
                //             <th>Prenom</th>
                //             <th>Login</th>
                //         </tr>
                //         </thead>
                //         <tbody>';
                //     foreach( $resultats as $result ) {
                //         echo '
                //         <tr>
                //             <td>' . $result['u_nom'] . '</td>
                //             <td>' . $result['u_prenom'] . '</td>
                //             <td>' . $result['u_login'] . '</td>
                //         </tr>';
                //     }
                //     echo '
                //         </tbody>
                //     </table>';
                //     }
                // } else {
                //     echo 'Un problème est survenu dans l\'exécution de la requête !';
                // }

                if( ( $etat = $maConnexion->prepare( 'SELECT * FROM `user` JOIN `rang` ON `u_rang_fk`=`r_id` WHERE `r_libelle`=:rang AND YEAR(`u_date_naissance`)<:annee' ) )!==false ) {
                    if( $etat->bindValue( 'rang', htmlentities( $_POST['rang'] ) ) && $etat->bindValue( 'annee', htmlentities( $_POST['annee'] ) ) ) {
                        if( $etat->execute() ) {
                            $resultats = $etat->fetchAll( PDO::FETCH_ASSOC );
                            if( count( $resultats )>0 ) {
                            echo '
                            <table border="1">
                                <thead>
                                <tr>
                                    <th>Nom</th>
                                    <th>Prenom</th>
                                    <th>Login</th>
                                    <th>Année</th>
                                    <th>Rang</th>
                                </tr>
                                </thead>
                                <tbody>';
                            foreach( $resultats as $result ) {
                                echo '
                                <tr>
                                    <td>' . $result['u_nom'] . '</td>
                                    <td>' . $result['u_prenom'] . '</td>
                                    <td>' . $result['u_login'] . '</td>
                                    <td>' . $result['u_date_naissance'] . '</td>
                                    <td>' . $result['r_libelle'] . '</td>
                                </tr>';
                            }
                            echo '
                                </tbody>
                            </table>';
                            }
                        } else {
                            echo 'Un problème est survenu dans l\'exécution de la requête !';
                        }
                    } else {
                        echo 'Un problème est survenu dans la préparation des valeurs !';
                    }
                } else {
                    echo 'Un problème est survenu dans la préparation de la requête !';
                }
            }
        } catch( Exception $e ) {
            die( utf8_encode($e->getMessage()) );
        }
        ?>
    </body>
</html>