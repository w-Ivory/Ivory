<?php
require_once( 'piece.class.php' );
/**
 * ------------------------------------------------------------
 * KING PIECE (EXTENDS GAME PIECES CONTROL)
 * ------------------------------------------------------------
**/
class King extends Piece {
    /**
     * --------------------------------------------------
     * CONSTANTS
     * --------------------------------------------------
    **/
    const NAME = 'Roi';
    const BE_CHECK = true;


    /**
     * --------------------------------------------------
     * MAGIC METHODS
     * --------------------------------------------------
    **/
    /**
     * __construct - Class constructor
     * @param   string  $color
     *          string  $hexa
     *          string  $direction
     *          array   $square
     * @return  
    **/
    public function __construct( $color, $hexa, $direction, $square ) {
        parent::__construct( array(
                'name'          => self::NAME,
                'abbreviation'  => $hexa,
                'move'          => array(
                    'axis'      => array(
                        'H' => true,
                        'V' => true
                    ),
                    'number'    => 1,
                    'alternate' => true,
                    'jump'      => array(
                        'friends'   => false,
                        'opponents' => false
                    )
                ),
                'direction'     => $direction,
                'color'         => $color,
                'place'         => $square
            )
        );
        parent::$_pieces[] = $this;
    }
}