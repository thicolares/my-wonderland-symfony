<?php
/**
 * Created by PhpStorm.
 * User: thiago
 * Date: 31/03/18
 * Time: 21:56
 */

namespace MyWonderland\Model;


class SpotifyMe
{
    /**
     * @var string
     */
    public $country;

    /**
     * @var string
     */
    public $displayName;

    /**
     * @var string
     */
    public $spotify;

    /**
     * SpotifyMe constructor.
     * @param string $country
     * @param string $displayName
     * @param string $spotify
     */
    public function __construct($country, $displayName, $spotify)
    {
        $this->country = $country;
        $this->displayName = $displayName;
        $this->spotify = $spotify;
    }

}