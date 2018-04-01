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
     * @param SpotifyService $spotifyService
     */
    public function __construct(StorageManager $storageManager, SpotifyService $spotifyService)
    {
        parent::__construct($storageManager);
        $this->spotifyService = $spotifyService;
    }


    public function auth()
    {
        header('Location: ' . $this->spotifyService->getAuthUri());
    }


    public function callback($code, $state = null)
    {
        // @todo check state against SPOTIFY_CALLBACK_STATE

        $this->storeManager->set('token', $this->spotifyService->requestToken($code));
        header('Location: ' . getenv('BASE_URI'));
    }


    public function logout() {
        $this->storeManager->unset('token');
        header('Location: /');
    }
}