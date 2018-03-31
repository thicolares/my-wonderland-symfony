<?php
/**
 * Created by PhpStorm.
 * User: thiago
 * Date: 31/03/18
 * Time: 18:47
 */

namespace MyWonderland\Service;


class SpotifyManager
{
    const REDIRECT_URI = '/callback';
    const BASE_AUTH_URI = 'https://accounts.spotify.com/authorize/';

    public function getAuthUri() {
        $scopes = 'user-read-private user-read-email user-top-read';
        $queryString = '?client_id=' . getenv('SPOTIFY_CLIENT_ID') .
            '&response_type=code' .
            '&redirect_uri=' . rawurlencode(getenv('BASE_URI') . self::REDIRECT_URI) .
            ($scopes ? '&scope=' . rawurlencode($scopes) : '') .
            '&state=' . getenv('SPOTIFY_CALLBACK_STATE');
        return self::BASE_AUTH_URI . $queryString;
    }
}