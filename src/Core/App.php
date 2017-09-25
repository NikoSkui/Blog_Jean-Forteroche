<?php

namespace System;

use System\Http\Response;
use System\Renderer\PHPRenderer;
use System\Container\DIContainer;

class App
{
  /**
  * List of modules.
  * @var array
  */
  private $modules = [];

  /**
  * List of modules.
  * @var array
  */
  private $middlewares = [];

  /**
  * Container.
  * @var DIContainer
  */
  private $container;

  /**
  * Config by default.
  * @var Container
  */
  private $defaultConfig;

  /**
  * Index for middlewares.
  * @var int
  */
  private $index = 0;



  /**
  * App constructor.
  * @param array $modules List of modules charged
  */
  public function __construct($config)
  {
    $this->defaultConfig = $config;
  }

  public function addModule($module)
  {
    $this->modules[] = $module;
    return $this;
  }

  public function pipe($middleware)
  {
    $this->middlewares[] = $middleware;
    return $this;
  }

  public function process(\System\Http\ServerRequest $request)
  {
    $middleware = $this->getMiddleware();
    if (is_null($middleware)){
      return $request;
    }
    return call_user_func_array($middleware,[$request,[$this,'process']]);

  }

  public function run($request)
  { 
    foreach ($this->modules as $module) {
      $this->getContainer()->get($module);
    }
    
    $process = $this->process($request);
    if($process instanceof Response) {
      return $process;
    } else {
      $request = $process;
    }



    /**
    * Step 2: Checks with router if the request path is the same as one of stored routes.
    *         If match, result is a new object "RouteMached"
    *         If not, result is null
    */
    $router = $this->container->get('System\Router');
    $route = $router->match($request);

    /**
    * Step 3: Processes the result of step 2.
    */

    // Case result is null, redirect Erreur with status 404 
    if (is_null($route)) {
        return new Response(404, [], '<h1>Erreur 404 : Route not Found<h1>');
    }

    // Adding routeMatched object parameters to the request
    $params = $route->getParams();
    $request = array_reduce(array_keys($params), function($request, $key) use ($params) {
        return $request->withAttribute($key,$params[$key]);
    }, $request);

    // Call the callable function of the routeMatched object and save it in a variable
    $callback = $route->getCallBack();
    if (is_string($callback)) {
        $callback = $this->container->get($callback);
    }
    $response = call_user_func_array($callback, [$request]);

    // According to the response, return a result
    switch ($response) {
        case is_string($response):
            return new Response(200, [], $response);
            break;   
        case $response instanceof Response:
            return $response;
            break;
        default:
            throw new \Exception("The response is not a string or an instance of Response");
            break;
    }
  }

  public function send(Response $response)
  {
      $http_line = sprintf('HTTP/%s %s %s',
          $response->getProtocolVersion(),
          $response->getStatusCode(),
          $response->getReasonPhrase()
      );
      
      header($http_line, true, $response->getStatusCode());

      foreach ($response->getHeaders() as $name => $values) {
          foreach ($values as $value) {
              header("$name: $value", false);
          }
      }

      $stream = $response->getBody();

      if ($stream->isSeekable()) {
          $stream->rewind();
      }

      while (!$stream->eof()) {
          echo $stream->read(1024 * 8);
      }
  }

  // initialised the container with singleton pattern
  private function getContainer ()
  {
    if ($this->container === null) {
      $builder = new DIContainer(); 
      $builder->addDefinition($this->defaultConfig);
      foreach ($this->modules as $module) {
          if ($module::DEFINITIONS) {
              $builder->addDefinition($module::DEFINITIONS);
          }
      }
      $this->container = $builder->build();
    }
    return $this->container;
  }

  private function getMiddleware ()
  {
    if(array_key_exists($this->index,$this->middlewares)) {
      $middleware = $this->container->get($this->middlewares[$this->index]);
      $this->index ++;
    } else {
      $middleware = null;
    }
    return $middleware;
  }

}
