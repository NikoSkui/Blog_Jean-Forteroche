<?php

namespace App\Comment\entities;

class Report
{
  public $id;
  public $count;
  public $report_lvl;
  public $report_msg;

  public function __construct()
  {

    switch ($this->report_lvl) {
      case '1':
        $this->report_msg = 'signalé ce commentaire comme ennuyeux ou inintéressant';
        break;
      case '2':
        $this->report_msg = 'signalé ce commentaire comme n’ayant rien à faire sur ce blog';
        break;
      case '3':
        $this->report_msg = 'signalé ce commentaire comme étant indésirable';
        break;
      
      default:
        $this->report_msg = 'test';
        break;
    }
  }

  /**
   * Method magique __call
   */
  public function __CALL($key,$params)
  {
    $method = 'get'.ucfirst($key);
    $this->$key = $this->$method($params);
    return $this->$key;
  }

  public function getCount($value)
  {
    if ($value[0] === 0) {
      $html = '<strong>1 personne</strong> a';
    } else {
      $value = $value[0] + 1;
      $html = '<strong>' . $value . ' personnes</strong> ont';
    }
    return $html;
  }

}
