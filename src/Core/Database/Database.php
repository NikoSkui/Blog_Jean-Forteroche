<?php

namespace System\Database;

use \PDO;

class Database
{

  private $db_name;

  private $db_port = 3306;

  private $db_host;

  private $db_user;

  private $db_pass;

  private $pdo;


  public function __construct($db_name, $db_host = 'localhost', $db_user = 'root' , $db_pass = 'root')
  {
    $this->db_name = $db_name;
    $this->db_host = $db_host;
    $this->db_user = $db_user;
    $this->db_pass = $db_pass;
  }

  public function query($statement)
  {
     $req = $this->getPDO()->query($statement);
     $datas = $req->fetchAll(PDO::FETCH_OBJ);
     return $datas; 
  }

  private function getPDO ()
  {
    if (!$this->pdo) {
      // try {
        
      // } catch (Exception $e){
        
      //   echo 'Erreur : '.$e->getMessage().'<br />';
      //   echo 'N° : '.$e->getCode();
      //   die();
        
      // }
      $pdo = new PDO('mysql:dbname='.$this->db_name.';port='.$this->db_port.';host='.$this->db_host.'',$this->db_user,$this->db_pass); 
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $this->pdo = $pdo;
      var_dump('PDO initialized');
    }
    var_dump('PDO called');
    return $this->pdo;
  }


}
