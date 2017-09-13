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
  * Container.
  * @var Container
  */
  private $container;


  /**
  * App constructor.
  * @param array $modules List of modules charged
  */
  public function __construct(array $modules = [])
  {
    $this->container = new DIContainer(); 
    $this->container->addDefinition(dirname(dirname(__DIR__)) . '/config/config.php');
    $this->container->build();

    foreach ($modules as $module) {
      $this->modules[] = $this->container->get($module);
    }
  }

  public function run($request)
  {
      $baseUri = $request->getServerParam('REQUEST_URI');
      $uri = $request->getUri()->getPath();
      if(!empty($uri) && strlen($uri) > 1 && $uri[-1] === '/') {
          return (new Response())
              ->withStatus(301)
              ->withHeader('location', substr($baseUri, 0, -1));
      }
      $router = $this->container->get('System\Router');
      $route = $router->match($request);
      if (is_null($route)) {
          return new Response(404, [], '<h1>Erreur 404<h1>');
      } 
      $params = $route->getParams();
      $request = array_reduce(array_keys($params), function($request, $key) use ($params) {
          return $request->withAttribute($key,$params[$key]);
      }, $request);
      $callback = $route->getCallBack();
      if (is_string($callback)) {
        $callback = $this->container->get($callback);
      }
      $response = call_user_func_array($callback, [$request]);

      if (is_string($response)) {
          return new Response(200, [], $response);
      } elseif ($response instanceof Response) {
          return response;
      } else {
          throw new \Exception("The response is not a string or an instance of Response");
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

}
