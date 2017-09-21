<?php

namespace System\Middlewares;

use System\Http\ServerRequest;
use System\Http\Response;

class MethodMiddleware
{

    /**
    * Middleware : Checks whether the posted form has a _method key and whether the value of this key is DELETE or PUT 
    *              If yes redirect change method request for value 
    *              If not continue
    */
  public function __invoke(ServerRequest $request, callable $next)
  {
    $parsedBody = $request->getParsedBody();
    if(
        array_key_exists('_method',$parsedBody) && 
        in_array($parsedBody['_method'],['DELETE','PUT'])
    ) {
        $request = $request->withMethod($parsedBody['_method']);
    }

    return $next($request);

  }
  
}
