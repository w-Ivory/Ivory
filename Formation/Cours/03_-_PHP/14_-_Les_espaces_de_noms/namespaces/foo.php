<?php
namespace Foo {
    $maVar = 10;

    const MACONST = 'Blabla';

    function appel()
    {
        bar\fopen();
    }

    class maClasse {
        public function maFonction() {
            echo MACONST;
            echo \MACONST;

            echo 'Hello ';
        }
        public static function maFonction2() {
            echo ' !!!';
        }
    }

}



namespace Foo\bar {

function fopen() {
    $obj = new \Foo\maClasse;
    $obj->maFonction();
    echo 'again M. ';
    \maFonction();
    \Foo\maClasse::maFonction2();
}


}