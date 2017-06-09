<?php
/**
 * --------------------------------------------------
 * CLASSES
 * --------------------------------------------------
**/

/**
 * Définir un camion-benne.
 * Description :
 *     Classe héritée de Vehicles et implémentant les interfaces iCabin et iPacking.
 * Méthodes :
 *     - move : écrit le mouvement du véhicule.
 *     - unlockCabin : écrit le comportement d'ouverture du véhicule.
 *     - pack : écrit le comportement de chargement véhicule.
 *     - unpack : écrit le comportement de déchargement du véhicule.
**/
class Truck extends vehicles implements iCabin, iPacking {
    /**
     * Déplacer le camion.
     * Description :
     *     .
     * Paramètres :
     *     - () : .
    **/
    public function move() {
        echo '<li>Chauffeur, si t\'es champion : appuie sur l\'champignon !</li>';
    }
    /**
     * Déverrouille le camion.
     * Description :
     *     .
     * Paramètres :
     *     - () : .
    **/
    public function unlockCabin() {
        echo '<li>Mettre la clé dans la serrure et la tourner</li>';
    }
    /**
     * S'assoir dans le camion.
     * Description :
     *     .
     * Paramètres :
     *     - () : .
    **/
    public function sit() {
        echo '<li>Grimpe à bord, il y a même un frigo et un lit à l\'arrière !</li>';
    }
    /**
     * Charge le camion.
     * Description :
     *     .
     * Paramètres :
     *     - () : .
    **/
    public function pack() {
        echo '<li>Pour charger :<ol><li>ouvrir la benne en sifflotant</li><li>s\'énerver en empilant comme il faut le matos</li><li>claquer la porte en râlant</li></ol></li>';
    }
    /**
     * Décharge le camion.
     * Description :
     *     .
     * Paramètres :
     *     - () : .
    **/
    public function unpack() {
        echo '<li>Arrivé à bon port, pour décharger :<ol><li>ouvrir la benne avec énervement</li><li>benner sauvagement le matos</li><li>fermer la porte avec le sourire</li></ol></li>';
    }
}