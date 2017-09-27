<?php

namespace System\Middlewares;

use System\Http\ServerRequest;
use System\Http\Response;

class RouterMiddleware
{

  private $router;

  public function __construct(\System\Router $router)
  {
    $this->router = $router;
  }
  /**
  * Middleware : Return null if no return before
  */
  public function __invoke(ServerRequest $request, $next)
  {
    /**
    * Step 2: Checks with router if the request path is the same as one of stored routes.
    *         If match, result is a new object "RouteMached"
    *         If not, result is null
    */
    $route = $this->router->match($request);

    /**
    * Step 3: Processes the result of step 2.
    */

    // Case result is null, redirect next
    if (is_null($route)) {
      return $next($request);
    }

    // Adding routeMatched object parameters to the request
    $params = $route->getParams();
    $request = array_reduce(array_keys($params), function($request, $key) use ($params) {
        return $request->withAttribute($key,$params[$key]);
    }, $request);

    $request = $request->withAttribute(get_class($route), $route);
    return $next($request);
  }
  
}
