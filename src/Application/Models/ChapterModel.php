<?php

namespace App\Models;

use \PDO;
use App\Entity\Chapter;
use System\Router;

class ChapterModel
{

  private $router;
  private $pdo;
  
  public function __construct(PDO $pdo, Router $router)
  {
    $this->pdo = $pdo;
    $this->router = $router;
  }

  /**
   * Find all Chapters with the slug of a book
   * @return array
   */
  public function findAll($slug)
  {
    $params[":slug"] = $slug;
    $query = 'SELECT books.name as book_name, chapters.id, chapters.slug, chapters.chapters_order, books.slug as book_slug
              FROM chapters
              LEFT JOIN books
              On chapters.books_id = books.id
              WHERE books.slug = :slug
              ORDER BY chapters.chapters_order ASC';

    $statement= $this->pdo->prepare($query);
    $statement->setFetchMode(PDO::FETCH_CLASS, Chapter::class,[$this->router]);
		$statement->execute($params);
    return $statement->fetchAll(PDO::FETCH_GROUP);
  }

  /**
   * Find one Chapter with the id of chapter
   * @return array
   */
  public function findOne($id)
  {
    $params[":id"] = $id;
    $query = 'SELECT chapters.*,books.name as book_name,books.slug as book_slug
              FROM chapters
              LEFT JOIN books
              On chapters.books_id = books.id
              WHERE chapters.id = :id
              ORDER BY chapters.chapters_order ASC';

    $statement= $this->pdo->prepare($query);
    $statement->setFetchMode(\PDO::FETCH_CLASS, Chapter::class,[$this->router]);
		$statement->execute($params);
    return $statement->fetch();
  }

  public function create($data)
  {
    foreach($data as $k=>$v){
      $fields[] = "$k=:$k";
      $params[":$k"] = $v;	
    }
    $sql = 'INSERT INTO chapters SET '.implode(',', $fields);
    $statement = $this->pdo->prepare($sql);
    $statement->execute($params);
  }


}
  