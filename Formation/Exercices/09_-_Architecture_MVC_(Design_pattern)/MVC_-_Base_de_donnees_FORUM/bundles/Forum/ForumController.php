<?php
/**
 * ------------------------------------------------------------
 * FORUM CONTROLLER
 * (Requires : TypeTest | NavigationManagement | SRequest | KernelException | KernelController | ClassForum | ClassConversation | ClassMessage)
 * ------------------------------------------------------------
**/
class ForumController extends KernelController {
    /**
     * --------------------------------------------------
     * CONSTANTS
     * --------------------------------------------------
    **/
    const SPEECH_BALLOON = '&#128172;';
    const LEFT_SPEECH_BUBBLE = '&#128488;';
    const RIGHT_SPEECH_BUBBLE = '&#128489;';
    const TWO_SPEECH_BUBBLES = '&#128490;';
    const THREE_SPEECH_BUBBLES = '&#128491;';



    /**
     * --------------------------------------------------
     * METHODS
     * --------------------------------------------------
    **/
    /**
     * defaultAction - Displays the default view
     * @param
     * @return
    **/
    public function defaultAction() {
        $this->init( __FUNCTION__ );

        try {
            $this->setModel();

            $forum = new ClassForum( $this->getModel()->getConversation() );

            $sitename = 'Conversations';
            $login = ( $this->getModAuth()!==null && $this->getModAuth()->getUser()!==null ? $this->getModAuth()->getUser()->getPrenom() : null );
            $error = $this->getRequest()->get( '_err' );

            include_once( WEBPATH . 'header.php' );
            include( ( isset( $this->getSettings()['view']['path'] ) ? $this->getSettings()['view']['path'] : '' ) . $this->getView() . '.php' );
            include_once( WEBPATH . 'footer.php' );
        } catch( Exception $e ) {
            throw new KernelException( 'Can not render the <strong>' . $this->getController() . '</strong> view', $e->getCode(), $e );
        }
    }


    public function conversationAction() {
        if( !( $this->getRequest()->get( 'conv' )!==NULL && TypeTest::is_valid_int( $this->getRequest()->get( 'conv' ) ) ) )
            NavigationManagement::redirect( DOMAIN . 'error/404' );

        $this->init( __FUNCTION__ );

        try {
            $this->setModel();

            ClassConversation::setLimit( RESULTS_PER_PAGE );
            $forum = new ClassForum( $this->getModel()->getConversation( $this->getRequest()->get( 'conv' ), ClassMessage::getSort() ) );
            if( !( $forum->getConversation( $this->getRequest()->get( 'conv' ) )!==NULL && is_object( $forum->getConversation( $this->getRequest()->get( 'conv' ) ) ) && get_class( $forum->getConversation( $this->getRequest()->get( 'conv' ) ) )=='ClassConversation' ) )
                NavigationManagement::redirect( DOMAIN . 'error/404' );

            $conversation_number = ( $forum->getConversation( $this->getRequest()->get( 'conv' ) )->getId()!==NULL ? $forum->getConversation( $this->getRequest()->get( 'conv' ) )->getId() : ( $this->getRequest()->get( 'conv' )!==NULL ? $this->getRequest()->get( 'conv' ) : '(inconnu)' ) );
            $sitename = 'Message de la conversation n°' . $conversation_number;
            $login = ( $this->getModAuth()!==null && $this->getModAuth()->getUser()!==null ? $this->getModAuth()->getUser()->getPrenom() : null );
            $error = $this->getRequest()->get( '_err' );
            $conversation = $forum->getConversation( $this->getRequest()->get( 'conv' ) );

            include_once( WEBPATH . 'header.php' );
            include( ( isset( $this->getSettings()['view']['path'] ) ? $this->getSettings()['view']['path'] : '' ) . $this->getView() . '.php' );
            include_once( WEBPATH . 'footer.php' );
        } catch( Exception $e ) {
            throw new KernelException( 'Can not render the <strong>' . $this->getController() . '</strong> view', $e->getCode(), $e );
        }
    }
}