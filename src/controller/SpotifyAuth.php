<?php
namespace MyWonderland\Controller;
use GuzzleHttp\Client;
use MyWonderland\Service\SpotifyManager;

/**
 * Created by PhpStorm.
 * User: thiago
 * Date: 31/03/18
 * Time: 12:00
 */

class SpotifyAuth extends AbstractController
{
    const REDIRECT_URI = '/callback';

    public function auth() {
        $spotifyManager = new SpotifyManager();
        header('Location: ' . $spotifyManager->getAuthUri());
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
                'redirect_uri' => getenv('BASE_URI') . self::REDIRECT_URI
            ],
            'headers'  => [
                'Authorization' => 'Basic  ' .
                    base64_encode(getenv('SPOTIFY_CLIENT_ID') . ':' . getenv('SPOTIFY_CLIENT_SECRET'))
            ]
        ]);

        // @todo use guzzle options
        $contents = \json_decode($response->getBody()->getContents(), true);

        /**
         * step 3
         */
        $client = new Client();
        $response = $client->request('GET', 'https://api.spotify.com/v1/me', [
            'headers' => [
                'Authorization' => 'Bearer ' . $contents['access_token']
            ]
        ]);
        $finalContents = \json_decode($response->getBody()->getContents(), true);
        print "<img src='{$finalContents['images'][0]['url']}' />";

        $client = new Client();
        $response = $client->request('GET', 'https://api.spotify.com/v1/me/top/artists', [
            'headers' => [
                'Authorization' => 'Bearer ' . $contents['access_token']
            ]
        ]);
        $top = \json_decode($response->getBody()->getContents(), true);
        print_r($top);

//        [access_token] => BQC4hHT8AtmMUygSls_KnMq8R3gqVnqmTKozJkxbFASxoKJ6S5drHVYWjPk7PFYDSUpycP0WHJ4Uyb1JIBArqjWIieyRwqSjhmLMxPGnlrcAlxdqcZ7cvsg4ntCBTtIlvHLK-zQY2RqCDGEQ1heyeN4axNUKItjATUE [token_type] => Bearer [expires_in] => 3600 [refresh_token] => AQAqMe5ge7GLPPwJgnZ4V5MuCVt2Ztm1Gd0k15IbJFE9XKU8-TgOUH8bRANUKb2iZHsi5ndbWvGqg91OOrJIjKp5Px0SZB9FO7tV4CMDuTc6IbXhmlX8xZv04gA4pSxO_ts [scope] => user-read-email user-read-private

    }
}