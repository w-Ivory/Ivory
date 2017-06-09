<?php
class ContactController {
    public function __construct() {
    }

    public function show() {
        include( 'View/ContactView.php' );
    }
}