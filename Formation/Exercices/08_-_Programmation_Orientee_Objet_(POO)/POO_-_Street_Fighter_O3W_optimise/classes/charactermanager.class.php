<?php
class CharacterManager {
    private $connexion;
    const TABLE = 'character';

    public function __construct( $scheme, $host, $dbname, $login, $pass ) {
        try {
            $this->connexion = new PDO( $scheme . ':host=' . $host . ';dbname=' . $dbname . ';charset=utf8', $login, $pass, array() );
        } catch( PDOException $e ) {
            die( $e->getMessage() );
        }
    }

    public function record_exists( $name ) {
        $sql = 'SELECT COUNT( `name` ) AS cpt FROM `' . self::TABLE . '` WHERE `name`=:name';
        $binds = array(
            'name' => $name
        );
        if( ( $row = $this->executeQuery( $sql, $binds ) )!==false ) {
            if( isset( $row[0]['cpt'] ) ) {
                if( $row[0]['cpt'] > 0 ) {
                    return true;
                } else {
                    return false;
                }
            }
        }

        return null;
    }

    public function getAll() {
        return $this->executeQuery( 'SELECT * FROM `' . self::TABLE . '` ORDER BY `name` ASC');
    }

    public function getUniq( $name ) {
        $sql = 'SELECT * FROM `' . self::TABLE . '` WHERE `name`=:name';
        $binds = array(
            'name' => $name
        );
        $tmp = $this->executeQuery( $sql, $binds );

        return new Character( $tmp[0]['name'], $tmp[0]['damages'] );
    }

    public function add( Character $character ) {
        $sql = 'INSERT INTO `' . self::TABLE . '`(`name`, `damages`) VALUES (:name, :damages)';
        $binds = array(
            'name' => $character->getName(),
            'damages' => $character->getDamages()
        );
        return $this->executeQuery( $sql, $binds );
    }

    public function update( Character $character ) {
        $sql = 'UPDATE `' . self::TABLE . '` SET `damages`=:damages WHERE `name`=:name';
        $binds = array(
            'name' => $character->getName(),
            'damages' => $character->getDamages()
        );
        return $this->executeQuery( $sql, $binds );
    }

    public function delete( $name ) {
        $sql = 'DELETE FROM `' . self::TABLE . '` WHERE `name`=:name';
        $binds = array(
            'name' => $name
        );
        return $this->executeQuery( $sql, $binds );
    }

    public function reset() {
        $sql = 'DELETE FROM `' . self::TABLE . '`';
        return $this->executeQuery( $sql );
    }



    private function executeQuery( $sql, $binds = array() ) {
        if( count( $binds )>0 ) {
            if( ( $stmt = $this->connexion->prepare( $sql ) )!==false ) {
                foreach( $binds as $key => $value ) {
                    if( !$stmt->bindValue( $key, $value ) ) {
                        return false;
                    }
                }

                if( $stmt->execute() ) {
                    if( strtoupper( substr( $sql, 0, 6 ) ) == 'SELECT' ) {
                        return $stmt->fetchAll( PDO::FETCH_ASSOC );
                    } else {
                        return true;
                    }
                }
            }
        } else {
            if( ( $stmt = $this->connexion->query( $sql ) )!==false ) {
                if( strtoupper( substr( $sql, 0, 6 ) ) == 'SELECT' ) {
                    return $stmt->fetchAll( PDO::FETCH_ASSOC );
                } else {
                    return true;
                }
            }
        }

        return false;
    }
}