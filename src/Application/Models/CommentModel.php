<?php

namespace App\Models;

use \PDO;
use App\Entity\Comment;
use System\Router;
use System\Model\Model;

class CommentModel extends Model
{

  protected $router;
  protected $pdo;

  protected $entity = Comment::class;

  protected $model = 'comments';

  protected $fetchModeAll = \PDO::FETCH_GROUP;
  
  public function __construct(PDO $pdo, Router $router)
  {
    $this->pdo = $pdo;
    $this->router = $router;
  }

  /**
  * Create a new comment
  */
  public function create($datas)
  {
    $fields = join(', ', array_map(function($fields){
      return "$fields = :$fields";
    }, array_keys($datas)));

    $query = "INSERT INTO comments SET $fields";
    $statement = $this->pdo->prepare($query);
    $statement->execute($datas);
  }

  /**
   * Read all Comments with the slug of a book
   * @return array
   */
  public function findAllWithChapter($id)
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
  
  /**
   * Read the parent comment of the current comment in a specific chapter
   * @return array
   */
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

  protected function queryFindAll()
  {
    return "SELECT comments.parent_id,comments.*, chapters.chapters_order,books.name as books_name
              FROM comments
              LEFT JOIN chapters ON comments.chapters_id = chapters.id
              LEFT JOIN books ON chapters.books_id = books.id
              ORDER BY books.id ASC, books.created_at ASC, chapters.chapters_order DESC";
  }

}