<?php
/**
 * Created by PhpStorm.
 * User: thiago
 * Date: 01/04/18
 * Time: 11:04
 */

namespace MyWonderland\Domain\Manager;

interface StorageManager
{
    public function set($key, $value);

    public function get($key);

    public function has($key);

    public function unset($key);
}