<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Abstraction</title>
    </head>
    <body>
        <h1>Abstraction</h1>
        <hr>
        <?php
        abstract class Oiseau {
            public $attr1;
            public $attr2;

            public static $compteur = 0;

            public function __construct() {
                self::$compteur++;
            }

            public function setAttr1( $value ) {
                $this->attr1 = $value;
            }
            public function setAttr2( $value ) {
                $this->attr2 = $value;
            }

            public function getAttr1() {
                return $this->attr1;
            }
            public function getAttr2() {
                return $this->attr2;
            }

            abstract public function crier();
        }

        class Moineau extends Oiseau {
            public function getAttr2() {
                return $this->attr2 * 2;
            }

            public function crier() {
                echo '<br />Je siffle';
            }
        }

        class Perroquet extends Oiseau {
            public function getAttr2() {
                return $this->attr2 * 3;
            }

            public function crier() {
                echo '<br />Je répète';
            }
        }

        // $monObj = new MaClasse;
        // $monObj->setAttr2( 10 );
        // echo '<br />' . $monObj->getAttr2();

        $monObjB = new Moineau;
        $monObjB->setAttr1('Mon nombre :' );
        $monObjB->setAttr2( 10 );
        echo '<br />' . $monObjB->getAttr1();
        echo '<br />' . $monObjB->getAttr2();
        echo '<br />' . $monObjB->crier();

        $monObjC = new Perroquet;
        $monObjC->setAttr1('Mon nombre :' );
        $monObjC->setAttr2( 10 );
        echo '<br />' . $monObjC->getAttr1();
        echo '<br />' . $monObjC->getAttr2();
        echo '<br />' . $monObjC->crier();
        ?>
    </body>
</html>
