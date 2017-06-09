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
        if( file_exists( $this->_paths[ 'model' ] . 'UserModel.php' ) ) :
            require_once( $this->_paths[ 'model' ] . 'UserModel.php' );
            $_model = new UserModel();
            $arr_datas = $_model->getList();
        endif;

        include( $this->_paths[ 'view' ] . 'default.php' );
    }
    
    /**
     * profileAction - Displays the profile view complemented by its data
     * @param   
     * @return  
    **/
    public function profileAction() {
        if( file_exists( $this->_paths[ 'model' ] . 'UserModel.php' ) ) :
            require_once( $this->_paths[ 'model' ] . 'UserModel.php' );
            $_model = new UserModel();
            $item = $_model->getUniq( $this->_request->get( 'id' ) );
        endif;

        include( $this->_paths[ 'view' ] . 'profile.php' );
    }
    
    /**
     * addAction - Displays the view to add a user
     * @param   
     * @return  
    **/
    public function addAction() {
        if( file_exists( $this->_paths[ 'model' ] . 'UserModel.php' ) ) :
            require_once( $this->_paths[ 'model' ] . 'UserModel.php' );
            $_model = new UserModel();
            $arr_datas = $_model->getRoles();
        endif;

        include( $this->_paths[ 'view' ] . 'add.php' );
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