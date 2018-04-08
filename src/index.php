<?php
/**
 * Created by PhpStorm.
 * User: thiago
 * Date: 31/03/18
 * Time: 11:53
 */

require_once __DIR__ . '/bootstrap.php';

/**
 * Simple handmade router and dispatcher :)
 */

$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
    $r->addRoute('GET', '/', \MyWonderland\Controller\HomeController::class . ':index');
    $r->addRoute('GET', '/report', \MyWonderland\Controller\HomeController::class . ':report');
    $r->addRoute('GET', '/auth', \MyWonderland\Controller\SpotifyAuthController::class . ':auth');
    $r->addRoute('GET', '/callback', \MyWonderland\Controller\SpotifyAuthController::class . ':callback');
    $r->addRoute('GET', '/logout', \MyWonderland\Controller\SpotifyAuthController::class . ':logout');
});


$routeInfo = $dispatcher->dispatch(
    $_SERVER['REQUEST_METHOD'],
    rawurldecode(extractAction($_SERVER['REQUEST_URI']))
);
callController($routeInfo, $_SERVER['QUERY_STRING']);


/**
 * @param string $uri Ex.: /callback?code=bli&test=3
 * @return bool|string Ex.? /callback
 */
function extractAction($uri) {
    if (false !== $pos = strpos($uri, '?')) {
        return substr($uri, 0, $pos);
    }
    return $uri;
}


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
        throw new \Exception("Missed the '{$param->getName()}'' param.", 1522882396);
    }
    return $sortedVars;
}


/**
 * @param $routeInfo
 * @param $queryString
 */
function callController($routeInfo, $queryString)
{
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

            parse_str($queryString, $queryStringVars);

            $sortedVars = sortParams($class, $method, $vars + $queryStringVars);

            call_user_func_array(array($container->build($class), $method), $sortedVars);
            break;
    }
}