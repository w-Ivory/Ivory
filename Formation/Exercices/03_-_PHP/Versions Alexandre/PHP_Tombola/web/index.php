<?php
session_start();

include("common.php");

//Gestion de la deconnexion
if(isset($_GET['deco']))
{
    session_destroy();
    //Recharge la page (. signifie répertoire actuel, on retourne donc sur le index.php du répertoire, c'est à dire ici)
    header('Location:.');
    exit;
}

//Initialisation du jeu
if(!isset($_SESSION['tombola']['argent']))
{
    //On prend la valeur de départ
    $_SESSION['tombola']['argent'] = ArgentDepart;
}
if(!isset($_SESSION['tombola']['ticketsJoueur']))
{
    $_SESSION['tombola']['ticketsJoueur'] = array();
}


//Achat des tickets
$ticketsLibres = DeterminerTicketsLibres($_SESSION['tombola']['ticketsJoueur']);
if(isset($_POST['nbTickets']) && is_numeric($_POST['nbTickets']) && $_POST['nbTickets'] > 0)
{
    $tickets = AcheterTickets((int)$_POST['nbTickets'], $_SESSION['tombola']['argent'], $ticketsLibres);
    //Ajoute les tickets achetés
    $_SESSION['tombola']['ticketsJoueur'] = array_merge($_SESSION['tombola']['ticketsJoueur'], $tickets);
}







//Affichage
echo 'Vous avez ' . $_SESSION['tombola']['argent'] . '€<br>';
$nbTicketsJoueur = count($_SESSION['tombola']['ticketsJoueur']);
if($nbTicketsJoueur > 0)
{
    echo 'Vos tickets : ' . implode(', ', $_SESSION['tombola']['ticketsJoueur']) . '<br><a href="tirage.php">Lancer le tirage</a><br>';
}

$achetables = TicketsAchetables($_SESSION['tombola']['argent'], $ticketsLibres);
if($achetables > 0)
{
    echo 'Vous pouvez encore acheter ' . $achetables . ' tickets.';
    ?>
    <br>
    <form action="" method="post">
        <input type="number" name="nbTickets">
        <input type="submit" value="Acheter tickets">
    </form>
    <?php
}
else
{
    echo 'Vous ne pouvez plus acheter de tickets!';
}
?>
<br>
<a href="?deco">Nouvelle partie</a>