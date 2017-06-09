<!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="utf-8" />
        <title>Ajouter un utilisateur | Forum</title>

        <link rel="stylesheet" type="text/css" href="style.css" />
    </head>
    <body>
        <header role="banner">
            <nav id="ariane">
                <ul class="list">
                    <li class="item"><a class="link" href="?" title="">Accueil</a></li>
                    <li class="item"><a class="link" href="<?php echo ( isset( $_GET['c'] ) ? '?c=' . $_GET['c'] : '?' ); ?>" title="">Utilisateurs</a></li>
                    <li class="item">Ajouter un utilisateur</li>
                </ul>
            </nav>
        </header>

        <section role="main">
            <article role="article">
                <header>
                    <h1>Ajouter un utilisateur | Forum</h1>
                </header>
                
                <?php
                if( isset( $_GET['_err'] ) ) :
                    echo '<div class="error">';
                    switch( $_GET['_err'] ) :
                        case 'adding':
                            echo 'Ooops, la création a échoué !';
                            break;
                    endswitch;
                    echo '</div>';
                endif;
                ?>

                <form action="<?php echo ( isset( $_GET['c'] ) ? 'c=' . $_GET['c'] . '&' : '?' ); ?>a=adding" data-role="formulaire" method="post">
                    <label class="required" data-role="label" for="txt-login">Identifiant</label>
                    <input id="txt-login" maxlength="30" name="login" required="required" type="text" value="" />
                    
                    <label data-role="label" for="txt-firstname">Nom</label>
                    <input id="txt-firstname" maxlength="255" name="nom" type="text" value="" />
                    
                    <label data-role="label" for="txt-lastname">Prénom</label>
                    <input id="txt-lastname" maxlength="255" name="prenom" type="text" value="" />
                    
                    <label data-role="label" for="txt-birthdate">Date de naissance</label>
                    <input id="txt-birthdate" name="date_naissance" type="date" value="" />

                    <label data-role="label" for="txt-role">Rang</label>
                    <select id="txt-role" name="rang_fk">
                        <?php
                        foreach( $arr_datas as $item ) :
                            echo '
                        <option value="' . $item['ID'] . '">' . $item['Label'] . '</option>';
                        endforeach;
                        ?>
                    </select>

                    <input data-role="submit" type="submit" value="Ajouter" />
                </form>
            </article>
        </section>

        <footer role="contentinfo"></footer>
    </body>
</html>