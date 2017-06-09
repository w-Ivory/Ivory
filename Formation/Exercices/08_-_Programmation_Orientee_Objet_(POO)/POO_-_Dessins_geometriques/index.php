<?php
/**
 * Inclure un fichier en fonction de son nom.
 * Description :
 *     On récupère le nom d'une classe/interface/trait et on inclut le fichier correspondant si ce dernier existe.
 * Paramètres :
 *     - (string) $v_name : nom de la classe/interface/trait
**/
function loadClass( $className ) {
    $_str_file = 'classes/' . strtolower( $className ) . '.class.php';
    if( file_exists( $_str_file ) ) :
        require_once( $_str_file );
    endif;
}
spl_autoload_register( 'loadClass' ); // On lance la procédure d'auto-chargement des classes avec la fonction "includeClass" en callback.
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0" />
        <title>Dessins géomètriques - Mise en pratique</title>

        <style type="text/css">
            <!--
            *,*::before,*::after {
                -webkit-box-sizing:border-box;
                -moz-box-sizing:border-box;
                -ms-box-sizing:border-box;
                -o-box-sizing:border-box;
                box-sizing:border-box;
            }
            /**
             * --------------------------------------------------
             * BALISES
             * --------------------------------------------------
            **/
            /* ------    html5    ------ */
            input[type="color"],input[type="date"],input[type="datetime"],input[type="datetime-local"],input[type="email"],input[type="month"],input[type="number"],input[type="range"],input[type="search"],input[type="tel"],input[type="time"],input[type="url"],input[type="week"],input::-webkit-input-placeholder { -webkit-appearance:none; }
            input[type="search"]::-webkit-search-cancel-button,input[type="search"]::-webkit-search-decoration,input[type="search"]::-webkit-search-results-button,input[type="search"]::-webkit-search-results-decoration { -webkit-appearance:none; }
            /* ------    générales    ------ */
            fieldset {
                border:none;
                border-top:rgba(0,0,0,.5) thin solid;
                display:inline-block;
                margin:10px 25px;margin:1rem 2.5rem;
                vertical-align:top;
            }
                fieldset legend {
                    background-color:rgb(21,21,21);
                    color:rgb(255,255,255);
                    display:inline-block;
                    font-weight:bold;
                    margin:0;
                    padding:10px 5px;padding:1rem .5rem;
                    text-transform:uppercase;
                }
                fieldset ul,fieldset ol {margin:0;}
            -->
        </style>
    </head>
    <body>
        <h1>Dessins géomètriques - Mise en pratique</h1>
        <hr />
        <p><em>Utiliser le formulaire pour générer la forme souhaitée dans le cadre.</em></p>
        <?php
        if( !isset( $_POST['shape'] ) ) :
            $shape = 'rectangle';
        else :
            $shape = htmlentities( $_POST['shape'] );
            $X = htmlentities( $_POST['x'] );
            $Y = htmlentities( $_POST['y'] );
            $R = htmlentities( $_POST['r'] );
            $G = htmlentities( $_POST['g'] );
            $B = htmlentities( $_POST['b'] );
            $width = htmlentities( $_POST['width'] );
            $height = htmlentities( $_POST['height'] );
            $radius = htmlentities( $_POST['radius']);    
            $side = htmlentities( $_POST['side'] );
            $valid = htmlentities( $_POST['valid'] );
        endif;
        ?>

        <form action="" method="post" name="frmDrawing">
            <table style="width:100%;">
                <tr>
                    <td align="left" valign="top">
                        <table style="width:100%;">
                            <tr>
                                <th align="left" colspan="2"><h3>Rectangle <input<?php echo $shape == 'rectangle' ? ' checked="checked"' : ''; ?> name="shape" type="radio" value="rectangle" /></h3></th>
                            </tr>
                            <tr>
                                <td>Largeur :</td>
                                <td><input min="0" name="width" type="number" value="<?php echo isset( $width ) ? $width : 100; ?>" /></td>
                            </tr>
                            <tr>
                                <td>Hauteur :</td>
                                <td><input min="0" name="height" type="number" value="<?php echo isset( $height ) ? $height : 50; ?>" /></td>
                            </tr>
                            <tr>
                                <th align="left" colspan="2"><h3>Cercle <input<?php echo $shape == 'circle' ? ' checked="checked"' : ''; ?> name="shape" type="radio" value="circle" /></h3></th>
                            </tr>
                            <tr>
                                <td>Rayon :</td>
                                <td><input min="0" name="radius" type="number" value="<?php echo isset( $radius ) ? $radius : 60; ?>" /></td>
                            </tr>
                            <tr>
                                <th align="left" colspan="2"><h3>Carré <input<?php echo $shape == 'square' ? ' checked="checked"' : ''; ?> name="shape" type="radio" value="square" /></h3></th>
                            </tr>
                            <tr>
                                <td>Côté :</td>
                                <td><input min="0" name="side" type="number" value="<?php echo isset( $side ) ? $side : 60; ?>" /></td>
                            </tr>
                        </table>
                    </td>
                    <td align="left" valign="top">
                        <table style="width:100%;">
                            <tr>
                                <th align="left" colspan="2"><h3>Avec les paramètres </h3></th>
                            </tr>
                            <tr>
                                <td>Abscisse :</td>
                                <td><input min="0" name="x" type="number" value="<?php echo isset( $X ) ? $X : 150; ?>" /></td>
                            </tr>
                            <tr>
                                <td>Ordonnée :</td>
                                <td><input min="0" name="y" type="number" value="<?php echo isset( $Y ) ? $Y : 150; ?>" /></td>
                            </tr>
                            <tr>
                                <td>Rouge :</td>
                                <td><input max="255" min="0" name="r" value="<?php echo isset( $R ) ? $R : 250; ?>" /></td>
                            </tr>
                            <tr>
                                <td>Vert :</td>
                                <td><input max="255" min="0" name="g" value="<?php echo isset( $G ) ? $G : 250; ?>" /></td>
                            </tr>
                            <tr>
                                <td>Bleu :</td>
                                <td><input max="255" min="0" name="b" value="<?php echo isset( $B ) ? $B : 150; ?>" /></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>

            <input name="valid" type="submit" value="Valider" />
        </form>

        <hr />
        <?php
        try{
            $displayWidth = 500;
            $displayHeight = 400;
            $display = new Display( ( isset( $displayWidth ) ? $displayWidth : 400 ), ( isset( $displayHeight ) ? $displayHeight : 300 ) );
            $display->setRGB( array( 'red'=>220, 'green'=>220, 'blue'=>220 ) );

            if( isset( $valid ) ) :
                switch( $shape ) :
                    case 'rectangle':
                        echo 'On dessine un rectangle<br />';
                        $rectangle = new Rectangle( $width, $height, array( 'x'=>$X, 'y'=>$Y ) );
                        $display->drawRectangle( $rectangle, array( 'red'=>$R, 'green'=>$G, 'blue'=>$B ) );
                        break;
                    case 'circle':
                        echo 'On dessine un cercle<br />';
                        $cercle = new Circle( $radius, array( 'x'=>$X, 'y'=>$Y ) );
                        $display->drawCircle( $cercle, array( 'red'=>$R, 'green'=>$G, 'blue'=>$B ) );
                        break;
                    case 'square':
                        echo 'On dessine un carré<br />';
                        $carre = new Square( $side, $side, array( 'x'=>$X, 'y'=>$Y ) );
                        $display->drawSquare( $carre, array( 'red'=>$R, 'green'=>$G, 'blue'=>$B ) );
                        break;
                endswitch;
            endif;
            
            $display->createImage();
            $display->displayHTMLImage();

            if( isset( $valid ) ) :
                switch( $shape ) :
                    case 'rectangle':
                        $rectangle->showInformation();
                        break;
                    case 'circle':
                        $cercle->showInformation();
                        break;
                    case 'square':
                        $carre->showInformation();
                        break;
                endswitch;
            endif;
        } catch ( Exception $e ) {
            die( $e->getMessage() );
        }
        ?>
    </body>
</html>