<?php

namespace App\Model;

class UserManager
{
    protected $oDb;

    public function __construct()
    {
        $this->oDb = new \App\Engine\Db;
    }

    public function getUsers()
    {
        $oStmt = $this->oDb->prepare('SELECT *
         FROM utilisateur');
        $oStmt->execute();
        return $oStmt->fetchAll(\PDO::FETCH_OBJ);
    }

    public function getUserById($id)
    {
        $oStmt = $this->oDb->prepare('SELECT * FROM utilisateur WHERE id = :userId');
        $oStmt->bindParam(':userId', $id, \PDO::PARAM_INT);
        $oStmt->execute();
        return $oStmt->fetch(\PDO::FETCH_OBJ);
    }

}