<?php

namespace App\Libraries;

use System\Http\Response;

/**
 * Adds methods related to the use of the router
 * RouterAwareController
 */
trait RouterAware
{

  /**
   * Returns a redirect response
   */
  public function redirect($path, array $params = [])
  {
    $redirectUri = $this->router->generateUri($path,$params);
    return (new Response())
      ->withStatus(301)
      ->withHeader('Location', $redirectUri);
  }
  
  
}
