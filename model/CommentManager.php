<?php

namespace App\Model;

class CommentManager
{
    protected $oDb;

    public function __construct()
    {
        $this->oDb = new \App\Engine\Db;
    }

    public function getComments()
    {
        $oStmt = $this->oDb->prepare('SELECT *
         FROM commentaire
         ORDER BY date DESC');
        $oStmt->execute();
        return $oStmt->fetchAll(\PDO::FETCH_OBJ);
    }

    public function getCommentsFromPost($id)
    {
        $oStmt = $this->oDb->prepare('SELECT *
        FROM commentaire
        WHERE idArticle = :postId
        ORDER BY date DESC');
        $oStmt->bindParam(':postId', $id, \PDO::PARAM_INT);
        $oStmt->execute();
        return $oStmt->fetch(\PDO::FETCH_OBJ);
    }

}