<?php
namespace MyWonderland;

require_once  __DIR__ . '/../vendor/autoload.php';

/**
 * DOTENV
 */
$dotenv = new \Dotenv\Dotenv(__DIR__ . '/../');
$dotenv->load();

/**
 * TWIG
 */
$loader = new \Twig_Loader_Filesystem(__DIR__ . '/templates');
$twig = new \Twig_Environment($loader);