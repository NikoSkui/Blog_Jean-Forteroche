<?php

namespace System\Router;

class Route
{

  /**
   * HTTP methods supported by this route
   * @var string[]
   */
  private $method = [];

  /**
   * The callable payload
   * @var callable
   */
  private $callable;

  /**
   * Route pattern
   * @var string
   */
  private $pattern;

  /**
   * Route name
   * @var null|string
   */
  private $name;

  /**
   * Restriction for parameters.
   * @var array
   */
  private $paramsRestrictions = [
    'id' =>'[0-9]+',
    'slug'=>'([a-z\-0-9]+)'
  ];

  /**
   * Create new route
   *
   * @param string|string[]   $methods The route HTTP methods
   * @param string            $pattern The route pattern
   * @param callable|string          $callable The route callable
   * @param null|string       $name The route name
   */
  public function __construct(array $method, string $pattern, $callable, string $name=null)
  {
    $this->method  = is_string($method) ? [$method] : $method;
    $this->pattern = $pattern;
    $this->callable = $callable;
    $this->name = $name;
  }

  /**
   * Check if restriction for parameter exist.
   *
   * @param  array $match
   */

  public function paramMatch ($match)
  {
    if(isset($this->paramsRestrictions[$match[1]])){
        return '(' . $this->paramsRestrictions[$match[1]] . ')';
    } else {
        return '([^/]+)';
    }
  }

  /**
   * add new restriction for parameter route.
   *
   * @param  string $param
   * @param  string $regex 
   */
  public function with($param, $regex){
    $this->paramsRestrictions[$param] = str_replace('(','(?:',$regex);
    return $this;
  }

  /**
   * @return string
   */
  public function getMethod()
  {
      return $this->method;
  }

    /**
   * @return string
   */
  public function getPattern()
  {
      return $this->pattern;
  }

  /**
   * @return string
   */
  public function getName()
  {
      return $this->name;
  }

  /**
   * @return callable|string
   */
  public function getCallable()
  {
      return $this->callable;
  }

  /**
   * @return string
   */
  public function getPath(array $params)
  {
    $path = $this->getPattern();
    foreach ($params as $k => $v) {
      $path = str_replace('{'.$k.'}',$v, $path);
    }

    return $path;
  }

}
