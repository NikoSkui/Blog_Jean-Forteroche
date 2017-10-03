<?php

namespace System\Middlewares;

use System\Http\ServerRequest;
use System\Http\Response;

class DispatcherMiddleware
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
    $route = $request->getAttribute(\System\Router\RouteMatched::class);

    // Case result is null, redirect next
    if (is_null($route)) {
      return $next($request);
    }
    // Call the callable function of the routeMatched object and save it in a variable
    $callback = $route->getCallBack();
    if (is_string($callback)) {
        $callback = $this->container->get($callback);
    }
    $response = call_user_func_array($callback, [$request,$next]);

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
  
}
