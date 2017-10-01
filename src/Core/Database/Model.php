<?php

namespace System\Database;

use \PDO;
use System\Container\DIContainer;

class Model
{
  protected $entity;

  protected $additionnalEntity;

  protected $model;

  protected $fetchModeAll;

  protected $container;
  
  protected $pdo;
  
  public function __construct(PDO $pdo, DIContainer $container)
  {
    
    $this->pdo = $pdo;

    $this->container = $container;
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
    if($this->entity){
      $statement->setFetchMode(\PDO::FETCH_CLASS, $this->entity,[$this->container]);
    }
		$statement->execute();
    return $statement->fetchAll($this->fetchModeAll);
  }

  protected function queryFindAll()
  {
    return "SELECT * FROM $this->model";
  }

  /**
   * Read additionnals elements 
   * @return array
   */
  public function findAdditionnals()
  {
    $query = $this->queryFindAdditionnal();
    $statement= $this->pdo->prepare($query);
    if($this->additionnalEntity){
      $statement->setFetchMode(\PDO::FETCH_CLASS, $this->additionnalEntity,[$this->container]);
    }
		$statement->execute();
    return $statement->fetchAll($this->fetchModeAll);
  }

  protected function queryFindAdditionnal()
  {
    return "SELECT * FROM $this->model";
  }

  /**
   * Read all elements with the column of element
   * @return array
   */
  public function findAllBy($field, $value)
  {
    $statement= $this->pdo->prepare("SELECT id FROM $this->model WHERE $field = ?");
    if($this->entity){
      $statement->setFetchMode(\PDO::FETCH_CLASS, $this->entity,[$this->container]);
    }
		$statement->execute([$value]);

    return $statement->fetchAll(PDO::FETCH_COLUMN);
  }

  /**
   * Read one element with the id of element
   * @return array
   */
  public function findOne($id)
  {
    $statement= $this->pdo->prepare("SELECT * FROM $this->model WHERE id = ?");
    if($this->entity){
      $statement->setFetchMode(\PDO::FETCH_CLASS, $this->entity,[$this->container]);
    }
		$statement->execute([$id]);
    return $statement->fetch();
  }

  /**
   * Read one element with the column of element
   * @return array
   */
  public function findBy($field, $value)
  {
    $statement= $this->pdo->prepare("SELECT * FROM $this->model WHERE $field = ?");
    if($this->entity){
      $statement->setFetchMode(\PDO::FETCH_CLASS, $this->entity,[$this->container]);
    }
		$statement->execute([$value]);

    return $statement->fetch();
  }

  /**
  * Update a new element
  * @return bool
  */
  public function update($id, $datas)
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
  public function delete($id)
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
  