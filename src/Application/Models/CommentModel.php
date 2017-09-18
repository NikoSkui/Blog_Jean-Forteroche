<?php

namespace App\Models;

use \PDO;
use App\Entity\Comment;
use System\Router;

class CommentModel
{

  private $router;
  private $pdo;
  
  public function __construct(PDO $pdo, Router $router)
  {
    $this->pdo = $pdo;
    $this->router = $router;
  }

  /**
   * Find all Comments with the slug of a book
   * @return array
   */
  public function findAll($id)
  {
    $params[":id"] = $id;
    $query = 'SELECT comments.parent_id,comments.*
              FROM comments
              LEFT JOIN chapters
              On comments.chapters_id = chapters.id
              WHERE chapters.id = :id
              ORDER BY comments.created_at ASC';

    $statement= $this->pdo->prepare($query);
    $statement->setFetchMode(PDO::FETCH_CLASS, Comment::class,[$this->router]);
		$statement->execute($params);
    return $statement->fetchAll(PDO::FETCH_GROUP);
  }

  public function hasParentCommentInChapter($chapters_id,$parent_id)
  {
    $params[":parent_id"] = $parent_id;
    $params[":chapters_id"] = $chapters_id;
    $query = 'SELECT comments.*
              FROM comments
              WHERE id = :parent_id
              AND chapters_id = :chapters_id';

    $statement= $this->pdo->prepare($query);
		$statement->execute($params);
    return $statement->fetch();
  }

  public function create($datas)
  {
    $fields = join(', ', array_map(function($fields){
      return "$fields = :$fields";
    }, array_keys($datas)));

    $query = "INSERT INTO comments SET $fields";
    // die();
    $statement = $this->pdo->prepare($query);
    $statement->execute($datas);
  }

}