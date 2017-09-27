<?php

namespace System\Middlewares;

use System\Http\ServerRequest;
use System\Http\Response;

class NotFoundMiddleware
{
  /**
  * Middleware : Return null if no return before
  */
  public function __invoke(ServerRequest $request, $next)
  {
    return new Response(404, [], 'Erreur 404');
  }
  
}
