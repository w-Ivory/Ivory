<?php
require_once( 'player.class.php' );
require_once( 'board.class.php' );
require_once( 'king.class.php' );
require_once( 'queen.class.php' );
require_once( 'knight.class.php' );
require_once( 'pawn.class.php' );
/**
 * ------------------------------------------------------------
 * GAME CONTROL
 * ------------------------------------------------------------
**/
class Game {
    /**
     * --------------------------------------------------
     * PROPERTIES
     * --------------------------------------------------
    **/
    private $_id;
    private $_board;
    private $_teams = [];
    private $_players = [];
    private $_historic = [];



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
        $this->setBoard( $settings );

        $this->setTeam( Board::TEAM_WHITE, array(
                array( 'x' => 1, 'y' => 5, 'piece' => new King( Board::TEAM_WHITE, '0113', Board::DIRECTION_TEAM_WHITE, array( 'x'=>1, 'y'=>5 ) ) ),
                array( 'x' => 1, 'y' => 4, 'piece' => new Queen( Board::TEAM_WHITE, '0107', Board::DIRECTION_TEAM_WHITE, array( 'x'=>1, 'y'=>4 ) ) ),
                array( 'x' => 1, 'y' => 3, 'piece' => new Knight( Board::TEAM_WHITE, '0104', Board::DIRECTION_TEAM_WHITE, array( 'x'=>1, 'y'=>3 ) ) ),
                array( 'x' => 1, 'y' => 6, 'piece' => new Knight( Board::TEAM_WHITE, '0104', Board::DIRECTION_TEAM_WHITE, array( 'x'=>1, 'y'=>6 ) ) ),
                array( 'x' => 2, 'y' => 3, 'piece' => new Pawn( Board::TEAM_WHITE, '0112', Board::DIRECTION_TEAM_WHITE, array( 'x'=>2, 'y'=>3 ) ) ),
                array( 'x' => 2, 'y' => 4, 'piece' => new Pawn( Board::TEAM_WHITE, '0112', Board::DIRECTION_TEAM_WHITE, array( 'x'=>2, 'y'=>4 ) ) ),
                array( 'x' => 2, 'y' => 5, 'piece' => new Pawn( Board::TEAM_WHITE, '0112', Board::DIRECTION_TEAM_WHITE, array( 'x'=>2, 'y'=>5 ) ) ),
                array( 'x' => 2, 'y' => 6, 'piece' => new Pawn( Board::TEAM_WHITE, '0112', Board::DIRECTION_TEAM_WHITE, array( 'x'=>2, 'y'=>6 ) ) )
            ) // White team is composed
        );
        $this->setTeam( Board::TEAM_BLACK, array(
                array( 'x' => 8, 'y' => 4, 'piece' => new King( Board::TEAM_BLACK, '0119', Board::DIRECTION_TEAM_BLACK, array( 'x'=>8, 'y'=>4 ) ) ),
                array( 'x' => 8, 'y' => 5, 'piece' => new Queen( Board::TEAM_BLACK, '0108', Board::DIRECTION_TEAM_BLACK, array( 'x'=>8, 'y'=>5 ) ) ),
                array( 'x' => 8, 'y' => 3, 'piece' => new Knight( Board::TEAM_BLACK, '0106', Board::DIRECTION_TEAM_BLACK, array( 'x'=>8, 'y'=>3 ) ) ),
                array( 'x' => 8, 'y' => 6, 'piece' => new Knight( Board::TEAM_BLACK, '0106', Board::DIRECTION_TEAM_BLACK, array( 'x'=>8, 'y'=>6 ) ) ),
                array( 'x' => 7, 'y' => 3, 'piece' => new Pawn( Board::TEAM_BLACK, '0111', Board::DIRECTION_TEAM_BLACK, array( 'x'=>7, 'y'=>3 ) ) ),
                array( 'x' => 7, 'y' => 4, 'piece' => new Pawn( Board::TEAM_BLACK, '0111', Board::DIRECTION_TEAM_BLACK, array( 'x'=>7, 'y'=>4 ) ) ),
                array( 'x' => 7, 'y' => 5, 'piece' => new Pawn( Board::TEAM_BLACK, '0111', Board::DIRECTION_TEAM_BLACK, array( 'x'=>7, 'y'=>5 ) ) ),
                array( 'x' => 7, 'y' => 6, 'piece' => new Pawn( Board::TEAM_BLACK, '0111', Board::DIRECTION_TEAM_BLACK, array( 'x'=>7, 'y'=>6 ) ) )
            ) // Black team is composed
        );

