<?php
/**
 * Created by PhpStorm.
 * User: thiago
 * Date: 31/03/18
 * Time: 20:50
 */

namespace MyWonderland\Controller;


use MyWonderland\Domain\Manager\StorageManager;
use MyWonderland\Domain\Model\Artist;
use MyWonderland\Domain\Model\SpotifyToken;
use MyWonderland\Service\SongkickService;
use MyWonderland\Service\SpotifyService;

class HomeController extends AbstractController
{
    /**
     * @var SpotifyService
     */
    protected $spotifyService;

    /**
     * @var SongkickService
     */
    protected $songkickService;

    /**
     * HomeController constructor.
     * @param StorageManager $storageManager
     * @param SpotifyService $spotifyService
     * @param SongkickService $songkickService
     */
    public function __construct(StorageManager $storageManager, \Twig_Environment $twig, SpotifyService $spotifyService, SongkickService $songkickService)
    {
        parent::__construct($storageManager, $twig);
        $this->spotifyService = $spotifyService;
        $this->songkickService = $songkickService;
    }

    public function index()
    {
        $logged = $this->storeManager->has('token');
        $me = null;
        $topArtists = [];
        if($logged === true) {
            /**
             * @var SpotifyToken $token
             */
            $token = $this->storeManager->get('token');
            $me = $this->spotifyService->requestMe($token);
            $topArtists = $this->spotifyService->requestTopArtists($token);

//            $artistId = $this->songkickService->getArtistIdByName('The Beatles');
//            print_r($artistId);


        }
        print $this->twig->render('index.twig', [
            'logged' => $logged,
            'me' => $me,
            'topArtists' => $topArtists,
        ]);
    }
}