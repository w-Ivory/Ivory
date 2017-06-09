<?php

class UserModel extends Model
{
    public function getUsers($nombreResParPage = null,$page = 1)
    {
        $query = "SELECT `u_nom`,`u_id` FROM `user` ORDER BY `u_nom`";
        if ($nombreResParPage) {
            //TODO Vérifier $nombreResParPage et $page
            $firstPos = ($page - 1)*$nombreResParPage;
            $query .= " LIMIT ".$firstPos.','.$nombreResParPage;
        }
        $stmt = $this->pdo->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUser($id)
    {
        $stmt = $this->pdo->prepare("SELECT `u_id`,`u_nom`,`u_prenom`,`u_date_naissance` FROM `user` WHERE `u_id` = ?");
        $stmt->execute(array($id));
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function lastPage($nombreResParPage = null)
    {
        if (!isset($nombreResParPage)) {
            return 1;
        } else {
            $query = "SELECT COUNT(`u_id`) AS 'u_total' FROM `user`";
            $stmt = $this->pdo->query($query);
            $row = $stmt->fetch();
            $total = $row['u_total'];

            return ceil($total/$nombreResParPage);
        }
    }

}