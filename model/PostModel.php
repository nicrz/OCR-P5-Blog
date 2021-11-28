<?php

namespace App\Model;

use App\Engine\Db as DB;

class PostModel
{
    protected $oDb;

    public function __construct()
    {
        $this->oDb = new DB;
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
        $oStmt = $this->oDb->prepare('SELECT article.id, titre, chapo, contenu, maj, idAuteur, utilisateur.nom, utilisateur.prenom
         FROM article
         INNER JOIN utilisateur ON article.idAuteur = utilisateur.id 
         WHERE article.id = :postId');
        $oStmt->bindParam(':postId', $id, \PDO::PARAM_INT);
        $oStmt->execute();
        return $oStmt->fetch(\PDO::FETCH_OBJ);
    }

    public function addPost($title, $chapo, $content, $author)
    {
        $oStmt = $this->oDb->prepare('INSERT INTO article (titre, chapo, contenu, maj, idAuteur) VALUES (:title, :chapo, :content, NOW(), :author)');
        $oStmt->bindParam(':title', $title, \PDO::PARAM_STR);
        $oStmt->bindParam(':chapo', $chapo, \PDO::PARAM_STR);
        $oStmt->bindParam(':content', $content, \PDO::PARAM_STR);
        $oStmt->bindParam(':author', $author, \PDO::PARAM_INT);
        $oStmt->execute();
    }

    public function editPost($postid, $title, $chapo, $content, $author)
    {
        $oStmt = $this->oDb->prepare('UPDATE article SET titre = :title, chapo = :chapo, contenu = :content, idAuteur = :author WHERE id = :postid');
        $oStmt->bindParam(':postid', $postid, \PDO::PARAM_INT);
        $oStmt->bindParam(':title', $title, \PDO::PARAM_STR);
        $oStmt->bindParam(':chapo', $chapo, \PDO::PARAM_STR);
        $oStmt->bindParam(':content', $content, \PDO::PARAM_STR);
        $oStmt->bindParam(':author', $author, \PDO::PARAM_INT);
        $oStmt->execute();
    }

    public function deletePost($postid)
    {
        $oStmt = $this->oDb->prepare('DELETE FROM article WHERE id = :postid');
        $oStmt->bindParam(':postid', $postid, \PDO::PARAM_INT);
        $oStmt->execute();
    }

}