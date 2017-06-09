<?php
/**
 * ------------------------------------------------------------
 * 
 * ------------------------------------------------------------
**/
class UserController extends Controller {
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
            $_model = new UserModel( $this->_db_settings['db'], $this->_db_settings['host'], $this->_db_settings['dbname'], $this->_db_settings['login'], $this->_db_settings['pass'] );
            $arr_datas = $_model->getList();
        endif;

        include( $this->_paths[ 'view' ] . 'default.php' );
    }
    
    /**
     * profileAction - Displays the profile view complemented by its data
     * @param   int     $id
     * @return  
    **/
    public function profileAction( $id ) {
        if( file_exists( $this->_paths[ 'model' ] . 'UserModel.php' ) ) :
            require_once( $this->_paths[ 'model' ] . 'UserModel.php' );
            $_model = new UserModel( $this->_db_settings['db'], $this->_db_settings['host'], $this->_db_settings['dbname'], $this->_db_settings['login'], $this->_db_settings['pass'] );
            $item = $_model->getUniq( $id );
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
            $_model = new UserModel( $this->_db_settings['db'], $this->_db_settings['host'], $this->_db_settings['dbname'], $this->_db_settings['login'], $this->_db_settings['pass'] );
            $arr_datas = $_model->getRoles();
        endif;

        include( $this->_paths[ 'view' ] . 'add.php' );
    }
    
    /**
     * addingAction - Proceeds to add a user
     * @param   array   $datas
     * @return  
    **/
    public function addingAction( $datas ) {
        if( file_exists( $this->_paths[ 'model' ] . 'UserModel.php' ) ) :
            require_once( $this->_paths[ 'model' ] . 'UserModel.php' );
            $_model = new UserModel( $this->_db_settings['db'], $this->_db_settings['host'], $this->_db_settings['dbname'], $this->_db_settings['login'], $this->_db_settings['pass'] );
            if( ( $id = $_model->add( $datas ) )!==false ) header( 'Location:.' . ( isset( $_GET['c'] ) ? '?c=' . $_GET['c'] . '&' : '?' ) . 'a=profile&id=' . $id );
            else header( 'Location:.' . ( isset( $_GET['c'] ) ? '?c=' . $_GET['c'] . '&' : '?' ) . 'a=add&_err=adding' );
        endif;
    }
}