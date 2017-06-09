<?php
class PageController {
    private $request;
    private $views_path;

    public function __construct( $path, &$request ) {
        $this->views_path = $path . 'Page/Views/';
        $this->request = &$request;
    }

    public function defaultAction() {
        $this->showHeader();
        include( $this->views_path . 'default.php' );
        $this->showFooter();
    }

    public function contactAction() {
        $this->showHeader();
        include( $this->views_path . 'contact.php' );
        $this->showFooter();
    }

    public function sendingAction() {
        /**
         * Je ferai mon script d'envoi d'email
        **/
        $result = 'Votre email a bien été envoyé';

        $this->showHeader();
        include( $this->views_path . 'contact.php' );
        $this->showFooter();
    }

    private function showHeader() {
        if( $this->request->session( 'mvc_o3w' )!==NULL && array_key_exists( 'connect', $this->request->session( 'mvc_o3w' ) ) )
            $connecte = 'ok';

        if( $this->request->get( '_err' )=='login' )
            $_err = 'Erreur de connexion';

        include( 'FW/includes/header.php' );

        if( isset( $connecte ) && $connecte=='ok' ) {
            include( 'FW/includes/nav-connected.php' );
        } else {
            if( isset( $_err ) ) { echo '<p>' . $_err . '</p>'; }
            include( 'FW/includes/frm-connect.php' );
        }
        echo '</header>';
    }

    private function showFooter() {
        include( 'FW/includes/footer.php' );
    }
}