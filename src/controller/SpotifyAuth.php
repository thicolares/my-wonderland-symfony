<?php
namespace MyWonderland\Controller;
use GuzzleHttp\Client;

/**
 * Created by PhpStorm.
 * User: thiago
 * Date: 31/03/18
 * Time: 12:00
 */

class SpotifyAuth extends AbstractController
{
    const REDIRECT_URI = 'http://my-wonderland.localhost/callback'; // @todo extract the base

    public function auth() {
        $baseUri = 'https://accounts.spotify.com/authorize/';
        $scopes = 'user-read-private user-read-email';

        $uri = '?client_id=' . getenv('SPOTIFY_CLIENT_ID') .
            '&response_type=code' .
            '&redirect_uri=' . rawurlencode(self::REDIRECT_URI) .
            ($scopes ? '&scope=' . rawurlencode($scopes) : '') .
            '&state=' . getenv('SPOTIFY_CALLBACK_STATE');
        header('Location: ' . $baseUri . $uri);
    }

    public function callback($code, $state = null) {
        print "authCallback";

        var_dump($code);
        var_dump($state);
        var_dump(getenv('SPOTIFY_CALLBACK_STATE'));

        $client = new Client();
        $response = $client->request('POST', 'https://accounts.spotify.com/api/token', [
            'form_params' => [
                'grant_type' => 'authorization_code',
                'code' => $code,
                'redirect_uri' => self::REDIRECT_URI
            ],
            'headers'  => [
                'Authorization' => 'Basic  ' .
                    base64_encode(getenv('SPOTIFY_CLIENT_ID') . ':' . getenv('SPOTIFY_CLIENT_SECRET'))
            ]
        ]);

        print_r(\json_decode($response->getBody()->getContents(), true));



    }
}