<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Clone</title>
    </head>
    <body>
        <h1>Copie d'objet</h1>
        <hr>
        <?php
        class MaClasse {
            public $attr1;
            public $attr2;

            public static $compteur = 0;

            public function __construct() {
                self::$compteur++;
            }

            public function __destruct() {
                echo '<br />Je suis détruit';
            }

            public function __clone() {
                self::__construct();
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
        }

        $monObj1 = new MaClasse;
        echo '<br />' . MaClasse::$compteur;
        $monObj1->setAttr1( 'Tugudu' );
        $monObj1->setAttr2( 'Patafiole' );
        echo '<br />' . $monObj1->getAttr1();
        echo '<br />' . $monObj1->getAttr2();

        $monObj2 = $monObj1;
        echo '<br />' . MaClasse::$compteur;

        echo '<br />' . $monObj2->getAttr1();
        echo '<br />' . $monObj2->getAttr2();

        $monObjClone = clone $monObj1;
        echo '<br />' . MaClasse::$compteur;

        echo '<br />' . $monObjClone->getAttr1();
        echo '<br />' . $monObjClone->getAttr2();
        $monObjClone->setAttr1( 'Patapouf' );
        $monObjClone->setAttr2( 'Patafiole' );

        $monObj2->setAttr2( 'Gruuuut' );
        echo '<br />Objet 1 :';
        echo '<br />' . $monObj1->getAttr1();
        echo '<br />' . $monObj1->getAttr2();

        echo '<br />Objet 2 :';
        echo '<br />' . $monObj2->getAttr1();
        echo '<br />' . $monObj2->getAttr2();

        echo '<br />Objet Clone :';
        echo '<br />' . $monObjClone->getAttr1();
        echo '<br />' . $monObjClone->getAttr2();
        ?>
    </body>
</html>
