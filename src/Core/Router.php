<?php

namespace System;

use System\Router\Route;
use System\Router\RouteMatched;
use System\Http\Request;

class Router
{
  
  /**
   * Routes injected with Modules.
   * @var Route[]
   */
  private $routes = [];

  public function __construct()
  {

  }

  /**
   * create new route with method GET.
   *
   * @param string $path
   * @param callable|string $callable
   * @param null|string $name
   */
  public function get(string $path, $callable, string $name = null)
  {
    $route = new Route(['GET'], $path, $callable, $name);
    $this->addRoute($route);
    return $route;
  }

  /**
   * create new route with method POST.
   *
   * @param string $path
   * @param callable|string $callable
   * @param null|string $name
   */
  public function post(string $path, $callable, string $name = null)
  {
    $route = new Route(['POST'], $path, $callable, $name);
    $this->addRoute($route);
    return $route;
  }

  /**
   * Checks if the request path is the same as one of stored routes.
   *
   * @param  Request $request
   * @return RouteMatched
   */
  public function match (Request $request)
  {
    // define variable
    $path       = $request->getUri()->getPath();
    $method     = $request->getMethod();

    /**
    * Step 1: Check if stored routes have the same method as the request 
    *         If not return null
    */
    if(!isset($this->routes[$method])){return null;}

    /**
    * Step 2: Loop all stored routes to see if a match
    *         If match, result will be a new object "RouteMached"
    *         If not, result will be null
    */
    foreach ($this->routes[$method] as $route) {
      $pattern = preg_replace_callback('#\{([\w]+)\}#',[$route,'paramMatch'], $route->getPattern());
      $regex = "#^$pattern$#i";
      if(preg_match($regex, $path, $matches)){
        // Recovery and association of params with match values
        $params = [];
        if (count($matches) > 1) {
          preg_match_all('#\{([\w]+)\}#',$route->getPattern(),$paramMatches);
          foreach ($paramMatches[1] as $key => $value) {
            $params[$value] = $matches[$key + 1];
          }
        }
        // Creating the RouteMatched object with $route and $params and retrun object
        return new RouteMatched($route,$params);
      }
      $result = null;
    }
    // Returns the result if no route has matched
    return $result;
  }

  /**
   * @param  string $name
   * @param  array $params 
   * @return string|null
   */
  public function generateUri (string $name, array $params = [])
  {
    foreach ($this->routes as $method => $arrayRoutes) {

      foreach ($arrayRoutes as $nameRoute => $route) {
        $routes[$nameRoute] = $route;
      }
    }

    if (! array_key_exists($name, $routes)) {
      throw new \Exception(sprintf(
          'Cannot generate URI for route "%s"; route not found',
          $name
      ));
    }
    $route = $routes[$name];
    $basePath = $this->getbasePath();

    
    return $basePath.$route->getPath($params);
  }

  public function getbasePath()
  {
    $sheme = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS']!== 'off' ? 'https' : 'http' ;
    $host = $_SERVER['HTTP_HOST'];
    $baseUri = str_replace('/index.php','',$_SERVER['SCRIPT_NAME']);

    return $sheme.'://'.$host.$baseUri;
  }

  /**
   * Add a route to the collection.
   *
   * @param Route $route
    */
  public function addRoute(Route $route)
  {
      $this->routes[$route->getMethod()[0]][$route->getName()] = $route;
  }

  
}
