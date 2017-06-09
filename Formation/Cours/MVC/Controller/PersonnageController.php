<?php
require_once( 'Model/PersonnageManager.php' );

class PersonnageController {
    private $model;

    public function __construct() {
        $this->model = new PersonnageManager;
    }

    public function show() {
        $model = $this->model;
        $datas = $model->getDatas();
        $nom = $datas->getNom();
        $age = $datas->getAge();

        include( 'View/PersonnageView.php' );
    }

    public function modif() {
        $model = $this->model;
        $datas = $model->getDatas();
        $nom = $datas->getNom();
        $age = $datas->getAge();

        include( 'View/PersonnageModifView.php' );
    }
}