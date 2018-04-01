<?php
/**
 * Created by PhpStorm.
 * User: thiago
 * Date: 31/03/18
 * Time: 18:47
 */
namespace MyWonderland\Service;

use GuzzleHttp\Client;
use MyWonderland\Domain\Model\Artist;
use MyWonderland\Domain\Model\SpotifyMe;
use MyWonderland\Domain\Model\SpotifyToken;

class SpotifyService
{
    const REDIRECT_URI = '/callback';
    const BASE_AUTH_URI = 'https://accounts.spotify.com/authorize/';
    const TOKEN_URI = 'https://accounts.spotify.com/api/token';
    const BASE_API = 'https://api.spotify.com/v1';

    /**
     * @var RequestService
     */
    protected $requestService;


    /**
     * SpotifyService constructor.
     * @param RequestService $requestService
     */
    public function __construct(RequestService $requestService)
    {
        $this->requestService = $requestService;
    }


    /**
     * @return string
     */
    public function getAuthUri()
    {
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
    public function requestToken($code)
    {
        $client = new Client();
        $response = $client->request('POST', self::TOKEN_URI, [
            'form_params' => [
                'grant_type' => 'authorization_code',
                'code' => $code,
                'redirect_uri' => getenv('BASE_URI') . self::REDIRECT_URI
            ],
            'headers' => [
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


    /**
     * @param SpotifyToken $token
     * @return SpotifyMe
     */
    public function requestMe(SpotifyToken $token)
    {
        $response = $this->requestService->requestContent('GET', 'https://api.spotify.com/v1/me', '', [
            'headers' => [
                'Authorization' => 'Bearer ' . $token->getAccessToken()
            ]
        ]);
        return new SpotifyMe(
            $response['country'],
            $response['display_name'],
            $response['images'][0]['url']
        );
    }

    public function requestTopArtists(SpotifyToken $token)
    {
        $response = $this->requestService->requestContent('GET', self::BASE_API . '/me/top/artists', '', [
            'headers' => [
                'Authorization' => 'Bearer ' . $token->getAccessToken()
            ]
        ]);
        $topArtists = [];
        foreach($response['items'] as $artist) {
            $topArtists[] = new Artist($artist['name'], $artist['images'][1]['url']);
        }
        return $topArtists;
    }
}