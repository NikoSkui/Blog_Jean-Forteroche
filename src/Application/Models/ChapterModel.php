<?php

namespace App\Models;

use App\Entity\Chapter;
use System\Model\Model;

class ChapterModel extends Model
{

  protected $entity = Chapter::class;

  protected $model = 'chapters';

  protected $fetchModeAll = \PDO::FETCH_GROUP;


  public function findAllWithBook(int $id)
  {
    $query = "SELECT b.name, c.chapters_order, c.slug as slugChapter, c.chapters_order, b.slug as slugBook
              FROM chapters as c
              LEFT JOIN books as b ON c.books_id = b.id
              WHERE b.id = ?
              ORDER BY c.chapters_order ASC";
    $statement= $this->pdo->prepare($query);
    $statement->setFetchMode(\PDO::FETCH_CLASS, $this->entity,[$this->router]);
		$statement->execute([$id]);
    return $statement->fetchAll($this->fetchModeAll);
  }
  /**
   * Read one element with the column of element
   * @return array
   */
  public function findOneWithBook(string $slugChapter, int $idBook)
  {

    $datas['id'] = $idBook;
    $datas['slug'] = $slugChapter;

    $query = "SELECT c.*
              FROM chapters as c
              LEFT JOIN books as b ON c.books_id = b.id
              WHERE b.id = :id AND c.slug = :slug
              ORDER BY c.chapters_order ASC";

    $statement= $this->pdo->prepare($query);
    if($this->entity){
      $statement->setFetchMode(\PDO::FETCH_CLASS, $this->entity,[$this->router]);
    }

		$statement->execute($datas);

    return $statement->fetch();
  }

  protected function queryFindAll()
  {
    return "SELECT b.name as book_name, c.id, c.name, c.slug, c.chapters_order
            FROM chapters as c
            LEFT JOIN books as b ON c.books_id = b.id
            ORDER BY c.chapters_order DESC";
  }

  protected function buildField (array $datas, $join = ', ')
  {
    return join($join, array_map(function($fields){
      return "$fields = :$fields";
    }, array_keys($datas)));
  }
  
}
  