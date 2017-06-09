<?php
    $this->setTitle('Accueil');
    $this->_layout->addMeta('description','Page d Accueil de mon super site qui parle de trucs.');
    $this->addScript('indexJs');
?>
<h1>IndexAction from IndexController</h1>
<ul>
    <li>
        <a href="<?php echo $this->url(array('controller'=>'user')); ?>">Voir les users</a>
    </li>
    <li>
        <a href="<?php echo $this->url(array('controller'=>'conversation')); ?>">Voir les conversation</a>
    </li>
</ul>