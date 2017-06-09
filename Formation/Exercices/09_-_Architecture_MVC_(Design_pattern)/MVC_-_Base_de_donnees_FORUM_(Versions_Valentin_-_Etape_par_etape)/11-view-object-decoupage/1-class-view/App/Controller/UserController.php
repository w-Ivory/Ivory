<?php
class UserController extends Controller
{

	public function indexAction()
	{
		//Nombre de résultats par page
		$resParPage = 10;
		//Numéro de page actuelle
		$page = (int) $this->request->get('page');//TODO faire les vrais tests qu'il faut faire en vrai de vrai
		if ($page<=0) {
			header('Location:index.php?controller=user&action=index&page=1');
			exit();
		}
		//Charger des données grâce au model
		$userModel = new UserModel();
		$users = $userModel->getUsers($resParPage,$page);
		$lastPage = $userModel->lastPage($resParPage);
		
		$this->renderView(array('page'=>$page,'lastPage'=>$lastPage,'users'=>$users));
	}

	public function voirAction()
	{
		$id =(int) $this->request->get('id');
		$userModel = new UserModel();
		$user = $userModel->getUser($id);
		
		$this->renderView(array('user'=>$user));
	}
}
