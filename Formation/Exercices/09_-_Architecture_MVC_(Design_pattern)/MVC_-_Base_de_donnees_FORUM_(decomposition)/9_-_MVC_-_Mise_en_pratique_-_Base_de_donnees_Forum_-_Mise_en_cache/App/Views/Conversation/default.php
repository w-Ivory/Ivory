<article role="article">
    <header>
        <h1>Liste des conversations | Forum</h1>
        <a class="link" href="<?php echo ( SRequest::getInstance()->get( 'c' )!==null ? '?c=' . SRequest::getInstance()->get( 'c' ) . '&' : '?' ); ?>a=add" title="">Ajouter une conversation</a>
    </header>

    <ul class="list">
        <?php
        foreach( $this->arr_datas as $item ) :
            echo '
        <li class="item"><a class="link" href="' . ( SRequest::getInstance()->get( 'c' )!==null ? '?c=' . SRequest::getInstance()->get( 'c' ) . '&' : '?' ) . 'a=conversation&id=' . $item['ID'] . '" title="">Conversation n° ' . $item['ID'] . ' (' . $item['Date'] . ')</a></li>';
        endforeach;
        ?>
    </ul>
</article>