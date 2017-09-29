<?php

namespace App\Models;

use \PDO;
use App\Entity\Report;
use System\Router;
use System\Model\Model;

class ReportModel extends Model
{

  protected $router;
  protected $pdo;

  protected $entity = Report::class;

  protected $model = 'reports';

  protected $fetchModeAll = \PDO::FETCH_GROUP;
  
  public function __construct(PDO $pdo, Router $router)
  {
    $this->pdo = $pdo;
    $this->router = $router;
  }

  protected function queryFindAll()
  {
    return "SELECT r.comments_id, r.id, r.report_lvl, c.pseudo, c.content, ch.chapters_order as chapter_name, b.name as book_name
              FROM reports as r
              LEFT JOIN comments as c ON r.comments_id = c.id
              LEFT JOIN chapters as ch ON c.chapters_id = ch.id
              LEFT JOIN books as b ON ch.books_id = b.id
              ORDER BY r.report_lvl
              ";
  }

      // return "SELECT comments.parent_id,comments.*, chapters.chapters_order,books.name as books_name
      //         FROM reports
      //         LEFT JOIN chapters ON comments.chapters_id = chapters.id
      //         LEFT JOIN books ON chapters.books_id = books.id
      //         ORDER BY books.id ASC, books.created_at ASC, chapters.chapters_order DESC";



  // /**
  //  * Read all Comments with the slug of a book
  //  * @return array
  //  */
  // public function findAllWithChapter($id)
  // {
  //   $params[":id"] = $id;
  //   $query = 'SELECT comments.parent_id,comments.*
  //             FROM comments
  //             LEFT JOIN chapters
  //             On comments.chapters_id = chapters.id
  //             WHERE chapters.id = :id
  //             ORDER BY comments.created_at ASC';

  //   $statement= $this->pdo->prepare($query);
  //   $statement->setFetchMode(PDO::FETCH_CLASS, Comment::class,[$this->router]);
	// 	$statement->execute($params);
  //   return $statement->fetchAll(PDO::FETCH_GROUP);
  // }
  
  // /**
  //  * Read the parent comment of the current comment in a specific chapter
  //  * @return array
  //  */
  // public function hasParentCommentInChapter($chapters_id,$parent_id)
  // {
  //   $params[":parent_id"] = $parent_id;
  //   $params[":chapters_id"] = $chapters_id;
  //   $query = 'SELECT comments.*
  //             FROM comments
  //             WHERE id = :parent_id
  //             AND chapters_id = :chapters_id';

  //   $statement= $this->pdo->prepare($query);
	// 	$statement->execute($params);
  //   return $statement->fetch();
  // }

}