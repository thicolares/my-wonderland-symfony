<?php
/**
 * Created by PhpStorm.
 * User: thiago
 * Date: 01/04/18
 * Time: 12:02
 */

namespace MyWonderland\Domain\Model;


class Artist
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $avatar;

    /**
     * @var string
     */
    public $songkickId;

    /**
     * Artist constructor.
     * @param $name
     * @param string $avatar
     */
    public function __construct($name, $avatar)
    {
        $this->name = $name;
        $this->avatar = $avatar;
        $this->songkickId = null;
    }
}