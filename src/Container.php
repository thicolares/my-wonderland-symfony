<?php
/**
 * Created by PhpStorm.
 * User: thiago
 * Date: 01/04/18
 * Time: 10:07
 */
namespace MyWonderland;

use MyWonderland\Controller\HomeController;
use MyWonderland\Controller\SpotifyAuthController;
use MyWonderland\Domain\Manager\SessionManager;
use MyWonderland\Service\RequestService;
use MyWonderland\Service\SongkickService;
use MyWonderland\Service\SpotifyService;

/**
 * A simple handmade Dependency Injection Container
 * @package MyWonderland
 */
class Container
{
    /**
     * Each time a shared object is called, the object instance created
     * for the first call will be returned
     *
     * Static methods and static variables (aka class methods and class variables)
     * are a way of putting code and data into a kind of namespace.
     *
     * https://stackoverflow.com/questions/11496884/private-static-method-vs-static-method
     */
    static private $shared = [];

    private $parameters = [];

    /**
     * Containerontainer constructor.
     * @param array $parameters
     */
    public function __construct(array $parameters = [])
    {
        $this->parameters = $parameters;
    }


    public function getTwig() {
        if (isset(self::$shared['twig'])) {
            return self::$shared['twig'];
        }

        $loader = new \Twig_Loader_Filesystem(__DIR__ . '/templates');
        self::$shared['twig'] = new \Twig_Environment($loader);
        return self::$shared['twig'];
    }


    public function build($class) {
        switch ($class) {
            case HomeController::class:
                return $this->getHomeController();
                break;
            case SpotifyAuthController::class:
                return $this->getSpotifyAuthController();
                break;
            default:
                return new $class();
                break;
        }
    }


    public function getHomeController() {
        return new HomeController(
            new SessionManager(),
            $this->getTwig(),
            new SpotifyService(new RequestService()),
            new SongkickService(new RequestService())
        );
    }


    public function getSpotifyAuthController() {
        return new SpotifyAuthController(
            new SessionManager(),
            $this->getTwig(),
            new SpotifyService(new RequestService())
        );
    }

}