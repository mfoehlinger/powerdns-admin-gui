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

namespace inc\core\register;


class singleton
{
    private static $instances = array();

    public static function init ()
    {
        $class  = get_called_class();

        if ( empty( self::$instances[$class] ) )
        {
            $rc                         = new \ReflectionClass($class);

            self::$instances[$class]    = $rc->newInstanceArgs(func_get_args());
        }

        return self::$instances[$class];
    }
}