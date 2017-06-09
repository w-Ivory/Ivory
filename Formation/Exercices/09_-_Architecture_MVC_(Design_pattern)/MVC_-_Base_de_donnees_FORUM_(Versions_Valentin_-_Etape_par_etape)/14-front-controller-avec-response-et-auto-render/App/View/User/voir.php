<!doctype html>
<html>
<head>
    <title></title>
    <meta charset="utf-8"/>
</head>
<body>
    <h1>voirAction from UserController</h1>

    <?php
    $user = $this->user;
    if($user){
        echo '<p><a href="index.php?controller=user&action=voir&id='.$user['u_id'].'&rendu=xml">Obtenir XML</a></p>
        <h2> Id: '.$user['u_id'].'</h2>
        <p>'.$user['u_nom'].' '.$user['u_prenom'].'</p>
        <p>'.$user['u_date_naissance'].'</p>';
    }else{
        echo '<p style="color:red">Aucun utilisateur trouvé</p>';
    }
    ?>
</body>
</html>