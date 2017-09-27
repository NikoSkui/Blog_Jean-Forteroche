<?php

namespace System\Middlewares;

use System\Http\ServerRequest;
use System\Http\Response;

class WhoopsMiddleware
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
      if ($this->container->get('env') === 'dev') {

        // Disable cache
        header("Cache-Control: max-age=0");
        
        // Dispaly all errors
        error_reporting(E_ALL);
        ini_set("display_errors", 1);

        // For showing properties even private
        \ref::config('showPrivateMembers', true);
        \ref::config('showMethods', true);
        \ref::config('validHtml', true);

        // Active whoops
        // $whoops = $this->container->get(\Whoops\Run::class);
        // $handler = $this->container->get(\Whoops\Handler\PrettyPageHandler::class);
        // $whoops->pushHandler($handler);
        // $whoops->register();
      }
      
      return $next($request);


  }
  
}
