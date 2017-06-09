<?php
/**
 * --------------------------------------------------
 * CLASSES
 * --------------------------------------------------
**/
require_once( 'shape.class.php' );

/**
 * Définir un rectangle.
 * Description :
 *     Elle permet de construire un rectangle géomètrique. Un rectangle est défini par sa hauteur et sa largeur.
 * Propriétés :
 *     - () $ : .
 * Méthodes :
 *     -  : .
**/
class Rectangle extends Shape {
    /**
     * Déclarations des propriétés
    **/
    private $_width;
    private $_height;

    /**
     * Constructeur de classe
     * Paramètres :
     *     - (int) $p_width     : la largeur du rectangle.
     *     - (int) $p_height    : la hauteur du rectangle.
    **/
    public function __construct( $p_width , $p_height, $p_coordinates=array( 'x'=>0, 'y'=>0 ) ) {
        parent::__construct( $p_coordinates );
        $this->_width = abs( $p_width ); // On force la largeur à être supérieure à zéro.
        $this->_height = abs( $p_height ); // On force la hauteur à être supérieure à zéro.
    }

    /**
     * Setters
    **/
    public function setWidth( $p_val ) {
        $this->_width = abs( $p_val );
    }
    public function setHeight( $p_val ) {
        $this->_height = abs( $p_val );
    }

    /**
     * Getters
    **/
    public function getWidth() {
        return $this->_width;
    }
    public function getHeight() {
        return $this->_height;
    }
    
    /**
     * Méthodes
    **/
    /**
     * Afficher les dimensions du rectangle, son aire et son perimetre.
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
            <td>Largeur</td>
            <td>' . $this->getWidth() . '</td>
        </tr>
        <tr>
            <td>Hauteur</td>
            <td>' . $this->getHeight() . '</td>
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
        return $this->getWidth() * $this->getHeight();
    }
    public function perimeter() {
        return ( $this->getWidth() + $this->getHeight() ) * 2;
    }
}