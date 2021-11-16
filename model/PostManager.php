<?php

namespace App\Model;

class PostManager
{
    protected $oDb;

    public function __construct()
    {
        $this->oDb = new \App\Engine\Db;
    }

    public function getPosts()
    {
        $oStmt = $this->oDb->prepare('SELECT article.id, titre, chapo, contenu, maj, utilisateur.nom, utilisateur.prenom
        FROM article
        INNER JOIN utilisateur ON article.idAuteur = utilisateur.id
        ORDER BY maj DESC');
        $oStmt->execute();
        return $oStmt->fetchAll(\PDO::FETCH_OBJ);
    }

    public function getById($id)
    {
        $oStmt = $this->oDb->prepare('SELECT * FROM article WHERE id = :postId');
        $oStmt->bindParam(':postId', $id, \PDO::PARAM_INT);
        $oStmt->execute();
        return $oStmt->fetch(\PDO::FETCH_OBJ);
    }

}