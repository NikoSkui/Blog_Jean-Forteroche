<?php

namespace App\Blog\entities;

use System\Http\ServerRequest;

class Chapter
{
  public $id;
  public $name;
  public $slug;
  public $content;
  public $created_at;
  public $modified_at;
  public $chapters_order;
  public $books_id;

  public function __construct()
  {

    $this->name = htmlentities($this->name);
    $this->created_at = new \Datetime($this->created_at);
    $this->modified_at = new \Datetime($this->modified_at);
  }

}
