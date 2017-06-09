<nav role="navigation">
    <a href="<?php echo defined( 'DOMAIN' ) ? DOMAIN : dirname( $_SERVER['PHP_SELF'] ); ?>" id="logo" rel="home" title="<?php echo defined( 'SITE_TITLE' ) ? SITE_TITLE : ''; ?>"><span data-role="logo-wrapper"><img alt="<?php echo defined( 'SITE_TITLE' ) ? SITE_TITLE : ''; ?>" data-role="logo" src="<?php echo defined( 'ASSETSURL' ) ? ASSETSURL : ( defined( 'DOMAIN' ) ? DOMAIN : dirname( $_SERVER['PHP_SELF'] ) ) . 'assets/'; ?>img/picto_O3W.jpg" /></span><span data-role="baseline"><?php echo defined( 'SITE_TITLE' ) ? SITE_TITLE : ''; ?></span></a>
    <ul class="menu-principal">
        <li<?php if( basename( $_SERVER['PHP_SELF'] )=='index.php' ) echo ' class="active"'; ?>><a href="<?php echo ( defined( 'DOMAIN' ) ? DOMAIN : '' ); ?>" title="">Accueil</a></li>
        <?php if( isAuthentified( 'registered', $_SESSION ) ) : ?>
        <?php if( hasAbility( 1, explode( ';', $_SESSION[APP_TAG]['registered']['autorisations'] ) ) ) : // Si la personne authentifiée a les droits pour lister, ?><li<?php if( basename( $_SERVER['PHP_SELF'] )=='users.php' || basename( $_SERVER['PHP_SELF'] )=='user.php' ) echo ' class="active"'; ?>><a href="<?php echo ( defined( 'DOMAIN' ) ? DOMAIN : '' ); ?>users.php" title="">Utilisateurs</a></li><?php endif; ?>
        <li><a href="?destroy" title="">Se déconnecter</a></li>
        <?php endif; ?>
    </ul>
</nav>