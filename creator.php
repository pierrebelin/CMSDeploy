<?php

include_once './src/CreatorTools.php';
include_once './src/MySQLContainerCreator.php';
include_once './src/PHPMyAdminContainerCreator.php';
include_once './src/WordPressContainerCreator.php';

use CMSDeploy\Creator;

const PATH_TEMPLATES = __DIR__ . '/templates/';
const PATH_STACKS = __DIR__ . '/stacks/';

$projectName = 'jose';
$baseFile = 'dc-wordpress-sql-base.yml';
$projectName = Creator\CreatorTools::cleanString($projectName);

if (is_dir(PATH_STACKS . $projectName)) {
    echo 'Le projet existe déjà !';
    die;
}

$pathProject = PATH_STACKS . $projectName;
mkdir($pathProject);

$dbName = $projectName;
$dbUser = $projectName;

$containerDbName = 'mysql';
$portCMS = 8000;
$portPHPMyAdmin = 7777;
$volumeDBName = 'db';
$volumeCMSName = 'content';

$fileContent = file_get_contents($baseFile);

// MySQL
$creatorDB = new Creator\MySQLContainerCreator(PATH_TEMPLATES . 'mysql.yml');

$dbPassword = Creator\CreatorTools::generatePassword(16);
$dbRootPassword = Creator\CreatorTools::generatePassword(16);

$creatorDB->setDbInfo($dbName, $dbUser, $dbPassword, $dbRootPassword);
$creatorDB->setContainerName($containerDbName);
$creatorDB->fillContentFile();

$fileContent = str_replace('%%SQL%%', $creatorDB->getContent(), $fileContent);

$pathFolderDB = $pathProject . '/' . $volumeDBName;
if (!is_dir($pathFolderDB)) {
    mkdir($pathFolderDB);
}
$fileContent = str_replace('%%PATH_VOLUME_DB%%', $pathFolderDB, $fileContent);

// PHPMyAdmin
$creatorPMA = new Creator\PHPMyAdminContainerCreator(PATH_TEMPLATES . 'phpmyadmin.yml');
$creatorPMA->setDbInfo($projectName, $portPHPMyAdmin);
$creatorPMA->setContainerName($containerDbName);
$creatorPMA->fillContentFile();

$fileContent = str_replace('%%PHPMYADMIN%%', $creatorPMA->getContent(), $fileContent);

// WordPress
$creatorWP = new Creator\WordPressContainerCreator(PATH_TEMPLATES . 'wordpress.yml');
$creatorWP->setDbInfo($dbName, $dbUser, $dbPassword, $projectName, $portCMS);
$creatorWP->setContainerName($containerDbName);
$creatorWP->fillContentFile();

$fileContent = str_replace('%%WORDPRESS%%', $creatorWP->getContent(), $fileContent);

$pathFolderCMS = $pathProject . '/' . $volumeCMSName;
if (!is_dir($pathFolderCMS)) {
    mkdir($pathFolderCMS);
}
$fileContent = str_replace('%%PATH_VOLUME_CMS%%', $pathFolderCMS, $fileContent);

file_put_contents('end.yml', $fileContent);
