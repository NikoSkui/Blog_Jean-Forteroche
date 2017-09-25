<?php

namespace App\Entity;

class Comment extends Entity
{
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
  public $indexComment = 0;

  public function __construct()
  {
    if($this->content) {
      $this->content = htmlentities($this->content);
    }
    if($this->pseudo) {
      $this->pseudo = htmlentities($this->pseudo);
    }
    if($this->created_at) {
      $this->created_at = new \Datetime($this->created_at);
    }
  }

  public function setIndexes($elements,$key)
  {
      if ($key > 0){
        $this->indexBook ++;
        $this->indexChapter ++;
        $this->indexComment ++;
      } 
       if (isset($elements[0][$key+1]->chapters_order) && $elements[0][$key+1]->chapters_order !== $this->chapters_order) {
         $this->indexChapter = -1;
         $this->indexComment = -1;
       }
       if (isset($elements[0][$key-1]->chapters_order) && $elements[0][$key-1]->chapters_order !== $this->chapters_order) {
         $this->indexChapter = 0;
       }
       if (isset($elements[0][$key+1]->books_name) && $elements[0][$key+1]->books_name !== $this->books_name) {
         $this->indexBook = -1;
       }
  }

}
