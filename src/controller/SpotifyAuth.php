<?php
namespace MyWonderland\Controller;
use GuzzleHttp\Client;
use MyWonderland\Service\SpotifyService;

/**
 * Created by PhpStorm.
 * User: thiago
 * Date: 31/03/18
 * Time: 12:00
 */

class SpotifyAuth extends AbstractController
{
    /**
     * @var SpotifyService
     */
    protected $spotifyService;


    /**
     * SpotifyAuth constructor.
     */
    public function __construct()
    {
        $this->spotifyService = SpotifyService::getInstance();
    }


    public function auth()
    {
        header('Location: ' . $this->spotifyService->getAuthUri());
    }


    public function callback($code, $state = null)
    {
        // @todo check state against SPOTIFY_CALLBACK_STATE

        $token = $this->spotifyService->requestToken($code);

        $client = new Client();
        $response = $client->get('https://api.spotify.com/v1/me', [
            'headers' => [
                'Authorization' => 'Bearer ' . $token->getAccessToken()
            ]
        ]);
        $finalContents = \json_decode($response->getBody()->getContents(), true);
        print "<img src='{$finalContents['images'][0]['url']}' />";

        $client = new Client();
        $response = $client->request('GET', 'https://api.spotify.com/v1/me/top/artists', [
            'headers' => [
                'Authorization' => 'Bearer ' . $token->getAccessToken()
            ]
        ]);
        $top = \json_decode($response->getBody()->getContents(), true);
        print_r($top);



    }
}