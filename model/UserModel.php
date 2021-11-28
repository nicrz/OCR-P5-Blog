<?php

namespace App\Model;

use App\Engine\Db as DB;

class UserModel
{
    protected $oDb;

    public function __construct()
    {
        $this->oDb = new DB;
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

    public function checkEmailExistence($email)
    {
        $oStmt = $this->oDb->prepare('SELECT * FROM utilisateur WHERE email = :email');
        $oStmt->bindParam(':email', $email, \PDO::PARAM_STR);
        $oStmt->execute();
        $res = $oStmt->fetch(\PDO::FETCH_OBJ);

        if ($res){
            return true;
        }else{
            return false;
        }
    }

    public function checkIdExistence($identifiant)
    {
        $oStmt = $this->oDb->prepare('SELECT * FROM utilisateur WHERE identifiant = :identifiant');
        $oStmt->bindParam(':identifiant', $identifiant, \PDO::PARAM_STR);
        $oStmt->execute();
        $res = $oStmt->fetch(\PDO::FETCH_OBJ);

        if ($res){
            return true;
        }else{
            return false;
        }
    }

    public function addUser($nom, $prenom, $identifiant, $email, $motdepasse)
    {
        $oStmt = $this->oDb->prepare('INSERT INTO utilisateur (nom, prenom, identifiant, email, motdepasse)
        VALUES
        (:nom, :prenom, :identifiant, :email, :motdepasse)');
        $oStmt->bindParam(':nom', $nom, \PDO::PARAM_STR);
        $oStmt->bindParam(':prenom', $prenom, \PDO::PARAM_STR);
        $oStmt->bindParam(':identifiant', $identifiant, \PDO::PARAM_STR);
        $oStmt->bindParam(':email', $email, \PDO::PARAM_STR);
        $oStmt->bindParam(':motdepasse', $motdepasse, \PDO::PARAM_STR);
        $oStmt->debugDumpParams();
        $oStmt->execute();
        
    }

    public function editUser($userid, $nom, $prenom, $identifiant, $email, $actif, $type)
    {
        $oStmt = $this->oDb->prepare('UPDATE utilisateur 
        SET nom = :nom, 
        prenom = :prenom,
        identifiant = :identifiant,
        email = :email,
        actif = :actif,
        type = :type
        WHERE id = :userid');
        $oStmt->bindParam(':userid', $userid, \PDO::PARAM_INT);
        $oStmt->bindParam(':nom', $nom, \PDO::PARAM_STR);
        $oStmt->bindParam(':prenom', $prenom, \PDO::PARAM_STR);
        $oStmt->bindParam(':identifiant', $identifiant, \PDO::PARAM_STR);
        $oStmt->bindParam(':email', $email, \PDO::PARAM_STR);
        $oStmt->bindParam(':actif', $actif, \PDO::PARAM_INT);
        $oStmt->bindParam(':type', $type, \PDO::PARAM_INT);
        $oStmt->execute();
    }

    public function login($email, $password)
    {
        $oStmt = $this->oDb->prepare('SELECT * FROM utilisateur WHERE email = :email');
        $oStmt->bindParam(':email', $email, \PDO::PARAM_STR);
        $oStmt->execute();
        $user = $oStmt->fetch(\PDO::FETCH_OBJ);

        if ($user && password_verify($password, $user->motdepasse)){
            return $user;
        }else{
            return false;
        }
    }

}