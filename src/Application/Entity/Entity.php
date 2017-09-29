<?php

namespace App\Entity;

class Entity
{
  public function __construct()
  {
    if($this->created_at) {
      $this->created_at = new \Datetime($this->created_at);
    }
    if($this->modified_at) {
      $this->modified_at = new \Datetime($this->modified_at);
    }
  }

  /**
   * Method magique __get
   */
  public function __GET($key)
  {
    $method = 'get'.ucfirst($key);
    $this->$key = $this->$method();
    return $this->$key;
  }

  /**
   * Method magique __call
   */
  public function __CALL($key,$params)
  {
    $method = $key;
    $this->$key = $this->$method($params);
    return $this->$key;
  }

  protected function getUrl($params = [])
  {

  }
  protected function url($params)
  {
    $this->getUrl($params);
  }

}
