<?php
/**
 * --------------------------------------------------
 * CLASSES
 * --------------------------------------------------
**/
require_once( 'rectangle.class.php' );
require_once( 'square.class.php' );
require_once( 'circle.class.php' );

/**
 * Afficher une forme.
 * Description :
 *     .
 * Propriétés :
 *     - (int) $_width      : la largeur du rectangle.
 *     - (int) $_height     : la hauteur du rectangle.
 *     - (int) $_filename   : le nom du fichier de sortie.
 *     - (array) $_rgb      : les couleurs de sortie.
 *     - () $_resource      : la ressource représentant une image.
 * Méthodes :
 *     -  : .
**/
class Display {
    private $_width;
    private $_height;
    private $_filename;
    private $_rgb;    
    public $_resource;
    
    /**
     * Constructeur de classe
     * Paramètres :
     *     - () $ : .
    **/
    public function __construct( $p_width, $p_height, $p_filename='tmp.png', $p_rgb=array( 'red'=>255, 'green'=>255, 'blue'=>255 ) ) {
        $this->_width = $p_width;
        $this->_height = $p_height;
        $this->_filename = $p_filename;
        $this->_resource = imagecreatetruecolor( $this->_width, $this->_height ); // On crée une nouvelle image en couleurs vraies (http://php.net/manual/fr/function.imagecreatetruecolor.php).
        
        $this->setRGB( $p_rgb );
    }
    /**
     * Destructeur de classe
     * Paramètres :
     *     - () $ : .
    **/
    public function __destruct() { 
        imagedestroy( $this->_resource ); // On détruit l'image.
    }

    /**
     * Setters
    **/
    public function setRGB( $p_rgb=array( 'red'=>255, 'green'=>255, 'blue'=>255 ) ) {
        if( is_array( $p_rgb ) ) :
            $this->_rgb = $p_rgb;
            $this->init(); // On réinitialise la couleur de fond de l'image.

            return true;
        endif;

        throw new Exception( 'Set correct RGB information using : array( \'red\'=>255, \'green\'=>255, \'blue\'=>255 )' );
        return false;
    }

    /**
     * Méthodes magiques
    **/
    public function __toString() {
        return '<fieldset>
    <legend>Attributs de l\'image</legend>

    <table>
        <tr>
            <td>Largeur</td>
            <td>' . $this->_width . '</td>
        </tr>
        <tr>
            <td>Hauteur</td>
            <td>' . $this->_height . '</td>
        </tr>
        <tr>
            <td>Fichier</td>
            <td>' . $this->_filename . '</td>
        </tr>
        <tr>
            <td>Couleur de fond</td>
            <td>R: ' . $this->_rgb['red'] . ' G: ' . $this->_rgb['green'] . ' B: ' . $this->_rgb['blue'] . '</td>
        </tr>
    </table>
</fieldset>';
    }

    /**
     * Méthodes
    **/
    /**
     * Initialiser un dessin en forme de rectangle.
     * Description :
     *     On alloue la couleur de fond puis dessine la forme.
     * Paramètres :
     *     - () $ : .
    **/
    public function init() {
        $color = imagecolorallocate( $this->_resource, $this->_rgb['red'], $this->_rgb['green'], $this->_rgb['blue'] ); // On alloue une couleur pour une image (http://php.net/manual/fr/function.imagecolorallocate.php).
        imagefilledrectangle( $this->_resource, 0, 0, $this->_width, $this->_height, $color ); // On dessine un rectangle rempli.
    }
    /**
     * Créer le fichier image.
     * Description :
     *     .
     * Paramètres :
     *     - () $ : .
    **/
    public function createImage() {
        imagepng( $this->_resource, $this->_filename ); // On envoie une image PNG vers un fichier.
    }
    /**
     * Enregistrer l'image sous un nouveau nom.
     * Description :
     *     .
     * Paramètres :
     *     - (string) $p_filename : le nouveau nom du fichier.
    **/
    public function saveAs( $p_filename ) {
        $this->_filename = $p_filename;
        imagepng( $this->_resource, $this->_filename );  
    }
    /**
     * Afficher l'image sous forme de balise HTML.
     * Description :
     *     .
     * Paramètres :
     *     - () $ : .
    **/
    public function displayHTMLImage() {
        echo '<img alt="" src="' . $this->_filename . '" />';
    }
    /**
     * Dessiner un rectangle.
     * Description :
     *     .
     * Paramètres :
     *     - () $ : .
    **/
    public function drawRectangle( $p_shape, $p_rgb ) {
        $color = imagecolorallocate( $this->_resource, $p_rgb['red'], $p_rgb['green'], $p_rgb['blue'] );
        $x1 = $p_shape->getX() - $p_shape->getWidth() / 2;
        $y1 = $p_shape->getY() - $p_shape->getHeight() / 2;
        $x2 = $p_shape->getX() + $p_shape->getWidth() / 2;
        $y2 = $p_shape->getY() + $p_shape->getHeight() / 2;
        imagefilledrectangle( $this->_resource, $x1, $y1, $x2, $y2, $color );
    }
    /**
     * Dessiner un carré.
     * Description :
     *     .
     * Paramètres :
     *     - () $ : .
    **/
    public function drawSquare( $p_shape, $p_rgb ) {
        $this->drawRectangle( $p_shape, $p_rgb );      
    }  
    /**
     * Dessiner un circle.
     * Description :
     *     .
     * Paramètres :
     *     - () $ : .
    **/
    public function drawCircle( $p_shape, $p_rgb ) {
        $color = imagecolorallocate( $this->_resource, $p_rgb['red'], $p_rgb['green'], $p_rgb['blue'] );
        imagefilledellipse( $this->_resource, $p_shape->getX(), $p_shape->getY(), $p_shape->getRadius() * 2, $p_shape->getRadius() * 2, $color );
    }
}