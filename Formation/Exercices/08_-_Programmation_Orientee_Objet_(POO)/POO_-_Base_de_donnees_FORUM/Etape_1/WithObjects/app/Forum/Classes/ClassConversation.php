<?php
class ClassConversation {
    use TypeTest;

    /**
     * --------------------------------------------------
     * PROPERTIES
     * --------------------------------------------------
    **/
    private $_id;
    private $_date;
    private $_heure;
    private $_total_messages;
    private $_status;
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
     * setTotalMessages - 
     * @param   int     $value
     * @return  
    **/
    public function setTotalMessages( $value ) {
        if( $this->is_valid_int( $value ) )
            $this->_total_messages = (int)$value;
    }

    /**
     * setStatus - 
     * @param   bool    $value
     * @return  
    **/
    public function setStatus( $value ) {
        if( $this->is_valid_bool( $value ) )
            $this->_status = (bool)$value;
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
     * getTotalMessages - 
     * @param   
     * @return  int
    **/
    public function getTotalMessages() {
        return $this->_total_messages;
    }

    /**
     * getStatus - 
     * @param   
     * @return  bool
    **/
    public function getStatus() {
        return $this->_status;
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
            $method = str_replace( '(', '', $key );
            $method = str_replace( ')', '', $method );
            $method = strtolower( $method );
            $method = ucwords( $method );
            $method = str_replace( ' ', '', $method );
            $method = 'set' . $method;

            if( method_exists( $this, $method ) ) :
                switch( $method ) :
                    case 'setStatus':
                        break;
                    default:
                        $this->setRows( $key );
                endswitch;

                $this->$method( $value );
            endif;
        endforeach;
    }

    /**
     * getClass - Formats CSS class name depending on the value of the "termine" property
     * @param   
     * @return  
    **/
    public function getClass() {
        return ( $this->getStatus()==TRUE ? 'closed' : 'opened' );
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
        $str .= '<th></th></tr>';

        return $str;
    }

    /**
     * getExcerpt - 
     * @param   
     * @return  
    **/
    public function getExcerpt() {
        $str = '<tr class="' . $this->getClass() . '">';

        foreach( $this as $key=>$value) :
            switch( $key ) :
                case '_status':
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

        $str .= '<td></td></tr>';

        return $str;
    }
}