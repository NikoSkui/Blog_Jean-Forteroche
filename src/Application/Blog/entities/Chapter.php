<?php

namespace App\Blog\entities;

use System\Http\ServerRequest;

class Chapter
{
  private $id;
  private $name;
  private $slug;
  private $content;
  private $created_at;
  private $modified_at;
  private $chapters_order;
  private $books_id;
  private $statut;
  private $slugBook;

  public function __construct()
  {
    $this->setName($this->name);
    $this->setCreated_at($this->created_at);
    $this->setModified_at($this->modified_at);
  }
  /**
   * Method to get private attribute
   **/
  private function getId()
  {
    return $this->id;
  }

  /**
   * Method to get private attribute
   **/
  private function getName()
  {
    return $this->name;
  }

  /**
   * Method go set private attribute
   **/
  private function getSlug()
  {
    return $this->slug;
  }

  /**
   * Method go set private attribute
   **/
  private function getSlugBook()
  {
    return $this->slugBook;
  }

  /**
   * Method to get private attribute
   **/
  private function getContent()
  {
    return $this->content;
  }

  /**
   * Method to get private attribute
   **/
  private function getCreated_at()
  {
    return $this->created_at;
  }

  /**
   * Method to get private attribute
   **/
  private function getModified_at()
  {
    return $this->modified_at;
  }

  /**
   * Method to get private attribute
   **/
  private function getChapters_order()
  {
    return $this->chapters_order;
  }

  /**
   * Method to get private attribute
   **/
  private function getStatut()
  {
    return $this->statut;
  }

  /**
   * Method to get private attribute
   **/
  private function getBooks_id()
  {
    return $this->books_id;
  }

  /**
   * Method to set private attribute
   **/
  private function setId($value)
  {
    $this->id = $value;
    return $this->id;
  }

  /**
   * Method to set private attribute
   **/
  private function setName($value)
  {
    $this->name = htmlentities($value);
  }

  /**
   * Method to set private attribute
   **/
  private function setSlug($value)
  {
    $this->slug = $value;
  }

  /**
   * Method to set private attribute
   **/
  private function setSlugBook($value)
  {
    $this->slugBook = $value;
  }

  /**
   * Method to set private attribute
   **/
  private function setContent($value)
  {
    $this->content = $value;
  }

  /**
   * Method to set private attribute
   **/
  private function setCreated_at($value)
  {
    if (is_string($value)) {
      $this->created_at = new \Datetime($value);
    }  
    return $this->created_at;
  }

  /**
   * Method to set private attribute
   **/
  private function setModified_at($value)
  {
    if (is_string($value)) {
      $this->modified_at = new \Datetime($value);
    }
    return $this->modified_at;
  }

  /**
   * Method to set private attribute
   **/
  private function setChapters_order($value)
  {
    $this->chapters_order = $value;
    return $this->chapters_order;
  }

  /**
   * Method to set private attribute
   **/
  private function setStatut($value)
  {
    $this->statut = $value;
    return $this->statut;  
  }

  /**
   * Method to set private attribute
   **/
  private function setBooks_id($value)
  {
    $this->books_id = $value;
    return $this->books_id;  
  }

  /**
   * Method magique __get
   */
  public function __GET($name)
  {
    $method = 'get'.ucfirst($name);
    $this->$name = $this->$method();
    return $this->$name;
  }

  /**
   * Method magique __set
   */
  public function __SET($name, $value)
  {
    $method = 'set'.ucfirst($name);
    $this->$name = $this->$method($value);
    return $this->$name;
  }

  /**
   * Method magique __isset
   */
  public function __ISSET($name)
  {
    if(isset($this->$name)){
      return true;
    }
  }


}
