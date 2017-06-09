<?php
/**
 * initLottery - Initialise les variables de la tombola
 * @param   array   $arr (E/S)
 * @return
**/
function initLottery( &$arr ) {
    if( !isset( $arr['jackpot'] ) ) : // Si la cagnotte n'existe pas,
        $arr['jackpot'] = INITIALJACKPOT; // On la crée avec la cagnotte par défaut.
    endif;

    if( !isset( $arr['tickets']['available'] ) ) : // Si la liste des tickets valables n'existe pas,
        for( $i=1; $i<=MAXTICKETS; $i++ ) : // Pour un nombre allant de 0 au nombre maximum de tickets,
            $arr['tickets']['available'][] = $i; // On ajoute le numéro de ticket.
        endfor;
    endif;

    if( !isset( $arr['tickets']['bought'] ) ) : // Si la liste des tickets achetés n'existe pas,
        $arr['tickets']['bought'] = array(); // On crée une liste vide.
    endif;

    if( !isset( $arr['status'] ) ) : // Si aucun tirage est en cours,
        $arr['status'] = false;
    endif;
}



/**
 * init - Initialise les variables de la tombola
 * @param   array   $arr
 * @return  array
**/
function availableTickets( $arr ) {
    return array_diff( $arr['tickets']['available'], $arr['tickets']['bought'] );
}


/**
 * 
**/
function manageTicketsNumber( $nb, $price, $lottery ) {
    $nbTickets = $nb; // On récupère le nombre de tickets demandés pour l'achat.

    /**
     * On détermine si la cagnotte est suffisante pour l'achat des tickets.
     * Sinon on calcule le nombre de tickets maximal avec cette cagnotte.
    **/
    if( ( $nb * $price )>$lottery['jackpot'] ) : // Si le coût d'achat du nombre de tickets saisi est supérieur au montant restant dans la cagnotte,
        $nbTickets = floor( $lottery['jackpot'] / $price ); // On calcule le nombre de tickets possibles avec la cagnotte restante - la fonction "floor" arrondit à l'entier inférieur (http://php.net/manual/fr/function.floor.php).
    endif;

    /**
     * On détermine si le nombre de tickets disponibles est suffisant pour l'achat des tickets.
     * Sinon on calcule le nombre de tickets maximal disponible.
    **/
    if( $nb>count( availableTickets( $lottery ) ) ) : // Si le nombre de tickets demandés est supérieur au nombre de tickets disponibles, soit à la différence entre les tickets disponibles et les tickets achetés (http://php.net/manual/fr/function.array-diff.php),
        $nbTickets = count( availableTickets( $lottery ) ); // On calcule le nombre de tickets disponible.
    endif;

    return $nbTickets;
}



/**
 * buyTickets - Achète aléatoirement le nombre de tickets passé en paramètre parmis les tickets disponibles.
 * @param   array   $arr (E/S)
 *          int     $nb
 * @return  
**/
function buyTickets( &$arr, $nb ) {
    if( count( availableTickets( $arr ) )>0 ) :
        $arr['tickets']['rand'] = (array)array_rand( availableTickets( $arr ), $nb ); // On sélectionne au hasard dans un tableau autant de tickets que saisit et retourne la ou les clés de ces valeurs. La fonction "array_rand" pouvant retourner un entier, on s'assure de toujours avoir un tableau avec le transtypage "(array)".
    else :
        $arr['tickets']['rand'] = array();
    endif;
    
    foreach( $arr['tickets']['rand'] as $key ) : // Pour chacune des clés tirées aléatoirement,
        $arr['jackpot'] -= PRICETICKET; // On soustrait de la cagnotte le prix du ticket.
        
        $arr['tickets']['bought'][] = $arr['tickets']['available'][$key]; // On ajoute le ticket correspondant dans le tableau des tickets achetés.
        
        // unset( $arr['tickets']['available'][$key] ); // On supprime l'entrée dans le tableau des tickets disponibles.
    endforeach;
    sort( $arr['tickets']['bought'] ); // On trie les tickets achetés par ordre croissant.
}



/**
 * lottery - Tire au sort les tickets gagnants
 * @param   array   $arr (E/S)
 * @return  array
**/
function lottery( &$arr ) {
    $_arr_wins = array();
    $arr['tickets']['rand'] = (array)array_rand( $arr['tickets']['available'], count( GAINS ) ); // On sélectionne au hasard dans un tableau autant de tickets que le nombre de gains et retourne la ou les clés de ces valeurs. La fonction "array_rand" pouvant retourner un entier, on s'assure de toujours avoir un tableau avec le transtypage "(array)".
    shuffle( $arr['tickets']['rand'] ); // On mélange les tickets tirés gagnants au sort.

    foreach( $arr['tickets']['rand'] as $key ) : // Pour chacune des clés tirées aléatoirement,
        $_arr_wins[] = $arr['tickets']['available'][$key]; // On récupère les tickets gagnants.
    endforeach;

    return $_arr_wins;
}