<?php
/**
 * On inclut les fichiers de configuration
**/
require( './ini.php' );
require( './common.php' );
/** **/

if( !isset( $_GET['id'] ) ) :
    redirect( 'users.php?_err=param' ); // On redirige vers la page de listing.
elseif( !is_numeric( $_GET['id'] ) ) :
    redirect( '404.php' ); // On redirige vers la page d'erreur 404.
else :
    $_pdo = connectDB( ( defined( 'DB_HOST' ) ? DB_HOST : '' ), ( defined( 'DB_NAME' ) ? DB_NAME : '' ), ( defined( 'DB_LOGIN' ) ? DB_LOGIN : '' ), ( defined( 'DB_PWD' ) ? DB_PWD : '' ) ); // On appelle la fonction de connexion

    if( !isReallyAuthentified( $_pdo, 'registered', $_SESSION ) ) : // Si personne n'est pas authentifiée ou que ses informations ont été modifiées,
        redirect();
    elseif( !( ( $_GET['id']==0 && hasAbility( 2, explode( ';', $_SESSION[APP_TAG]['registered']['autorisations'] ) ) ) || ( $_GET['id']!=0 && hasAbility( 3, explode( ';', $_SESSION[APP_TAG]['registered']['autorisations'] ) ) ) ) ) : // Si la personne authentifiée n'a pas les droits d'ajout ou n'a pas les droits d'édition,
        redirect( 'users.php?_err=ability' );
    else :
        if( isset( $_POST['action'] ) && $_POST['action']=='Modifier' && hasAbility( 4, explode( ';', $_SESSION[APP_TAG]['registered']['autorisations'] ) ) ) : // Si personne authentifiée a les droits de modification,
            if( isset( $_POST['id'] ) && is_numeric( $_POST['id'] ) && isset( $_POST['identifiant'] ) && $_POST['identifiant']!='' && isset( $_POST['role'] ) && is_numeric( $_POST['role'] ) ) : // Si les champs obligatoires sont transmis,
                if( $_POST['id']==$_GET['id'] && hasPower( $_pdo, getPower( $_pdo, $_POST['id'] ), $_SESSION[APP_TAG]['registered']['ID'] ) ) : // Si personne authentifiée a le pouvoir de modifier l'utilisateur ciblé,
                    $_str_query = 'UPDATE `user` SET `user`.`login`=:login' . ( isset( $_POST['pass'] ) && $_POST['pass']!='' && isset( $_POST['pass2'] ) && $_POST['pass2']==$_POST['pass'] ? ', `user`.`pwd`=:pwd' : '' ) . ', `user`.`lastname`=:lastname, `user`.`firstname`=:firstname' . ( hasPower( $_pdo, $_POST['role'], $_SESSION[APP_TAG]['registered']['puissance'] ) ? ', `user`.`role_fk`=:role' : '' ) . ' WHERE `user`.`id`=:id'; // On définit la chaîne de caractères représentant la requête.
                    $_arr_options = array(
                        'id'        => array(
                            'VAL'   => $_POST['id'],
                            'TYPE'  => PDO::PARAM_INT
                        ),
                        'login'     => array(
                            'VAL'   => $_POST['identifiant']
                        ),
                        'lastname'  => array(
                            'VAL'   => $_POST['nom']
                        ),
                        'firstname' => array(
                            'VAL'   => $_POST['prénom']
                        )
                    );
                    if( isset( $_POST['pass'] ) && $_POST['pass']!='' && isset( $_POST['pass2'] ) && $_POST['pass2']==$_POST['pass'] ) : // Si un changement de mot de passe est demandé et que la valeur est confirmée,
                        $_arr_options['pwd'] = array(
                            'VAL'   => $_POST['pass2']
                        );
                    endif;
                    if( isset( $_POST['pass'] ) && $_POST['pass']!='' && isset( $_POST['pass2'] ) && $_POST['pass2']!=$_POST['pass'] ) : // Si un changement de mot de passe est demandé mais que les mots de passe ne correspondent pas,
                        $_int_update = 'pwd';
                    else :
                        if( hasPower( $_pdo, $_POST['role'], $_SESSION[APP_TAG]['registered']['puissance'] ) ) : // Si l'utilisateur authentifié est autorisé à utiliser le rôle transmis,
                            $_arr_options['role'] = array(
                                'VAL'   => $_POST['role'],
                                'TYPE'  => PDO::PARAM_INT
                            );
                            $_int_update = executeQuery( $_pdo, $_str_query, $_arr_options );
                            if( !isReallyAuthentified( $_pdo, 'registered', $_SESSION ) ) : // Si personne n'est authentifié ou si la personne authentifiée n'a pas les droits d'édition,
                                redirect();
                            endif;
                        else :
                            $_int_update = 'power';
                        endif;
                    endif;
                else :
                    $_int_update = 'power';
                endif;
            endif;
        elseif( isset( $_POST['action'] ) && $_POST['action']=='Ajouter' && hasAbility( 2, explode( ';', $_SESSION[APP_TAG]['registered']['autorisations'] ) ) ) : // Si personne authentifiée a les droits d'ajout,
            if( isset( $_POST['identifiant'] ) && $_POST['identifiant']!='' && isset( $_POST['pass'] ) && $_POST['pass']!='' && isset( $_POST['role'] ) && is_numeric( $_POST['role'] ) ) : // Si les champs obligatoires sont transmis,
                $_str_query = 'INSERT INTO `user`( `login`' . ( isset( $_POST['pass2'] ) && $_POST['pass2']==$_POST['pass'] ? ', `pwd`' : '' ) . ( isset( $_POST['nom'] ) ? ', `lastname`' : '' ) . ( isset( $_POST['prénom'] ) ? ', `firstname`' : '' ) . ( hasPower( $_pdo, $_POST['role'], $_SESSION[APP_TAG]['registered']['puissance'] ) ? ', `role_fk`' : '' ) . ' )
