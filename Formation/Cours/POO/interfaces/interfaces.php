<?php
// require_once( 'classes/magicien.class.php' );

function load( $value ) {
    $file = 'classes/' . strtolower( $value ) . '.class.php';
    if( file_exists( $file ) ) {
        require_once( $file );
    }
    $file = 'interfaces/' . strtolower( $value ) . '.interface.php';
    if( file_exists( $file ) ) {
        require_once( $file );
    }
}
spl_autoload_register( 'load' );

?><!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Interfaces</title>
    </head>
    <body>
        <h1>Interfaces</h1>
        <hr>
        <?php
        $monMag = new Magicien;
        $monMag->test();
        ?>
    </body>
</html>