<?php

namespace CMSDeploy\Creator;

abstract class ContainerCreator
{
    protected $fileContent;

    public function __construct($pathBase)
    {
        $this->fileContent = file_get_contents($pathBase);
    }

    public function getContent()
    {
        return $this->fileContent;
    }
}
