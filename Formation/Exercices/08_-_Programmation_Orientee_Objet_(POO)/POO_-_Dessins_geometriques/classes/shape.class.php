<?php
/**
 * --------------------------------------------------
 * CLASSES
 * --------------------------------------------------
**/

/**
 * Définir une forme.
 * Description :
 *     Classe abstraite.
 * Propriétés :
 *     - (int) $_x : abscisse.
 *     - (int) $_y : ordonnée.
 * Méthodes :
 *     -  : .
 * Méthodes abstraites :
 *     - area       : Calculer l'aire de la forme.
 *     - perimeter  : Calculer le périmètre de la forme.
**/
abstract class Shape {
    /**
     * Déclarations des propriétés
    **/
    private $_x;
    private $_y;

    /**
     * Constructeur de classe
     * Paramètres :
     *     - (array) $p_coordinates : les coordonnées d'abscisse et d'ordonnée.
    **/
    public function __construct( $p_coordinates=array( 'x'=>0, 'y'=>0 ) ) {
        $this->_x = $p_coordinates['x'];
        $this->_y = $p_coordinates['y'];
    }

    /**
     * Getters
    **/
    public function getX() {
        return $this->_x;
    }
    public function getY() {
        return $this->_y;
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
    <legend>' . get_class() . '</legend>

    <table>
        <tr>
            <td>Abscisse</td>
            <td>' . $this->getX() . '</td>
        </tr>
        <tr>
            <td>Ordonnée</td>
            <td>' . $this->getY() . '</td>
        </tr>
    </table>
</fieldset>';
    }

    abstract public function area();
    abstract public function perimeter();
}