VALUES ( :login' . ( isset( $_POST['pass2'] ) && $_POST['pass2']==$_POST['pass'] ? ', :pwd' : '' ) . ( isset( $_POST['nom'] ) ? ', :lastname' : '' ) . ( isset( $_POST['prénom'] ) ? ', :firstname' : '' ) . ( hasPower( $_pdo, $_POST['role'], $_SESSION[APP_TAG]['registered']['puissance'] ) ? ', :role' : '' ) . ' )'; // On définit la chaîne de caractères représentant la requête.
                $_arr_options = array(
                    'login'     => array(
                        'VAL'   => $_POST['identifiant']
                    )
                );
                if( isset( $_POST['pass2'] ) && $_POST['pass2']==$_POST['pass'] ) : // Si un changement de mot de passe est demandé et que la valeur est confirmée,
                    $_arr_options['pwd'] = array(
                        'VAL'   => $_POST['pass2']
                    );
                endif;
                if( isset( $_POST['nom'] ) ) : // Si un changement de mot de passe est demandé et que la valeur est confirmée,
                    $_arr_options['lastname'] = array(
                        'VAL'   => $_POST['nom']
                    );
                endif;
                if( isset( $_POST['prénom'] ) ) : // Si un changement de mot de passe est demandé et que la valeur est confirmée,
                    $_arr_options['firstname'] = array(
                        'VAL'   => $_POST['prénom']
                    );
                endif;
                if( isset( $_POST['pass2'] ) && $_POST['pass2']!=$_POST['pass'] ) : // Si un changement de mot de passe est demandé mais que les mots de passe ne correspondent pas,
                    $_int_update = 'pwd';
                else :
                    if( hasPower( $_pdo, $_POST['role'], $_SESSION[APP_TAG]['registered']['puissance'] ) ) : // Si l'utilisateur authentifié est autorisé à utiliser le rôle transmis,
                        $_arr_options['role'] = array(
                            'VAL'   => $_POST['role'],
                            'TYPE'  => PDO::PARAM_INT
                        );
                        $_int_update = executeQuery( $_pdo, $_str_query, $_arr_options );
                        redirect( 'users.php' ); // On redirige vers la page.
                    else :
                        $_int_update = 'power';
                    endif;
                endif;
            endif;
        elseif( isset( $_POST['action'] ) && $_POST['action']=='Supprimer' && hasAbility( 5, explode( ';', $_SESSION[APP_TAG]['registered']['autorisations'] ) ) ) : // Si personne authentifiée a les droits de suppression,
            if( isset( $_POST['id'] ) && is_numeric( $_POST['id'] ) ) : // Si les champs obligatoires sont transmis,
                $_str_query = 'DELETE FROM `user` WHERE `id`=:id'; // On définit la chaîne de caractères représentant la requête.
                $_arr_options = array(
                    'id'        => array(
                        'VAL'   => $_POST['id'],
                        'TYPE'  => PDO::PARAM_INT
                    )
                );
                $_int_update = executeQuery( $_pdo, $_str_query, $_arr_options );
                redirect( 'users.php' ); // On redirige vers la page.
            endif;
        endif;

        if( $_GET['id']!=0 && ( hasAbility( 3, explode( ';', $_SESSION[APP_TAG]['registered']['autorisations'] ) ) || hasAbility( 4, explode( ';', $_SESSION[APP_TAG]['registered']['autorisations'] ) ) ) ) : // Si on souhaite éditer un utilisateur et que la personne authentifiée en a le droit ou celui de modification,
            $_str_query = 'SELECT `user`.`id` AS "ID", `user`.`login` AS "Identifiant", `user`.`pwd` AS "Mot de passe", `user`.`lastname` AS "Nom", `user`.`firstname` AS "Prénom", `role`.`id` AS "roleID", `role`.`lbl` AS "Rôle"
    FROM `user`
    INNER JOIN `role` ON `user`.`role_fk`=`role`.`id`
    LEFT JOIN `rel_role_capability` ON `role`.`id`=`rel_role_capability`.`role`
    LEFT JOIN `capability` ON `rel_role_capability`.`capability`=`capability`.`id`
    WHERE `user`.`id`=:id
    GROUP BY `user`.`id`
    LIMIT 1'; // On définit la chaîne de caractères représentant la requête.
            $_arr_options = array(
                'id'    => array(
                    'VAL'   => $_GET['id'],
                    'TYPE'  => PDO::PARAM_INT
                )
            );
            $_arr_datas = executeQuery( $_pdo, $_str_query, $_arr_options );
            if( count( $_arr_datas )<1 ) :
                redirect( '404.php' ); // On redirige vers la page d'erreur 404.
            endif;
        endif;

        $sitename = isset( $_arr_datas[0]['Prénom'] ) ? $_arr_datas[0]['Prénom'] . ' ' . $_arr_datas[0]['Nom'] : 'Utilisateur';
        include( './inc/head.php' ); // On inclut le fichier d'en-tête
