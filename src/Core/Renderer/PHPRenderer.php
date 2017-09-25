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
   * Layout utilisé pour rendre la vue
   *
   * @var array
   */
  private $layoutNamespace;

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

  public function __construct ($defaultPath = null, $globals = null)
  {
    if (!is_null($defaultPath)) {
      $this->addPath($defaultPath);
    }
    if (!is_null($globals)) {
      foreach ($globals as $k => $v) {
        $this->addGlobal($k, $v);
      }
    }

  }

  /**
   * Permet de rajouter un chemin pour charger les vues
   *
   * @param string $path
   * @param null|string $namespace
   */
  public function addPath ($path, $namespace = null)
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
  public function render ($view, $params = [])
  {
    if ($this->hasNamespace($view)) {
      $path = $this->replaceNamespace($view) . '.php';
      
      if (!$this->templateCharged) {
        $this->templateCharged = true;
        $params['content'] = $this->loadTemplate($path, $params);
        if ($this->getLayoutNamespace() === self::DEFAULT_NAMESPACE) {
          $path = $this->paths[$this->getLayoutNamespace()].'/layout.php';
        } else {
          $path = $this->paths[$this->getLayoutNamespace()].'/template/layout.php';
        }
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
  public function addGlobal($key, $value)
  {
    $this->globals[$key] = $value;
  }

  public function hasView ($view)
  {
    $namespace = $this->getNamespace($view);
    if (isset($this->paths[$namespace])) {
      return true;
    }
  }
  public function getLayoutNamespace ()
  {
    if ($this->layoutNamespace) {
     return $this->layoutNamespace ;
    }
    return self::DEFAULT_NAMESPACE;
  }

  public function setLayoutNamespace($namespace)
  {
    $this->layoutNamespace = $namespace;
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

  private function hasNamespace($view)
  {
    return $view[0] === '@';
  }

  private function getNamespace($view)
  {
     return substr($view, 1, strpos($view, '/') -1);
  }

  private function replaceNamespace ($view)
  {
    $namespace = $this->getNamespace($view);
    return str_replace('@'.$namespace, $this->paths[$namespace], $view);
  }


}
