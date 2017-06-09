<?php
class UserController extends Controller
{
    private $_authModule;

    public function __preload(){
        $this->_authModule = new AuthModule();
        
    }
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
        $this->view->users = $userModel->getUsers($resParPage,$page);
        $this->view->lastPage = $userModel->lastPage($resParPage);
        $this->view->page = $page;

        $this->renderView();
    }

    public function voirAction()
    {
        $id =(int) $this->request->get('id');
        $userModel = new UserModel();
        
        $this->view->user = $userModel->getUser($id);


        if($this->request->get('rendu')=='xml'){
            $this->renderView('voirXML',false);
        }else{
            $this->renderView();
        }
    }
}
