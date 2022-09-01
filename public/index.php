<?php

require __DIR__ . '/../vendor/autoload.php';

session_start();

$app = require_once __DIR__.'/../bootstrap/app.php';

$app->boot()->run();
