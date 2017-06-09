<article role="article">
    <header>
        <h1>Profil de <?php echo $this->item['Nom'] . ' ' . $this->item['Prénom'] . ' (' . $this->item['Login'] . ')'; ?> | Forum</h1>
    </header>

    <ul class="list">
        <?php
        foreach( $this->item as $key=>$value ) :
            echo '
        <li class="item"><strong>' . $key . '</strong> : ' . $value . '</li>';
        endforeach;
        ?>
    </ul>
</article>