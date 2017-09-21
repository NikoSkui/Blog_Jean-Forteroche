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
  private $attributesPassed = [];

  /**
  * @var array
  */
  private $queryParams = [];
  
  /**
  * @var array
  */
  private $parsedBody;

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
  public function __construct($method = 'GET', Uri $uri, string $version = null, array $serverParams = [])
  {
    $this->serverParams = $serverParams;
    parent::__construct($method, $uri, $version);
  }
  
  public static function fromGlobals()
  {
    $method = isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : 'GET';
    $uri = self::getUriFromGlobals();
    $protocol = isset($_SERVER['SERVER_PROTOCOL']) ? str_replace('HTTP/','',$_SERVER['SERVER_PROTOCOL']) : '1.1';

    $serverRequest = new ServerRequest($method, $uri, $protocol, $_SERVER);

    return $serverRequest
      ->withQueryParams($_GET)
      ->withParsedBody($_POST);
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



  // public function withGetParams(array $query)
  // {
  //     $new = clone $this;
  //     $new->queryParams = $query;
  //     return $new;
  // }


  // public function withCookieParams(array $cookies)
  // {
  //     $new = clone $this;
  //     $new->cookieParams = $cookies;
  //     return $new;
  // }



  /**
   * Retrieve server parameters.
   *
   * Retrieves data related to the incoming request environment,
   * typically derived from PHP's $_SERVER superglobal. The data IS NOT
   * REQUIRED to originate from $_SERVER.
   *
   * @return array
   */
  public function getServerParams()
  {
    return $this->serverParams;
  }

  /**
   * Retrieve a single server parameters.
   *
   * @param string $name The server parameters name.
   * @param mixed $default Default value to return if the server parameters does not exist.
   * @return mixed
   */
  public function getServerParam($name, $default = null)
  {
    if (false === array_key_exists($name, $this->serverParams)) {
      return $default;
    }
    return $this->serverParams[$name];
  }

  /**
    * Retrieve cookies.
    *
    * Retrieves cookies sent by the client to the server.
    *
    * The data MUST be compatible with the structure of the $_COOKIE
    * superglobal.
    *
    * @return array
    */
  public function getCookieParams()
  {
    //TODO Implement method() from interface PSR-7
  }
  /**
    * Return an instance with the specified cookies.
    *
    * The data IS NOT REQUIRED to come from the $_COOKIE superglobal, but MUST
    * be compatible with the structure of $_COOKIE. Typically, this data will
    * be injected at instantiation.
    *
    * This method MUST NOT update the related Cookie header of the request
    * instance, nor related values in the server params.
    *
    * This method MUST be implemented in such a way as to retain the
    * immutability of the message, and MUST return an instance that has the
    * updated cookie values.
    *
    * @param array $cookies Array of key/value pairs representing cookies.
    * @return static
    */
  public function withCookieParams(array $cookies)
  {
    //TODO Implement method() from interface PSR-7
  }
  /**
    * Retrieve query string arguments.
    *
    * Retrieves the deserialized query string arguments, if any.
    *
    * Note: the query params might not be in sync with the URI or server
    * params. If you need to ensure you are only getting the original
    * values, you may need to parse the query string from `getUri()->getQuery()`
    * or from the `QUERY_STRING` server param.
    *
    * @return array
    */
  public function getQueryParams()
  {
    //TODO Implement method() from interface PSR-7
  }
  /**
    * Return an instance with the specified query string arguments.
    *
    * @param array $query Array of query string arguments, typically from
    *     $_GET.
    * @return static
    */
  public function withQueryParams(array $query)
  {
        $new = clone $this;
        $new->queryParams = $query;

        return $new;
  }
  /**
    * Retrieve normalized file upload data.
    *
    * This method returns upload metadata in a normalized tree, with each leaf
    * an instance of Psr\Http\Message\UploadedFileInterface.
    *
    * These values MAY be prepared from $_FILES or the message body during
    * instantiation, or MAY be injected via withUploadedFiles().
    *
    * @return array An array tree of UploadedFileInterface instances; an empty
    *     array MUST be returned if no data is present.
    */
  public function getUploadedFiles()
  {
    //TODO Implement method() from interface PSR-7
  }
  /**
    * Create a new instance with the specified uploaded files.
    *
    * This method MUST be implemented in such a way as to retain the
    * immutability of the message, and MUST return an instance that has the
    * updated body parameters.
    *
    * @param array $uploadedFiles An array tree of UploadedFileInterface instances.
    * @return static
    * @throws \InvalidArgumentException if an invalid structure is provided.
    */
  public function withUploadedFiles(array $uploadedFiles)
  {
    //TODO Implement method() from interface PSR-7
  }
  /**
    * Retrieve any parameters provided in the request body.
    *
    * If the request Content-Type is either application/x-www-form-urlencoded
    * or multipart/form-data, and the request method is POST, this method MUST
    * return the contents of $_POST.
    *
    * Otherwise, this method may return any results of deserializing
    * the request body content; as parsing returns structured content, the
    * potential types MUST be arrays or objects only. A null value indicates
    * the absence of body content.
    *
    * @return null|array|object The deserialized body parameters, if any.
    *     These will typically be an array or object.
    */
  public function getParsedBody()
  {
    return $this->parsedBody;
  }
  /**
    * Return an instance with the specified body parameters.
    *
    *
    * @param null|array|object $data The deserialized body data. This will
    *     typically be in an array or object.
    * @return static
    * @throws \InvalidArgumentException if an unsupported argument type is
    *     provided.
    */
  public function withParsedBody($data)
  {
        $new = clone $this;
        $new->parsedBody = $data;
        
        return $new;
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
   * @param string $name The attribute name.
   * @param mixed $default Default value to return if the attribute does not exist.
   * @return mixed
   */
  public function getAttribute($name, $default = null)
  {
    if (false === array_key_exists($name, $this->attributes)) {
      return $default;
    }

    return $this->attributes[$name];
  }
  /**
   * Return an instance with the specified derived request attribute.
   *
   * @param string $name The attribute name.
   * @param mixed $value The value of the attribute.
   * @return static
   */
  public function withAttribute($name, $value)
  {
      $new = clone $this;
      $new->attributes[$name] = $value;
      return $new;
  }
  
  /**
    * Return an instance that removes the specified derived request attribute.
    *
    * This method allows removing a single derived request attribute as
    * described in getAttributes().
    *
    * This method MUST be implemented in such a way as to retain the
    * immutability of the message, and MUST return an instance that removes
    * the attribute.
    *
    * @see getAttributes()
    * @param string $name The attribute name.
    * @return static
    */
  public function withoutAttribute($name)
  {
    //TODO Implement method() from interface PSR-7
  }

  /**
   * Return an instance with the specified derived request attribute.
   *
   * @param string $name The attribute name.
   * @param mixed $value The value of the attribute.
   * @return static
   */
  public function withAttributePassed($name, $value)
  {
      $new = clone $this;
      $new->attributesPassed[$name] = $value;
      return $new;
  }
  
}
