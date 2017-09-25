<?php

namespace System\Database;

use \PDO;
use System\Container\DIContainer;

class DatabaseFactory
{
  public function __construct() {}
  
  public function __invoke(DIContainer $container)
  {
    return new PDO(
      'mysql:host='.$container->get('database.host').';dbname='.$container->get('database.name'),
      $container->get('database.username'),
      $container->get('database.password'),
      [
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
      ]
    );
  }
}
