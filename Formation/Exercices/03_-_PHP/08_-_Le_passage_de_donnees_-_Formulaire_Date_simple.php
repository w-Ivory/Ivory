<?php
$date = [
    'days'      => ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'],
    'months'    => ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre']
];
?><!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0" />
        <title>Saisie de date | Le passage de données - Mise en pratique</title>
    </head>
    <body>
        <h1>Saisie de date | Le passage de données - Mise en pratique</h1>
        <p>Dans cet exercice, nous souhaitons mettre en place un sélecteur de date, élément par élément. Nous allons donc devoir :</p>
        <ul>
            <li>stocker dans des tableaux les jours (lundi, mardi, ...) et les mois (janvier, février, ...)</li>
            <li>créer un formulaire HTML avec :
                <ul>
                    <li>une liste déroulante pour le jour</li>
                    <li>un champ pour le numéro du jour dans le mois</li>
                    <li>une liste déroulante pour le mois</li>
                </ul>
            </li>
        </ul>
        <p>A la soumission du formulaire, vous devrez afficher en dessous la date sélectionnée.</p>
        <hr />
        <form action="" method="POST" name="frm-date">
            <fieldset>
                <legend>Composez une date :</legend>
                
                <select name="day">
                    <?php foreach ($date['days'] as $key => $value) {
                        echo '<option value="' . $value . '">' . $value . '</option>';
                    }
                    ?>
                </select>

                <input name="num" min="1" max="31" type="number" value="" />

                <select name="month">
                    <?php foreach ($date['months'] as $key => $value) {
                        echo '<option value="' . $value . '">' . $value . '</option>';
                    }
                    ?>
                </select>

                <input type="submit" value="Envoyer la date" />
            </fieldset>
        </form>

        <hr />
        <p>Date choisie :<?php echo ( isset( $_POST['day'] ) ? ' ' . $_POST['day'] : '' ) . ( isset( $_POST['num'] ) ? ' ' . $_POST['num'] : '' ) . ( isset( $_POST['month'] ) ? ' ' . $_POST['month'] : '' ); ?></p>
        <p>Date choisie :
        <?php
        if( isset( $_POST['day'] ) ) { echo ' ' . $_POST['day']; }
        if( isset( $_POST['num'] ) ) { echo ' ' . $_POST['num']; }
        if( isset( $_POST['month'] ) ) { echo ' ' . $_POST['month']; }
        ?>
        </p>

        <form action="" method="POST" name="frm-reset">
            <input type="submit" value="Reset">
        </form>
    </body>
</html>