<?php
/**
 * Created by PhpStorm.
 * User: thiago
 * Date: 01/04/18
 * Time: 10:56
 */
namespace MyWonderland\Domain\Manager;

/**
 * Class SessionManager
 * @package MyWonderland\Domain\Manager
 *
 * (from PHP docs): Caution -- If you turn on session.auto_start then the only way to put objects
 * into your sessions is to load its class definition using auto_prepend_file in which you load
 * the class definition else you will have to serialize() your object and unserialize() it afterwards.
 * http://php.net/manual/en/intro.session.php
 */
class SessionManager implements StorageManager
{
    // @todo improve security
    function __construct()
    {
        session_start();
    }

    function set($key, $value)
    {
        $_SESSION[$key] = serialize($value);
    }

    function get($key)
    {
        return unserialize($_SESSION[$key]);
    }

    function has($key)
    {
        return isset($_SESSION[$key]);
    }

    function unset($key)
    {
        unset($_SESSION[$key]);
    }
}