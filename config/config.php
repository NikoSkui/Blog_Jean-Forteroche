<?php

return [
  'database.host' => 'localhost',
  'database.username' => 'root',
  'database.password' => 'root',
  'database.name' => 'Blog_Jean-Forteroche',
  System\Renderer\RendererInterface::class => function() {
    return new System\Renderer\PHPRenderer(dirname(__DIR__) . '/src/Templates');
  },
  \PDO::class => function(System\Container\DIContainer $c) {
    return new \PDO(
      'mysql:host='.$c->get('database.host').';dbname='.$c->get('database.name'),
      $c->get('database.username'),
      $c->get('database.password'),
      [
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
      ]
    );
  }
];