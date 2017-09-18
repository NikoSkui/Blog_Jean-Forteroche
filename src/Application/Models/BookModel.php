<?php

namespace App\Models;

use \PDO;
use App\Entity\Book;
use System\Router;

class BookModel
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
  public function findAll()
  {
    $query = 'SELECT *
              FROM books
              ORDER BY created_at ASC';
              
    $statement = $this->pdo->prepare($query);
    $statement->setFetchMode(\PDO::FETCH_CLASS, Book::class,[$this->router]);
		$statement->execute();
    return $statement->fetchAll();
  }

  /**
   * Find the last book
   * @return array
   */
  public function findLast()
  {
    $query = 'SELECT *
              FROM books
              ORDER BY created_at ASC
              LIMIT 1';

    $statement = $this->pdo->prepare($query);
    $statement->setFetchMode(\PDO::FETCH_CLASS, Book::class,[$this->router]);
    $statement->execute();
    return $statement->fetch();
  }
}
  