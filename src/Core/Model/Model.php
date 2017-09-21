<?php

namespace System\Model;

use \PDO;
use System\Router;

class Model
{
  protected $entity;

  protected $model;

  protected $fetchModeAll;

  protected $router;
  
  protected $pdo;
  
  public function __construct(PDO $pdo, Router $router)
  {
    
    $this->pdo = $pdo;

    $this->router = $router;
  }

  /**
  * Create a new Chapter
  * @return bool
  */
  public function create($datas)
  {
    $fields = $this->buildField($datas);
    $statement = $this->pdo->prepare("INSERT INTO $this->model SET $fields");
    return $statement->execute($datas);
  }

  /**
   * Read all elements 
   * @return array
   */
  public function findAll()
  {
    $query = $this->queryFindAll();
    $statement= $this->pdo->prepare($query);
    $statement->setFetchMode(PDO::FETCH_CLASS, $this->entity,[$this->router]);
		$statement->execute();
    return $statement->fetchAll($this->fetchModeAll);
  }

  protected function queryFindAll()
  {
    return "SELECT * FROM $this->model";
  }

  /**
   * Read one element with the id of element
   * @return array
   */
  public function findOne(int $id)
  {
    $statement= $this->pdo->prepare("SELECT * FROM $this->model WHERE id = ?");
    if($this->entity){
      $statement->setFetchMode(\PDO::FETCH_CLASS, $this->entity,[$this->router]);
    }
		$statement->execute([$id]);
    return $statement->fetch();
  }

  /**
   * Read one element with the column of element
   * @return array
   */
  public function findBy(string $field ,string $value)
  {
    $statement= $this->pdo->prepare("SELECT * FROM $this->model WHERE $field = ?");
    if($this->entity){
      $statement->setFetchMode(\PDO::FETCH_CLASS, $this->entity,[$this->router]);
    }
		$statement->execute([$value]);

    return $statement->fetch();
  }

  /**
  * Update a new element
  * @return bool
  */
  public function update(int $id, array $datas)
  {
    $fields = $this->buildField($datas);
    $datas['id'] = $id;

    $statement = $this->pdo->prepare("UPDATE $this->model SET $fields WHERE id = :id");
    return $statement->execute($datas);
  }

  /**
  * Delete one element with id of element
  * @return bool
  */
  public function delete(int $id)
  { 
    $statement = $this->pdo->prepare("DELETE FROM $this->model WHERE id = ?");
    return $statement->execute([$id]);
  }

  private function buildField (array $datas, $join = ', ')
  {
    return join($join, array_map(function($fields){
      return "$fields = :$fields";
    }, array_keys($datas)));
  }

}
  