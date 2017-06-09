<?php
require_once( 'piece.class.php' );
/**
 * ------------------------------------------------------------
 * KNIGHT PIECE (EXTENDS GAME PIECES CONTROL)
 * ------------------------------------------------------------
**/
class Knight extends Piece {
    /**
     * --------------------------------------------------
     * CONSTANTS
     * --------------------------------------------------
    **/
    const NAME = 'Cavalier';
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
                        'V' => true
                    ),
                    'number'    => 3,
                    'alternate' => true,
                    'jump'      => array(
                        'friends'   => true,
                        'opponents' => true
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