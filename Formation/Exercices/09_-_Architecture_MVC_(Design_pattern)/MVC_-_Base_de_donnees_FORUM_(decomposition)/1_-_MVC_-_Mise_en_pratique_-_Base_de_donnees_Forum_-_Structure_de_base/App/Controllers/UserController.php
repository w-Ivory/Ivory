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
        require_once( $this->_paths[ 'model' ] . 'UserModel.php' );
        $_model = new UserModel( $this->_db_settings['db'], $this->_db_settings['host'], $this->_db_settings['dbname'], $this->_db_settings['login'], $this->_db_settings['pass'] );
        $arr_datas = $_model->getList();

        include( $this->_paths[ 'view' ] . 'index.php' );
    }
}