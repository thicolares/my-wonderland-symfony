<?php
namespace MyWonderland\Controller;

/**
 * Created by PhpStorm.
 * User: thiago
 * Date: 31/03/18
 * Time: 12:00
 */

class SpotifyAuth extends AbstractController
{
    public function auth() {
        $baseUri = 'https://accounts.spotify.com/authorize/';
        $scopes = 'user-read-private user-read-email';
        $redirectUri = 'http://my-wonderland.localhost/callback';
        $uri = '?client_id=' . getenv('SPOTIFY_CLIENT_ID') .
            '&response_type=code' .
            '&redirect_uri=' . rawurlencode($redirectUri) .
            ($scopes ? '&scope=' . rawurlencode($scopes) : '') .
            '&state=' . getenv('SPOTIFY_CALLBACK_STATE');
        header('Location: ' . $baseUri . $uri);
    }

    public function callback($code, $state = null) {
        print "authCallback";
        print_r($_GET);
        var_dump($code);
        var_dump($state);
        var_dump(getenv('SPOTIFY_CALLBACK_STATE'));
    }
}