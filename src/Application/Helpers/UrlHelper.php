<?php

namespace App\Helpers;

class UrlHelper
{
  private $container;

  public function __construct(\System\Container\DIContainer $container)
  {
    $this->container = $container;
  }

  public function baseUrl()
  {
    return $this->container->get('config.basePath');
  }
}
