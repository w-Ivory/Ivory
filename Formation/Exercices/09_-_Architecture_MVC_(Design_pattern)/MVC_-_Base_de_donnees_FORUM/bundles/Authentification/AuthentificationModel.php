<?php
/**
 * ------------------------------------------------------------
 * AUTHENTIFICATION MODEL
 * (Requires : TypeTest | KernelException | KernelModel | UserModel)
 * ------------------------------------------------------------
**/
class AuthentificationModel extends KernelModel {
    /**
     * --------------------------------------------------
     * METHODS
     * --------------------------------------------------
    **/
    /**
     * isAuthMatch - Performs a database select query
     * @param   array   $post
     * @return
     * @return  mixed (string|bool)
    **/
    public function isAuthMatch( $post ) {
        try {
            if( ( $out = $this->query( 'SELECT `' . ClassUser::PREFIX . 'id` FROM `user` WHERE `' . ClassUser::PREFIX . 'login`=:login', array( 'login' => array( 'VAL' => $post['login'], 'TYPE' => PDO::PARAM_STR ) ) ) )!==FALSE )
                return $out[ClassUser::PREFIX . 'id'];

            return FALSE;
        } catch( PDOException $e ) {
            throw new KernelException( 'Can not get the <strong>' . $this->getModel() . '</strong> datas', $e->getCode(), $e );
        } catch( Exception $e ) {
            throw new KernelException( 'Can not get the <strong>' . $this->getModel() . '</strong> datas', $e->getCode(), $e );
        }
    }

    /**
     * getUserByToken - Performs a database select query
     * @param   int     $token
     * @return
     * @return  mixed (object|bool)
    **/
    public function getUserByToken( $token ) {
        try {
            if( ( $datas = $this->query( 'SELECT * FROM `user` WHERE `' . ClassUser::PREFIX . 'id`=:token', array( 'token' => array( 'VAL' => $token, 'TYPE' => PDO::PARAM_INT ) ) ) )!==FALSE )
                return new ClassUser( $datas );

            return FALSE;
        } catch( PDOException $e ) {
            throw new KernelException( 'Can not get the <strong>' . $this->getModel() . '</strong> datas', $e->getCode(), $e );
        } catch( Exception $e ) {
            throw new KernelException( 'Can not get the <strong>' . $this->getModel() . '</strong> datas', $e->getCode(), $e );
        }
    }
}