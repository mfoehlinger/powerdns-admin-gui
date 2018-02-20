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

spl_autoload_register(
    function($class)
    {
        $folder = BASEDIR;

        $folder = explode('/',$folder);

        $folder = implode(DIRECTORY_SEPARATOR, $folder);

        $class  = implode(DIRECTORY_SEPARATOR,explode('\\',$class));

        $class  = $folder.DIRECTORY_SEPARATOR.$class;

        if( file_exists( $class.'.php' ) )
        {
            require_once $class.'.php';
        }
    }
);
