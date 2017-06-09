<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>
    Accueil - Minisite
</title>
<meta http-equiv="content-type" 
    content="text/html;charset=utf-8" />
<link type="text/css" rel="stylesheet" href="style.css"/>
</head>

<body>
    <div id="page">
        <div id="header">
                    <h1>Mon Site</h1>
            <div>
                <div id="bloc-connect">
                    <!-- Bloc lorsque l'on est connecté : 
                    <p>
                        Bienvenue <span class="gras">Prénom</span>,<br />
                        vous-êtes connecté en tant qu'<span class="ita">administrateur</span>. <br />
                        <a href="deconnexion">Se déconnecter</a>
                    </p>
                    -->
                    <!-- Lorsque non connecté :-->
                    <form method="post" action="connexion.php">
                        <p>
                            <label for="login">Login : </label>
                            <label for="password">Password : </label>
                            <input type="text" name="login" id="login"/>
                            <input type="password" name="password" id="password"/>
                            <input type="submit" value="Se Connecter" class="submit"/>
                        </p>
                    </form>             </div>
                <div id="notif">
                    
                    <h2>Notifications : </h2>
                    <ul>
                        <li class="notif">Connectez-vous pour acceder au reste du site</li>
                        <li class="warning">Mise à jour prochaine du site</li>
                        <li class="error">Erreur lors de l'accés à la page</li>
                    </ul>               </div>
            </div>      </div>
        <div class="wrap">
            <ul id="menu">
                                <li>Menu : 
                    <ul>
                        <li><a href="page.php">Page intéréssante</a></li>
                    </ul>
                </li>
                <li>Menu user : 
                    <ul>
                        <li><a href="proposer-une-page.php">Proposer une page</a></li>
                    </ul>
                </li>
                <li>Menu admin : 
                    <ul>
                        <li><a href="supprimer-une-page.php">Supprimer une page</a></li>
                        <li><a href="ajouter-une-page.php">Ajouter une page</a></li>
                        <li><a href="editer-une-page.php">Editer une page</a></li>
                    </ul>
                </li>
                <li>Menu super admin : 
                    <ul>
                        <li><a href="supprimer-le-site.php">Supprimer le site</a></li>
                    </ul>
                </li>           </ul>
            <div id="content">
                <?php
                    echo $html;
                ?>
            </div>
        </div>
        <div id="footer">
            Footer de mon site      </div>
    </div>
</body>
</html>