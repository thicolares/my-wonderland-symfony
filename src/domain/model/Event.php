<?php
/**
 * Created by PhpStorm.
 * User: thiago
 * Date: 01/04/18
 * Time: 16:35
 */

namespace MyWonderland\Domain\Model;


class Event
{
    /**
     * @var string
     */
    public $city;

    /**
     * @var string
     */
    public $country;

    /**
     * @var string
     */
    public $state;

    /**
     * Event constructor.
     * @param string $city
     * @param string $country
     * @param string $state
     */
    public function __construct($city, $country, $state)
    {
        $this->city = $city;
        $this->country = $country;
        $this->state = $state;
    }
}