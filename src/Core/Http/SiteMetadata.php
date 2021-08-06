<?php
namespace EricMurano\Core\Http;

/**
 * Provides information about the site the code is running on
 *
 * @package EricMurano\Core\Http
 */
class SiteMetadata
{
    private array $serverData;

    /**
     * @param array $serverData The $_SERVER super global array
     */
    public function __construct(array $serverData)
    {
        $this->serverData = $serverData;
    }

    /**
     * Determines the base url of the site, give the current path provided
     *
     * @param string $currentPath The path to remove from the URI to get to the base url
     * @return string|null Returns the base url or null if it couldn't be determined
     */
    public function baseUrl(string $currentPath): ?string
    {
        if (!is_array($this->serverData)) return null;
        return $this->protocol() . "://"
            . $this->serverData['HTTP_HOST']
            . preg_replace(
                "/^".preg_quote($currentPath, "/")."/",
                "",
                $this->serverData['REQUEST_URI'],
                1
            );
    }

    private function protocol(): string
    {
        if (!is_array($this->serverData)) return 'http';
        if (!array_key_exists('HTTPS', $this->serverData)) return 'http';
        if ($this->serverData['HTTPS'] && $this->serverData['HTTPS'] !== "off") return 'https';
        return 'http';
    }

}