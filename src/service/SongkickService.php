<?php
/**
 * Created by PhpStorm.
 * User: thiago
 * Date: 31/03/18
 * Time: 10:05
 */

namespace MyWonderland\Service;

use MyWonderland\Domain\Model\Event;

class SongkickService
{
    const BASE_URI = 'http://api.songkick.com/api/3.0';


    /**
     * @var RequestService
     */
    protected $requestService;

    /**
     * SongkickService constructor.
     * @param RequestService $requestService
     */
    public function __construct(RequestService $requestService)
    {
        $this->requestService = $requestService;
    }


    /**
     * @param $name
     * @return string
     */
    public function getArtistIdByName($name)
    {
        $queryStringWOKey = '/search/artists.json' .
            '?per_page=1' .
            '&query=' . rawurlencode($name);
        $queryString = $queryStringWOKey . '&apikey=' . getenv('SONGKICK_API_KEY');
        $res = $this->requestService->requestContent('GET',
            self::BASE_URI . $queryString, [], $queryStringWOKey);

        // @todo check if resultsPage -> status is ok

        return $res['resultsPage']['results']['artist'][0]['id'];
    }

    public function getArtistUpcomingEvents($artistId)
    {
        $queryStringWOKey = '/artists/' . $artistId . '/calendar.json';
        $queryString = $queryStringWOKey . '?apikey=' . getenv('SONGKICK_API_KEY');
        $res = $this->requestService->requestContent('GET',
            self::BASE_URI . $queryString, [], $queryStringWOKey);

        // @todo check if resultsPage -> status is ok

        if (!isset($res['resultsPage']['results']['event'])) {
            return [];
        }

        $upcomingEvents = [];
        foreach ($res['resultsPage']['results']['event'] as $event) {
            $upcomingEvents[] = new Event(
                $event['venue']['metroArea']['displayName'],
                $event['venue']['metroArea']['country']['displayName'],
                isset($event['venue']['metroArea']['state']) ? $event['venue']['metroArea']['state']['displayName'] : null
            );
        }
        return $upcomingEvents;
    }
}