?>

<div class="grid-wrapper">
<div class="grid12 x2">
<header role="banner">
    <?php include( './inc/nav.php' ); // On inclut le fichier de navigation ?>
</header>
</div>

<div class="grid12 x10">
<section role="main" id="users">
    <aside class="align-right" role="complementary">
        <p>Bienvenue <?php echo $_SESSION[APP_TAG]['registered']['pnom'] . ' ' . $_SESSION[APP_TAG]['registered']['nom']; ?></p>
    </aside>
    <article role="article">
        <header class="header">
            <h1 class="title-lvl1">Tableau de bord</h1>
            <nav role="navigation">
                <ul class="menu-ariane">
                    <li><a href="<?php echo ( defined( 'DOMAIN' ) ? DOMAIN : '' ); ?>" title="">Tableau de bord</a></li>
                    <li><a href="<?php echo ( defined( 'DOMAIN' ) ? DOMAIN : '' ); ?>users.php" title="">Utilisateurs</a></li>
                    <li><?php echo isset( $sitename ) ? $sitename : ''; ?></li>
                </ul>
            </nav>
        </header>
        <?php
        if( isset( $_err ) ) :
            echo $_err['msg'];
        endif;
        if( isset( $_GET['_err'] ) ) :
            displayError( $_GET['_err'] );
        endif;
        ?>
        <ul class="grid-wrapper widgets">
            <li class="grid12 x12 item before" data-id="<?php echo $sitename; ?>">
                <?php if( $_GET['id']!=0 && hasAbility( 4, explode( ';', $_SESSION[APP_TAG]['registered']['autorisations'] ) ) && hasPower( $_pdo, $_arr_datas[0]['roleID'], $_SESSION[APP_TAG]['registered']['puissance'] ) ) : // Si personne authentifiée a les droits de modification, ?>
                <form action="<?php echo isset( $_GET['id'] ) ? '?id=' . $_GET['id'] : ''; ?>" data-role="formulaire" method="POST">
                <ul>
                    <?php
                    if( isset( $_arr_datas ) && is_array( $_arr_datas ) && count( $_arr_datas )>0 ) :
                        foreach( $_arr_datas[0] as $key=>$item ) :
                            switch( $key ) :
                                case 'ID':
                    ?>
                    <li class="text-justify"><span class="lbl"></span> <span class="value"><input name="id" required="required" type="hidden" value="<?php echo $item; ?>" /></span></li>
                    <?php
                                    break;
                                case 'Identifiant':
                    ?>
                    <li class="text-justify"><span class="lbl"><?php echo $key; ?></span> <span class="value"><input name="<?php echo mb_strtolower( $key ); ?>" required="required" type="text" value="<?php echo $item; ?>" /></span></li>
                    <?php
                                    break;
                                case 'Mot de passe':
                    ?>
                    <li class="text-justify"><span class="lbl"><?php echo $key; ?></span> <span class="value"><input name="pass" type="password" value="" /></span></li>
                    <li class="text-justify"><span class="lbl">Répétez votre <?php echo mb_strtolower( $key ); ?></span> <span class="value"><input name="pass2" type="password" value="" /></span></li>
                    <?php
                                    break;
                                case 'roleID':
                                    $_str_query = 'SELECT `role`.`id`, `role`.`lbl`
