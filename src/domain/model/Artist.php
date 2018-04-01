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
    public $songkickId;

    /**
     * @var string
     */
    public $name;

    /**
     * Artist constructor.
     * @param string $songkickId
     * @param string $name
     */
    public function __construct($songkickId, $name)
    {
        $this->songkickId = $songkickId;
        $this->name = $name;
    }

}