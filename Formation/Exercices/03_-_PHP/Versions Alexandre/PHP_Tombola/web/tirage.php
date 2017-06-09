<?php
session_start();

include("common.php");

if(!(isset($_SESSION['tombola']) && count($_SESSION['tombola']['ticketsJoueur']) > 0))
{
    header('Location:.');
    exit;
}

$tickets = range(1, TicketMax);
$gagnants = TirerTickets(3, $tickets);

$prix = array(Prix1, Prix2, Prix3);
echo 'Vos tickets : ' . implode(', ', $_SESSION['tombola']['ticketsJoueur']) . '<br>';
echo 'Tickets gagnants : ' . implode(', ', $gagnants) . '<br>';

$gains = 0;
for($i = 0; $i < 3; $i++)
{
    if(in_array($gagnants[$i], $_SESSION['tombola']['ticketsJoueur']))
    {
        $gains += $prix[$i];
    }
}

if($gains != 0)
{
    echo 'Vous avez gagné ' . $gains . '€!<br>';
}
else
{
    echo 'Dommage! Vous n\'avez rien gagné!<br>';
}



//Fin de la partie : application des gains et perte des tickets
unset($_SESSION['tombola']['ticketsJoueur']);
$_SESSION['tombola']['argent'] += $gains

?>

<a href=".">Continuer</a>