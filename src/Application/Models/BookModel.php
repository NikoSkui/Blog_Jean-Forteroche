<?php

namespace App\Models;

use App\Entity\Book;
use System\Model\Model;

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
      $statement->setFetchMode(\PDO::FETCH_CLASS, $this->entity,[$this->router]);
    }
    $statement->execute([$id]);
    return $statement->fetchAll(\PDO::FETCH_GROUP);
  }

  public function findForHomePage()
  {
    $query = "SELECT *
              FROM $this->model as b
              WHERE b.id = ?";

    $statement= $this->pdo->prepare($query);
    if($this->entity){
      $statement->setFetchMode(\PDO::FETCH_CLASS, $this->entity,[$this->router]);
    }
    $statement->execute([1]);
    return $statement->fetch();
  }
  
}
// SELECT * FROM t1 WHERE column1 = (SELECT column1 FROM t2);

// "SELECT b.*
// FROM $this->model as b
// LEFT JOIN chapters as c ON b.id = c.books_id
// WHERE b.id = ?
// ORDER BY c.chapters_order ASC";