<?php
require_once('Controller/Controller.php');
class UserController extends Controller{

	public function indexAction(){

		//Charger des données grâce au model
		require_once('Model.php');
		$model = new Model();
		$data = $model->getData();
		// var_dump($data);
		require('View/user/index.php');
	}
	public function voirAction(){
		$id =(int) $this->request->get('id');
		require_once('Model.php');
		$model = new Model();
		$user = $model->getUser($id);
		require('View/user/voir.php');
	}
}