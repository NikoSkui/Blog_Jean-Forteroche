<?php

namespace System\Container;

class DIContainer
{

  /**
  * Definition.
  * @var array
  */
  private $definitions = [];

  /**
  * Registry.
  * @var array
  */
  private $registry = [];

  /**
  * Config.
  * @var array
  */
  private $config = [];

  /**
  * Registry.
  * @var array
  */
  private $factories = [];

  /**
  * Instances.
  * @var array
  */
  private $instances = [];

  public function __construct ()
  {
    $this->instances['System\Container\DIContainer'] = $this;
  }

  /**
   * Add new path for definitions.
   *
   * @param string $definition path to definition.
   */
  public function addDefinition ($definition)
  {
    $this->definitions[] = $definition;
  }

  /**
   * Build registry by default with config add via addDefinition().
   */
  public function build ()
  {
    foreach ($this->definitions as $definition) {
      $config = require($definition);
      foreach ($config as $id => $resolver) {
        if (!is_callable($resolver)) {      
          $this->setConfig($id, $resolver);
        } else {
          $this->set($id, $resolver);
        }
      }
    }

    return $this;
  }

  /**
   * Set new registry of the container with identifier and resolver.
   *
   * @param string $id Identifier of the entry to look for.
   * @param callable $resolver function to return with get.
   */
  public function set($id, callable $resolver)
  {
    $this->registry[$id] = $resolver;
  }

  /**
   * Set new config of the container with identifier and resolver.
   *
   * @param string $id Identifier of the entry to look for.
   * @param callable $resolver function to return with get.
   */
  public function setConfig($id,$resolver)
  {
    $this->config[$id] = $resolver;
  }

  /**
   * Set new factory of the container with identifier and resolver.
   *
   * @param string $id Identifier of the entry to look for.
   * @param callable $resolver function to return with get.
   */
  public function setFactory($id, callable $resolver)
  {
    $this->factories[$id] = $resolver;
  }

  /**
   * Set new instance in container.
   *
   * @param string $instance Identifier of the entry to look for.
   */
  public function setInstance ($instance)
  {
    $reflection = new \ReflectionClass($instance); 
    $this->instances[$reflection->getName()] = $instance;
  }

  /**
   * Finds an entry of the container by its identifier and returns it.
   *
   * @param string $id Identifier of the entry to look for.
   *
   * @throws Exception **this** is not an instanciable class.
   *
   * @return mixed Entry.
   */
  public function get($id)
  {
    
    if ($this->hasConfig($id)) {
      return $this->config[$id]; 
    }
    if ($this->hasFactory($id)) {
      return $this->factories[$id](); 
    }
    if (!$this->has($id)) {
      if ($this->hasRegistry($id)) {
        $this->instances[$id] = $this->registry[$id]($this); 
      } else {
        $reflected_class = new \ReflectionClass($id);
        if ($reflected_class->isInstantiable()) {
          $constructor = $reflected_class->getConstructor();
          if(!$constructor){
            return $reflected_class->newInstanceWithoutConstructor();
          }
          $params = $constructor->getParameters(); 
          $constructor_params = [];
          foreach ($params as $param) {
            if($param->getClass()){
              $constructor_params[] = $this->get($param->getClass()->getName());
            } else {
              $constructor_params[] = $param->getDefaultValue();
            }
          }      
          $this->instances[$id] = $reflected_class->newInstanceArgs($constructor_params);
        } else {
          throw new \Exception(sprintf('"%s" is not an instanciable class.', $id));   
        }
      }
    }
    return $this->instances[$id];
  }

  /**
   * Returns true if the container can return an entry for the given identifier.
   * Returns false otherwise.
   *
   * `has($id)` returning true does not mean that `get($id)` will not throw an exception.
   * It does however mean that `get($id)` will not throw a `NotFoundExceptionInterface`.
   *
   * @param string $id Identifier of the entry to look for.
   *
   * @return bool
   */
  public function has($id)
  {
    return isset($this->instances[$id]);
  }

  /**
   * Returns true if the container can return an entry for the given identifier.
   * Returns false otherwise.
   *
   * @param string $id Identifier of the entry to look for.
   *
   * @return bool
   */
  public function hasConfig($id)
  {
    return isset($this->config[$id]);
  } 

  /**
   * Returns true if the container can return an entry for the given identifier.
   * Returns false otherwise.
   *
   * @param string $id Identifier of the entry to look for.
   *
   * @return bool
   */
  public function hasRegistry($id)
  {
    return isset($this->registry[$id]);
  } 

  /**
   * Returns true if the container can return an entry for the given identifier.
   * Returns false otherwise.
   *
   * @param string $id Identifier of the entry to look for.
   *
   * @return bool
   */
  public function hasFactory($id)
  {
    return isset($this->factories[$id]);
  } 
}
