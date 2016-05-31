<?php
/**
 * Load composer libraries
 */
require __DIR__ . '/../vendor/autoload.php';

$app = new app\App(new app\config\Config(), new app\component\Request());
$app->processValidation();
$app->processFriendList();
