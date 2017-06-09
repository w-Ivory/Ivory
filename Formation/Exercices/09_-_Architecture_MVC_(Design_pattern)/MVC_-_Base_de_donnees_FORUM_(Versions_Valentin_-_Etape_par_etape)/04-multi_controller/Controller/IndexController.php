<?php
require_once('Controller/Controller.php');
class IndexController extends Controller{
	public function indexAction(){
		require('View/index/index.php');
	}
}