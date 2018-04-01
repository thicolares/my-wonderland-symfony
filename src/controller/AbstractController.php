<?php
namespace MyWonderland\Controller;
/**
 * Created by PhpStorm.
 * User: thiago
 * Date: 31/03/18
 * Time: 12:00
 */

abstract class AbstractController
{
    /**
     * @var \Twig_Environment
     */
    protected $twig;
    /**
     * AbstractController constructor.
     */
    public function __construct()
    {
        global $twig;
        $this->twig = $twig;
    }
}