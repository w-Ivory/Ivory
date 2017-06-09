<article role="article">
    <header>
        <h1>Conversation n° <?php echo $this->item['ID']; ?> | Forum</h1>
    </header>

    <ul class="list">
        <?php
        foreach( $this->item as $key=>$value ) :
            switch( $key ) :
                case 'Status':
                    echo '
        <li class="item"><strong>' . $key . '</strong> : ' . ( $value==1 ? 'Fermée' : 'En cours' ) . '</li>';
                    break;
                default:
                    echo '
        <li class="item"><strong>' . $key . '</strong> : ' . $value . '</li>';
            endswitch;
        endforeach;
        ?>
    </ul>
</article>