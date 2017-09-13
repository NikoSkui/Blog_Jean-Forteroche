<?php

namespace System\Http;

use \Psr\Http\Message\RequestInterface;
use \Psr\Http\Message\UriInterface;

class Request
{
  use MessageTrait;

  /**
   * @var string
   */
  private $method;

  /**
   * @var Uri
   */
  private $uri;

  public function __construct(string $method, Uri $uri, string $version = null) 
  {
    $this->method = strtoupper($method);
    $this->uri = $uri;
    $this->protocole = $version;
  }

  /**
   * Retrieves the HTTP method of the request.
   *
   * @return string Returns the request method.
   */
  public function getMethod()
  {
    return $this->method;
  }


  /**
   * Retrieves the URI instance.
   *
   * @return UriInterface Returns a UriInterface instance
   *     representing the URI of the request.
   */
  public function getUri()
  {
    return $this->uri;
  }

}
