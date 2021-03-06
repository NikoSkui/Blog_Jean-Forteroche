<?php

namespace System;

use System\Router\Route;
use System\Router\RouteMatched;
use System\Http\Request;
use System\Http\ServerRequest;

class Router
{
  
  /**
   * Routes injected with Modules.
   * @var Route[]
   */
  private $routes = [];

  /**
   * @var DIContainer
   */
  private $container;

  public function __construct(\System\Container\DIContainer $container)
  {
    $this->container = $container;
  }

  /**
   * create new route with method GET.
   *
   * @param string $path
   * @param callable|string $callable
   * @param null|string $name
   */
  public function get($path, $callable, $name = null)
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
  public function post($path, $callable, $name = null)
  {
    $route = new Route(['POST'], $path, $callable, $name);
    $this->addRoute($route);
    return $route;
  }

  /**
   * create new route with method PUT.
   *
   * @param string $path
   * @param callable|string $callable
   * @param null|string $name
   */
  public function put($path, $callable, $name = null)
  {
    $route = new Route(['PUT'], $path, $callable, $name);
    $this->addRoute($route);
    return $route;
  }

  /**
   * create new route with method DELETE.
   *
   * @param string $path
   * @param callable|string $callable
   * @param null|string $name
   */
  public function delete($path, $callable, $name = null)
  {
    $route = new Route(['DELETE'], $path, $callable, $name);
    $this->addRoute($route);
    return $route;
  }

  /**
   * create routes with syteme CRUD REST.
   *
   * @param string $path
   * @param callable|string $callable
   * @param null|string $name
   */
  public function crud($prefixPath, $callable, $prefixName)
  {
      $this->get($prefixPath.'/new',     $callable, "$prefixName#Create");
      $this->post($prefixPath.'/new',    $callable, "$prefixName#Create");
      $this->get($prefixPath,            $callable, "$prefixName#Read");
      $this->get($prefixPath.'/{id}',    $callable, "$prefixName#Update");
      $this->put($prefixPath.'/{id}',    $callable, "$prefixName#Update");
      $this->delete($prefixPath.'/{id}', $callable, "$prefixName#Delete");
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
  public function generateUri ($name, array $params = [])
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
    if(is_null($route->getName())) {
      $this->routes[$route->getMethod()[0]][] = $route;
    } else {
      $this->routes[$route->getMethod()[0]][$route->getName()] = $route;
    }
  }
  
}
