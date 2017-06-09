<nav>
    <ul>
        <li><a href="<?php if( defined( 'DOMAIN' ) ) echo DOMAIN; ?>?c=user&a=logout">Déconnexion</a></li>
        <li><a href="<?php if( defined( 'DOMAIN' ) ) echo DOMAIN; ?>?c=user">Utilisateurs</a>
            <ul>
                <li><a href="<?php if( defined( 'DOMAIN' ) ) echo DOMAIN; ?>?c=user&a=profile">Profil</a>
                <li><a href="<?php if( defined( 'DOMAIN' ) ) echo DOMAIN; ?>?c=user&a=add">Ajouter</a>
            </ul>
        </li>
    </ul>
</nav>