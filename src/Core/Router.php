<?php

namespace System;

use System\Router\Route;
use System\Router\RouteMatched;
use System\Router\RouterException;
use System\Http\Request;

class Router
{
  
  /**
   * Routes to inject into the underlying RouteCollector.
   * @var Route[]
   */
  private $routesToInject = [];

  private $uniqid;

  public function __construct()
  {
    $this->uniqid = uniqid();
  }

  /**
   * create new route with method GET.
   *
   * @param string $path
   * @param callable|string $callable
   * @param string $name
   */
  public function get(string $path, $callable, string $name)
  {
    $route = new Route(['GET'], $path, $callable, $name);
    $this->addRoute($route);
    return $route;
  }

  public function post(string $path, callable $callable, string $name)
  {
    $route = new Route(['POST'], $path, $callable, $name);
    $this->addRoute($route);
    return $route;
  }

  /**
    * @param  Request $request
    * @return RouteMatched
    */
  public function match (Request $request)
  {
    $path       = $request->getUri()->getPath();
    $method     = $request->getMethod();
    if(!isset($this->routesToInject[$method])){return null;}
    foreach ($this->routesToInject[$method] as $route) {
      $pattern = preg_replace_callback('#\{([\w]+)\}#',[$route,'paramMatch'], $route->getPattern());
      $regex = "#^$pattern$#i";
      if(preg_match($regex, $path, $matches)){
        preg_match_all('#\{([\w]+)\}#',$route->getPattern(),$params);
        array_shift($params);
        if (count($matches)>1) {
          array_shift($matches);
        }
        foreach ($params[0] as $key => $value) {
          $params[$value] = $matches[$key];
        }
        array_shift($params);
        $result = new RouteMatched($route,$params);
        return $result;
      }
      $result = null;
    }
    return $result;
  }

  /**
   * @param  string $name
   * @param  array $params 
   * @return string|null
   */
  public function generateUri (string $name, array $params = [])
  {
    foreach ($this->routesToInject as $method => $routesToInject) {
      foreach ($routesToInject as $namedRoute => $route) {
        $routes[$namedRoute] = $route;
      }
    }
    if (! array_key_exists($name, $routes)) {
      throw new \Exception(sprintf(
          'Cannot generate URI for route "%s"; route not found',
          $name
      ));
    }
    $route = $routes[$name];

    return $route->getPath($params);
  }

  /**
    * Add a route to the collection.
    *
    * @param Route $route
    */
  public function addRoute(Route $route)
  {
      $this->routesToInject[$route->getMethod()[0]][$route->getName()] = $route;
  }

  
}