FROM `role`
WHERE `role`.`power`>=:power
ORDER BY `role`.`power` ASC'; // On définit la chaîne de caractères représentant la requête.
                                    $_arr_options = array(
                                        'power' => array(
                                            'VAL'   => $_SESSION[APP_TAG]['registered']['puissance'],
                                            'TYPE'  => PDO::PARAM_INT
                                        )
                                    );
                                    $_arr_datas_secondary = executeQuery( $_pdo, $_str_query, $_arr_options );

                                    if( isset( $_arr_datas_secondary ) && is_array( $_arr_datas_secondary ) && count( $_arr_datas_secondary )>0 ) :
                    ?>
                    <li class="text-justify">
                        <label class="lbl" for="list-role">Rôle</label>
                        <span class="value">
                            <select dir="rtl" id="list-role" name="role" required="required">
                                <?php foreach( $_arr_datas_secondary as $item_secondary ) : ?>
                                <option<?php echo $item==$item_secondary['id'] ? ' selected="selected"' : ''; ?> value="<?php echo $item_secondary['id']; ?>"><?php echo $item_secondary['lbl']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </span>
                    </li>
                    <?php
                                    endif;
                                    break;
                                case 'Rôle':
                                    break;
                                default:
                    ?>
                    <li class="text-justify"><span class="lbl"><?php echo $key; ?></span> <span class="value"><input name="<?php echo mb_strtolower( $key ); ?>" type="text" value="<?php echo $item; ?>" /></span></li>
                    <?php
                            endswitch;
                        endforeach;
                    endif;
                    ?>
                    <li class="text-justify">
                        <?php
                        if( isset( $_int_update ) ) :
                            if( $_int_update===false ) :
                                echo '<span class="lbl alert-block warning">Aucune modification effectuée !</span>';
                            elseif( $_int_update===true ) :
                                echo '<span class="lbl alert-block ok">La modification s\'est bien effectuée !</span>';
                            elseif( $_int_update==='pwd' ) :
                                echo '<span class="lbl alert-block warning">Les mots de passe ne sont pas identiques !</span>';
                            elseif( $_int_update==='power' ) :
                                echo '<span class="lbl alert-block warning">Vous avez tenté d\'outrepasser vos droits !<br />Aucune modification effectuée.</span>';
                            else :
                                echo '<span class="lbl alert-block error">Une erreur est survenue !</span>';
                            endif;
                        else : echo '<span class="lbl"></span>';
                        endif;
                        ?>
                        <span class="value"><input data-role="submit" name="action" type="submit" value="Modifier" /><?php if( hasAbility( 5, explode( ';', $_SESSION[APP_TAG]['registered']['autorisations'] ) ) ) : ?>&nbsp;<input data-role="submit" name="action" type="submit" value="Supprimer" /><?php endif; ?></span>
                    </li>
                </ul>
                </form>
                <?php elseif( $_GET['id']==0 && hasAbility( 2, explode( ';', $_SESSION[APP_TAG]['registered']['autorisations'] ) ) ) : // Si personne authentifiée a les droits d'ajout, ?>
                <form action="<?php echo isset( $_GET['id'] ) ? '?id=' . $_GET['id'] : ''; ?>" data-role="formulaire" method="POST">
                <ul>
                    <li class="text-justify"><span class="lbl">Identifiant</span> <span class="value"><input name="identifiant" required="required" type="text" /></span></li>
                    <li class="text-justify"><span class="lbl">Mot de passe</span> <span class="value"><input name="pass" type="password" /></span></li>
                    <li class="text-justify"><span class="lbl">Répétez votre mot de passe</span> <span class="value"><input name="pass2" type="password" /></span></li>
                    <li class="text-justify"><span class="lbl">Nom</span> <span class="value"><input name="nom" type="text" /></span></li>
                    <li class="text-justify"><span class="lbl">Prénom</span> <span class="value"><input name="prénom" type="text" /></span></li>
                    <?php
                    $_str_query = 'SELECT `role`.`id`, `role`.`lbl`
