<?php

namespace System\Middlewares;

use System\Http\ServerRequest;
use System\Http\Response;

class LoginMiddleware
{
  
  private $container;

  public function __construct(\System\Container\DIContainer $container)
  {
    $this->container = $container;
  }

    /**
    * Middleware : Checks whether the posted form has a _method key and whether the value of this key is DELETE or PUT 
    *              If yes redirect change method request for value 
    *              If not continue
    */
  public function __invoke(ServerRequest $request, $next)
  {
    $router = $this->container->get(\System\Router::class);
    $session = $this->container->get(\System\Session\PHPSession::class); 
    $route = $request->getAttribute(\System\Router\RouteMatched::class);

    // Case result is null, redirect next
    if (is_null($route)) {
      return $next($request);
    }

    $path = $route->getName();
    $params = $route->getParams();
    $prefix = strtolower(strstr($path,'#',true));
    switch ($prefix) {
      case 'admin':
      if (is_null($session->get('user'))){
        $redirectUri = $router->generateUri("User#Control#Login",$params);
        return (new Response())
          ->withStatus(301)
          ->withHeader('Location', $redirectUri);
      }
        return $next($request);
        break;
      
      default:
        return $next($request);
        break;
    }



  }
  
}
