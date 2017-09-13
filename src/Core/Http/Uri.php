<?php
namespace System\Http;

class Uri
{

  private $scheme = '';
  private $host = '';
  private $port;
  private $path = '';
  private $query = '';

    /**
     * @return string The URI scheme.
     */
    public function getScheme() 
    {
      return $this->scheme;
    }

    /**
     * @return string The URI host.
     */
    public function getHost()
    {
      return $this->host;
    }

    /**
     * @return null|int The URI port.
     */
    public function getPort()
    {
      return $this->port;      
    }

    /**
     * @return string The URI path.
     */
    public function getPath()
    {
      return $this->path;  
    }

    /**
     * @return string The URI query string.
     */
    public function getQuery()
    {
      return $this->query;
    }

    /**
     * @param string $scheme The scheme to use with the new instance.
     * @return static A new instance with the specified scheme.
     * @throws \InvalidArgumentException for invalid or unsupported schemes. TODO with filterScheme
     */
    public function withScheme($scheme)
    {
      $new = clone $this;
      $new->scheme =  $scheme;

      return $new;
    }

    /**
     * @param string $host The hostname to use with the new instance.
     * @return static A new instance with the specified host.
     * @throws \InvalidArgumentException for invalid hostnames. TODO with filterHost
     */
    public function withHost($host)
    {
      $new = clone $this;
      $new->host =  $host;

      return $new;
    }

    /**
     * @param null|int $port The port to use with the new instance; a null value
     *     removes the port information.
     * @return static A new instance with the specified port.
     * @throws \InvalidArgumentException for invalid ports. TODO with filterPort
     */
    public function withPort($port)
    {
      $new = clone $this;
      $new->port =  $port;

      return $new; 
    }

    /**
     * @param string $path The path to use with the new instance.
     * @return static A new instance with the specified path.
     * @throws \InvalidArgumentException for invalid paths. TODO with filterPath
     */
    public function withPath($path)
    {
        $new = clone $this;
        $new->path = $path;

        return $new;
    }

    /**
     * @param string $query The query string to use with the new instance.
     * @return static A new instance with the specified query string.
     * @throws \InvalidArgumentException for invalid query strings. TODO with filterQuery
     */
    public function withQuery($query)
    {
        $new = clone $this;
        $new->query = $query;

        return $new;
    }

}
