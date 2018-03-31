<?php
namespace MyWonderland;

use MyWonderland\Service\SongkickManager;

require_once __DIR__ . '/bootstrap.php';

//SongkickManager::hw();

echo $twig->render('index.twig', ['name' => 'Thiago']);