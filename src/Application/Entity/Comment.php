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

}
