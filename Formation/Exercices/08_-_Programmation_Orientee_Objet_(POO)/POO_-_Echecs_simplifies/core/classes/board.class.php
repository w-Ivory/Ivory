<?php
/**
 * ------------------------------------------------------------
 * BOARD CONTROL
 * ------------------------------------------------------------
**/
class Board {
    /**
     * --------------------------------------------------
     * CONSTANTS
     * --------------------------------------------------
    **/
    const TEAM_WHITE = 'blanc';
    const TEAM_BLACK = 'noir';
    const DIRECTION_TEAM_WHITE = '+';
    const DIRECTION_TEAM_BLACK = '-';
    const DEFAULT_TEAM = 'blanc';
    const CLASS_CHESSBOARD = 'chessBoard';
    const SQUARES_COUNT_X = 8;
    const SQUARES_COUNT_Y = 8;
    const SQUARES_SIZE = 60;
    /**
     * --------------------------------------------------
     * PROPERTIES
     * --------------------------------------------------
    **/
    private $_squares = [];
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
        if( !is_null( $settings ) )
            foreach( $settings as $property=>$value ) :
                $this->$property = $value;
            endforeach;

        $this->init();
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
        if( isset( $this->_prop ) && array_key_exists( $property, $this->_prop ) )
            return $this->_prop[$property];
    }

    /**
     * __unset - Unsetter
     * @param   string  $property
     * @return  
    **/
    public function __unset( $property ) {
        if( isset( $this->_prop ) && array_key_exists( $property, $this->_prop ) )
            unset( $this->_prop[$property] );
    }

    /**
     * __toString - Makes the object as a string
     * @param   
     * @return  string
    **/
    public function __toString() {
        return 'Vous devez appeler les méthodes plubliques printStyle() et printBoard() pour obtenir l\'échiquier.';
    }



    /**
     * --------------------------------------------------
     * SETTERS
     * --------------------------------------------------
    **/
    /**
     * setSquare - Fills a square of the chessboard
     * @param   int     $x
     *          int     $y
     *          object  $piece
     * @return  
    **/
    public function setSquare( $x, $y, $piece = null ) {
        $piece->place = array( 'x'=>$x, 'y'=>$y );
        $this->_squares[$y][$x] = $piece;
    }



    /**
     * --------------------------------------------------
     * UNSETTERS
     * --------------------------------------------------
    **/
    /**
     * unsetSquare - Empties a square of the chessboard
     * @param   int     $x
     *          int     $y
     * @return  bool
    **/
    public function unsetSquare( $x, $y ) {
        if( isset( $this->_squares[$y][$x] ) ) :
            unset( $this->_squares[$y][$x] );

            return true;
        endif;
        
        return false;
    }



    /**
     * --------------------------------------------------
     * GETTERS
     * --------------------------------------------------
    **/
    /**
     * getSquare - Returns a square of the chessboard
     * @param   int     $x
     *          int     $y
     * @return  mixed (object|null)
    **/
    public function getSquare( $x, $y ) {
        return ( isset( $this->_squares[$y][$x] ) ? $this->_squares[$y][$x] : null );
    }



    /**
     * --------------------------------------------------
     * METHODS
     * --------------------------------------------------
    **/
    /**
     * init - Inits pieces on the chessboard
     * @param   array   $pieces
     * @return  
    **/
    public function init( $pieces = [] ) {
        foreach( $pieces as $item ) :
            $this->setSquare( $item['x'], $item['y'], ( isset( $item['piece'] ) ? $item['piece'] : null ) );
        endforeach;
    }

    /**
     * isOnBoard - Checks the coordinates are part of the squares of the chessboard
     * @param   int     $x
     *          int     $y
     * @return  bool
    **/
    private function isOnBoard( $x, $y ) {
        return ( $x>0 && $x<=self::SQUARES_COUNT_X && $y>0 && $y<=self::SQUARES_COUNT_Y );
    }

    /**
     * isEmpty - Checks if the square is free
     * @param   int     $x
     *          int     $y
     * @return  bool
    **/
    private function isEmpty( $x, $y ) {
        return ( $this->isOnBoard( $x, $y ) && ( is_null( $this->getSquare( $x, $y ) ) || !$this->getSquare( $x, $y ) ) );
    }

    /**
     * isAvailable - Checks if the square is playable
     * @param   int     $x
     *          int     $y
     * @return  bool
    **/
    private function isAvailable( $x, $y ) {
        return ( $this->isOnBoard( $x, $y ) && $this->isEmpty( $x, $y ) );
    }

    /**
     * isDirectionOK - Checks if the can move in that direction
     * @param   object  $piece
     *          array   $moveto
     * @return  bool
    **/
    public function isDirectionOK( $piece, $moveto ) {
        return (
            $piece->canTurnBack()
            || ( $piece->direction=='+' && $moveto['x']>$piece->place['x'] )
            || ( $piece->direction=='-' && $moveto['x']<$piece->place['x'] )
        );
    }

    /**
     * isDistanceOK - Checks if the can access to the square according to its moving capabilities
     * @param   object  $piece
     *          array   $moveto
     * @return  bool
    **/
    public function isDistanceOK( $piece, $moveto ) {
        return (
            (
                $piece->canMoveOnTheAxis( 'x' )
                && (
                    $piece->move['number']==INF
                    || ( ( $piece->place['x'] + $piece->move['number'] ) - $moveto['x'] ) === 0
                    || ( ( $piece->place['x'] - $piece->move['number'] ) - $moveto['x'] ) === 0
                )
                && $piece->place['y']==$moveto['y']
            )
            ||
            (
                $piece->canMoveOnTheAxis( 'y' )
                && (
                    $piece->move['number']==INF
                    || ( ( $piece->place['y'] + $piece->move['number'] ) - $moveto['y'] ) === 0
                    || ( ( $piece->place['y'] - $piece->move['number'] ) - $moveto['y'] ) === 0
                )
                && $piece->place['x']==$moveto['x']
            )
        );
    }

    /**
     * isPieceInTheWay - Checks if a piece is in the way
     * @param   object  $piece
     *          array   $moveto
     * @return  bool
    **/
    private function isPieceInTheWay( $piece, $moveto ) {
        if( $piece->place['y']==$moveto['y'] )
            if( $piece->place['x']>=$moveto['x'] )
                for( $i = $piece->place['x']; $i>=$moveto['x']; $i-- ) :
                    if( !empty( $this->getSquare( $i, $moveto['y'] ) ) ) return true;
                endfor;
            else
                for( $i = $piece->place['x']; $i<=$moveto['x']; $i++ ) :
                    if( !empty( $this->getSquare( $i, $moveto['y'] ) ) ) return true;
                endfor;
        elseif( $piece->place['x']==$moveto['x'] )
            if( $piece->place['y']>=$moveto['y'] )
                for($i = $piece->place['y']; $i>=$moveto['y']; $i--) :
                    if( !empty( $this->getSquare( $moveto['x'], $i ) ) ) return true;
                endfor;
            else
                for( $i = $piece->place['y']; $i<=$moveto['y']; $i++ ) :
                    if( !empty( $this->getSquare( $moveto['x'], $i ) ) ) return true;
                endfor;

        return false;
    }

    /**
     * isInTheWay - Checks if a piece is in the way
     * @param   object  $piece
     *          array   $moveto
     *          bool    $same
     * @return  bool
    **/
    private function isInTheWay( $piece, $moveto, $same ) {
        if( $piece->place['y']==$moveto['y'] )
            if( $piece->place['x']>=$moveto['x'] )
                for( $i = $piece->place['x']-1; $i>$moveto['x']; $i-- ) :
                    if( $piece->isFriend( $this->getSquare( $i, $moveto['y'] ) )===$same ) return true;
                endfor;
            else
                for( $i = $piece->place['x']+1; $i<$moveto['x']; $i++ ) :
                    if( $piece->isFriend( $this->getSquare( $i, $moveto['y'] ) )===$same ) return true;
                endfor;
        elseif( $piece->place['x']==$moveto['x'] )
            if( $piece->place['y']>=$moveto['y'] )
                for($i = $piece->place['y']-1; $i>$moveto['y']; $i--) :
                    if( $piece->isFriend( $this->getSquare( $moveto['x'], $i ) )===$same ) return true;
                endfor;
            else
                for( $i = $piece->place['y']+1; $i<$moveto['y']; $i++ ) :
                    if( $piece->isFriend( $this->getSquare( $moveto['x'], $i ) )===$same ) return true;
                endfor;

        return false;
    }

    /**
     * isEnemyInTheWay - Checks if an enemy piece is in the way
     * @param   object  $piece
     *          array   $moveto
     * @return  bool
    **/
    private function isEnemyInTheWay( $piece, $moveto ) {
        return $this->isInTheWay( $piece, $moveto, false );
    }

    /**
     * isFriendInTheWay - Checks if a friend piece is in the way
     * @param   object  $piece
     *          array   $moveto
     * @return  bool
    **/
    private function isFriendInTheWay( $piece, $moveto ) {
        return $this->isInTheWay( $piece, $moveto, true );
    }

    /**
     * isJumpOK - Checks if jump is possible over another piece
     * @param   object  $piece
     *          array   $moveto
     * @return  bool
    **/
    public function isJumpOK( $piece, $moveto ) {
        if( $this->isPieceInTheWay( $piece, $moveto ) ) :
            if( $this->isFriendInTheWay( $piece, $moveto ) )
                if( !$piece->canJumpOverFriend() )
                    return false;

            if( $this->isEnemyInTheWay( $piece, $moveto ) )
                if( !$piece->canJumpOverOpponent() )
                    return false;
        endif;

        return true;
    }

    /**
     * isPieceMovable - Checks if the can be moved
     * @param   object  $piece
     *          array   $moveto
     * @return  bool
    **/
    public function isPieceMovable( $piece, $moveto ) {
        if( $piece->move['number']==INF && empty( $moveto ) )
            return true;

        if( $piece->canMoveOnTheAxis( 'x' ) && $piece->canMoveOnTheAxis( 'y' ) )
            if( $piece->canTurnBack() ) :
                $positive_x = $piece->move['number']!=INF && empty( $moveto ) ? ( $piece->place['x'] + $piece->move['number'] ) : $moveto['x'];
                $negative_x = $piece->move['number']!=INF && empty( $moveto ) ? ( $piece->place['x'] - $piece->move['number'] ) : $moveto['x'];
                $positive_target_x = $this->getSquare( $positive_x, $piece->place['y'] );
                $negative_target_x = $this->getSquare( $negative_x, $piece->place['y'] );

                $positive_y = $piece->move['number']!=INF && empty( $moveto ) ? ( $piece->place['y'] + $piece->move['number'] ) : $moveto['y'];
                $negative_y = $piece->move['number']!=INF && empty( $moveto ) ? ( $piece->place['y'] - $piece->move['number'] ) : $moveto['y'];
                $positive_target_y = $this->getSquare( $piece->place['x'], $positive_y );
                $negative_target_y = $this->getSquare( $piece->place['x'], $negative_y );
                
                return (
                    (
                        (
                            $this->isAvailable( $positive_x, $piece->place['y'] )
                            || (
                                !( is_null( $positive_target_x )
                                || !$positive_target_x
                            )
                            && $piece->isFriend( $positive_target_x )!==true )
                        ) || (
                            $this->isAvailable( $negative_x, $piece->place['y'] )
                            || (
                                !( is_null( $negative_target_x )
                                || !$negative_target_x
                            )
                            && $piece->isFriend( $negative_target_x )!==true )
                        )
                    ) || (
                        (
                            $this->isAvailable( $piece->place['x'], $positive_y )
                            || (
                                !( is_null( $positive_target_y )
                                || !$positive_target_y
                            )
                            && $piece->isFriend( $positive_target_y )!==true )
                        ) || (
                            $this->isAvailable( $piece->place['x'], $negative_y )
                            || (
                                !( is_null( $negative_target_y )
                                || !$negative_target_y
                            )
                            && $piece->isFriend( $negative_target_y )!==true )
                        )
                    )
                );
            else :
                switch( $piece->direction ) :
                    case '+':
                        $x = $piece->move['number']!=INF && empty( $moveto ) ? ( $piece->place['x'] + $piece->move['number'] ) : $moveto['x'];
                        $y = $piece->move['number']!=INF && empty( $moveto ) ? ( $piece->place['y'] + $piece->move['number'] ) : $moveto['y'];
                        break;
                    case '-':
                        $x = $piece->move['number']!=INF && empty( $moveto ) ? ( $piece->place['x'] - $piece->move['number'] ) : $moveto['x'];
                        $y = $piece->move['number']!=INF && empty( $moveto ) ? ( $piece->place['y'] - $piece->move['number'] ) : $moveto['y'];
                        break;
                endswitch;
                $target = $this->getSquare( $x, $y );

                return ( ( $this->isAvailable( $x, $y ) || ( !( is_null( $target ) || !$target ) && $piece->isFriend( $target )!==true ) ) && $this->isDirectionOK( $piece, array( 'x' => $x, 'y' => $y ) ) );
            endif;
        else
            if( $piece->canMoveOnTheAxis( 'x' ) )
                if( $piece->canTurnBack() ) :
                    $positive_x = $piece->move['number']!=INF && empty( $moveto ) ? ( $piece->place['x'] + $piece->move['number'] ) : $moveto['x'];
                    $negative_x = $piece->move['number']!=INF && empty( $moveto ) ? ( $piece->place['x'] - $piece->move['number'] ) : $moveto['x'];
                    $positive_target = $this->getSquare( $positive_x, $piece->place['y'] );
                    $negative_target = $this->getSquare( $negative_x, $piece->place['y'] );
                    
                    return (
                        (
                            $this->isAvailable( $positive_x, $piece->place['y'] )
                            || (
                                !( is_null( $positive_target )
                                || !$positive_target
                            )
                            && $piece->isFriend( $positive_target )!==true )
                        ) || (
                            $this->isAvailable( $negative_x, $piece->place['y'] )
                            || (
                                !( is_null( $negative_target )
                                || !$negative_target
                            )
                            && $piece->isFriend( $negative_target )!==true )
                        )
                    );
                else :
                    switch( $piece->direction ) :
                        case '+':
                            $x = $piece->move['number']!=INF && empty( $moveto ) ? ( $piece->place['x'] + $piece->move['number'] ) : $moveto['x'];
                            break;
                        case '-':
                            $x = $piece->move['number']!=INF && empty( $moveto ) ? ( $piece->place['x'] - $piece->move['number'] ) : $moveto['x'];
                            break;
                    endswitch;
                    $target = $this->getSquare( $x, $piece->place['y'] );

                    return ( ( $this->isAvailable( $x, $piece->place['y'] ) || ( !( is_null( $target ) || !$target ) && $piece->isFriend( $target )!==true ) ) && $this->isDirectionOK( $piece, array( 'x' => $x, 'y' => $piece->place['y'] ) ) );
                endif;
            elseif( $piece->canMoveOnTheAxis( 'y' ) )
                if( $piece->canTurnBack() ) :
                    $positive_y = $piece->move['number']!=INF && empty( $moveto ) ? ( $piece->place['y'] + $piece->move['number'] ) : $moveto['y'];
                    $negative_y = $piece->move['number']!=INF && empty( $moveto ) ? ( $piece->place['y'] - $piece->move['number'] ) : $moveto['y'];
                    $positive_target = $this->getSquare( $piece->place['x'], $positive_y );
                    $negative_target = $this->getSquare( $piece->place['x'], $negative_y );
                    
                    return (
                        (
                            $this->isAvailable( $piece->place['x'], $positive_y )
                            || (
                                !( is_null( $positive_target )
                                || !$positive_target
                            )
                            && $piece->isFriend( $positive_target )!==true )
                        ) || (
                            $this->isAvailable( $piece->place['x'], $negative_y )
                            || (
                                !( is_null( $negative_target )
                                || !$negative_target
                            )
                            && $piece->isFriend( $negative_target )!==true )
                        )
                    );
                else :
                    switch( $piece->direction ) :
                        case '+':
                            $y = $piece->move['number']!=INF && empty( $moveto ) ? ( $piece->place['y'] + $piece->move['number'] ) : $moveto['y'];
                            break;
                        case '-':
                            $y = $piece->move['number']!=INF && empty( $moveto ) ? ( $piece->place['y'] - $piece->move['number'] ) : $moveto['y'];
                            break;
                    endswitch;
                    $target = $this->getSquare( $piece->place['x'], $y );
                    
                    return ( ( $this->isAvailable( $piece->place['x'], $y ) || ( !( is_null( $target ) || !$target ) && $piece->isFriend( $target )!==true ) ) && $this->isDirectionOK( $piece, array( 'x' => $piece->place['x'], 'y' => $y ) ) );
                endif;
    }

    /**
     * printStyle - Displays the style of the chessboard
     * @param   
     * @return  
    **/
    public function printStyle() {
        echo '
<style type="text/css">
    <!--
    ' . ( isset( $this->font['file'] ) && file_exists( $this->font['file'] ) && isset( $this->font['name'] ) ? '@font-face {
        font-family:\'' . $this->font['name'] . '\';
        src:url(\'' . $this->font['file'] . '\') format(\'truetype\');
        font-weight:normal;
        font-style:normal;
    }' : '' ) . '
    .font-chess {
        font-family:' . ( isset( $this->font['file'] ) && file_exists( $this->font['file'] ) && isset( $this->font['name'] ) ? '\'' . $this->font['name'] . '\', ' : '' ) . 'sans-serif;
    }
    .' . self::CLASS_CHESSBOARD . ' {
        border-collapse:collapse;
        border:none;
        color:' . ( isset( $this->color['text']['all'] ) ? $this->color['text']['all'] : 'rgb(21,21,21)' ) . ';
        font-size:' . ( self::SQUARES_SIZE * ( 25 / 100 ) ) . 'px;
        /*height:' . ( self::SQUARES_SIZE * self::SQUARES_COUNT_Y ) . 'px;*/
        table-layout:fixed;
        /*width:' . ( self::SQUARES_SIZE * self::SQUARES_COUNT_X ) . 'px;*/
    }
    .' . self::CLASS_CHESSBOARD . '::before {
        border-color:transparent;
        border-style:solid;
        border-width:10px;

        border-top-color:' . ( isset( $this->color['borders']['top'] ) ? $this->color['borders']['top'] : 'rgb(182,132,99)' ) . ';
        border-right-color:' . ( isset( $this->color['borders']['right'] ) ? $this->color['borders']['right'] : 'rgb(73,38,18)' ) . ';
        border-bottom-color:' . ( isset( $this->color['borders']['bottom'] ) ? $this->color['borders']['bottom'] : 'rgb(42,10,0)' ) . ';
        border-left-color:' . ( isset( $this->color['borders']['left'] ) ? $this->color['borders']['left'] : 'rgb(120,84,52)' ) . ';
        
        content:\'\';
        bottom:-10px;
        height:' . ( ( self::SQUARES_SIZE * self::SQUARES_COUNT_Y ) + 20 ) . 'px;
        position:absolute;
        right:-10px;
        width:' . ( ( self::SQUARES_SIZE * self::SQUARES_COUNT_X ) + 20 ) . 'px;
        z-index:-1;
    }
            .' . self::CLASS_CHESSBOARD . ' tr > th { padding:10px; }
            .' . self::CLASS_CHESSBOARD . ' tr > td {
                background-color:' . ( isset( $this->color['board'] ) ? $this->color['board'] : 'rgb(240,217,181)' ) . ';
                cursor:default;
                font-family:' . ( isset( $this->font['file'] ) && file_exists( $this->font['file'] ) && isset( $this->font['name'] ) ? '\'' . $this->font['name'] . '\', ' : '' ) . 'sans-serif;
                font-size:' . ( isset( $this->font['file'] ) && file_exists( $this->font['file'] ) && isset( $this->font['name'] ) ? self::SQUARES_SIZE * ( 60 / 100 ) : self::SQUARES_SIZE * ( 25 / 100 ) ) . 'px;
                height:' . self::SQUARES_SIZE . 'px;
                position:relative;
                text-align:center;
                vertical-align:middle;
                width:' . self::SQUARES_SIZE . 'px;
            }
            .' . self::CLASS_CHESSBOARD . ' tr:first-child > th { padding-bottom:20px; }
            .' . self::CLASS_CHESSBOARD . ' tr:not(:first-child) > th { padding-right:20px; }
            .' . self::CLASS_CHESSBOARD . ' tr:nth-child( 2n ) > td:nth-child( 2n ) {
                background-color:' . ( isset( $this->color['alternate'] ) ? $this->color['alternate'] : 'rgb(181,136,99)' ) . ';
            }
            .' . self::CLASS_CHESSBOARD . ' tr:nth-child( 2n+1 ) > td:nth-child( 2n+1 ) {
                background-color:' . ( isset( $this->color['alternate'] ) ? $this->color['alternate'] : 'rgb(181,136,99)' ) . ';
            }
            .' . self::CLASS_CHESSBOARD . ' tr > td.' . self::TEAM_WHITE . ' { color:' . ( isset( $this->color['text']['light'] ) ? $this->color['text']['light'] : 'rgb(255,255,255)' ) . '; }
            .' . self::CLASS_CHESSBOARD . ' tr > td.' . self::TEAM_BLACK . ' { color:' . ( isset( $this->color['text']['dark'] ) ? $this->color['text']['dark'] : 'rgb(21,21,21)' ) . '; }
                .' . self::CLASS_CHESSBOARD . ' tr > td a {
                    bottom:0;
                    display:block;
                    left:0;
                    position:absolute;
                    right:0;
                    text-decoration:none;
                    top:0;
                }
                .' . self::CLASS_CHESSBOARD . ' tr > td.' . self::TEAM_WHITE . ' a { color:' . ( isset( $this->color['text']['light'] ) ? $this->color['text']['light'] : 'rgb(255,255,255)' ) . '; }
                .' . self::CLASS_CHESSBOARD . ' tr > td.' . self::TEAM_BLACK . ' a { color:' . ( isset( $this->color['text']['dark'] ) ? $this->color['text']['dark'] : 'rgb(21,21,21)' ) . '; }
    -->
