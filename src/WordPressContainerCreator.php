<?php

namespace CMSDeploy\Creator;

include_once 'ContainerCreator.php';

class WordPressContainerCreator extends ContainerCreator
{
    private $dbUser;
    private $dbName;
    private $dbPassword;
    private $port;
    private $serviceName;
    private $containerDbName;

    public function __construct(string $pathBase)
    {
        parent::__construct($pathBase);
    }

    public function setDbInfo(string $dbName, string $dbUser, string $dbPassword, string $serviceName, int $port)
    {
        $this->dbName = $dbName;
        $this->dbUser = $dbUser;
        $this->dbPassword = $dbPassword;
        $this->serviceName = $serviceName;
        $this->port = $port;
    }

    public function setContainerName(string $containerDbName)
    {
        $this->containerDbName = $containerDbName;
    }

    public function fillContentFile()
    {
        $this->fileContent = str_replace('%%CONTAINER_DB_NAME%%', $this->containerDbName, $this->fileContent);
        $this->fileContent = str_replace('%%CMS_PORT%%', $this->port, $this->fileContent);
        $this->fileContent = str_replace('%%DB_NAME%%', $this->dbName, $this->fileContent);
        $this->fileContent = str_replace('%%DB_USER%%', $this->dbUser, $this->fileContent);
        $this->fileContent = str_replace('%%DB_PASSWORD%%', $this->dbPassword, $this->fileContent);
        $this->fileContent = str_replace('%%PROJECT_NAME%%', $this->serviceName, $this->fileContent);
    }
}
