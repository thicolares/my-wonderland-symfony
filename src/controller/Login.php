<?php
namespace MyWonderland\Controller;
/**
 * Created by PhpStorm.
 * User: thiago
 * Date: 31/03/18
 * Time: 12:00
 */

class Login extends AbstractController
{
    public function login() {
        global $twig;
        echo $twig->render('login.twig', ['name' => 'Thiago']);
//        print "bli";
    }
}