<?php
/**
 * Created by PhpStorm.
 * User: thiago
 * Date: 31/03/18
 * Time: 20:50
 */

namespace MyWonderland\Controller;


use MyWonderland\Domain\Manager\StorageManager;
use MyWonderland\Domain\Model\SpotifyToken;
use MyWonderland\Service\RequestService;
use MyWonderland\Service\SpotifyService;

class HomeController extends AbstractController
{
    /**
     * @var SpotifyService
     */
    protected $spotifyService;

    /**
     * @var RequestService
     */
    protected $requestService;

    /**
     * HomeController constructor.
     * @param StorageManager $storageManager
     * @param SpotifyService $spotifyService
     * @param RequestService $requestService
     */
    public function __construct(StorageManager $storageManager, SpotifyService $spotifyService, RequestService $requestService)
    {
        parent::__construct($storageManager);
        $this->spotifyService = $spotifyService;
        $this->requestService = $requestService;
    }

    public function index()
    {
        $logged = $this->storeManager->has('token');
        $me = null;

        if($logged === true) {
            /**
             * @var SpotifyToken $token
             */
            $token = $this->storeManager->get('token');
            $me = $this->spotifyService->requestMe($token);



//            $client = new Client();
//            $response = $client->request('GET', 'https://api.spotify.com/v1/me/top/artists', [
//                'headers' => [
//                    'Authorization' => 'Bearer ' . $token->getAccessToken()
//                ]
//            ]);
//            $top = \json_decode($response->getBody()->getContents(), true);
//            print_r($top);
        }
        print $this->twig->render('index.twig', ['logged' => $logged, 'me' => $me]);
    }
}