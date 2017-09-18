<?php

use System\Renderer\RendererInterface;

return [

  // VIEWS BASE FOR DEFAULT TEMPLATE
  'views.path' => dirname(__DIR__) . '/src/Application/Templates',
  
  // DATABASE
  'database.host' => 'localhost',
  'database.username' => 'root',
  'database.password' => 'root',
  'database.name' => 'Blog_Jean-Forteroche',

  // OBJECT WHITH params
  RendererInterface::class => function() {
    return call_user_func_array($this->get('System\Renderer\PHPRendererFactory'),[$this]);
  },
  \PDO::class => function() {
    return call_user_func_array($this->get('System\Database\DatabaseFactory'),[$this]);
  }
];