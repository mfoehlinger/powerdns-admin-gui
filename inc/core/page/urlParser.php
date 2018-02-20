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


use inc\core\client\clientServer;

class urlParser
{
    private $clientServer;

    /**
     * urlParser constructor.
     */
    public function __construct()
    {
        $this->clientServer     = new clientServer();
    }

    /**
     * @param bool $suffix
     * @return string
     */
    public function getUri(bool $suffix = False)
    {
        $parsedUrl      = $this->getParsedUrl();

        $urlPathinfo    = $this->getUrlPathInfo( $parsedUrl['path'] );

        $requestUri     = $this->clientServer->getRequestUri();

        if( $suffix === False && isset( $urlPathinfo['extension'] ) && $urlPathinfo['extension'] != '' )
        {
            $fileExtensionLenght    = strlen( $urlPathinfo['extension'] );

            $requestUri             = substr( $requestUri, 0,'-'.($fileExtensionLenght + 1));
        }

        return $requestUri;
    }

    /**
     * @return mixed
     */
    private function getParsedUrl()
    {
        return parse_url($this->clientServer->getFullUrl());
    }

    /**
     * @param string $file
     * @return mixed|array
     */
    private function getUrlPathInfo(string $file)
    {
        return pathinfo($file);
    }

    /**
     * @return array
     */
    public function getUriArray()
    {
        return explode('/',$this->getUri());
    }

    /**
     * @return string
     */
    public function getHostUrl()
    {
        return ( $this->clientServer->getHttps() === True ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'];
    }
}