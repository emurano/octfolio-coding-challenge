<?php
namespace EricMurano\Core\Configuration;

/**
 * The application's configuration from the JSON configuration
 */
class AppConfiguration
{
    private array $configuration;

    public function __construct(string $filename)
    {
        $this->configuration = parse_ini_file($filename, false, INI_SCANNER_TYPED);
    }

    /**
     * Retrieves the setting with the given name
     *
     * e.g.
     *
     * @param string $settingName the flattened name of th setting
     * @param $defaultValue mixed The value to use if there is no such setting in the configuration
     */
    public function getSetting(string $settingName, $defaultValue = null)
    {
        if (array_key_exists($settingName, $this->configuration)) {
            return $this->configuration[$settingName];
        }
        return $defaultValue;
    }
}