<?php
/**
 * ------------------------------------------------------------
 * FORUM CONTROLLER
 * (Requires : TypeTest | NavigationManagement | SRequest | KernelException | KernelController)
 * ------------------------------------------------------------
**/
class PageController extends KernelController {
    /**
     * --------------------------------------------------
     * METHODS
     * --------------------------------------------------
    **/
    /**
     * defaultAction - Displays the default view
     * @param
     * @return
    **/
    public function defaultAction() {
        $this->init( __FUNCTION__ );

        $this->render();
    }
}