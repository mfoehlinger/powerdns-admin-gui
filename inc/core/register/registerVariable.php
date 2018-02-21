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


class registerVariable
{
    private static $variables = array();

    /**
     * @param string $variable
     * @param        $value
     */
    public static function set(string $variable, $value)
    {
        self::$variables[$variable] = $value;
    }

    /**
     * @param string $variable
     * @return bool|mixed
     */
    public static function get(string $variable)
    {
        return isset( self::$variables[$variable] ) ? self::$variables[$variable] : False;
    }
}