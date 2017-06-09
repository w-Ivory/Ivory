<?php
require_once( ( defined( 'COREPATH' ) ? COREPATH : '' ) . 'CoreController.php' ); // Loads the core controller
/**
 * ------------------------------------------------------------
 * 
 * ------------------------------------------------------------
**/
class UserController extends CoreController {
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
     * profileAction - Displays the profile view complemented by its data
     * @param   
     * @return  
    **/
    public function profileAction() {
        $this->init( __FUNCTION__ );

        if( $this->getModel()!==null )
            $this->_view->item = $this->getModel()->getUniq( $this->_request->get( 'id' ) );

        $this->_view->private = true;
        $this->render();
    }
    
    /**
     * addAction - Displays the view to add a user
     * @param   
     * @return  
    **/
    public function addAction() {
        $this->init( __FUNCTION__ );

        if( $this->getModel()!==null )
            $this->_view->arr_datas = $this->getModel()->getRoles();

        $this->_view->private = true;
        $this->render();
    }
    
    /**
     * addingAction - Proceeds to add a user
     * @param   
     * @return  
    **/
    public function addingAction() {
        if( $this->getModel()!==null ) :
            if( ( $id = $this->getModel()->add( $this->_request->post() ) )!==false )
                header( 'Location:.' . ( $this->_request->get( 'c' )!==null ? '?c=' . $this->_request->get( 'c' ) . '&' : '?' ) . 'a=profile&id=' . $id );
            else
                header( 'Location:.' . ( $this->_request->get( 'c' )!==null ? '?c=' . $this->_request->get( 'c' ) . '&' : '?' ) . 'a=add&_err=adding' );
        endif;
    }
}