        $this->initBoard();
    }

    /**
     * __toString - Makes the object as a string returning only the history
     * @param   
     * @return  string
    **/
    public function __toString() {
        $moves = $this->getHistoric();
        if( is_array( $moves ) && !empty( $moves ) ) :
            $return = '<ul class="history">';
            foreach( $moves as $move ) :
                $return .= '<li class="item">' . $move['piece']->name . ' ' . $move['piece']->color . ( isset( $this->getBoard()->font['file'] ) && file_exists( $this->getBoard()->font['file'] ) && isset( $this->getBoard()->font['name'] ) ? ' (<span class="font-chess">&#' . $move['piece']->abbreviation . '</span>)' : '' ) . ' en ' . chr( 64 + $move['y'] ) . $move['x'] . ( isset( $move['lost'] ) ? ' | Prend ' . $move['lost']->name . ' ' . $move['lost']->color . ( isset( $this->getBoard()->font['file'] ) && file_exists( $this->getBoard()->font['file'] ) && isset( $this->getBoard()->font['name'] ) ? ' (<span class="font-chess">&#' . $move['lost']->abbreviation . '</span>)' : '' ) : '' ) . '</li>';
            endforeach;
            $return .= '</ul>';
        endif;

        return ( isset( $return ) ? $return : '' );
    }



    /**
     * --------------------------------------------------
     * SETTERS
     * --------------------------------------------------
    **/
    /**
     * setId - 
     * @param   int     $value
     * @return  
    **/
    public function setId( $value ) {
        if( is_numeric( $value ) )
            $this->_id = $value;
    }
    
    /**
     * setBoard - Instantiates a new board
     * @param   array   $value
     * @return  
    **/
    private function setBoard( $value ) {
        $this->_board = new Board( $value );
    }
    
    /**
     * setTeam - Creates teams with all the necessary pieces to play
     * @param   string  $team
     *          array   $pieces
     * @return  
    **/
    private function setTeam( $team, $pieces ) {
        $this->_teams[$team] = $pieces;
    }
    
    /**
     * setPlayer - Assigns players to the game
     * @param   string  $team
     *          array or object   $player
     * @return  
    **/
    public function setPlayer( $team, $player ) {
        $this->_players[$team] = ( is_object( $player ) && get_class( $player )=='Player' ? $player : new Player( $player ) );
        $this->getBoard()->init( $this->getTeam( $team ) );
    }
    
    /**
     * setHistoric - Completes game's historic
     * @param   int     $x
     *          int     $y
     *          object  $piece
     *          object  $lost
     * @return  
    **/
    private function setHistoric( $x, $y, $piece = null, $lost = null ) {
        $this->_historic[] = array(
            'piece' => $piece,
            'x'     => $x,
            'y'     => $y,
            'lost'  => $lost
        );
    }



    /**
     * --------------------------------------------------
     * GETTERS
     * --------------------------------------------------
    **/
    /**
     * getId - 
     * @param   
     * @return  int
    **/
    public function getId() {
        return ( isset( $this->_id ) ? $this->_id : null );
    }

    /**
     * getBoard - Returns the ingame board
     * @param   
     * @return  mixed (object|null)
    **/
    private function getBoard() {
        return ( isset( $this->_board ) ? $this->_board : null );
    }

    /**
     * getTeam - Returns the composition of a team if specified, all teams if not
     * @param   string  $value
     * @return  array
    **/
    private function getTeam( $value = null ) {
        return ( empty( $value ) ? ( isset( $this->_teams ) ? $this->_teams : array() ) : ( isset( $this->_teams[$value] ) ? $this->_teams[$value] : array() ) );
    }

    /**
     * getPlayer - Returns the player values
     * @param   string  $team
     * @return  mixed (array|object|null)
    **/
    public function getPlayer( $team = null ) {
        // if( empty( $team ) ) {
        //     if( isset( $this->_players ) ) {
        //         return $this->_players;
        //     }
        // } else {
        //     if( isset( $this->_players[$team] ) ) {
        //         return $this->_players[$team];
        //     }
        // }

        // return null;

        return ( empty( $team ) ? ( isset( $this->_players ) ? $this->_players : null ) : ( isset( $this->_players[$team] ) ? $this->_players[$team] : null ) );
    }

    /**
     * getHistoric - Returns the content of the history
     * @param   
     * @return  array
    **/
    public function getHistoric() {
        return ( isset( $this->_historic ) ? $this->_historic : array() );
    }



    /**
     * --------------------------------------------------
     * METHODS
     * --------------------------------------------------
    **/
    /**
     * initBoard - Inits pieces on the chessboard
     * @param   array   $pieces
     * @return  
    **/
    private function initBoard( $pieces = [] ) {
        $this->getBoard()->init( $pieces );
    }

    /**
     * movePiece - Moves a piece on the chessboard
     * @param   object  $piece
     *          array   $moveto
     * @return  mixed (string|bool)
    **/
    private function movePiece( $piece, $moveto = null ) {
        if( $this->getBoard()->isPieceMovable( $piece, $moveto ) )
            if( !empty( $moveto ) )
                if( $this->getBoard()->isDistanceOK( $piece, $moveto ) && $this->getBoard()->isJumpOK( $piece, $moveto ) ) :
                    $this->getBoard()->unsetSquare( $piece->place['x'], $piece->place['y'] );

                    if( !is_null( $this->getBoard()->getSquare( $moveto['x'], $moveto['y'] ) ) && $this->getBoard()->getSquare( $moveto['x'], $moveto['y'] )!==false )
                        $obj_historic = $this->getBoard()->getSquare( $moveto['x'], $moveto['y'] );
                    
                    $this->getBoard()->setSquare( $moveto['x'], $moveto['y'], $piece );

                    return array( 'code' => true, 'x' => $moveto['x'], 'y' => $moveto['y'], 'piece' => $piece, 'lost' => ( isset( $obj_historic ) ? $obj_historic : null ) );
                else :
                    return array( 'code' => false, 'msg' => '<span style="background-color:red;color:white;display:inline-block;padding:4px 7px;">Mouvement impossible !<br />Veuillez sélectionner une autre case.</span>' );
                endif;
            else
                return array( 'code' => false );
        else
            if( !empty( $moveto ) && !$this->getBoard()->isDirectionOK( $piece, $moveto ) )
                return array( 'code' => false, 'msg' => '<span style="background-color:red;color:white;display:inline-block;padding:4px 7px;">Mouvement impossible !<br />Veuillez sélectionner une autre case.</span>' );
            else
                return array( 'code' => true, 'msg' => '<span style="background-color:red;color:white;display:inline-block;padding:4px 7px;">Aucun mouvement disponible pour cette pièce !<br />Veuillez en sélectionner une autre.</span>' );

        return array( 'code' => true );
    }

    /**
     * play - Plays the game
     * @param   object  $piece
     *          array   $moveto
     * @return  mixed (array|bool)
    **/
    public function play( $piece = null, $moveto = null ) {
        $movement = ( !empty( $piece ) ? $this->movePiece( $piece, $moveto ) : false );

        if( isset( $movement['piece'] ) )
            $this->setHistoric( $movement['x'], $movement['y'], $movement['piece'], $movement['lost'] );

        if( isset( $movement['code'] ) && $movement['code'] ) :
            $piece = null;
            $moveto = null;
        endif;

        $this->getBoard()->printStyle();
        $this->getBoard()->printBoard( $this->getHistoric(), $piece, $moveto );

        return $movement;
    }

    /**
     * printHistoric - Displays the history
     * @param   
     * @return  
    **/
    public function printHistoric() {
        $moves = $this->getHistoric();
        if( is_array( $moves ) && !empty( $moves ) ) :
            echo '<ul class="history">';
            foreach( $moves as $move ) :
                echo '<li class="item">' . $move['piece']->name . ' ' . $move['piece']->color . ( isset( $this->getBoard()->font['file'] ) && file_exists( $this->getBoard()->font['file'] ) && isset( $this->getBoard()->font['name'] ) ? ' (<span class="font-chess">&#' . $move['piece']->abbreviation . '</span>)' : '' ) . ' en ' . chr( 64 + $move['y'] ) . $move['x'] . ( isset( $move['lost'] ) ? ' | Prend ' . $move['lost']->name . ' ' . $move['lost']->color . ( isset( $this->getBoard()->font['file'] ) && file_exists( $this->getBoard()->font['file'] ) && isset( $this->getBoard()->font['name'] ) ? ' (<span class="font-chess">&#' . $move['lost']->abbreviation . '</span>)' : '' ) : '' ) . '</li>';
            endforeach;
            echo '</ul>';
        endif;
    }

    /**
     * printLost - Displays the lost pieces
     * @param   string  $team
     * @return  
    **/
    public function printLost( $team ) {
        $lost = array();
        foreach( $this->getHistoric() as $turn ) :
            if( is_object( $turn['lost'] ) && is_subclass_of( $turn['lost'], 'Piece', false ) && get_class( $turn['lost'] )!=='Pawn' && $turn['lost']->color==$team )
                $lost[] = $turn['lost'];
        endforeach;

        if( is_array( $lost ) && !empty( $lost ) ) :
            echo '<select name="lost">';
            foreach( $lost as $piece ) :
                echo '<option value="">' . $piece->name . ' ' . $piece->color . ( isset( $this->getBoard()->font['file'] ) && file_exists( $this->getBoard()->font['file'] ) && isset( $this->getBoard()->font['name'] ) ? ' (<span class="font-chess">&#' . $piece->abbreviation . '</span>)' : '' ) . '</option>';
            endforeach;
            echo '</select>';
        endif;
    }
}