<?php
class Character {
    private $name;
    private $damages;

    public function __construct( $name, $damages ) {
        $this->setName( $name );
        $this->setDamages( $damages );
    }

    public function setName( $value ) {
        $this->name = $value;
    }
    public function setDamages( $value ) {
        if( is_numeric( $value ) )
            $this->damages = $value;
    }

    public function getName() {
        return $this->name;
    }
    public function getDamages() {
        return $this->damages;
    }

    public function hit( Character $character ) {
        if( $this->getName() !== $character->getName() ) {
            return $character->receiveDamages();
        } else {
            return 'Frappe sur moi-même';
        }
    }
    public function receiveDamages() {
        $damages_add = rand( 0, 25 );
        $damages_cumul = $this->getDamages() + $damages_add;
        $this->setDamages( $damages_cumul );

        if( $this->getDamages() >= 100 ) {
            return 'KO';
        } else {
            return 'Touché : +' . $damages_add . ' dégâts';
        }
    }
}