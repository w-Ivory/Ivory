<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0" />
        <title><?php echo ( isset( $sitename ) ? $sitename . ( defined( 'TITLE_SEPARATOR' ) ? TITLE_SEPARATOR : '' ) : '' ) . ( defined( 'SITE_TITLE' ) ? SITE_TITLE : '' ); ?></title>
        
        <style type="text/css">
            <!--
            @import url(style.css);
            @import url(responsive.css);
            -->
        </style>
    </head>

    <body>
        <div style="height:96vh;">

            <div class="grid-wrapper">
            <div class="grid12 x3 noprint">
            <header role="banner">
                <?php include( './inc/nav.php' ); // On inclut le fichier de navigation ?>
            </header>
            </div>

            <div class="grid12 x9">