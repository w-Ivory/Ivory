<?php
class ClassMessage {
    use TypeTest;

    /**
     * --------------------------------------------------
     * CONSTANTS
     * --------------------------------------------------
    **/
    const ORDER_BY_ID = 'ID';
    const ORDER_BY_DATE = 'Date';
    const ORDER_BY_AUTHOR = 'Auteur';
    const SORT_ASC = 'ASC';
    const SORT_DESC = 'DESC';

    /**
     * --------------------------------------------------
     * PROPERTIES
     * --------------------------------------------------
    **/
    private $_id;
    private $_date;
    private $_heure;
    private $_auteur;
    private $_message;
    private $_rows;

    /**
     * --------------------------------------------------
     * STATICS
     * --------------------------------------------------
    **/
    static $_request;
    static $_current_order = self::SORT_ASC;
    static $_current_sort = self::ORDER_BY_DATE;



    /**
     * --------------------------------------------------
     * MAGIC METHODS
     * --------------------------------------------------
    **/
    /**
     * __construct - Class constructor
     * @param   array   $datas
     * @return  
    **/
    public function __construct( $datas ) {
        $this->hydrate( $datas );
    }

    /**
     * __toString - Determines how the object responds when treated as a string
     * @param   
     * @return  
    **/
    public function __toString() {
        $str = '<tr>';

        foreach( $this as $key=>$value) :
            switch( $key ) :
                case '_id':
                case '_rows':
                    break;
                default:
                    $method = str_replace( '_', '', $key );
                    $method = 'get' . ucwords( $method );
                    if( method_exists( $this, $method ) )
                        $str .= '<td>' . $this->$method() . '</td>';
                    break;
            endswitch;
        endforeach;

        return $str;
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
    protected function setId( $value ) {
        if( self::is_valid_int( $value ) )
            $this->_id = (int)$value;
    }

    /**
     * setDate - 
     * @param   date    $value
     * @return  
    **/
    protected function setDate( $value ) {
        if( self::is_valid_date( $value, 'd/m/Y' ) )
            $this->_date = $value;
    }

    /**
     * setHeure - 
     * @param   time    $value
     * @return  
    **/
    protected function setHeure( $value ) {
        if( self::is_valid_date( $value, 'H:i:s' ) )
            $this->_heure = $value;
    }

    /**
     * setAuteur - 
     * @param   string  $value
     * @return  
    **/
    protected function setAuteur( $value ) {
        $this->_auteur = $value;
    }

    /**
     * setMessage - 
     * @param   string  $value
     * @return  
    **/
    protected function setMessage( $value ) {
        $this->_message = $value;
    }

    /**
     * setRows - 
     * @param   string  $value
     * @return  
    **/
    protected function setRows( $value ) {
        $this->_rows[] = $value;
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
        return $this->_id;
    }
    
    /**
     * getDate - 
     * @param   
     * @return  date
    **/
    protected function getDate() {
        return $this->_date;
    }
    
    /**
     * getHeure - 
     * @param   
     * @return  time
    **/
    protected function getHeure() {
        return $this->_heure;
    }
    
    /**
     * getAuteur - 
     * @param   
     * @return  string
    **/
    protected function getAuteur() {
        return $this->_auteur;
    }

    /**
     * getMessage - 
     * @param   
     * @return  string
    **/
    protected function getMessage() {
        return $this->_message;
    }



    /**
     * --------------------------------------------------
     * METHODS
     * --------------------------------------------------
    **/
    /**
     * hydrate - Converts a key to a method name before calling it, if it exists
     * @param   array   $datas
     * @return  
    **/
    protected function hydrate( $datas ) {
        foreach( $datas as $key=>$value ) :
            $method = strtolower( $key );
            $method = ucwords( $method );
            $method = str_replace( ' ', '', $method );
            $method = 'set' . $method;

            if( method_exists( $this, $method ) ) :
                switch( $method ) :
                    case 'setId':
                        break;
                    default:
                        $this->setRows( $key );
                endswitch;

                $this->$method( $value );
            endif;
        endforeach;
    }

    /**
     * getRows - Formats rows
     * @param   
     * @return  
    **/
    public function getRows() {
        $str = '<tr>';
        foreach( $this->_rows as $value ) :
            switch( $value ) :
                case 'Date':
                case 'Auteur':
                    $str .= '<th>' . $value . ' (<a class="tri' . ( isset( static::$_current_order ) && static::$_current_sort==$value ? ' actif ' . strtolower( static::$_current_order ) : '' ) . '" href="' . ( count( self::$_request )>0 ? '?' . http_build_query( self::$_request ) . '&sortby=' . strtolower( $value ) . '&sort=' . ( static::$_current_order=='ASC' ? 'DESC' : 'ASC' ) : '?sortby=' . strtolower( $value ) . '&sort=' . ( static::$_current_order=='ASC' ? 'DESC' : 'ASC' ) ) . '" title="">Changer tri</a>)</th>';
                    break;
                default:
                    $str .= '<th>' . $value . '</th>';
                    break;
            endswitch;
        endforeach;
        $str .= '</tr>';

        return $str;
    }

    /**
     * getSort - Formats a SQL string for order by
     * @param   
     * @return  
    **/
    static function getSort() {
        self::$_request = SRequest::getInstance()->get();

        if( self::$_request['sort']!==NULL ) :
            switch( self::$_request['sort'] ) :
                case self::SORT_DESC:
                    static::$_current_order = self::SORT_DESC;
                    break;
                default:
                    static::$_current_order = self::SORT_ASC;
            endswitch;
            unset( self::$_request['sort'] );
        else :
            static::$_current_order = self::SORT_ASC;
        endif;

        if( self::$_request['sortby']!==NULL ) :
            switch( ucwords( strtolower( self::$_request['sortby'] ) ) ) :
                case self::ORDER_BY_AUTHOR :
                    unset( self::$_request['sortby'] );
                    static::$_current_sort = self::ORDER_BY_AUTHOR;
                    return ' ORDER BY `u_prenom` ' . static::$_current_order . ', `u_nom` ' . static::$_current_order;
                    break;
                default :
                    unset( self::$_request['sortby'] );
                    static::$_current_sort = self::ORDER_BY_DATE;
                    return ' ORDER BY `m_date` ' . static::$_current_order;
            endswitch;
        else :
            static::$_current_sort = self::ORDER_BY_DATE;
            return ' ORDER BY `m_date` ' . static::$_current_order;
        endif;
    }
}