<?php
class ManagerException extends Exception {
    /**
     * __toString - Determines how the object responds when treated as a string
     * @param   
     * @return  
    **/
    public function __toString() {
        return 'Une erreur est survenue avec le message suivant :<strong>' . $this->getMessage() . '</strong><br />[ManagerException]';
    }
}