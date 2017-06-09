<article role="article">
    <header>
        <h1>Ajouter un utilisateur | Forum</h1>
    </header>
    
    <?php
    if( SRequest::getInstance()->get( '_err' )!==null ) :
        echo '<div class="error">';
        switch( SRequest::getInstance()->get( '_err' ) ) :
            case 'adding':
                echo 'Ooops, la création a échoué !';
                break;
        endswitch;
        echo '</div>';
    endif;
    ?>

    <form action="<?php echo ( SRequest::getInstance()->get( 'c' )!==null ? '?c=' . SRequest::getInstance()->get( 'c' ) . '&' : '?' ); ?>a=adding" data-role="formulaire" method="post">
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
            foreach( $this->arr_datas as $item ) :
                echo '
            <option value="' . $item['ID'] . '">' . $item['Label'] . '</option>';
            endforeach;
            ?>
        </select>

        <input data-role="submit" type="submit" value="Ajouter" />
    </form>
</article>