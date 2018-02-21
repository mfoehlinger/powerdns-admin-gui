<?php
/**
 * This file is part of the PowerDNS-Admin-GUI project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 *
 */

namespace inc\core\page;


use inc\core\page\database\DbHandler;

class pageConfigLoader
{
    private $dbHandler;

    public function __construct()
    {
        $this->dbHandler    = new DbHandler();
    }

    public function loadPageGetRequest()
    {
        $urlParser          = new urlParser();

        $requestUri         = $urlParser->getUri();

        $systemUrlsResult   = $this->dbHandler->getAllSystemUrls();

        $systemUrls         = array();

        foreach( $systemUrlsResult AS $key => $systemUrl )
        {
            $systemUrls[$systemUrl['system_uri']]   = $systemUrl;
        }

        return $this->getSystemUrlData($requestUri, $systemUrls);
    }

    /**
     * @param string $requestUri
     * @param array  $systemUrls
     * @return mixed
     */
    private function getSystemUrlData(string $requestUri, array $systemUrls)
    {
         return isset( $systemUrls[$requestUri] ) ? $systemUrls[$requestUri] : $this->reduceUri($requestUri, $systemUrls);
    }

    /**
     * @param string $uri
     * @param array  $uris
     * @return array
     */
    private function reduceUri(string $uri, array $uris)
    {
        if( $uri == '' || $uri == '/' || count($uris) < 1 )
        {
            return $this->getDefaultSystemFallBack();
        }

        $uriArray   = explode('/',$uri);

        array_pop($uriArray);

        $uri        = implode('/',$uriArray);

        return isset( $uris[$uri] ) ? $uris[$uri] : $this->reduceUri($uri,$uris);
    }

    /**
     * @return array
     */
    public function getDefaultSystemFallBack()
    {
        return $this->dbHandler->getDefaultSystemFallback();
    }
}