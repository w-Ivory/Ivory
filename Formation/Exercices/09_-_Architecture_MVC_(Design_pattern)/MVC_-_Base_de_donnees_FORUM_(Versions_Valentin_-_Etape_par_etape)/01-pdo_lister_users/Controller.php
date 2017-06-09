<?php
class Controller{
	public function action(){
		//Charger des données grâce au model
		require_once('Model.php');
		$model = new Model();
		$data = $model->getData();
		// var_dump($data);
		require('view.php');
	}
}