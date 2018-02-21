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


use inc\core\client\clientAccessHandler;
use inc\core\client\clientServer;
use inc\core\loader\refelctionLoader;
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

        $return                 = False;

        if( $this->sessionHandler->get('success') )
        {
            #core::init()->output('notification',$sessionHandler->get('success'));
            $this->sessionHandler->del('success');
        }

        if( !isset($_REQUEST['_noexpire']) )
        {
            $this->sessionHandler->setNewExpire();
        }

        #if( $this->clientServer->getRequestMethodPost() === True && isset( $_REQUEST['action'] ) )
        #{
            #$this->processPostRequest($_REQUEST);
        #}

        if( $this->pageForm === False || $this->clientServer->getRequestMethodGet() === True )
        {
            $return = $this->processGetRequest();
        }

        return $return;
    }

    /**
     * @return mixed
     * @throws \ReflectionException
     */
    public function processGetRequest()
    {
        $fallBack           = False;

        $pageConfigLoader   = new pageConfigLoader();

        $systemUrlData      = $pageConfigLoader->loadPageGetRequest();

        if( !isset( $systemUrlData['user_group_id'] ) )
        {
            $systemUrlData['user_group_id']     = 0;
        }

        if( !isset( $systemUrlData['user_right_id'] ) )
        {
            $systemUrlData['user_right_id']     = 0;
        }

        if(
            isset($systemUrlData['url_access']) &&
            $systemUrlData['url_access'] == 1 &&
            $systemUrlData['user_group_id'] != 0
        )
        {
            $userRightId    = $systemUrlData['user_right_id'] != 0 ? $systemUrlData['user_right_id'] : False;

            if( clientAccessHandler::checkAccess($systemUrlData['user_group_id'],$userRightId) === False )
            {
                $fallBack = true;
            }
        }

        if( $fallBack === False )
        {
            if( method_exists($systemUrlData['return_class'], $systemUrlData['return_function']) )
            {
                $reflectionLoader   = new refelctionLoader($systemUrlData['return_class'], $systemUrlData['return_function']);

                $invokeReturn       = $reflectionLoader->invokde();

                if( $invokeReturn !== False )
                {
                    #variable::set('page.loader.pageData',$pageData);

                    return $invokeReturn;
                }
            }

            $fallBack = true;
        }

        if( $fallBack === True )
        {
            $reflectionLoader   = new refelctionLoader($systemUrlData['fallback_class'], $systemUrlData['fallback_class']);

            #variable::set('page.loader.pageData',$pageData);

            return $reflectionLoader->invokde();
        }
    }
}