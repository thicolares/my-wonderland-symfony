<?php
namespace MyWonderland\Controller;
use MyWonderland\Domain\Manager\StorageManager;
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
     * SpotifyAuthController constructor.
     * @param StorageManager $storageManager
     * @param \Twig_Environment $twig
     * @param SpotifyService $spotifyService
     */
    public function __construct(StorageManager $storageManager, \Twig_Environment $twig, SpotifyService $spotifyService)
    {
        parent::__construct($storageManager, $twig);
        $this->spotifyService = $spotifyService;
    }


    public function auth()
    {
        header('Location: ' . $this->spotifyService->getAuthUri());
    }


    public function callback($state, $code = null, $error = null)
    {
        // @todo check state against SPOTIFY_CALLBACK_STATE

        if($error !== null) {
            header('Location: /');
        }

        $this->storeManager->set('token', $this->spotifyService->requestToken($code));
        header('Location: /');
    }


    public function logout() {
        $this->storeManager->unset('token');
        header('Location: /');
    }
}