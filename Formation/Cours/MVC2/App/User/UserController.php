<?php
class UserController {
    private $request;
    private $bundle_path;
    private $model_path;
    private $views_path;

    private $model;

    public function __construct( $path, &$request, $instance ) {
        $this->bundle_path = $path . 'User/';
        $this->model_path = $this->bundle_path;
        $this->views_path = $this->bundle_path . 'Views/';

        $this->request = &$request;


        require_once( $this->model_path . 'UserModel.php' );
        $this->model = new UserModel( $instance );
    }

    public function loginAction( $post ) {
        if( $this->model->record_exists( $post['login'], $post['password'] ) ) {
            $this->request->session( 'mvc_o3w', array( 'connect' => 'ok' ) );
            header( 'Location:.' );
            exit;
        }
        
        header( 'Location:./?_err=login' );
        exit;
    }

    public function logoutAction() {
        $this->request->unset( 'session', 'mvc_o3w' );
        header( 'Location:.' );
        exit;
    }
}