FROM `role`
WHERE `role`.`power`>=:power
ORDER BY `role`.`power` ASC'; // On définit la chaîne de caractères représentant la requête.
                    $_arr_options = array(
                        'power' => array(
                            'VAL'   => $_SESSION[APP_TAG]['registered']['puissance'],
                            'TYPE'  => PDO::PARAM_INT
                        )
                    );
                    $_arr_datas_secondary = executeQuery( $_pdo, $_str_query, $_arr_options );

                    if( isset( $_arr_datas_secondary ) && is_array( $_arr_datas_secondary ) && count( $_arr_datas_secondary )>0 ) :
                    ?>
                    <li class="text-justify">
                        <label class="lbl" for="list-role">Rôle</label>
                        <span class="value">
                            <select dir="rtl" id="list-role" name="role" required="required">
                                <?php foreach( $_arr_datas_secondary as $item_secondary ) : ?>
                                <option value="<?php echo $item_secondary['id']; ?>"><?php echo $item_secondary['lbl']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </span>
                    </li>
                    <?php endif; ?>
                    <li class="text-justify">
                        <?php
                        if( isset( $_int_update ) ) :
                            if( $_int_update===false ) :
                                echo '<span class="lbl alert-block warning">Aucune modification effectuée !</span>';
                            elseif( $_int_update===true ) :
                                echo '<span class="lbl alert-block ok">La modification s\'est bien effectuée !</span>';
                            elseif( $_int_update==='pwd' ) :
                                echo '<span class="lbl alert-block warning">Les mots de passe ne sont pas identiques !<br />Aucune opération effectuée.</span>';
                            elseif( $_int_update==='power' ) :
                                echo '<span class="lbl alert-block warning">Vous avez tenté d\'outrepasser vos droits !<br />Aucune opération effectuée.</span>';
                            else :
                                echo '<span class="lbl alert-block error">Une erreur est survenue !</span>';
                            endif;
                        else : echo '<span class="lbl"></span>';
                        endif;
                        ?>
                        <span class="value"><input data-role="submit" name="action" type="submit" value="Ajouter" /></span>
                    </li>
                </ul>
                </form>
                <?php elseif( $_GET['id']!=0 && hasAbility( 3, explode( ';', $_SESSION[APP_TAG]['registered']['autorisations'] ) ) ) : // Si personne authentifiée a juste les droits d'édition, ?>
                <div data-role="formulaire">
                <ul>
                    <?php
                    if( isset( $_arr_datas ) && is_array( $_arr_datas ) && count( $_arr_datas )>0 ) :
                        foreach( $_arr_datas[0] as $key=>$item ) :
                            switch( $key ) :
                                case 'ID':
                                case 'Mot de passe':
                                case 'roleID':
                                    break;
                                default:
                    ?>
                    <li class="text-justify"><span class="lbl"><?php echo $key; ?></span> <span class="value"><?php echo $item; ?></span></li>
                    <?php
                            endswitch;
                        endforeach;
                    endif;
                    ?>
                </ul>
                </div>
                <?php endif; ?>
            </li>
        </ul>
    </article>
</section>
</div>
</div>

<?php
    endif;
endif;
include( './inc/foot.php' ); // On inclut le fichier de pied de page