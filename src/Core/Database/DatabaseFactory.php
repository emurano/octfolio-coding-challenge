<?php
namespace EricMurano\Core\Database;

use EricMurano\Core\Configuration\AppConfiguration;

/**
 * Responsible for creating new PDO objects for database access
 */
class DatabaseFactory
{
    private AppConfiguration $appConfig;

    /**
     * @param AppConfiguration $appConfig
     */
    public function __construct(AppConfiguration $appConfig)
    {
        $this->appConfig = $appConfig;
    }

    public function connect(): \PDO
    {
        $dsnParts = [];
        $this->addToDsn('database.name', 'dbname', $dsnParts);
        $this->addToDsn('database.host', 'host', $dsnParts);
        $this->addToDsn('database.port', 'port', $dsnParts);
        return new \PDO(
            $this->appConfig->getSetting('database.type', 'mysql') . ':' . implode(';', $dsnParts),
            $this->appConfig->getSetting('database.user'),
            $this->appConfig->getSetting('database.password')
        );
    }

    private function addToDsn(string $configName, string $dsnPartName, array & $dsnParts)
    {
        $value = $this->appConfig->getSetting($configName, null);
        if ($value === null) return;
        $dsnParts[] = $dsnPartName . '=' . $value;
    }
}