<?php

namespace System\Middlewares;

use System\Http\ServerRequest;
use System\Http\Response;

class TrailingSlashMiddleware
{
  /** 
  * Middleware: Check if end of url is a slash "/"
  *             If yes redirect without slash "/", with status 301 
  *             If not continue
  */
  public function __invoke(ServerRequest $request, $next)
  {
    $baseUri = $request->getServerParam('REQUEST_URI');
    $uri = $request->getUri()->getPath();
    if(!empty($uri) && strlen($uri) > 1 && substr($uri,-1) === '/') {
        return (new Response())
            ->withStatus(301)
            ->withHeader('location', substr($baseUri, 0, -1));
    }

    return $next($request);

  }
  
}
