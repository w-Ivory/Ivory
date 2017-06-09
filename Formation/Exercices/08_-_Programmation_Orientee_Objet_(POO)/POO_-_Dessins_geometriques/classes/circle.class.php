<?php
require_once( 'shape.class.php' );
class Circle extends Shape {
    /**
     * Déclarations des propriétés
    **/
    private $_radius;

    /**
     * Constructeur de classe
     * Paramètres :
     *     - (int) $p_width     : la largeur du cercle.
     *     - (int) $p_height    : la hauteur du cercle.
    **/
    public function __construct( $p_radius, $p_coordinates=array( 'x'=>0, 'y'=>0 ) ) {
        parent::__construct( $p_coordinates );
        $this->_radius = abs( $p_radius ); // On force le rayon à être supérieure à zéro.
    }

    /**
     * Setters
    **/
    public function setRadius( $p_val ) {
        $this->_radius = abs( $p_val );
    }

    /**
     * Getters
    **/
    public function getRadius() {
        return $this->_radius;
    }
    
    /**
     * Méthodes
    **/
    /**
     * Afficher les dimensions du cercle, son aire et son perimetre.
     * Description :
     *     On fait une sortie écran des informations.
     * Paramètres :
     *     - () $ : .
    **/
    public function showInformation() {
        echo '<fieldset>
    <legend>' . get_class( $this ) . '</legend>

    <table>
        <tr>
            <td>Rayon</td>
            <td>' . $this->getRadius() . '</td>
        </tr>
        <tr>
            <td>Aire</td>
            <td>' . $this->area() . '</td>
        </tr>
        <tr>
            <td>Périmètre</td>
            <td>' . $this->perimeter() . '</td>
        </tr>
    </table>
</fieldset>';
    }

    public function area() {
        return pi() * pow( $this->getRadius(), 2 );
    }
    public function perimeter() {
        return 2 * pi() * $this->getRadius();
    }
}