<?php
namespace MyWonderland\Controller;
use MyWonderland\Domain\Manager\StorageManager;

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
     * @var StorageManager
     */
    protected $storeManager;

    /**
     * AbstractController constructor.
     * @param StorageManager $storageManager
     * @param \Twig_Environment $twig
     */
    public function __construct(StorageManager $storageManager, \Twig_Environment $twig)
    {
        $this->storeManager = $storageManager;
        $this->twig = $twig;
    }
}