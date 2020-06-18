<?php

const PATH_STACKS = __DIR__ . '/stacks/';

$cleanFiles = true;
$projectName = 'asalog';

// TODO Remplacer avec rmdir recursif
shell_exec('rm -R ' . PATH_STACKS . $projectName);
shell_exec('rm ' . $projectName . '.yml');
shell_exec('docker stack rm ' . $projectName);
