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
    $builder = new DIContainer(); 
    $builder->addDefinition(dirname(dirname(__DIR__)) . '/config/config.php');
    foreach ($modules as $module) {
        if ($module::DEFINITIONS) {
            $builder->addDefinition($module::DEFINITIONS);
        }
    }
    $this->container = $builder->build();
    foreach ($modules as $module) {
      $this->modules[] = $this->container->get($module);
    }
  }

  public function run($request)
  {

    /**
    * Step 1: Check if end of url is a slash "/"
    *         If yes redirect without slash "/", with status 301 
    *         If not continue
    */
    $baseUri = $request->getServerParam('REQUEST_URI');
    $uri = $request->getUri()->getPath();
    if(!empty($uri) && strlen($uri) > 1 && $uri[-1] === '/') {
        return (new Response())
            ->withStatus(301)
            ->withHeader('location', substr($baseUri, 0, -1));
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

    // Case result is null, redirect Erreur with status 301 
    if (is_null($route)) {
        return new Response(404, [], '<h1>Erreur 404<h1>');
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

}
