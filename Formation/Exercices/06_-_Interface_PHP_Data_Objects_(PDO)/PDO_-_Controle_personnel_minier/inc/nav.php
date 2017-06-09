<nav role="navigation">
    <a href="<?php echo defined( 'DOMAIN' ) ? DOMAIN : dirname( $_SERVER['PHP_SELF'] ); ?>" id="logo" rel="home" title="<?php echo defined( 'SITE_TITLE' ) ? SITE_TITLE : ''; ?>"><span data-role="logo-wrapper"><img alt="<?php echo defined( 'SITE_TITLE' ) ? SITE_TITLE : ''; ?>" data-role="logo" src="<?php echo defined( 'ASSETSURL' ) ? ASSETSURL : ( defined( 'DOMAIN' ) ? DOMAIN : dirname( $_SERVER['PHP_SELF'] ) ) . 'assets/'; ?>img/logo_mine.png" /></span><span data-role="baseline"><?php echo defined( 'SITE_TITLE' ) ? SITE_TITLE : ''; ?></span></a>
    <ul class="menu-principal">
        <li<?php if( basename( $_SERVER['PHP_SELF'] )=='index.php' ) echo ' class="active"'; ?>><a href="<?php echo ( defined( 'DOMAIN' ) ? DOMAIN : '' ); ?>" title="">Accueil</a></li>
        <li<?php if( basename( $_SERVER['PHP_SELF'] )=='nains.php' || basename( $_SERVER['PHP_SELF'] )=='nain.php' ) echo ' class="active"'; ?>><a href="<?php echo ( defined( 'DOMAIN' ) ? DOMAIN : '' ); ?>nains.php" title="">Nains</a></li>
        <li<?php if( basename( $_SERVER['PHP_SELF'] )=='groupes.php' || basename( $_SERVER['PHP_SELF'] )=='groupe.php' ) echo ' class="active"'; ?>><a href="<?php echo ( defined( 'DOMAIN' ) ? DOMAIN : '' ); ?>groupes.php" title="">Groupes</a></li>
        <li<?php if( basename( $_SERVER['PHP_SELF'] )=='tavernes.php' || basename( $_SERVER['PHP_SELF'] )=='taverne.php' ) echo ' class="active"'; ?>><a href="<?php echo ( defined( 'DOMAIN' ) ? DOMAIN : '' ); ?>tavernes.php" title="">Tavernes</a></li>
        <li<?php if( basename( $_SERVER['PHP_SELF'] )=='villes.php' || basename( $_SERVER['PHP_SELF'] )=='ville.php' ) echo ' class="active"'; ?>><a href="<?php echo ( defined( 'DOMAIN' ) ? DOMAIN : '' ); ?>villes.php" title="">Villes</a></li>
    </ul>
</nav>