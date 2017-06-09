<?php
class ClassConversation {
    use TypeTest;
    use NavigationManagement;

    /**
     * --------------------------------------------------
     * PROPERTIES
     * --------------------------------------------------
    **/
    private $_request;
    private $_id;
    private $_date;
    private $_heure;
    private $_total_messages;
    private $_status;
    private $_rows;
    private $_messages;
    private $_pagination;

    /**
     * --------------------------------------------------
     * STATICS
     * --------------------------------------------------
    **/
    static $_limit;



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
        $this->setPagination( $current_page, static::$_limit );
    }

    /**
     * __toString - Determines how the object responds when treated as a string
     * @param   
     * @return  
    **/
    public function __toString() {
        if( $this->overflow() )
            $this->redirect();

        $str = '
        <a class="back" href="index.php" title="">Revenir aux conversations</a>';
        
        if( $this->getMessage()!==NULL && is_array( $this->getMessage() ) && count( $this->getMessage() )>0 ) :

            $str .= '
        <table class="messages" style="width:100%;">
            <thead>
                ' . $this->getPagination() . '
                ' . reset( $this->getMessage() )->getRows() . '
            </thead>
            <tfoot>
                ' . $this->getPagination() . '
            </tfoot>
            <tbody>';

            $messages = array();
            foreach( $this->getMessage() as $message ) :
                $messages[] = $message;
            endforeach;
            if( isset( $this->_pagination['CURRENT_PAGE'] ) && isset( $this->_pagination['RESULTS_PER_PAGE'] ) ) :
                for( $cpt = ( ( $this->_pagination['CURRENT_PAGE'] - 1 ) * $this->_pagination['RESULTS_PER_PAGE'] ); $cpt <= ( ( ( $this->_pagination['CURRENT_PAGE'] - 1 ) * $this->_pagination['RESULTS_PER_PAGE'] ) + $this->_pagination['RESULTS_PER_PAGE'] ); $cpt++ ) :
                    $str .= $messages[$cpt];
                endfor;
            endif;

            $str .= '
            </tbody>
        </table>';
        else :
            $str .= '<div class="alert">Cette conversation est vide pour le moment.</div>';
        endif;

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
     * setTotalMessages - 
     * @param   int     $value
     * @return  
    **/
    protected function setTotalMessages( $value ) {
        if( self::is_valid_int( $value ) )
            $this->_total_messages = (int)$value;
    }

    /**
     * setStatus - 
     * @param   bool    $value
     * @return  
    **/
    protected function setStatus( $value ) {
        if( self::is_valid_bool( $value ) )
            $this->_status = (bool)$value;
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
     * setMessage - 
     * @param   mixed(array|ClassMessage)  $value
     * @return  
    **/
    protected function setMessage( $value ) {
        if( is_object( $value ) && get_class( $value )=='ClassMessage' ) :
            $this->_messages[$value->getId()] = $value;
        elseif( is_array( $value ) ) :
            $message = new ClassMessage( $value );
            if( $message->getId()!==NULL )
                $this->_messages[$message->getId()] = $message;
        endif;
    }

    /**
     * setPagination - 
     * @param   
     * @return  
    **/
    protected function setPagination() {
        if( SRequest::getInstance()->get( 'page' )!==NULL && is_numeric( SRequest::getInstance()->get( 'page' ) ) && SRequest::getInstance()->get( 'page' )>0 ) :
            $current_page = SRequest::getInstance()->get( 'page' );
            SRequest::getInstance()->unset( 'get', 'page' );
        else :
            $current_page = 1;
        endif;

        if( self::is_valid_int( $current_page ) && self::is_valid_int( static::$_limit ) && $current_page>=0 && static::$_limit>0 )
            $this->_pagination = array( 'CURRENT_PAGE' => (int)$current_page, 'RESULTS_PER_PAGE' => (int)static::$_limit );
    }

    /**
     * setLimit - 
     * @param   int     $value
     * @return  
    **/
    static function setLimit( $value ) {
        if( self::is_valid_int( $value ) )
            static::$_limit = $value;
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
     * getTotalMessages - 
     * @param   
     * @return  int
    **/
    protected function getTotalMessages() {
        return $this->_total_messages;
    }

    /**
     * getStatus - 
     * @param   
     * @return  bool
    **/
    protected function getStatus() {
        return $this->_status;
    }

    /**
     * getMessage - 
     * @param   [int    $id]
     * @return  mixed(array|ClassMessage)
    **/
    protected function getMessage( $id = NULL ) {
        if( !is_null( $id ) )
            if( isset( $this->_messages[$id] ) )
                return $this->_messages[$id];
            else
                return NULL;
        else
            return $this->_messages;
    }

    /**
     * getLimit - 
     * @param   
     * @return  int
    **/
    protected function getLimit() {
        return $this->_limit;
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
                    case 'setMessage':
                        foreach( explode( '_;_', $value ) as $lines ) :
                            $message = array();
                            foreach( explode( '_,_', $lines ) as $line ) :
                                $row = explode( '_:_', $line );
                                $message[$row[0]] = $row[1];
                            endforeach;
                            if( !empty( $message ) )
                                $this->setMessage( $message );
                        endforeach;
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
    protected function getClass() {
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
                case '_messages':
                case '_pagination':
                case '_order':
                    break;
                default:
                    $method = str_replace( '_', '', $key );
                    $method = 'get' . ucwords( $method );
                    if( method_exists( $this, $method ) )
                        $str .= '<td>' . $this->$method() . '</td>';
                    break;
            endswitch;
        endforeach;
        
        $str .= '<td>' . ( $this->getId()!==NULL ? '<a class="more" href="conversation.php?conv=' . $this->getId() . '" title="">Voir les messages</a>' : '' ) . '</td></tr>';

        return $str;
    }

    /**
     * getPagination - 
     * @param   
     * @return  
    **/
    protected function getPagination() {
        if( isset( $this->_pagination['CURRENT_PAGE'] ) && self::is_valid_int( $this->_pagination['CURRENT_PAGE'] ) && isset( $this->_pagination['RESULTS_PER_PAGE'] ) && self::is_valid_int( $this->_pagination['RESULTS_PER_PAGE'] ) && $this->_pagination['CURRENT_PAGE']>=0 && $this->_pagination['RESULTS_PER_PAGE']>0 )
            return '
        <tr>
            <td bgcolor="gray">' . ( isset( $this->_pagination['CURRENT_PAGE'] ) && $this->_pagination['CURRENT_PAGE']>1 ? '<a class="first" href="?' . http_build_query( SRequest::getInstance()->get() ) . '" title="">Première page</a>' : '' ) . '</td>
            <td bgcolor="gray">' . ( isset( $this->_pagination['CURRENT_PAGE'] ) && $this->_pagination['CURRENT_PAGE']>1 ? '<a class="prev" href="?' . http_build_query( SRequest::getInstance()->get() ) . '&page=' . ( $this->_pagination['CURRENT_PAGE'] - 1 ) . '" title="">Précedent</a>' : '' ) . '</td>
            <td align="right" bgcolor="gray">' . ( isset( $this->_pagination['CURRENT_PAGE'] ) && $this->_pagination['CURRENT_PAGE']<( $this->getTotalMessages() / $this->_pagination['RESULTS_PER_PAGE'] )  ? '<a class="next" href="?' . http_build_query( SRequest::getInstance()->get() ) . '&page=' . ( $this->_pagination['CURRENT_PAGE'] + 1 ) . '" title="">Suivant</a>' : '' ) . '</td>
            <td align="right" bgcolor="gray">' . ( isset( $this->_pagination['CURRENT_PAGE'] ) && $this->_pagination['CURRENT_PAGE']<( $this->getTotalMessages() / $this->_pagination['RESULTS_PER_PAGE'] ) ? '<a class="last" href="?' . http_build_query( SRequest::getInstance()->get() ) . '&page=' . ( ceil( $this->getTotalMessages() / $this->_pagination['RESULTS_PER_PAGE'] ) ) . '" title="">Dernière page</a>' : '' ) . '</td>
        </tr>';
    }

    /**
     * overflow - 
     * @param   
     * @return  
    **/
    protected function overflow() {
        if( isset( $this->_pagination['CURRENT_PAGE'] ) && ( ( count( $this->getMessage() )==0 && $this->_pagination['CURRENT_PAGE']>1 ) || ( count( $this->getMessage() )>0 && isset( $this->_pagination['RESULTS_PER_PAGE'] ) && $this->_pagination['CURRENT_PAGE']>ceil( ( count( $this->getMessage() ) / $this->_pagination['RESULTS_PER_PAGE'] ) ) ) ) )
            return true;

        return false;
    }
}