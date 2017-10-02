<?php

namespace App\Comment\entities;

use System\Container\DIContainer;

class Comment
{
  // private $container;
  
  public $id;
  public $pseudo;
  public $email;
  public $content;
  public $created_at;
  public $chapters_id;
  public $parent_id;
  
  public $index = 0;
  public $indexBook = 0;
  public $indexChapter = 0;
  public $indexEndChapter = 0;
  public $indexComment = 0;

  public function __construct()
  {
    

      $this->content = htmlentities($this->content);
      $this->pseudo = htmlentities($this->pseudo);
      $this->created_at = new \Datetime($this->created_at);
  }

  public function getGravatar($params)
  {
    $rating = 'pg'; // Set self-rate images : g, pg, r, x
    $default ="http://mybook.3desquisse.fr/img/avatar.png"; // Set a Default Avatar
    $email = md5(strtolower(trim($this->email)));
    $gravurl = "http://www.gravatar.com/avatar/$email?d=$default&s=120&r=$rating";
    return '<p class="image is-'.$params.'x'.$params.'"><img src="'.$gravurl.'" alt="Avatar"></p>';
  }

  public function setIndexes($elements,$key)
  {
    // Shifts the elements and detects the end of loops
      if ($key > 0){
        $this->indexBook ++;
        $this->indexChapter ++;
        $this->indexEndChapter ++;
        $this->indexComment ++;
      } 
      if (
        (isset($elements[0][$key+1]->chapters_order) && 
        $elements[0][$key+1]->chapters_order !== $this->chapters_order) ||
        (isset($elements[0][$key+1]->books_name) && 
        $elements[0][$key+1]->books_name !== $this->books_name)
      ) {
        $this->indexChapter = -1;
        $this->indexComment = -1;
      }

      if (
        isset($elements[0][$key-1]->chapters_order) &&
        $elements[0][$key-1]->chapters_order !== $this->chapters_order ||
        (isset($elements[0][$key-1]->books_name) && 
        $elements[0][$key-1]->books_name !== $this->books_name)
      ) {
        $this->indexChapter = 0;
      }

      if (
        isset($elements[0][$key-1]->books_name) &&
        $elements[0][$key-1]->books_name !== $this->books_name
      ) {
        $this->indexBook = 0;
      }

      if (
        isset($elements[0][$key+1]->books_name) &&
        $elements[0][$key+1]->books_name !== $this->books_name
      ) {
        $this->indexEndChapter = -1;
      }
  }

  /**
   * Method magique __get
   */
  public function __CALL($key, $params)
  {
    if (count($params === 1)){
      $params = $params[0];
    }
    $method = 'get'.ucfirst($key);
    $this->$key = $this->$method($params);
    return $this->$key;
  }

}
