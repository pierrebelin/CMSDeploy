<?php

namespace CMSDeploy\Creator;

include_once 'ContainerCreator.php';

class MySQLContainerCreator extends ContainerCreator
{
    private $dbDatabase;
    private $dbUser;
    private $dbPassword;
    private $dbRootPassword;
    private $containerDbName;

    public function __construct(string $pathBase)
    {
        parent::__construct($pathBase);
    }

    public function fillContentFile()
    {
        $this->fileContent = str_replace('%%CONTAINER_DB_NAME%%', $this->containerDbName, $this->fileContent);
        $this->fileContent = str_replace('%%DB_DATABASE%%', $this->dbDatabase, $this->fileContent);
        $this->fileContent = str_replace('%%DB_USER%%', $this->dbUser, $this->fileContent);
        $this->fileContent = str_replace('%%DB_PASSWORD%%', $this->dbPassword, $this->fileContent);
        $this->fileContent = str_replace('%%DB_ROOT_PASSWORD%%', $this->dbRootPassword, $this->fileContent);
    }

    public function setDbInfo(string $dbDatabase, string $dbUser, string $dbPassword, string $dbRootPassword)
    {
        $this->dbDatabase = $dbDatabase;
        $this->dbUser = $dbUser;
        $this->dbPassword = $dbPassword;
        $this->dbRootPassword = $dbRootPassword;
    }

    public function setContainerName(string $containerDbName)
    {
        $this->containerDbName = $containerDbName;
    }
}
