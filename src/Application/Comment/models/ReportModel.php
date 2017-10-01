<?php

namespace App\Comment\models;

use \PDO;
use App\Comment\entities\Report;
use System\Router;
use System\Database\Model;

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

}