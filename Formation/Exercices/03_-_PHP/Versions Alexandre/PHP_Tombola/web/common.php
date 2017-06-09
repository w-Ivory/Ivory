<?php
//Définition des valeurs en constantes
define('ArgentDepart', 500);
define('PrixTicket', 2);
define('TicketMax', 100);
define('Prix1', 100);
define('Prix2', 50);
define('Prix3', 20);

//Determine les tickets libres à partir de ceux du joueur.
function DeterminerTicketsLibres($ticketsJoueur)
{
    return array_diff(range(1, TicketMax), $ticketsJoueur);
}

//Renvoie le nombre de tickets maximum que l'on peut acheter, en fonction des tickets restants et de son argent
function TicketsAchetables($argent, $ticketsLibres)
{
    $maxAchetable = floor($argent/ PrixTicket);     //Permet de savoir combien de tickets on pourrait acheter
    $maxTickets = count($ticketsLibres);            //On ne peut pas prendre plus de ticket qu'il n'en existe
    return min($maxAchetable, $maxTickets);         //On garde le facteur le plus limitant
}

//Retire $nbTickets de $ticketsLibres et les renvoie dans un tableau
function TirerTickets($nbTickets, &$ticketsLibres)
{
    $resultat = array();
    for($i = 0; $i < $nbTickets; $i++)
    {
        //array_rand renvoie une clé aléatoire
        $cle = array_rand($ticketsLibres);
        $resultat[] = $ticketsLibres[$cle];
        unset($ticketsLibres[$cle]);
    }
    
    return $resultat;
}

//Cette fonction achète $ticketsVoulus tickets dans $ticketsLibres avec $argent et les renvoie (limité par $argent et la taille de $ticketsLibres)
function AcheterTickets($ticketsVoulus, &$argent, &$ticketsLibres)
{    
    //Limite le nombre de tickets achetés
    $nbTickets = min($ticketsVoulus, TicketsAchetables($argent, $ticketsLibres));
    
    //Paiement
    $argent -= $nbTickets * PrixTicket;
    
    return TirerTickets($nbTickets, $ticketsLibres);
}