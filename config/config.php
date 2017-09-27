<?php

use System\Renderer\RendererInterface;

return [

  // VARIABLE ENVIRONNEMENT => prod or dev
  'env' => 'prod',

  // BASE URL
  'config.baseUrl' => 'http://localhost:8888',
  // BASE PATH
  'config.basePath' => dirname(__DIR__),

  // VIEWS BASE FOR DEFAULT TEMPLATE
  'views.path' => dirname(__DIR__) . '/src/Application/Template',
  
  // DATABASE
  'database.host' => 'localhost',
  'database.username' => 'root',
  'database.password' => 'root',
  'database.name' => '',

  // OBJECT WHITH params
  RendererInterface::class => function() {
    return call_user_func_array($this->get('System\Renderer\PHPRendererFactory'),[$this]);
  },
  \PDO::class => function() {
    return call_user_func_array($this->get('System\Database\DatabaseFactory'),[$this]);
  }
];