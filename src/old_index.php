<?php
namespace MyWonderland;

use MyWonderland\Service\SongkickService;

require_once __DIR__ . '/bootstrap.php';

//SongkickManager::hw();

echo $twig->render('index.twig', ['name' => 'Thiago']);