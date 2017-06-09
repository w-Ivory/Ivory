<?php
trait tError {
    public function error( $err ) {
        switch( $err ) {
            case 'toto':
                echo '<br />Je suis erreur Toto';
                break;
            default:
                echo 'blabla error';
        }
    }
}