<?php
/**
 * Inclure un fichier en fonction de son nom.
 * Description :
 *     On récupère le nom d'une classe/interface/trait et on inclut le fichier correspondant si ce dernier existe.
 * Paramètres :
 *     - (string) $v_name : nom de la classe/interface/trait
**/
function loadClass( $className ) {
    $_file_ = 'classes/' . strtolower( $className ) . '.class.php';
    if( file_exists( $_file_ ) ) :
        require_once( $_file_ );
    endif;
    $_file_ = 'interfaces/' . strtolower( $className ) . '.interface.php';
    if( file_exists( $_file_ ) ) :
        require_once( $_file_ );
    endif;
}
spl_autoload_register( 'loadClass' ); // On lance la procédure d'auto-chargement des classes avec la fonction "includeClass" en callback.
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0" />
        <title>POO avancée - Mise en pratique</title>

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
            /* ------    générales    ------ */
            fieldset {
                border:none;
                border-top:rgba(0,0,0,.5) thin solid;
                display:block;
                margin:10px auto;margin:1rem auto;
                vertical-align:top;
                width:80%;
            }
                fieldset legend {
                    background-color:rgb(21,21,21);
                    color:rgb(255,255,255);
                    display:inline-block;
                    font-weight:bold;
                    margin:0 15px;margin:0 1.5rem;
                    padding:10px 5px;padding:1rem .5rem;
                    text-transform:uppercase;
                }
                fieldset ul,fieldset ol {margin:0;}
            -->
        </style>
    </head>
    <body>
        <h1>POO avancée (Abstract / Interfaces) - Mise en pratique</h1>
        <hr />
        <p><em>En fonction de l'énoncé fourni dans le fichier pdf, concevoir les classes, héritages, abstraction, interfaces et traits semblant être appropriés.</em></p>
        <fieldset id="car">
            <legend>Voiture</legend>

            <?php
            $voiture = new Car; // On instancie un objet de type "voiture".
            $voiture->unlockCabin(); // On déverrouille le véhicule.
            $voiture->sit(); // On prend place comme conducteur.
            $voiture->move(); // On se déplace.

            unset( $voiture ); // On détruit le véhicule.
            ?>
        </fieldset>
        <fieldset id="truck">
            <legend>Camion</legend>

            <?php
            $camion = new Truck; // On instancie un objet de type "camion-benne".
            $camion->unlockCabin(); // On déverrouille le véhicule.
            $camion->pack(); // On charge la benne/remorque.
            $camion->sit(); // On prend place comme conducteur.
            $camion->move(); // On se déplace.
            $camion->unpack(); // On décharge la benne/remorque.

            unset( $camion ); // On détruit le véhicule.
            ?>
        </fieldset>
        <fieldset id="cycle">
            <legend>Vélo</legend>

            <?php
            $velo = new Cycle; // On instancie un objet de type "vélo avec remorque".
            $velo->pack(); // On charge la benne/remorque.
            $velo->sit(); // On prend place comme conducteur.
            $velo->move(); // On se déplace.
            $velo->unpack(); // On décharge la benne/remorque.

            unset( $velo ); // On détruit le véhicule.
            ?>
        </fieldset>
    </body>
</html>