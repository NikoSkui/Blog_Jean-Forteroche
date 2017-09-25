<?php

namespace System\Renderer;

interface RendererInterface
{

  /**
   * Permet de rajouter un chemin pour charger les vues
   *
   * @param string $path
   * @param null|string $namespace
   */
  public function addPath ($path, $namespace = null);

  /**
   * Permet de rendre une vue
   * le chemin peut être précisé avec des namespaces rajouté via le addPath()
   * $this->renderer->render ('@blog/view');
   * $this->renderer->render ('view');
   *
   * @param string $view
   * @param array $params
   * @return string
   */
  public function render ($view, $params = []);

  /**
   * Permet de rajouter des variables globales à toute les vue
   *
   * @param string $key
   * @param mixed $value
   */
  public function addGlobal($key, $value);

}
