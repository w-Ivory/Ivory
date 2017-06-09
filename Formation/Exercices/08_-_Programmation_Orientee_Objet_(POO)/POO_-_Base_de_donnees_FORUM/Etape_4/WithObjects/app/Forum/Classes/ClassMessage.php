<?php
class ClassMessage {
    use TypeTest;

    /**
     * --------------------------------------------------
     * CONSTANTS
     * --------------------------------------------------
    **/
    const ORDER_BY_ID = 'm_id';
    const ORDER_BY_DATE = 'm_date';
    const ORDER_BY_AUTHOR = 'Auteur';

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
    public function setId( $value ) {
        if( $this->is_valid_int( $value ) )
            $this->_id = (int)$value;
    }

    /**
     * setDate - 
     * @param   date    $value
     * @return  
    **/
    public function setDate( $value ) {
        if( $this->is_valid_date( $value, 'd/m/Y' ) )
            $this->_date = $value;
    }

    /**
     * setHeure - 
     * @param   time    $value
     * @return  
    **/
    public function setHeure( $value ) {
        if( $this->is_valid_date( $value, 'H:i:s' ) )
            $this->_heure = $value;
    }

    /**
     * setAuteur - 
     * @param   string  $value
     * @return  
    **/
    public function setAuteur( $value ) {
        $this->_auteur = $value;
    }

    /**
     * setMessage - 
     * @param   string  $value
     * @return  
    **/
    public function setMessage( $value ) {
        $this->_message = $value;
    }

    /**
     * setRows - 
     * @param   string  $value
     * @return  
    **/
    private function setRows( $value ) {
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
    public function getDate() {
        return $this->_date;
    }
    
    /**
     * getHeure - 
     * @param   
     * @return  time
    **/
    public function getHeure() {
        return $this->_heure;
    }
    
    /**
     * getAuteur - 
     * @param   
     * @return  string
    **/
    public function getAuteur() {
        return $this->_auteur;
    }

    /**
     * getMessage - 
     * @param   
     * @return  string
    **/
    public function getMessage() {
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
    private function hydrate( $datas ) {
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
            $str .= '<th>' . $value . '</th>';
        endforeach;
        $str .= '</tr>';

        return $str;
    }
}