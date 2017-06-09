<?php
/**
 * --------------------------------------------------
 * CLASSES
 * --------------------------------------------------
**/

/**
 * Définir un vélo avec une remorque.
 * Description :
 *     Classe héritée de Vehicles et implémentant l'interface iPacking.
 * Méthodes :
 *     - move : écrit le mouvement du véhicule.
 *     - pack : écrit le comportement de chargement véhicule.
 *     - unpack : écrit le comportement de déchargement du véhicule.
**/
class Cycle extends vehicles implements iPacking {
    /**
     * Déplacer le vélo.
     * Description :
     *     .
     * Paramètres :
     *     - () : .
    **/
    public function move() {
        echo '<li>Pédaler ... à fond à fond à FOOOOOOOOONNNNNNNDDDDDD !!!</li>';
    }
    /**
     * S'assoir sur le vélo.
     * Description :
     *     .
     * Paramètres :
     *     - () : .
    **/
    public function sit() {
        echo '<li>S\'assoir : aïe, ça fait toujours aussi mal au ...</li>';
    }
    /**
     * Charge la remorque du vélo.
     * Description :
     *     .
     * Paramètres :
     *     - () : .
    **/
    public function pack() {
        echo '<li>Pour charger : tout jeter dans la remorque</li>';
    }
    /**
     * Décharge la remorque du vélo.
     * Description :
     *     .
     * Paramètres :
     *     - () : .
    **/
    public function unpack() {
        echo '<li>Marre de pédaler : renverser la remorque</li>';
    }
}