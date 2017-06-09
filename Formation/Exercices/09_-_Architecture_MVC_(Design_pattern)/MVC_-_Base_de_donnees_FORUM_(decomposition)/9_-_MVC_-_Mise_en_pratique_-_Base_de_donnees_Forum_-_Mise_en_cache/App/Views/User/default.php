<article role="article">
    <header>
        <h1>Liste des utilisateurs | Forum</h1>
        <a class="link" href="<?php echo ( SRequest::getInstance()->get( 'c' )!==null ? '?c=' . SRequest::getInstance()->get( 'c' ) . '&' : '?' ); ?>a=add" title="">Ajouter un utilisateur</a>
    </header>

    <ul class="list">
        <?php
        foreach( $this->arr_datas as $item ) :
            echo '
        <li class="item"><a class="link" href="' . ( SRequest::getInstance()->get( 'c' )!==null ? '?c=' . SRequest::getInstance()->get( 'c' ) . '&' : '?' ) . 'a=profile&id=' . $item['ID'] . '" title="' . $item['Nom'] . ' ' . $item['Prénom'] . ' (' . $item['Login'] . ')">' . $item['Nom'] . ' ' . $item['Prénom'] . ' (' . $item['Login'] . ')</a></li>';
        endforeach;
        ?>
    </ul>
</article>