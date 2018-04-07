<?php
/**
 * Created by PhpStorm.
 * User: thiago
 * Date: 07/04/18
 * Time: 19:21
 */

namespace MyWonderland\Test\Service;

use MyWonderland\Service\RequestService;
use MyWonderland\Service\SongkickService;

class SongkickServiceTest extends \PHPUnit\Framework\TestCase
{

    /**
     * @test
     */
    public function getArtistIdByNameTest()
    {
        $requestServiceMock = $this->getMockBuilder(RequestService::class)
            ->setMethods(['requestContent'])
            ->getMock();
        $requestServiceMock->expects($this->once())
            ->method('requestContent')
            ->willReturn($this->artistNameRequestResponseMock());

        $songkickService = new SongkickService($requestServiceMock);

        $this->assertEquals(417271, $songkickService->getArtistIdByName('a-key', 'an-artist'));
    }


    /**
     * @return array
     */
    private function artistNameRequestResponseMock()
    {
        return [
            "resultsPage" => [

                "status" => "ok",
                "results" => [
                    "artist" => [
                        0 => [
                            "identifier" => [
                                0 => [
                                    "eventsHref" => "http://api.songkick.com/api/3.0/artists/mbid:b10bbbfc-cf9e-42e0-be17-e2c3e1d2600d/calendar.json",
                                    "setlistsHref" => "http://api.songkick.com/api/3.0/artists/mbid:b10bbbfc-cf9e-42e0-be17-e2c3e1d2600d/setlists.json",
                                    "mbid" => "b10bbbfc-cf9e-42e0-be17-e2c3e1d2600d",
                                    "href" => "http://api.songkick.com/api/3.0/artists/mbid:b10bbbfc-cf9e-42e0-be17-e2c3e1d2600d.json"
                                ]

                            ],

                            "onTourUntil" => null,
                            "displayName" => "The Beatles",
                            "uri" => "http://www.songkick.com/artists/417271-beatles?utm_source=10918&utm_medium=partner",
                            "id" => 417271
                        ]

                    ]

                ],

                "perPage" => 1,
                "page" => 1,
                "totalEntries" => 196
            ]

        ];
    }

}