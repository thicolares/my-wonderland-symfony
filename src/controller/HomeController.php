<?php
/**
 * Created by PhpStorm.
 * User: thiago
 * Date: 31/03/18
 * Time: 20:50
 */

namespace MyWonderland\Controller;


use GuzzleHttp\Client;
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
     * @param SpotifyService $spotifyService
     * @param RequestService $requestService
     */
    public function __construct(SpotifyService $spotifyService, RequestService $requestService)
    {
        parent::__construct();
        $this->spotifyService = $spotifyService;
        $this->requestService = $requestService;
    }

    public function index()
    {
        session_start();
        $logged = isset($_SESSION['token']);
        $me = null;


        if($logged === true) {
            /**
             * @var SpotifyToken $token
             */
            $token = $_SESSION['token'];
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