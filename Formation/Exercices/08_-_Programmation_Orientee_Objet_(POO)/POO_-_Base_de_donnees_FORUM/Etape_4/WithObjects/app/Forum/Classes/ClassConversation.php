<?php
class ClassConversation {
    use TypeTest;
    use NavigationManagement;

    /**
     * --------------------------------------------------
     * CONSTANTS
     * --------------------------------------------------
    **/
    const ORDER_BY_ID = 'c_id';
    const ORDER_BY_DATE = 'c_date';
    const ORDER_BY_NBMESSAGE = 'Total Message(s)';
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
    private $_total_messages;
    private $_status;
    private $_rows;
    private $_messages;
    private $_pagination;
    private $_order;



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
     * setMessage - 
     * @param   mixed(array|ClassMessage)  $value
     * @return  
    **/
    public function setMessage( $value ) {
        if( is_object( $value ) && get_class( $value )=='ClassMessage' ) :
            $this->_messages[$value->getId()] = $value;
        elseif( is_array( $value ) ) :
            $message = new ClassMessage( $value );
            if( $message->getId()!==NULL )
                $this->_messages[$this->getOrderField() . '-' . $message->getId()] = $message;
        endif;
    }

    /**
     * setPagination - 
     * @param   int     $current
     *          int     $per_page
     * @return  
    **/
    public function setPagination( $current, $per_page ) {
        if( $this->is_valid_int( $current ) && $this->is_valid_int( $per_page ) && $current>=0 && $per_page>0 )
            $this->_pagination = array( 'CURRENT_PAGE' => (int)$current, 'RESULTS_PER_PAGE' => (int)$per_page );
    }

    /**
     * setOrder - 
     * @param   [string     $order_by]
     *          [string     $sort]
     * @return  
    **/
    public function setOrder( $order_by = self::ORDER_BY_ID, $sort = self::SORT_ASC ) {
        $this->_order = array( 'ORDER_BY' => $order_by, 'SORT' => $sort );
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
     * getMessage - 
     * @param   [int    $id]
     * @return  mixed(array|ClassMessage)
    **/
    public function getMessage( $id = NULL ) {
        if( !is_null( $id ) )
            if( isset( $this->_messages[$id] ) )
                return $this->_messages[$id];
            else
                return NULL;
        else
            return $this->_messages;
    }

    /**
     * getOrder - 
     * @param   
     * @return  string
    **/
    public function getOrder() {
        return $this->_order;
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
     * getOrderField - 
     * @param   
     * @return  
    **/
    private function getOrderField() {
        switch( $this->getOrder()['ORDER_BY'] ) :
            case self::ORDER_BY_DATE:
                return $this->getDate() . '-';
                break;
            case self::ORDER_BY_NBMESSAGE:
                return $this->getTotalMessages() . '-';
                break;
        endswitch;
    }

    /**
     * getClass - Formats CSS class name depending on the value of the "termine" property
     * @param   
     * @return  
    **/
    private function getClass() {
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
    private function getPagination() {
        if( isset( $this->_pagination['CURRENT_PAGE'] ) && $this->is_valid_int( $this->_pagination['CURRENT_PAGE'] ) && isset( $this->_pagination['RESULTS_PER_PAGE'] ) && $this->is_valid_int( $this->_pagination['RESULTS_PER_PAGE'] ) && $this->_pagination['CURRENT_PAGE']>=0 && $this->_pagination['RESULTS_PER_PAGE']>0 )
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
    private function overflow() {
        if( isset( $this->_pagination['CURRENT_PAGE'] ) && ( ( count( $this->getMessage() )==0 && $this->_pagination['CURRENT_PAGE']>1 ) || ( count( $this->getMessage() )>0 && isset( $this->_pagination['RESULTS_PER_PAGE'] ) && $this->_pagination['CURRENT_PAGE']>ceil( ( count( $this->getMessage() ) / $this->_pagination['RESULTS_PER_PAGE'] ) ) ) ) )
            return true;

        return false;
    }
}