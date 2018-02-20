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

namespace inc\core\session;


use inc\core\client\clientAccessHandler;

class sessionHandler
{
    public  $ttl    = 30;

    private $sessionName;

    private $sessionId;

    /**
     * sessionhandler constructor.
     * @param string $name
     */
    public function __construct(string $name = 'Session')
    {
        $this->sessionName  = $name;
    }

    public function setup()
    {
        ini_set('session.save_handler', 'files');
        ini_set('session.serialize_handler', 'php_serialize');
        ini_set("session.gc_maxlifetime", ($this->ttl * 60));
        ini_set("session.gc_divisor", "1");
        ini_set("session.gc_probability", "1");
        ini_set("session.cookie_lifetime", "0");
        session_name($this->sessionName);
        session_save_path('/tmp');
    }

    /**
     * @return bool
     */
    public function start()
    {
        session_start();

        $this->sessionId    = session_id();

        return True;
    }

    /**
     * @return bool
     */
    public function delete()
    {
        $_SESSION   = array();

        session_destroy();

        $this->refresh();

        return True;
    }

    /**
     * @return bool
     */
    public function refresh()
    {
        session_regenerate_id(True);

        return True;
    }

    /**
     * @return bool
     */
    public function isExpired()
    {
        $expire     = isset( $_SESSION['_expire'] ) ? $_SESSION['_expire'] : $this->setNewExpire();

        if ( time() < $expire )
        {
            return False;
        }

        return True;
    }

    /**
     * @return bool
     */
    public function isFingerprint()
    {
        $hash = sha1(
            $_SERVER['HTTP_USER_AGENT'] .
            (ip2long($_SERVER['REMOTE_ADDR']) & ip2long('255.255.0.0'))
        );

        if ( isset( $_SESSION['_fingerprint'] ) )
        {
            return $_SESSION['_fingerprint'] === $hash;
        }

        $_SESSION['_fingerprint']   = $hash;

        return True;
    }

    /**
     * @return float|int
     */
    public function setNewExpire()
    {
        $expire     = time() + ( $this->ttl * 60 );

        #if( clientAccessHandler::checkAccess('user') === TRUE )
        #{
        #    $userDatabaseHandler    = new databaseHandler();

        #    $expire_    = date('Y-m-d H:i:s', $expire);

        #    $userDatabaseHandler->setUserNewExpireTime($_SESSION['user']['userId'], session_id(), $expire_);
        #}

        $_SESSION['_expire']    = $expire;

        return $expire;
    }

    /**
     * @return bool
     */
    public function isValid()
    {
        if( $this->isExpired() === True || $this->isFingerprint() === False)
        {
            return False;
        }

        return True;
    }

    /**
     * @return bool
     */
    public function check()
    {
        if( $this->isValid() === False )
        {
            $this->delete();

            return False;
        }
    }

    /**
     * @return int
     */
    public function getExpiredTime()
    {
        return $_SESSION['_expire'] - time();
    }

    /**
     * @param $name
     * @return array|mixed|null
     */
    public function get($name)
    {
        $parsed     = explode('.', $name);

        $result     = isset( $_SESSION ) ? $_SESSION : array();

        while ($parsed)
        {
            $next   = array_shift($parsed);

            if( isset( $result[$next] ) )
            {
                $result     = $result[$next];
            }
            else
            {
                return Null;
            }
        }

        return $result;
    }

    /**
     * @return mixed
     */
    public function getSessionId()
    {
        return $this->sessionId;
    }

    /**
     * @param $name
     * @param $value
     */
    public function put($name, $value)
    {
        $parsed     = explode('.', $name);

        $session    =& $_SESSION;

        while ( count($parsed) > 1 )
        {
            $next   = array_shift($parsed);

            if ( !isset( $session[$next] ) || !is_array( $session[$next] ) )
            {
                $session[$next]     = [];
            }

            $session                =& $session[$next];
        }

        $session[array_shift($parsed)]  = $value;

        $_SESSION                             = $session;
    }

    /**
     * @param $name
     */
    public function del($name)
    {
        $this->put($name, False);
    }

}