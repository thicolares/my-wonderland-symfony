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
     * @param string $cacheKey
     * @return mixed
     */
    public function requestContent($method, $uri = '', array $options = [], $cacheKey = '') {
        $cacheKey = md5($cacheKey);

        $this->instanceCache->clear();
        $cachedString = $this->instanceCache->getItem($cacheKey);

        if (is_null($cachedString->get())) {
            $client = new Client();
//            if(!isset($options['connect_timeout'])) {
//                $options['connect_timeout'] = 10;
//            }
            $res = $client->request($method, $uri, $options);
            $content = json_decode($res->getBody()->getContents(), true);

            //in seconds, also accepts Datetime
            $cachedString->set($content)->expiresAfter(30 * 24 * 3600);

            // Save the cache item just like you do with doctrine and entities
            $this->instanceCache->save($cachedString);

            // "FIRST LOAD // WROTE OBJECT TO CACHE // RELOAD THE PAGE AND SEE // ";
            return $cachedString->get();
        }

        // "READ FROM CACHE // ";
        return $cachedString->get();
    }

}