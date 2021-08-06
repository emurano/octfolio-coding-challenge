<?php

namespace EricMurano\Core\Http;

/**
 * Encapsulates HTTP requests
 *
 * Class HttpRequest
 * @package EricMurano\Core
 */
class HttpRequest
{
    private array $getVariables;
    private array $postVariables;
    private array $serverData;

    /**
     * @param array $getVariables GET variables as an assoc array
     * @param array $serverData The $_SERVER super global
     */
    public function __construct(array $getVariables, array $serverData)
    {
        $this->getVariables = $getVariables;
        $this->serverData = $serverData;
    }

    /**
     * The request method of the request
     *
     * e.g. GET or POST etc
     *
     * @return string|null Returns null if it was not possible to tell what the request method was
     */
    public function requestMethod(): ?string
    {
        print_r($this->serverData);
        if (is_array($this->serverData)
            && array_key_exists('REQUEST_METHOD', $this->serverData)) {
            return $this->serverData['REQUEST_METHOD'];
        }
        return null;
    }

    /**
     * Tells you whether there is a GET variable with the given name
     *
     * @param string $getName The name of the GET variable
     * @return bool true if there is a GET variable with the given name
     */
    public function hasGetVariable(string $getName): bool
    {
        return is_array($this->getVariables) && array_key_exists($getName, $this->getVariables);
    }

    /**
     * Retrieves a GET variable with the given name
     *
     * @param string $getName The name of the GET variable
     * @return string|array|null
     */
    public function getVariable(string $getName)
    {
        if ($this->hasGetVariable($getName)) {
            return $this->getVariables[$getName];
        }
        return null;
    }

    /**
     * Returns the path of the request, which is the URI without the part of the URI that defines the GET variables
     *
     * e.g. The path for http://localhost/hello/world?post=1234 is /hello/world
     * @return string
     */
    public function path(): ?string
    {
        if (!is_array($this->serverData)) return null;
        if (!array_key_exists('REQUEST_URI', $this->serverData)) return null;
        $parts = explode('?', $this->serverData['REQUEST_URI']);
        if (count($parts) <= 0) return null;
        return $parts[0];
    }
}