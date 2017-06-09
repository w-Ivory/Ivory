<xml>
    <?php
        $user = $this->user;
        echo '
        <user>
            <id>'.$user['u_id'].'</id>
            <nom>'.$user['u_nom'].'</nom>
            <prenom>'.$user['u_prenom'].'</prenom>
            <date>'.$user['u_date_naissance'].'</date>
        </user>';
    ?>
</xml>