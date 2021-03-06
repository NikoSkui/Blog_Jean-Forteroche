<?php

namespace System;

use System\Http\Response;
use System\Renderer\PHPRenderer;
use System\Container\DIContainer;

use \Psr\Http\Message\ServerRequestInterface;

class App
{
  
  /**
  * List of modules.
  * @var array
  */
  private $modules = [];

  /**
  * List of middlewares.
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
  * @param string $config Path to default config
  */
  public function __construct($config)
  {
    $this->defaultConfig = $config;
  }

  /**
  * Adding a module to load
  * @param instance $module Name of instance to load
  */
  public function addModule($module)
  {
    $this->modules[] = $module;
    return $this;
  }

  /**
  * Adding a middleware to load
  * @param instance $middleware Name of instance to load
  */
  public function pipe($middleware)
  {
    $this->middlewares[] = $middleware;
    return $this;
  }

  public function handle(ServerRequestInterface $request)
  {
    $middleware = $this->getMiddleware();
  
    if (is_null($middleware)){
      throw new \Exception("no midlleware intercepted in the request", 1);
    } elseif (is_callable($middleware)) {
      return call_user_func_array($middleware,[$request,[$this,'handle']]);
    } elseif ($middleware instanceof \Interop\Http\Server\MiddlewareInterface) {
      return $middleware->process($request, $this);
    }

  }

  /**
  * Instantiates all modules and processes middleware
  * @param object $request 
  */
  public function run($request)
  { 
    foreach ($this->modules as $module) {
      $this->getContainer()->get($module);
    }
    return $this->handle($request);
  }

  /**
  * Return the response to the brower with good header
  * @param object $response 
  */
  public function send($response)
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

    echo $response->getBody();

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
      $builder->addDefinition(dirname(dirname(__DIR__)) . '/config.php');
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
