<?php

namespace CMSDeploy\Creator;

include_once 'ContainerCreator.php';

class PHPMyAdminContainerCreator extends ContainerCreator
{
    private $port;
    private $serviceName;
    private $containerDbName;

    public function __construct(string $pathBase)
    {
        parent::__construct($pathBase);
    }

    public function setDbInfo(string $serviceName, int $port)
    {
        $this->port = $port;
        $this->serviceName = $serviceName;
    }

    public function setContainerName(string $containerDbName)
    {
        $this->containerDbName = $containerDbName;
    }

    public function fillContentFile()
    {
        $this->fileContent = str_replace('%%CONTAINER_DB_NAME%%', $this->containerDbName, $this->fileContent);
        $this->fileContent = str_replace('%%PMA_PORT%%', $this->port, $this->fileContent);
        $this->fileContent = str_replace('%%PROJECT_NAME%%', $this->serviceName, $this->fileContent);
    }
}
