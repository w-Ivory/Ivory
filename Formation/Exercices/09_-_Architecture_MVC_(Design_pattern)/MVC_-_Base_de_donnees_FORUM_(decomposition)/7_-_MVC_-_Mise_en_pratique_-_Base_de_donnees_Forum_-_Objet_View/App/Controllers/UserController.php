<?php
/**
 * ------------------------------------------------------------
 * 
 * ------------------------------------------------------------
**/
class UserController extends CoreController {
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
        $this->setAction( __FUNCTION__ );//$this->setAction( __METHOD__ );

        if( file_exists( $this->_paths[ 'model' ] . 'UserModel.php' ) ) :
            require_once( $this->_paths[ 'model' ] . 'UserModel.php' );
            $_model = new UserModel();
            $this->_view->arr_datas = $_model->getList();//$arr_datas = $_model->getList();
        endif;

        $this->render();//include( $this->_paths[ 'view' ] . 'default.php' );
    }
    
    /**
     * profileAction - Displays the profile view complemented by its data
     * @param   
     * @return  
    **/
    public function profileAction() {
        $this->setAction( __FUNCTION__ );//$this->setAction( __METHOD__ );

        if( file_exists( $this->_paths[ 'model' ] . 'UserModel.php' ) ) :
            require_once( $this->_paths[ 'model' ] . 'UserModel.php' );
            $_model = new UserModel();
            $this->_view->item = $_model->getUniq( $this->_request->get( 'id' ) );
        endif;

        $this->render();//include( $this->_paths[ 'view' ] . 'profile.php' );
    }
    
    /**
     * addAction - Displays the view to add a user
     * @param   
     * @return  
    **/
    public function addAction() {
        $this->setAction( __FUNCTION__ );//$this->setAction( __METHOD__ );

        if( file_exists( $this->_paths[ 'model' ] . 'UserModel.php' ) ) :
            require_once( $this->_paths[ 'model' ] . 'UserModel.php' );
            $_model = new UserModel();
            $this->_view->arr_datas = $_model->getRoles();
        endif;

        $this->render();//include( $this->_paths[ 'view' ] . 'add.php' );
    }
    
    /**
     * addingAction - Proceeds to add a user
     * @param   
     * @return  
    **/
    public function addingAction() {
        if( file_exists( $this->_paths[ 'model' ] . 'UserModel.php' ) ) :
            require_once( $this->_paths[ 'model' ] . 'UserModel.php' );
            $_model = new UserModel();
            if( ( $id = $_model->add( $this->_request->post() ) )!==false ) header( 'Location:.' . ( $this->_request->get( 'c' )!==null ? '?c=' . $this->_request->get( 'c' ) . '&' : '?' ) . 'a=profile&id=' . $id );
            else header( 'Location:.' . ( $this->_request->get( 'c' )!==null ? '?c=' . $this->_request->get( 'c' ) . '&' : '?' ) . 'a=add&_err=adding' );
        endif;
    }
}