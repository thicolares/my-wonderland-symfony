<?php
namespace MyWonderland\Controller;

/**
 * Created by PhpStorm.
 * User: thiago
 * Date: 31/03/18
 * Time: 20:50
 */

use MyWonderland\Domain\Manager\StorageManager;
use MyWonderland\Domain\Model\Artist;
use MyWonderland\Domain\Model\Ranking;
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
        // @todo Implement a middleware
        $logged = $this->storeManager->has('token');
        if ($logged === true) {
            header('Location: /report');
        }

        print $this->twig->render('index.twig', [
            'logged' => $logged
        ]);
    }


    public function report()
    {
        // @todo Implement a middleware
        $logged = $this->storeManager->has('token');
        if ($logged !== true) {
            header('Location: /');
        }

        /**
         * @var SpotifyToken $token
         */
        $token = $this->storeManager->get('token');
        $me = $this->spotifyService->requestMe($token);
        $topArtists = $this->spotifyService->requestTopArtists($token);
        $events = [];
        $count = 0;
        foreach ($topArtists as $artist) {
            /**
             * @var $artist Artist
             */
            $artist->songkickId = $this->songkickService->getArtistIdByName(
                getenv('SONGKICK_API_KEY'), $artist->name);
            $artistEvents = $this->songkickService->getArtistUpcomingEvents(
                getenv('SONGKICK_API_KEY'), $artist->songkickId);
            if (!empty($artistEvents)) {
                $count += count($artistEvents);
                $events = array_merge($events, $artistEvents);
            }
        }
        $ranking = new Ranking($events);
        $report = $ranking->report();

        print $this->twig->render('report.twig', [
            'logged' => $logged,
            'me' => $me,
            'topArtists' => $topArtists,
            'report' => array_slice($report, 0, 10)
        ]);
    }
}