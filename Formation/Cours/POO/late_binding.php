<?php
class A {
    public function qui() {
        echo __CLASS__;
    }
    public function test() {
        $this->qui(); // Ici, résolution à la volée
    }
}

class B extends A {
    public function qui() {
         echo __CLASS__;
    }
}

$b = new B;
$b->test();


echo '<hr />';


class ASTATIC {
    public static function qui() {
        echo __CLASS__;
    }
    public static function test() {
        static::qui(); // Ici, résolution à la volée
    }
}

class BSTATIC extends ASTATIC {
    public static function qui() {
         echo __CLASS__;
    }
}

BSTATIC::test();