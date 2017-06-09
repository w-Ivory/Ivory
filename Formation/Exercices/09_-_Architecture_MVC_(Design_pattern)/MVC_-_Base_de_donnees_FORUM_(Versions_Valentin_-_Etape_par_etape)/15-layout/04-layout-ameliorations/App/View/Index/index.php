<?php
    $this->setTitle('Accueil');
    $this->_layout->addMeta('description','Page d Accueil de mon super site qui parle de trucs.');
?>
<h1>IndexAction from IndexController</h1>
<ul>
    <li>
        <a href="index.php?controller=user">Voir les users</a>
    </li>
    <li>
        <a href="index.php?controller=conversation">Voir les conversation</a>
    </li>
</ul>