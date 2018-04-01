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
use MyWonderland\Service\RequestService;
use MyWonderland\Service\SpotifyService;

/**
 * A simple handmade Dependency Injection Container
 * @package MyWonderland
 */
class Container
{
    protected $parameters = [];

    /**
     * Containerontainer constructor.
     * @param array $parameters
     */
    public function __construct(array $parameters = [])
    {
        $this->parameters = $parameters;
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
            new SpotifyService(),
            new RequestService()
        );
    }

    public function getSpotifyAuthController() {
        return new SpotifyAuthController(
            new SpotifyService()
        );
    }


}