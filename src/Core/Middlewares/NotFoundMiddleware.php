<?php

namespace System\Middlewares;

use System\Http\ServerRequest;
use System\Http\Response;

class NotFoundMiddleware
{
  private $container;

  public function __construct(\System\Container\DIContainer $container)
  {
    $this->container = $container;
  }

  /**
  * Middleware : Return null if no return before
  */
  public function __invoke(ServerRequest $request, $next)
  {
    $router = $this->container->get(\System\Router::class);
    
    if ($this->container->has(\App\Error\ErrorModule::class)) {

      // Call the callable function of the routeMatched object and save it in a variable
      $callback = $this->container->get(\App\Error\controllers\ErrorController::class);

      $response = call_user_func_array($callback, [$request]);


      return new Response(404, [], $response);
    }
    
    return new Response(404, [], 'Erreur 404');
  }
  
}
