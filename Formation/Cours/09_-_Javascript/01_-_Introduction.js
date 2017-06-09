/**
 * ------------------------------
 * Déclaration de variable
 * ------------------------------
**/
// Syntaxes autorisées pour une variable
var $aaa;
var aaa;
var _aaa;
var a3;
// var 3a; // Syntaxe non autorisée pour une variable
/** ------------------------------ **/

var cpt = 'testducpt';

/**
 * ------------------------------
 * Déclaration de fonction
 * ------------------------------
**/
function maFct() {
    var i, str;
    b = 'bla';

    i = 2;
    str = 'Bonjour ';

    if( i == 2 ) {
        console.log( 'La fonction maFct indique : "' + str + '"' );

        for( var cpt = 0; cpt < 3; cpt++ ) {
            i++;
        }
    }

    console.log( 'La boucle dans la fonction maFct a fait : "' + cpt + '" itérations' );
    console.log( 'La variable cpt a pour valeur : "' + cpt + '" dans la fonction' );
}
// Appel de la fonction
maFct();
/** ------------------------------ **/

/**
 * ------------------------------
 * Portée de variable en Javascript, mot-clé : var (cf. la variable cpt déclarée dans l'algorithme principal ET dans la fonction)
 * ------------------------------
**/
console.log( 'La variable cpt a pour valeur : "' + cpt + '" dans l\'algorithme principal');
/** ------------------------------ **/

/**
 * ------------------------------
 * Types de données
 * ------------------------------
**/
var t_str = 'string';
var t_number = 24; // Les nombres peuvent être des entiers et des flottants mais aussi des nombres de toutes les bases numériques (décimal, hexadécimal, binaire, ...)
var t_bool = true;
var t_object = {};
var t_null = null;
var t_undefined;
/** ------------------------------ **/

/**
 * ------------------------------
 * Changmeent de type de données
 * ------------------------------
**/
var maVar = '10';
console.log( '10 + 5 vaut : ' + ( maVar + 5 ) );
console.log( '10 + 5 vaut : ' + ( parseInt( maVar ) + 5 ) );
var maVarStr = 'string';
console.log( 'maVarStr vaut : ' + ( parseInt( maVarStr ) ) );