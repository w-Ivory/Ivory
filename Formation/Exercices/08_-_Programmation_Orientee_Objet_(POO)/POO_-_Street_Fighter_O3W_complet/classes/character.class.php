<?php
/**
 * --------------------------------------------------
 * CLASSE REPRÉSENTANT UN PERSONNAGE
 * --------------------------------------------------
**/
class Character {
    /**
     * --------------------------------------------------
     * PROPRIÉTÉ(S)
     * --------------------------------------------------
    **/
    protected $_name;
    protected $_damages;
    protected $_css;
    /**
     * --------------------------------------------------
     * CONSTANTE(S) DE CLASSE
     * --------------------------------------------------
    **/
    const LIFE_MIN = 0; // On définit le maximum de points de vie pour un personnage
    const LIFE_MAX = 100; // On définit le maximum de points de vie pour un personnage
    const MYSELF = 1; // On définit la constante renvoyée par la méthode 'hit()' si le personnage se frappe lui-même
    const HIT = 2; // On définit la constante renvoyée par la méthode 'hit()' si l'attaque du personnage porte
    const KO = 3; // On définit la constante renvoyée par la méthode 'hit()' si le personnage est mis K.O.
    const BLOCK = 4; // On définit la constante renvoyée par la méthode 'hit()' si le personnage pare l'attaque
    const AVOID = 5; // On définit la constante renvoyée par la méthode 'hit()' si le personnage esquive l'attaque
    const ESCAPE = 6; // On définit la constante renvoyée par la méthode 'hit()' si le personnage fuit le combat
    const DAMAGES_MIN = 2; // On définit le minimum de points de dégâts infligé
    const DAMAGES_MAX = 25; // On définit le maximum de points de dégâts infligé
    const BLOCK_PROBABILITY = 20; // On définit le pourcentage de chance de parer un coup
    const AVOID_PROBABILITY = 12; // On définit le pourcentage de chance d'esquiver un coup
    const ESCAPE_PROBABILITY = 7; // On définit le pourcentage de chance de fuir un combat
    const BLOCK_BONUS = 2; // On définit la constante de bonus qui divisera les dégâts en cas de coup paré



    /**
     * --------------------------------------------------
     * MÉTHODES MAGIQUES
     * --------------------------------------------------
    **/
    /**
     * __construct - Constructeur de classe
     * @param   array   $settings
     * @return  
    **/
    public function __construct( $settings ) {
        $this->hydrate( $settings ); // On hydrate l'instance
    }
    /**
     * __toString - Formatage de l'objet pour une sortie depuis un appel direct
     * @param
     * @return  string
    **/
    public function __toString() {
        return '<p>Nom : ' . htmlspecialchars( $this->getName() ) . '<br />Dégâts : ' . $this->getDamages() . '</p><div class="avatar" style="' . $this->getCss() . '"></div>';
    }



    /**
     * --------------------------------------------------
     * MUTATEUR(S)
     * --------------------------------------------------
    **/
    public function setName( $value ) {
        $this->_name = $value;
    }
    public function setDamages( $value ) {
        if( is_numeric( $value ) && ( $value>=self::LIFE_MIN && $value<=self::LIFE_MAX ) )
            $this->_damages = (int)$value;
        else
            throw new CharacterException( 'Set numeric damage between ' . self::LIFE_MIN . ' and  ' . self::LIFE_MAX );
    }
    public function setCss( $value ) {
        $this->_css = $value;
    }



    /**
     * --------------------------------------------------
     * ACCESSEUR(S)
     * --------------------------------------------------
    **/
    public function getName() {
        return $this->_name;
    }
    public function getDamages() {
        return $this->_damages;
    }
    public function getCss() {
        return $this->_css;
    }



    /**
     * --------------------------------------------------
     * MÉTHODE(S)
     * --------------------------------------------------
    **/
    /**
     * hydrate - Convertit une clé en nom de méthode avant de l'appeler si elle existe
     * @param   array   $datas
     * @return  
    **/
    private function hydrate( $datas ) {
        foreach( $datas as $key=>$value ) :
            /**
             * On convertit, selon la convention de nommage, chaque clé du tableau en un nom possible pour un mutateur
            **/
            $key = str_replace( '_', ' ', $key );
            $key = ucwords( $key );
            $key = str_replace( ' ', '', $key );
            $method = 'set' . $key;
            /** **/

            if( method_exists( $this, $method ) ) // Si le mutateur correspondant existe comme méthode de la classe (http://php.net/manual/fr/function.method-exists.php),
                $this->$method( $value ); // On appelle le mutateur correspondant
        endforeach;
    }

