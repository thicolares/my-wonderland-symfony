<?php
/**
 * Created by PhpStorm.
 * User: thiago
 * Date: 31/03/18
 * Time: 18:47
 */
namespace MyWonderland\Service;

use GuzzleHttp\Client;
use MyWonderland\Model\SpotifyToken;

class SpotifyService extends AbstractService
{
    const REDIRECT_URI = '/callback';
    const BASE_AUTH_URI = 'https://accounts.spotify.com/authorize/';
    const TOKEN_URI = 'https://accounts.spotify.com/api/token';


    /**
     * @return string
     */
    public function getAuthUri() {
        $scopes = 'user-read-private user-read-email user-top-read';
        $queryString = '?client_id=' . getenv('SPOTIFY_CLIENT_ID') .
            '&response_type=code' .
            '&redirect_uri=' . rawurlencode(getenv('BASE_URI') . self::REDIRECT_URI) .
            ($scopes ? '&scope=' . rawurlencode($scopes) : '') .
            '&state=' . getenv('SPOTIFY_CALLBACK_STATE');
        return self::BASE_AUTH_URI . $queryString;
    }


    /**
     * @param $code
     * @return SpotifyToken
     */
    public function requestToken($code) {
        $client = new Client();
        $response = $client->request('POST', self::TOKEN_URI, [
            'form_params' => [
                'grant_type' => 'authorization_code',
                'code' => $code,
                'redirect_uri' => getenv('BASE_URI') . self::REDIRECT_URI
            ],
            'headers'  => [
                'Authorization' => 'Basic  ' .
                    base64_encode(getenv('SPOTIFY_CLIENT_ID') . ':' . getenv('SPOTIFY_CLIENT_SECRET'))
            ]
        ]);

        // @todo use guzzle options
        $responseBody = \json_decode($response->getBody()->getContents(), true);
        return new SpotifyToken(
            $responseBody['access_token'],
            $responseBody['token_type'],
            $responseBody['expires_in'],
            $responseBody['refresh_token'],
            $responseBody['scope']
        );
    }
}