<?php
/**
 * --------------------------------------------------
 * INTERFACES
 * --------------------------------------------------
**/

/**
 * Contraintes imposées pour le chargement/déchargement.
 * Description :
 *     .
 * Méthodes :
 *     - pack : impose un comportement de chargement.
 *     - unpack : impose un comportement de déchargement.
**/
interface iPacking {
    public function pack();
    public function unpack();
}