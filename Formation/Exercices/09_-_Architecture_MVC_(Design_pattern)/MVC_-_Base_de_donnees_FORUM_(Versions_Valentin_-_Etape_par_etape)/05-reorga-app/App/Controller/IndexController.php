<?php
require_once('FW/Controller.php');
class IndexController extends Controller{
	public function indexAction(){
		require('App/View/index/index.php');
	}
}