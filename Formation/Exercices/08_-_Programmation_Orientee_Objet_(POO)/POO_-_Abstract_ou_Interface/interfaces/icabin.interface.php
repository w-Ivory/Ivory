<?php
/**
 * --------------------------------------------------
 * INTERFACES
 * --------------------------------------------------
**/

/**
 * Contraintes imposées pour un véhicule avec une carrosserie fermée.
 * Description :
 *     .
 * Méthodes :
 *     - unlockCabin : impose un comportement d'ouverture.
**/
interface iCabin {
    public function unlockCabin();
}