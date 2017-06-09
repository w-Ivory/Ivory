<?php
class AccueilController {
    public function __construct() {
    }

    public function show() {
        include( 'View/AccueilView.php' );
    }
}