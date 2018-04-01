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
     */
    public function __construct(StorageManager $storageManager)
    {
        $this->storeManager = $storageManager;

        global $twig;
        $this->twig = $twig;
    }
}