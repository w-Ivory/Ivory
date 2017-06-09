<?php
require_once('FW/Controller.php');
class UserController extends Controller{

	public function indexAction(){

		//Charger des données grâce au model
		require_once('App/Model.php');
		$model = new Model();
		$data = $model->getData();
		// var_dump($data);
		require('App/View/User/index.php');
	}
	public function voirAction(){
		$id =(int) $this->request->get('id');
		require_once('App/Model.php');
		$model = new Model();
		$user = $model->getUser($id);
		require('App/View/User/voir.php');
	}
}