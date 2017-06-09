<?php
class SRequest {
    private $post;
    private $get;
    private $session;

    protected static $instance;

    private function __construct() {
        if( is_null( session_id() ) )
            session_start();

        $this->post = $_POST;
        $this->get = $_GET;
        $this->session = &$_SESSION;
        $_POST = $_GET = null;
    }

    public static function getInstance() {
        if( !isset( self::$instance ) ) {
            self::$instance = new SRequest();
        }

        return self::$instance;
    }

    public function post( $key = null ) {
        if( isset( $key ) )
            return $this->post[$key];
        else
            return $this->post;
    }

    public function get( $key = null ) {
        if( isset( $key ) )
            return $this->get[$key];
        else
            return $this->get;
    }

    public function getSession( $key = null ) {
        if( isset( $key ) )
            return $this->session[$key];
        else
            return $this->session;
    }

    public function setSession( $key, $value ) {
        $this->session[$key] = $value;
        // $_SESSION[$key] = $value;
    }

    // public function __destruct() {
    //     $_SESSION = $this->session;
    // }
}