</style>
';
    }

    /**
     * printBoard - Displays the chessboard
     * @param   array   $history
     *          object  $piece
     *          array   $moveto
     * @return  
    **/
    public function printBoard( $history, $piece = null, $moveto = null ) {
        echo '
<table class="' . self::CLASS_CHESSBOARD . '" id="' . self::CLASS_CHESSBOARD . '">
    <tr>
        <th></th>';
        for( $cptCol = 1; $cptCol <= self::SQUARES_COUNT_X; $cptCol++ ) :
            echo '
        <th>' . $cptCol . '</th>';
        endfor;
        echo '
    </tr>';
        for( $cptRow = 1; $cptRow <= self::SQUARES_COUNT_Y; $cptRow++ ) :
            echo '
    <tr>
        <th>' . chr( ( ord( 'A' ) - 1 ) + $cptRow ) . '</th>';
            for( $cptCol = 1; $cptCol <= self::SQUARES_COUNT_X; $cptCol++ ) :
                $square = $this->getSquare( $cptCol, $cptRow );
                if( !empty( $square ) ) :
                    echo '
        <td class="' . $square->color . '">';
                    if( isset( $this->font['file'] ) && file_exists( $this->font['file'] ) && isset( $this->font['name'] ) )
                        echo $square->composeName( $piece, true );
                    else
                        echo $square->composeName( $piece );

                    if( !empty( $piece ) )
                        echo ( $piece->isFriend( $square )!==true ? '<a href="?piece=' . urlencode( serialize( $piece ) ) . '&moveto=' . urlencode( serialize( array( 'x'=>$cptCol, 'y'=>$cptRow ) ) ) . '#' . self::CLASS_CHESSBOARD . '" title=""></a>' : '' );
                    else
                        if( count( $history )===0 ) :
                            echo ( $square->color==self::DEFAULT_TEAM ? '<a href="?piece=' . urlencode( serialize( $square ) ) . '#' . self::CLASS_CHESSBOARD . '" title=""></a>' : '' );
                        else :
                            $obj_lastMove = $history[count( $history )-1];
                            echo ( $obj_lastMove['piece']->isFriend( $square )!==true ? '<a href="?piece=' . urlencode( serialize( $square ) ) . '#' . self::CLASS_CHESSBOARD . '" title=""></a>' : '' );
                        endif;

                    echo '
        </td>';
                else :
                    echo ( !empty( $piece ) ? '
        <td><a href="?piece=' . urlencode( serialize( $piece ) ) . '&moveto=' . urlencode( serialize( array( 'x'=>$cptCol, 'y'=>$cptRow ) ) ) . '#' . self::CLASS_CHESSBOARD . '" title=""></a></td>' : '
        <td></td>' );
                endif;
            endfor;
            echo '
    </tr>';
        endfor;
        echo '
</table>';
    }
}