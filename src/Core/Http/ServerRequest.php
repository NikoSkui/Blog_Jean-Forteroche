<?php

namespace System\Http;

use \Psr\Http\Message\UriInterface;

class ServerRequest extends Request
{
  /**
  * @var array
  */
  private $attributes = [];

  /**
   * @var array
   */
  private $serverParams;

  /**
   * @param string                               $method       HTTP method
   * @param string|UriInterface                  $uri          URI
   * @param string                               $version      Protocol version
   * @param array                                $serverParams Typically the $_SERVER superglobal
   */
  public function __construct(string $method, Uri $uri, string $version = null, array $serverParams = [])
  {
    $this->serverParams = $serverParams;
    parent::__construct($method, $uri, $version);
  }
  
  public static function fromGlobals()
  {

    $method = isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : 'GET';
    $uri = self::getUriFromGlobals();
    $protocol = isset($_SERVER['SERVER_PROTOCOL']) ? str_replace('HTTP/','',$_SERVER['SERVER_PROTOCOL']) : '1.1';

    $request = new ServerRequest($method, $uri, $protocol, $_SERVER);

    return $request;
  }

  private static function getUriFromGlobals () {
    $uri = new Uri();
    $uri = $uri->withScheme(!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS']!== 'off' ? 'https' : 'http' );
    
    $hasPort = false;
    if (isset($_SERVER['HTTP_HOST'])) {
        $hostHeaderParts = explode(':', $_SERVER['HTTP_HOST']);
        $uri = $uri->withHost($hostHeaderParts[0]);
        if (isset($hostHeaderParts[1])) {
            $hasPort = true;
            $uri = $uri->withPort($hostHeaderParts[1]);
        }
    } elseif (isset($_SERVER['SERVER_NAME'])) {
        $uri = $uri->withHost($_SERVER['SERVER_NAME']);
    } elseif (isset($_SERVER['SERVER_ADDR'])) {
        $uri = $uri->withHost($_SERVER['SERVER_ADDR']);
    }

    if (!$hasPort && isset($_SERVER['SERVER_PORT'])) {
        $uri = $uri->withPort($_SERVER['SERVER_PORT']);
    }

    $hasQuery = false;
    if (isset($_SERVER['REQUEST_URI'])) {
        $requestUriParts = explode('?', $_SERVER['REQUEST_URI']);
        $requestUriPre = str_replace('/index.php','',$_SERVER['SCRIPT_NAME']);

        $requestUriParts[0] = str_replace($requestUriPre,'',$requestUriParts[0]);
        $uri = $uri->withPath($requestUriParts[0]);
        if (isset($requestUriParts[1])) {
            $hasQuery = true;
            $uri = $uri->withQuery($requestUriParts[1]);
        }
    }

    if (!$hasQuery && isset($_SERVER['QUERY_STRING'])) {
        $uri = $uri->withQuery($_SERVER['QUERY_STRING']);
    }

    return $uri;
  }

  /**
   * Retrieve attributes derived from the request.
   *
   * @return array Attributes derived from the request.
   */
  public function getAttributes()
  {
      return $this->attributes;
  }

  /**
   * Retrieve a single derived request attribute.
   *
   * @param string $attribute The attribute name.
   * @param mixed $default Default value to return if the attribute does not exist.
   * @return mixed
   */
  public function getAttribute($attribute, $default = null)
  {
    if (false === array_key_exists($attribute, $this->attributes)) {
      return $default;
    }

    return $this->attributes[$attribute];
  }

  /**
   * Retrieve attributes derived from the request.
   *
   * @return array Attributes derived from the request.
   */
  public function getServerParams()
  {
    return $this->serverParams;
  }

  /**
   * Retrieve a single derived request attribute.
   *
   * @param string $attribute The attribute name.
   * @param mixed $default Default value to return if the attribute does not exist.
   * @return mixed
   */
  public function getServerParam($param, $default = null)
  {
    if (false === array_key_exists($param, $this->serverParams)) {
      return $default;
    }

    return $this->serverParams[$param];
  }

  /**
   * Return an instance with the specified derived request attribute.
   *
   * @param string $attribute The attribute name.
   * @param mixed $value The value of the attribute.
   * @return static
   */
  public function withAttribute($attribute, $value)
  {
      $new = clone $this;
      $new->attributes[$attribute] = $value;

      return $new;
  }
  
}
