<?php
session_start();
// comment out the following two lines when deployed to production
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

$ser_root = $_SERVER['DOCUMENT_ROOT'];
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';
require 'function.php';

// ini_set('error_reporting', E_ALL);
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);

$config = require __DIR__ . '/../config/web.php';
(new yii\web\Application($config))->run();
