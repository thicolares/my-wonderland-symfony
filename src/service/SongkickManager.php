<?php
/**
 * Created by PhpStorm.
 * User: thiago
 * Date: 31/03/18
 * Time: 10:05
 */

namespace MyWonderland\Service;


class SongkickManager
{
    static function hw() {
        $client = new \GuzzleHttp\Client();
        // http://api.songkick.com/api/3.0/artists/379603/gigography.json?apikey=AfG9d5gdhJMscGjZ

        $uri = getenv('SONGKICK_API_URI') . 'artists/379603/gigography.json?apikey=' . getenv('SONGKICK_API_KEY');
        $res = $client->request('GET', $uri);
        //echo $res->getStatusCode();
// 200
        //echo $res->getHeaderLine('content-type');
// 'application/json; charset=utf8'
        echo $res->getBody();
// '{"id": 1420053, "name": "guzzle", ...}'

// Send an asynchronous request.
//        $request = new \GuzzleHttp\Psr7\Request('GET', 'http://httpbin.org');
//        $promise = $client->sendAsync($request)->then(function ($response) {
//            echo 'I completed! ' . $response->getBody();
//        });
//        $promise->wait();
    }
}