    /**
     * displayCss - Affiche l'attribut style
     * @param   
     * @return  
    **/
    public function displayCss() {
        echo ( $this->getCss()!='' ? ' style="' . $this->getCss() . '"' : '' );
    }

    /**
     * hit - Frappe un personnage
     * @param   object  $opponent
     * @return  int
    **/
    public function hit( Character $opponent ) {
        if( $opponent->getName()==$this->_name ) // Si on se frappe pas soi-même,
            return self::MYSELF; // On stoppe tout en renvoyant une valeur signifiant que le personnage ciblé est le personnage qui attaque

        return $opponent->receiveDamages(); // On indique au personnage qu'il doit recevoir des dégâts, puis on retourne la valeur renvoyée par une des constantes : self::HIT, self::KO, self::BLOCK, self::AVOID, self::ESCAPE
    }

    /**
     * receiveDamages - Inflige les dégâts
     * @param   
     * @return  int
    **/
    public function receiveDamages() {
        if( !$this->escape() ) : // Si le personnage ne parvient pas à fuir le combat,
            if( !$this->avoid() ) : // Si le personnage ne parvient pas à esquiver l'attaque,
                $blockAttempt = $this->block();
                if( $blockAttempt ) // Si le personnage parvient à parer le coup,
                    $this->countDamages( self::BLOCK_BONUS ); // On inflige les dégâts amoindris
                else
                    $this->countDamages(); // On inflige les dégâts

                if( $this->_damages>=self::LIFE_MAX ) // Si on a le maximum de dégâts possible ou plus,
                    return self::KO; // On renvoie une valeur signifiant que le personnage a été mis K.O.

                if( $blockAttempt ) // Si le personnage parvient à parer le coup,
                    return self::BLOCK; // On renvoie une valeur signifiant que le personnage pare l'attaque
                else
                    return self::HIT; // On renvoie une valeur signifiant que l'attaque du personnage porte
            endif;

            return self::AVOID; // On renvoie une valeur signifiant que le personnage esquive l'attaque
        endif;

        $this->restoreDamages(); // On dispense des soins
        return self::ESCAPE; // On renvoie une valeur signifiant que le personnage fuit le combat
    }

    /**
     * block - Pare un coup
     * @param   
     * @return  bool
    **/
    protected function block() {
        return ( rand( 0, 100 ) <= self::BLOCK_PROBABILITY ); // On retourne si le pourcentage de chance de parer un coup correspond à la probabilité
    }

    /**
     * avoid - Esquive un coup
     * @param   
     * @return  bool
    **/
    protected function avoid() {
        return ( rand( 0, 100 ) <= self::AVOID_PROBABILITY ); // On retourne si le pourcentage de chance d'esquiver un coup correspond à la probabilité
    }

    /**
     * escape - Fuit un combat
     * @param   
     * @return  bool
    **/
    protected function escape() {
        return ( rand( 0, 100 ) <= self::ESCAPE_PROBABILITY ); // On retourne si le pourcentage de chance de fuir le combat correspond à la probabilité
    }

    /**
     * countDamages - Calcule les dégâts
     * @param   int     $divider
     * @return  int
    **/
    protected function countDamages( $divider = 1 ) {
        $rand = rand( self::DAMAGES_MIN, self::DAMAGES_MAX ) / $divider;
        if( ( $this->getDamages() + $rand )<=self::LIFE_MAX )
            $this->setDamages( $this->getDamages() + $rand ); // On augmente les dégâts d'une valeur aléatoire divisée par un diviseur le cas échéant
        else
            $this->setDamages( self::LIFE_MAX ); // On augmente les dégâts au maximum

        return $rand;
    }

    /**
     * restoreDamages - Calcule les soins
     * @param   
     * @return  int
    **/
    protected function restoreDamages() {
        $rand = rand( self::LIFE_MIN, $this->getDamages() );
        $this->setDamages( $this->getDamages() - $rand ); // On diminue les dégâts d'une valeur aléatoire comprise entre la vie minimum et les dégâts déjà subits

        return $rand;
    }
}