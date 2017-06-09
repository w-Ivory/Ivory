<?php
/**
 * ------------------------------------------------------------
 * 
 * ------------------------------------------------------------
**/
class UserController {
    /**
     * --------------------------------------------------
     * PROPERTIES
     * --------------------------------------------------
    **/
    private $_paths = [];
    private $_db_settings;
    private $_model;



    /**
     * --------------------------------------------------
     * MAGIC METHODS
     * --------------------------------------------------
    **/
    /**
     * __construct - Class constructor
     * @param   string  $model_path
     *          string  $view_path
     * @return  
    **/
    public function __construct( $model_path, $view_path, $db = null, $host = null, $dbname = null, $login = null, $pass = null ) {
        $this->_paths[ 'model' ] = $model_path;
        $this->_paths[ 'view' ] = $view_path;

        $this->_db_settings = array(
            'db'        => $db,
            'host'      => $host,
            'dbname'    => $dbname,
            'login'     => $login,
            'pass'      => $pass,
        );

        if( file_exists( $this->_paths[ 'model' ] . 'UserModel.php' ) ) :
            require_once( $this->_paths[ 'model' ] . 'UserModel.php' );
            $this->_model = new UserModel( $this->_db_settings['db'], $this->_db_settings['host'], $this->_db_settings['dbname'], $this->_db_settings['login'], $this->_db_settings['pass'] );
        endif;
    }



    /**
     * --------------------------------------------------
     * METHODS
     * --------------------------------------------------
    **/
    /**
     * indexAction - Displays the default view complemented by its data
     * @param   
     * @return  
    **/
    public function indexAction() {
        $arr_datas = $this->_model->getList();

        include( $this->_paths[ 'view' ] . 'index.php' );
    }
    
    /**
     * profileAction - Displays the profile view complemented by its data
     * @param   int     $id
     * @return  
    **/
    public function profileAction( $id ) {
        $item = $this->_model->getUniq( $id );

        include( $this->_paths[ 'view' ] . 'profile.php' );
    }
    
    /**
     * addAction - Displays the view to add a user
     * @param   
     * @return  
    **/
    public function addAction() {
        $arr_datas = $this->_model->getRoles();

        include( $this->_paths[ 'view' ] . 'add.php' );
    }
    
    /**
     * addingAction - Processes the addition of a user
     * @param   array   $datas
     * @return  
    **/
    public function addingAction( $datas ) {
        if( ( $id = $this->_model->add( $datas ) )!==false ) header( 'Location:.?a=profile&id=' . $id );
        else header( 'Location:.?a=add&_err=adding' );
    }
}