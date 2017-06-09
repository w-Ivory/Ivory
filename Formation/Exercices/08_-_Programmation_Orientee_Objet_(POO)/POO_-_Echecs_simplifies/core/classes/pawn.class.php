<?php
require_once( 'piece.class.php' );
/**
 * ------------------------------------------------------------
 * PAWN PIECE (EXTENDS GAME PIECES CONTROL)
 * ------------------------------------------------------------
**/
class Pawn extends Piece {
    /**
     * --------------------------------------------------
     * CONSTANTS
     * --------------------------------------------------
    **/
    const NAME = 'Pion';
    const BE_CHECK = false;



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
                        'V' => false
                    ),
                    'number'    => 1,
                    'alternate' => false,
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