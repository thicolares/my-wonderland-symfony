<?php
namespace MyWonderland\Controller;
use MyWonderland\Service\SpotifyService;

/**
 * Created by PhpStorm.
 * User: thiago
 * Date: 31/03/18
 * Time: 12:00
 */

class SpotifyAuthController extends AbstractController
{
    /**
     * @var SpotifyService
     */
    protected $spotifyService;


    /**
     * SpotifyAuth constructor.
     */
    public function __construct(SpotifyService $spotifyService)
    {
        $this->spotifyService = $spotifyService;
    }


    public function auth()
    {
        header('Location: ' . $this->spotifyService->getAuthUri());
    }


    public function callback($code, $state = null)
    {
        // @todo check state against SPOTIFY_CALLBACK_STATE

        // @todo improve the security
        session_start();
        $_SESSION['token'] = $this->spotifyService->requestToken($code);
        header('Location: ' . getenv('BASE_URI'));
    }


    public function logout() {
        session_start();
        unset($_SESSION['token']);
        header('Location: /');
    }
}