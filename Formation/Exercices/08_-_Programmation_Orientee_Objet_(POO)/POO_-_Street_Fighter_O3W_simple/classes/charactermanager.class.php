<?php
class CharacterManager {
    private $connexion;

    public function __construct( $scheme, $host, $dbname, $login, $pass ) {
        try {
            $this->connexion = new PDO( $scheme . ':host=' . $host . ';dbname=' . $dbname . ';charset=utf8', $login, $pass, array() );
        } catch( PDOException $e ) {
            die( $e->getMessage() );
        }
    }

    public function record_exists( $name ) {
        if( ( $stmt = $this->connexion->prepare( 'SELECT COUNT( `name` ) AS cpt FROM `character` WHERE `name`=:name' ) )!==false ) {
            if( $stmt->bindValue( 'name', $name ) ) {
                if( $stmt->execute() ) {
                    if( ( $row = $stmt->fetch( PDO::FETCH_ASSOC ) )!==false ) {
                        if( isset( $row['cpt'] ) ) {
                            if( $row['cpt'] > 0 ) {
                                return true;
                            } else {
                                return false;
                            }
                        }
                    }
                }
            }
        }

        return null;
    }

    public function getAll( $type = 'data' ) {
        if( ( $stmt = $this->connexion->query( 'SELECT * FROM `character` ORDER BY `name` ASC' ) )!==false ) {
            switch( $type ) {
                case 'object':
                    $arr = array();
                    foreach( $stmt->fetchAll( PDO::FETCH_ASSOC ) as $perso ) {
                        $arr[] = new Character( $perso['name'], $perso['damages'] );
                    }
                    return $arr;
                    break;
                default:
                    return $stmt->fetchAll( PDO::FETCH_ASSOC );
            }
        }
    }

    public function getUniq( $name ) {
        if( ( $stmt = $this->connexion->prepare( 'SELECT * FROM `character` WHERE `name`=:name' ) )!==false ) {
            if( $stmt->bindValue( 'name', $name ) ) {
                if( $stmt->execute() ) {
                    return $stmt->fetch( PDO::FETCH_ASSOC );
                }
            }
        }
    }

    public function add( Character $character ) {
        if( ( $stmt = $this->connexion->prepare( 'INSERT INTO `character`(`name`, `damages`) VALUES (:name, :damages)' ) )!==false ) {
            if( $stmt->bindValue( 'name', $character->getName() ) && $stmt->bindValue( 'damages', $character->getDamages() ) ) {
                if( $stmt->execute() ) {
                    return true;
                }
            }
        }

        return false;
    }

    public function update( Character $character ) {
        if( ( $stmt = $this->connexion->prepare( 'UPDATE `character` SET `damages`=:damages WHERE `name`=:name' ) )!==false ) {
            if( $stmt->bindValue( 'name', $character->getName() ) && $stmt->bindValue( 'damages', $character->getDamages() ) ) {
                if( $stmt->execute() ) {
                    return true;
                }
            }
        }

        return false;
    }

    public function delete( $name ) {
        if( ( $stmt = $this->connexion->prepare( 'DELETE FROM `character` WHERE `name`=:name' ) )!==false ) {
            if( $stmt->bindValue( 'name', $name ) ) {
                if( $stmt->execute() ) {
                    return true;
                }
            }
        }

        return false;
    }

    public function reset() {
        if( ( $stmt = $this->connexion->query( 'DELETE FROM `character`' ) )!==false ) {
            if( $stmt->execute() ) {
                return true;
            }
        }

        return false;
    }
}