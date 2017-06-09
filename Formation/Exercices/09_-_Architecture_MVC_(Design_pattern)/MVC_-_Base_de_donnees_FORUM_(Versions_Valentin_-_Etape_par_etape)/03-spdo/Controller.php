<?php
class Controller{
	public $request;

	public function __construct($request){
		$this->request = $request;
	}

	public function indexAction(){

		//Charger des données grâce au model
		require_once('Model.php');
		$model = new Model();
		$data = $model->getData();
		// var_dump($data);
		require('View/index.php');
	}
	public function voirAction(){
		$id =(int) $this->request->get('id');
		require_once('Model.php');
		$model = new Model();
		$user = $model->getUser($id);
		require('View/voir.php');
	}
}