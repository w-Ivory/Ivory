<?php
/**
 * ------------------------------------------------------------
 * GAME PIECES CONTROL
 * ------------------------------------------------------------
**/
abstract class Piece {
    /**
     * --------------------------------------------------
     * CONSTANTS
     * --------------------------------------------------
    **/
    const IN_GAME = 1;
    const OUT_GAME = 0;
    /**
     * --------------------------------------------------
     * STATICS
     * --------------------------------------------------
    **/
    protected static $_pieces = [];
    /**
     * --------------------------------------------------
     * PROPERTIES
     * --------------------------------------------------
    **/
    private $_prop = [];



    /**
     * --------------------------------------------------
     * MAGIC METHODS
     * --------------------------------------------------
    **/
    /**
     * __construct - Class constructor
     * @param   array   $settings
     * @return  
    **/
    public function __construct( $settings = null ) {
        if( !is_null( $settings ) ) :
            foreach( $settings as $property=>$value ) :
                $this->$property = $value;
            endforeach;

            $this->status = self::IN_GAME;
        endif;
    }

    /**
     * __set - Setter
     * @param   string  $property
     *          mixed   $value
     * @return  
    **/
    public function __set( $property, $value ) {
        $this->_prop[$property] = $value;
    }
    
    /**
     * __get - Getter
     * @param   string  $property
     * @return  mixed
    **/
    public function __get( $property ) {
        return ( isset( $this->_prop ) && array_key_exists( $property, $this->_prop ) ? $this->_prop[$property] : false );
    }



    /**
     * --------------------------------------------------
     * METHODS
     * --------------------------------------------------
    **/
    /**
     * isFriend - Checks if a piece is friend
     * @param   object  $piece
     * @return  mixed (bool|null)
    **/
    public function isFriend( $piece = null ) {
        // if( !empty( $piece ) ) {
        //     if( $this->color==$piece->color ) {
        //         return true;
        //     } else {
        //         return false;
        //     }
        // }
        // return null;

        return ( !empty( $piece ) ? ( $this->color==$piece->color ) : null );
    }

    /**
     * composeName - Determines the name of a piece based on the code for the font or the full name associated with color
     * @param   object  $piece
     *          bool    $font
     * @return  string
    **/
    public function composeName( $piece, $font = false ) {
        if( $font )
            if( empty( $piece ) || $this == $piece )
                return '&#' . $this->abbreviation . ';';
            else
                return '&#' . ( $this->abbreviation - 32 ) . ';';
        else
            return $this->name . '<br />' . $this->color;
    }
    
    /**
     * canMoveOnTheAxis - Determines whether the piece can move on the specified axis
     * @param   char    $axis
     * @return  bool
    **/
    public function canMoveOnTheAxis( $axis ) {
        switch( $axis ) :
            case 'x':
                return $this->move['axis']['H'];
                break;
            case 'y':
                return $this->move['axis']['V'];
                break;
        endswitch;
    }

    /**
     * canTurnBack - Determines whether the piece can turn back
     * @param   
     * @return  bool
    **/
    public function canTurnBack() {
        return $this->move['alternate'];
    }

    /**
     * canJumpOverFriend - Determines whether the piece can jump over a friend
     * @param   
     * @return  bool
    **/
    public function canJumpOverFriend() {
        return $this->move['jump']['friends'];
    }

    /**
     * canJumpOverOpponent - Determines whether the piece can jump over an opponent
     * @param   
     * @return  bool
    **/
    public function canJumpOverOpponent() {
        return $this->move['jump']['opponents'];
    }
}