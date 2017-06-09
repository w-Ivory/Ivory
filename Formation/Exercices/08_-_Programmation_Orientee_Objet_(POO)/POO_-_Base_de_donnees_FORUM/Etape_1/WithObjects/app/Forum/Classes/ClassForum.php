<?php
class ClassForum {
    /**
     * --------------------------------------------------
     * PROPERTIES
     * --------------------------------------------------
    **/
    private $_conversations;



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
        $this->_conversations = [];

        foreach( $datas as $value )
            $this->setConversation( $value );
    }

    /**
     * __toString - Determines how the object responds when treated as a string
     * @param   
     * @return  
    **/
    public function __toString() {
        $str = '';

        if( $this->getConversation()!==NULL && is_array( $this->getConversation() ) && count( $this->getConversation() )>0 ) :
            $str .= '
        <table class="conversations" style="width:100%;">
            <thead>
                ' . $this->getConversation()[0]->getRows() . '
            </thead>
            <tbody>';

            foreach( $this->getConversation() as $conversation ) :
                $str .= $conversation->getExcerpt();
            endforeach;

            $str .= '
            </tbody>
        </table>';
        endif;

        return $str;
    }



    /**
     * --------------------------------------------------
     * SETTERS
     * --------------------------------------------------
    **/
    /**
     * setConversation - 
     * @param   mixed(array|ClassConversation)  $value
     * @return  
    **/
    public function setConversation( $value ) {
        if( is_object( $value ) && get_class( $value )=='ClassConversation' )
            $this->_conversations[$value->getId()] = $value;
        elseif( is_array( $value ) )
            $this->_conversations[] = new ClassConversation( $value );
    }



    /**
     * --------------------------------------------------
     * GETTERS
     * --------------------------------------------------
    **/
    /**
     * getConversation - 
     * @param   [int    $id]
     * @return  mixed(array|ClassConversation)
    **/
    public function getConversation( $id = NULL ) {
        if( !is_null( $id ) )
            if( isset( $this->_conversations[$id] ) )
                return $this->_conversations[$id];
            else
                return NULL;
        else
            return $this->_conversations;
    }



    /**
     * --------------------------------------------------
     * METHODS
     * --------------------------------------------------
    **/
}