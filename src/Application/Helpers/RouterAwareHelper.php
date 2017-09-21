<?php

namespace App\Helpers;

use System\Http\Response;

/**
 * Adds methods related to the use of the router
 * RouterAwareController
 */
trait RouterAwareHelper
{

  /**
   * Returns a redirect response
   */
  public function redirect(string $path, array $params = [])
  {
    $redirectUri = $this->router->generateUri($path,$params);
    return (new Response())
      ->withStatus(301)
      ->withHeader('Location', $redirectUri);
  }
  
}
