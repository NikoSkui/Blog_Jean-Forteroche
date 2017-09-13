<?php

namespace System\Renderer;

class PHPRenderer implements RendererInterface
{

  const DEFAULT_NAMESPACE = '__MAIN';

  /**
   * Variable pour savoir si le template à déjà été chargé
   *
   * @var bool
   */
  private $templateCharged = false;

  /**
   * Template utilisé pour rendre la vue
   *
   * @var array
   */
  private $template = 'layout';

  /**
   * Ensemble des chemins ajouté au renderer
   *
   * @var array
   */
  private $paths = [];

  /**
   * Variable globalement accessible pour toute les vues
   *
   * @var array
   */
  private $globals = [];

  public function __construct (string $defaultPath = null)
  {
    if (!is_null($defaultPath)) {
      $this->addPath($defaultPath);
    }
  }

  /**
   * Permet de rajouter un chemin pour charger les vues
   *
   * @param string $path
   * @param null|string $namespace
   */
  public function addPath (string $path, string $namespace = null)
  {
    if (is_null($namespace)) {
      $this->paths[self::DEFAULT_NAMESPACE] = $path;
    } else {
      $this->paths[$namespace] = $path;
    }
  }

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
  public function render (string $view, array $params = [])
  {
    if ($this->hasNamespace($view)) {
      $path = $this->replaceNamespace($view) . '.php';
      if (!$this->templateCharged) {
        $this->templateCharged = true;
        $params['content'] = $this->loadTemplate($path, $params);
        $path = $this->paths[self::DEFAULT_NAMESPACE] . '/' .$this->template .'.php'; 
      }
    } else {
      $path = $this->paths[self::DEFAULT_NAMESPACE] . '/' . $view . '.php'; 
    }

    return $this->loadTemplate($path, $params);
 
  }

  /**
   * Permet de rajouter des variables globales à toute les vue
   *
   * @param string $key
   * @param mixed $value
   */
  public function addGlobal(string $key, $value)
  {
    $this->globals[$key] = $value;
  }

  private function loadTemplate($path, $params)
  {
    ob_start();
    extract($this->globals);
    extract($params);
    $renderer = $this;
    require($path);
    return ob_get_clean();
  }

  private function hasNamespace (string $view)
  {
    return $view[0] === '@';
  }

  private function getNamespace (string $view)
  {
     return substr($view, 1, strpos($view, '/') -1);
  }

  private function replaceNamespace (string $view)
  {
    $namespace = $this->getNamespace($view);
    return str_replace('@'.$namespace, $this->paths[$namespace], $view);
  }

}
