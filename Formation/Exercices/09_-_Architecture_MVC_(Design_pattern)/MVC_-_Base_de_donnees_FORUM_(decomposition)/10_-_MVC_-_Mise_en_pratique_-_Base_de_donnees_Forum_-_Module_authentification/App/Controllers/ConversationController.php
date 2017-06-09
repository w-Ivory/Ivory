<?php
require_once( ( defined( 'COREPATH' ) ? COREPATH : '' ) . 'CoreController.php' ); // Loads the core controller
/**
 * ------------------------------------------------------------
 * 
 * ------------------------------------------------------------
**/
class ConversationController extends CoreController {
    /**
     * --------------------------------------------------
     * MAGIC METHODS
     * --------------------------------------------------
    **/
    /**
     * __construct - Class constructor
     * @param   object  $request
     *          array   $paths
     * @return  
    **/
    public function __construct( SRequest $request, $paths = array() ) {
        parent::__construct( $request, $paths );
        $this->setModel();
    }



    /**
     * --------------------------------------------------
     * METHODS
     * --------------------------------------------------
    **/
    /**
     * defaultAction - Displays the default view complemented by its data
     * @param   
     * @return  
    **/
    public function defaultAction() {
        $this->init( __FUNCTION__ );

        if( $this->getModel()!==null )
            $this->_view->arr_datas = $this->getModel()->getList();

        $this->_view->private = true;
        $this->render();
    }
    
    /**
     * conversationAction - Displays the conversation view complemented by its data
     * @param   
     * @return  
    **/
    public function conversationAction() {
        $this->init( __FUNCTION__ );

        if( $this->getModel()!==null )
            $this->_view->item = $this->getModel()->getUniq( $this->_request->get( 'id' ) );

        $this->_view->private = true;
        $this->render();
    }
    
    /**
     * addAction - Displays the view to add a conversation
     * @param   
     * @return  
    **/
    public function addAction() {
        if( $this->getModel()!==null ) :
            if( ( $id = $this->getModel()->add() )!==false )
                header( 'Location:.' . ( $this->_request->get( 'c' )!==null ? '?c=' . $this->_request->get( 'c' ) . '&' : '?' ) . 'a=conversation&id=' . $id );
            else
                header( 'Location:.' . ( $this->_request->get( 'c' )!==null ? '?c=' . $this->_request->get( 'c' ) . ( $this->_request->get( 'a' )!==null ? '&a=' . $this->_request->get( 'a' ) : '' ) . '&' : ( $this->_request->get( 'a' )!==null ? '?a=' . $this->_request->get( 'a' ) . '&' : '?' ) . '_err=adding' ) );
        endif;
    }
}