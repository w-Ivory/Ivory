<?php
error_reporting(E_ALL-E_NOTICE); // On fixe le niveau de rapport d'erreurs PHP (http://php.net/manual/fr/function.error-reporting.php)

class CharacterException extends Exception {
    /**
     * __toString - Détermine comment l'objet doit réagir lorsqu'il est traité comme une chaîne de caractères
     * @param   
     * @return  
    **/
    public function __toString() {
        return 'Une erreur est survenue avec le message suivant :<strong>' . $this->getMessage() . '</strong><br />[CharacterException]';
    }
}