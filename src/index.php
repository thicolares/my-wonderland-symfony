<?php
/**
 * Created by PhpStorm.
 * User: thiago
 * Date: 31/03/18
 * Time: 11:53
 */

require_once __DIR__ . '/bootstrap.php';

/**
 * Routes
 */
$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
    $r->addRoute('GET', '/', \MyWonderland\Controller\HomeController::class . ':index');
    $r->addRoute('GET', '/report', \MyWonderland\Controller\HomeController::class . ':report');
    $r->addRoute('GET', '/auth', \MyWonderland\Controller\SpotifyAuthController::class . ':auth');
    $r->addRoute('GET', '/callback', \MyWonderland\Controller\SpotifyAuthController::class . ':callback');
    $r->addRoute('GET', '/logout', \MyWonderland\Controller\SpotifyAuthController::class . ':logout');
});

// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];
$queryStringVars = [];
$queryString = '';

// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $queryString = substr($uri, $pos+1);
    parse_str($queryString, $queryStringVars);
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);
$routeInfo = $dispatcher->dispatch($httpMethod, $uri);

/**
 * @param $class
 * @param $method
 * @param $allVars
 * @return array
 * @throws Exception
 */
function sortParams($class, $method, $allVars)
{
    $params = (new ReflectionMethod($class, $method))->getParameters();
    $sortedVars = [];
    foreach ($params as $param) {
        //$param is an instance of ReflectionParameter
        if (isset($allVars[$param->getName()])) {
            $sortedVars[$param->getName()] = $allVars[$param->getName()];
            continue;
        }
        if ($param->isOptional()) {
            $sortedVars[$param->getName()] = $param->getDefaultValue();
            continue;
        }
        throw new \Exception("Missed {$param->getName()} param.", 1522882396);
    }
    return $sortedVars;
}

switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        print "404 Not Found";
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        print "405 Not Allowed";
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];
        list($class, $method) = explode(":", $handler, 2);
        $container = new \MyWonderland\Container();

        parse_str($queryString, $queryString);

        $allVars = $vars + $queryStringVars;
        $sortedVars = sortParams($class, $method, $allVars);

        call_user_func_array(array($container->build($class), $method), $sortedVars);
        break;
}