<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Les traits</title>
    </head>
    <body>
        <h1>Les traits</h1>
        <hr />
        <?php
        require_once( 'classes/maclasse.class.php' );
        $monObj = new MaClasse;
        $monObj->error();
        ?>
    </body>
</html>