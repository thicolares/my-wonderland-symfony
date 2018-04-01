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
    function set($key, $value);

    function get($key);

    function has($key);

    function unset($key);
}