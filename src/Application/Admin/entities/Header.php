<?php

namespace App\Admin\entities;

use  System\Renderer\RendererInterface;

class Header
{
  private $renderer;

  public $typePage = 'dashboard';
  public $title = 'Administration';
  public $subtitle = 'Gestion du site';
  public $callToAction;
  public $navbar;

  public function __construct (RendererInterface $renderer) {

    $this->renderer = $renderer;
    
    $this->navbar = [
      'Book' => [
        'name' => 'Livres',
        'prefixName' => 'Admin#Books'
      ],
      'Chapters' => [
        'name' => 'Chapitres',
        'prefixName' => 'Admin#Chapters'
      ]
    ];

    if ($this->renderer->hasView('@comment/')) {
      $this->navbar['Comments'] = [
        'name' => 'Commentaires',
        'prefixName' => 'Admin#Comments'
      ];
    }
  }

}
