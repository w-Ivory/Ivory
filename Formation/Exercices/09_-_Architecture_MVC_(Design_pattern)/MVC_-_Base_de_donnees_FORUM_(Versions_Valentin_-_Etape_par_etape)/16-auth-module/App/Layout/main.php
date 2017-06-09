<?php
$this->addMeta('charset','utf-8');
$this->addMeta('toto','tata');
$this->addStylesheet('style');
$this->addScript('https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js');
$this->addScript('monJs');

?><!DOCTYPE html>
<html>
<head>
    <?php 
    $this->insert_title("Mon site avec mon FW - %title%");
    $this->insert_metas();
    $this->insert_stylesheets();
    $this->insert_scripts();
    ?>
</head>

<body>
    <div id="page">
        <div id="header">
            <h1>Mon Site</h1>
            <div>
                <div id="bloc-connect">
                    <?php
                    if($this->_view->login !== null){
                        ?> <!-- Bloc lorsque l'on est connecté : -->
                        <p>
                            Bienvenue <span class="gras"><?php echo $this->_view->login;?> </span>,<br />
                            vous-êtes connecté en tant qu'<span class="ita">administrateur</span>. <br />
                            <a href="<?php echo $this->_view->url(array('controller'=>'authentification','action'=>'deconnexion')); ?>">Se déconnecter</a>
                        </p>
                        <?php
                    }else{
                        ?>
                        <!-- Lorsque non connecté :-->

                        <form method="post" action="<?php echo $this->_view->url(array('controller'=>'authentification','action'=>'connexion')); ?>">
                            <p>
                                <label for="login">Login : </label>
                                <label for="password">Password : </label>
                                <input type="text" name="login" id="login"/>
                                <input type="password" name="password" id="password"/>
                                <input type="submit" value="Se Connecter" class="submit"/>
                            </p>
                        </form>  
                        <?php
                    }
                    ?>


                </div>
                <div id="notif">

                    <h2>Notifications : </h2>
                    <ul>
                        <li class="notif">Connectez-vous pour acceder au reste du site</li>
                        <li class="warning">Mise à jour prochaine du site</li>
                        <li class="error">Erreur lors de l'accés à la page</li>
                    </ul>               
                </div>
            </div>      
        </div>
        <div class="wrap">
            <ul id="menu">
                <li>Menu : 
                    <ul>
                        <li><a href="index.php">Accueil</a></li>
                    </ul>
                </li>
                <li>Menu user : 
                    <ul>
                        <li><a href="<?php echo $this->_view->url(array('controller'=>'conversation')); ?>">Voir les conversations</a></li>
                        <li><a href="<?php echo $this->_view->url(array('controller'=>'user')); ?>">Voir l'annuaire</a></li>
                    </ul>
                </li>
                
            </ul>
            <div id="content">
                <?php
                echo $this->_view->getContent();
                ?>
            </div>
        </div>
        <div id="footer">
            Footer de mon site      
        </div>
    </div>
</body>
</html>