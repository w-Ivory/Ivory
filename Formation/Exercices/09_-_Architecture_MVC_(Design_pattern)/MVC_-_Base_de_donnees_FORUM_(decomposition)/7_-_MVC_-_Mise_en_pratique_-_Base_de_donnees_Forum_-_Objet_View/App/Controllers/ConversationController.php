<?php
/**
 * ------------------------------------------------------------
 * 
 * ------------------------------------------------------------
**/
class ConversationController extends CoreController {
    /**
     * --------------------------------------------------
     * METHODS
     * --------------------------------------------------
    **/
    /**
     * defaultAction - Displays the default view complemented by its data
     * @param   
     * @return  
    **/
    public function defaultAction() {
        $this->setAction( __FUNCTION__ );//$this->setAction( __METHOD__ );

        if( file_exists( $this->_paths[ 'model' ] . 'ConversationModel.php' ) ) :
            require_once( $this->_paths[ 'model' ] . 'ConversationModel.php' );
            $_model = new ConversationModel();
            $this->_view->arr_datas = $_model->getList();
        endif;

        $this->render();//$this->render();//include( $this->_paths[ 'view' ] . 'default.php' );
    }
    
    /**
     * conversationAction - Displays the conversation view complemented by its data
     * @param   
     * @return  
    **/
    public function conversationAction() {
        $this->setAction( __FUNCTION__ );//$this->setAction( __METHOD__ );

        if( file_exists( $this->_paths[ 'model' ] . 'ConversationModel.php' ) ) :
            require_once( $this->_paths[ 'model' ] . 'ConversationModel.php' );
            $_model = new ConversationModel();
            $this->_view->item = $_model->getUniq( $this->_request->get( 'id' ) );
        endif;

        $this->render();//include( $this->_paths[ 'view' ] . 'conversation.php' );
    }
    
    /**
     * addAction - Displays the view to add a conversation
     * @param   
     * @return  
    **/
    public function addAction() {
        if( file_exists( $this->_paths[ 'model' ] . 'ConversationModel.php' ) ) :
            require_once( $this->_paths[ 'model' ] . 'ConversationModel.php' );
            $_model = new ConversationModel();
            if( ( $id = $_model->add() )!==false ) header( 'Location:.' . ( $this->_request->get( 'c' )!==null ? '?c=' . $this->_request->get( 'c' ) . '&' : '?' ) . 'a=conversation&id=' . $id );
            else header( 'Location:.' . ( $this->_request->get( 'c' )!==null ? '?c=' . $this->_request->get( 'c' ) . ( $this->_request->get( 'a' )!==null ? '&a=' . $this->_request->get( 'a' ) : '' ) . '&' : ( $this->_request->get( 'a' )!==null ? '?a=' . $this->_request->get( 'a' ) . '&' : '?' ) . '_err=adding' ) );
        endif;
    }
}