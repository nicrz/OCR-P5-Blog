<?php

namespace App\Model;

use App\Engine\Db as DB;

class CommentModel
{
    protected $oDb;

    public function __construct()
    {
        $this->oDb = new DB;
    }

    public function getComments()
    {
        $oStmt = $this->oDb->prepare('SELECT *
         FROM commentaire
         ORDER BY date DESC');
        $oStmt->execute();
        return $oStmt->fetchAll(\PDO::FETCH_OBJ);
    }

    public function getCommentsFromPost($postid)
    {
        $oStmt = $this->oDb->prepare('SELECT commentaire.id, contenu, date, valide, utilisateur.nom, utilisateur.prenom
        FROM commentaire
        INNER JOIN utilisateur on commentaire.idUtilisateur = utilisateur.id
        WHERE idArticle = :postId and valide = 1
        ORDER BY date DESC');
        $oStmt->bindParam(':postId', $postid, \PDO::PARAM_INT);
        $oStmt->execute();
        return $oStmt->fetchAll(\PDO::FETCH_OBJ);
    }

    public function getPendingCommentsFromPost($postid)
    {
        $oStmt = $this->oDb->prepare('SELECT commentaire.id, contenu, date, valide, utilisateur.nom, utilisateur.prenom
        FROM commentaire
        INNER JOIN utilisateur on commentaire.idUtilisateur = utilisateur.id
        WHERE idArticle = :postId and valide = 0
        ORDER BY date DESC');
        $oStmt->bindParam(':postId', $postid, \PDO::PARAM_INT);
        $oStmt->execute();
        return $oStmt->fetchAll(\PDO::FETCH_OBJ);
    }

    public function addComment($content, $postid, $userid)
    {
        $oStmt = $this->oDb->prepare('INSERT INTO commentaire (contenu, date, valide, idArticle, idUtilisateur)
        VALUES (:content, NOW(), 0, :article, :user)');
        $oStmt->bindParam(':content', $content, \PDO::PARAM_STR);
        $oStmt->bindParam(':article', $postid, \PDO::PARAM_INT);
        $oStmt->bindParam(':user', $userid, \PDO::PARAM_INT);
        $oStmt->execute();

        if ($oStmt){
            return true;
        }
    }

    public function updateCommentStatus($status, $postid)
    {
        $oStmt = $this->oDb->prepare('UPDATE commentaire SET valide = :status WHERE id = :postid');
        $oStmt->bindParam(':postid', $postid, \PDO::PARAM_INT);
        $oStmt->bindParam(':status', $status, \PDO::PARAM_INT);
        $oStmt->execute();
    }

    public function checkIfCommentAwaiting($postid, $userid)
    {
        $oStmt = $this->oDb->prepare('SELECT *
        FROM commentaire
        WHERE valide = 0 AND idArticle = :postid AND idUtilisateur = :userid
        ORDER BY date DESC');
        $oStmt->bindParam(':postid', $postid, \PDO::PARAM_INT);
        $oStmt->bindParam(':userid', $userid, \PDO::PARAM_INT);
        $oStmt->execute();
        return $oStmt->fetch(\PDO::FETCH_OBJ);
    }

    public function deleteComment($postid)
    {
        $oStmt = $this->oDb->prepare('DELETE FROM commentaire WHERE id = :postid');
        $oStmt->bindParam(':postid', $postid, \PDO::PARAM_INT);
        $oStmt->execute();
    }



}