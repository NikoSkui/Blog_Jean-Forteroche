<?php

namespace System\Router;

/**
 *
 * Represent a matched route
 *
 */
class RouteMatched
{
  /**
   * Route matched during routing
   *
   * @var Route $route
   */
  private $route;

  /**
   * @var array
   */
  private $params = [];

  /**
   * Create new matched route
   *
   * @param route       $route the route object who matched
   * @param array       $params The route matched params
   */
  public function __construct(route $route, array $params = [])
  {
    $this->route = $route;
    $this->params = $params;

  }

  /**
   * @return string
   */
  public function getName()
  {
    return $this->route->getName();
  }

  /**
   * @return callable|string
   */
  public function getCallback()
  {
    return $this->route->getCallable();
  }

  /**
   * @return array
   */
  public function getParams()
  {
    return $this->params;
  }

}
