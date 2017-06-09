<?php
/**
 * --------------------------------------------------
 * CLASSES
 * --------------------------------------------------
**/

/**
 * Définir une voiture.
 * Description :
 *     Classe héritée de Vehicles et implémentant l'interface iCabin.
 * Méthodes :
 *     - move : écrit le mouvement du véhicule.
 *     - unlockCabin : écrit le comportement d'ouverture du véhicule.
**/
class Car extends vehicles implements iCabin {
    /**
     * Déplacer la voiture.
     * Description :
     *     .
     * Paramètres :
     *     - () : .
    **/
    public function move() {
        echo '<li>Accélérer ... à fond à fond à FOOOOOOOOONNNNNNNDDDDDD !!!</li>';
    }
    /**
     * Déverrouille la voiture.
     * Description :
     *     .
     * Paramètres :
     *     - () : .
    **/
    public function unlockCabin() {
        echo '<li>Appuyer sur la télécommande</li>';
    }
    /**
     * S'assoir dans la voiture.
     * Description :
     *     .
     * Paramètres :
     *     - () : .
    **/
    public function sit() {
        echo '<li>Cale toi bien dans le siège baquet</li>';
    }
}