<?php
$page = $this->page;
$lastPage = $this->lastPage;
$users = $this->users;
?>

    <h1>indexAction from UserController</h1>

    <ul>
        <?php 
        if($page !=1){
        ?>
        <li>
            <a href="<?php echo $this->url(array('controller'=>'user','page'=>1)); ?>">Première page</a>
        </li>
        <li>
            <a href="<?php echo $this->url(array('controller'=>'user','page'=> $page-1)); ?>">Page Précédente</a>
        </li>
        <?php 
        }else{
        ?>

        <li>
            <span>Première page</span>
        </li>
        <li>
            <span>Page Précédente</span>
        </li>
        <?php
        }

        if($page<$lastPage){
         ?>
        <li>
            <a href="<?php echo $this->url(array('controller'=>'user','page'=> $page+1)); ?>">Page Suivante</a>
        </li>
        <li>
            <a href="<?php echo $this->url(array('controller'=>'user','page'=> $lastPage)); ?>">Dernière page</a>
        </li>
        <?php 
        }else{
        ?>

        <li>
            <span>Page Suivante</span>
        </li>
        <li>
            <span>Dernière page</span>
        </li>
        <?php
        }
         ?>
    </ul>
    <h2>Page <?php echo $page;?>: </h2>

    <?php 
    // var_dump($data);
    $liste = '<ul>';
    foreach ($users as $user) {
        $liste .= '
        <li>
            <a href="'.$this->url(array('controller'=>'user','action'=>'voir','id'=>$user['u_id'])).'">
                '.$user['u_id'].':'.$user['u_nom'].'
            </a>
        </li>';
    }
    $liste .= '</ul>';
    echo $liste;