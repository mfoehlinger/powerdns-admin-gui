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


use inc\core\session\sessionHandler;

class clientAccessHandler
{
    /**
     * @param string $userGroup
     * @param string $userRight
     * @return bool
     */
    public static function checkAccess(string $userGroup, string $userRight = '')
    {
        $session            = new sessionHandler();

        $userGroupRights    = $session->get('user.access');

        if( !isset( $userGroupRights[$userGroup] ) )
        {
            return False;
        }

        if( $userRight == '' )
        {
            return True;
        }

        if( !isset( $userGroupRights[$userGroup][$userRight] ) )
        {
            return False;
        }

        return True;
    }

}