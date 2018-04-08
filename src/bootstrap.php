<?php
namespace MyWonderland;



require_once  __DIR__ . '/../vendor/autoload.php';

/**
 * DOTENV
 */
$dotenv = new \Dotenv\Dotenv(__DIR__ . '/../');
$dotenv->load();