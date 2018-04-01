<?php
/**
 * Created by PhpStorm.
 * User: thiago
 * Date: 31/03/18
 * Time: 10:46
 */

namespace MyWonderland\Service;

use GuzzleHttp\Client;
use phpFastCache\Core\Pool\ExtendedCacheItemPoolInterface;

class RequestService
{
    /**
     * @var ExtendedCacheItemPoolInterface
     */
    protected $instanceCache;

    /**
     * ClientService constructor.
     */
    public function __construct()
    {
        $this->instanceCache = \phpFastCache\CacheManager::getInstance('files');
    }



    /**
     * @param $method
     * @param string $uri
     * @param array $options
     * @param string $salt a random data that is used as an additional input to a one-way function that "hashes" data
     * @return mixed
     */
    public function requestContent($method, $uri = '', array $options = [], $salt = '') {
        $cacheKey = md5($method.$uri.$salt);

        $cachedString = $this->instanceCache->getItem($cacheKey);

        if (is_null($cachedString->get())) {

            $client = new Client();
            $res = $client->request($method, $uri , $options);
            // Não estou cacheando o res porque na deserialização, o
            // [stream:GuzzleHttp\Psr7\Response:private] => GuzzleHttp\Psr7\Stream Object (
            //    [stream:GuzzleHttp\Psr7\Stream:private] => Resource id #79
            //
            // tá virando
            // [stream:GuzzleHttp\Psr7\Response:private] => GuzzleHttp\Psr7\Stream Object (
            //    [stream:GuzzleHttp\Psr7\Stream:private] => 0

            $content = json_decode( $res->getBody()->getContents(), true);

            $cachedString->set($content)->expiresAfter(30 * 24 * 3600);//in seconds, also accepts Datetime. Coloquei 1 ano
            $this->instanceCache->save($cachedString); // Save the cache item just like you do with doctrine and entities

            // "FIRST LOAD // WROTE OBJECT TO CACHE // RELOAD THE PAGE AND SEE // ";
            return $cachedString->get();
        }

        // "READ FROM CACHE // ";
        return $cachedString->get();// Will print 'First product'
    }

}