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

namespace inc\core\client;


class clientServer
{
    /**
     * @return string
     */
    public function getFullUrl()
    {
        return ($this->getHttps() === True ? "https://" : "http://") . $this->getHttpHost() . $this->getRequestUri();
    }

    /**
     * @return bool
     */
    public function getRedirectStatus()
    {
        return isset($_SERVER['REDIRECT_STATUS']) ? $_SERVER['REDIRECT_STATUS'] : false;
    }

    /**
     * @return bool
     */
    public function getHttps()
    {
        return isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on'
            ? true
            : false;
    }

    /**
     * @return bool
     */
    public function getHttpHost()
    {
        return isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : false;
    }

    /**
     * @return bool
     */
    public function getUserAgent()
    {
        return isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : false;
    }

    /**
     * @return bool
     */
    public function getDocumentRoot()
    {
        return isset($_SERVER['DOCUMENT_ROOT']) ? $_SERVER['DOCUMENT_ROOT'] : false;
    }

    /**
     * @return bool
     */
    public function getRequestScheme()
    {
        return isset($_SERVER['REQUEST_SCHEME']) ? $_SERVER['REQUEST_SCHEME'] : false;
    }

    /**
     * @return bool
     */
    public function getRequestMethod()
    {
        return isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : false;
    }

    /**
     * @return bool
     */
    public function getRemoteAddress()
    {
        return isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : false;
    }

    /**
     * @return bool
     */
    public function getHttpClientIp()
    {
        return isset($_SERVER['HTTP_CLIENT_IP']) ? $_SERVER['HTTP_CLIENT_IP'] : false;
    }

    /**
     * @return bool
     */
    public function getRequestMethodGet()
    {
        return $this->getRequestMethod() == 'GET' ? true : false;
    }

    /**
     * @return bool
     */
    public function getRequestMethodPost()
    {
        return $this->getRequestMethod() == 'POST' ? true : false;
    }

    /**
     * @return bool
     */
    public function getRequestUri()
    {
        return isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : false;
    }

    /**
     * @return bool
     */
    public function getQueryString()
    {
        return isset($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : false;
    }

    /**
     * @return bool
     */
    public function getRequestTime()
    {
        return isset($_SERVER['REQUEST_TIME']) ? $_SERVER['REQUEST_TIME'] : false;
    }

    /**
     * @return bool
     */
    public function getRequestTimeFloat()
    {
        return isset($_SERVER['REQUEST_TIME_FLOAT']) ? $_SERVER['REQUEST_TIME_FLOAT'] : false;
    }

    /**
     * @return bool|string
     */
    public function getBrowserLanguage()
    {
        $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);

        return $lang;
    }
}