<?php
class Character {
    private $name;
    private $damages;
    private $order;

    static private $count = 0;

    const DAMAGE_INIT = 0;

    public function __construct( $name, $damages ) {
        $this->setName( $name );
        $this->setDamages( $damages );

        self::$count++;
        $this->order = self::$count;
    }

    public function setName( $value ) {
        $this->name = $value;
    }
    public function setDamages( $value ) {
        $this->damages = $value;
    }
    public function setCount( $value ) {
        self::$count = $value;
    }

    public function getName() {
        return $this->name;
    }
    public function getDamages() {
        return $this->damages;
    }
    public function getOrder() {
        return $this->order;
    }

    public static function getCount() {
        return self::$count;
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

    public function __destruct() {
        self::$count--;
    }
}