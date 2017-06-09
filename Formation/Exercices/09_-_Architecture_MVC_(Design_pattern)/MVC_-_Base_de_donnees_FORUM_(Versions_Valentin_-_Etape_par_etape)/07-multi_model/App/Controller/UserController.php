<?php
require_once('FW/Controller.php');
class UserController extends Controller{

	public function indexAction(){

		//Charger des données grâce au model
		require_once('App/Model/UserModel.php');
		$userModel = new UserModel();
		$data = $userModel->getData();
		// var_dump($data);
		require('App/View/User/index.php');
	}
	public function voirAction(){
		$id =(int) $this->request->get('id');
		require_once('App/Model/UserModel.php');
		$userModel = new UserModel();
		$user = $userModel->getUser($id);
		require('App/View/User/voir.php');
	}
}