<?php
/**
 * Created by PhpStorm.
 * User: thiago
 * Date: 31/03/18
 * Time: 20:50
 */

namespace MyWonderland\Controller;


class HomeController extends AbstractController
{
    public function index()
    {
        session_start();
        $logged = isset($_SESSION['token']);
        print $this->twig->render('index.twig', ['logged' => $logged]);
    }
}