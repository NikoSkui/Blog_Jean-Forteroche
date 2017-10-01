<?php

namespace App\Blog\models;

use App\Blog\entities\Book;
use System\Database\Model;

class BookModel extends Model
{

  protected $entity = Book::class;

  protected $model = 'books';

  public function findOneFront(int $id)
  {
    $query = "SELECT b.name
              FROM $this->model as b
              LEFT JOIN chapters as c ON b.id = c.books_id
              WHERE b.id = ?
              ORDER BY c.chapters_order ASC";

    $statement= $this->pdo->prepare($query);
    if($this->entity){
      $statement->setFetchMode(\PDO::FETCH_CLASS, $this->entity,[$this->container]);
    }
    $statement->execute([$id]);
    return $statement->fetchAll(\PDO::FETCH_GROUP);
  }

  public function findForHomePage()
  {
    $query = "SELECT *
              FROM $this->model as b
              WHERE b.on_home = 1";

    $statement= $this->pdo->prepare($query);
    if($this->entity){
      $statement->setFetchMode(\PDO::FETCH_CLASS, $this->entity,[$this->container]);
    }
    $statement->execute();
    return $statement->fetch();
  }
  
}