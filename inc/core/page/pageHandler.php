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
use inc\core\session\sessionHandler;

class pageHandler
{
    private $sessionHandler;

    private $urlParser;

    private $clientServer;

    private $pageForm   = False;

    public function __construct()
    {
        $this->urlParser        = new urlParser();

        $this->clientServer     = new clientServer();

        $this->sessionHandler   = new sessionHandler();

        $this->sessionHandler->check();

        if( $this->sessionHandler->get('success') )
        {
            #core::init()->output('notification',$sessionHandler->get('success'));
            $this->sessionHandler->del('success');
        }

        if( !isset($_REQUEST['_noexpire']) )
        {
            $this->sessionHandler->setNewExpire();
        }

        if( $this->clientServer->getRequestMethodPost() === True && isset( $_REQUEST['action'] ) )
        {
            #$this->processPostRequest($_REQUEST);
        }

        if( $this->pageForm === False || $this->clientServer->getRequestMethodGet() === True )
        {
            $this->processGetRequest();
        }

    }

    public function processGetRequest()
    {
        $fallBack           = False;

        $pageConfigLoader   = new pageConfigLoader();

        $systemUrlData      = $pageConfigLoader->loadPageGetRequest();
    }
}