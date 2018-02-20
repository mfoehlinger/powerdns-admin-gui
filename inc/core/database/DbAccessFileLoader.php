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

namespace inc\core\database;


use inc\core\loader\yamlLoader;

class DbAccessFileLoader
{
    private $dbAccessFile;

    public function __construct()
    {
        $this->dbAccessFile =   BASEDIR.DIRECTORY_SEPARATOR.'inc'.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'database'.DIRECTORY_SEPARATOR.'database.cfg';
    }

    public function getDbAccessArray()
    {
        if( !file_exists( $this->dbAccessFile ) )
        {
            return False;
        }

        $yamlLoader         = new yamlLoader();

        return $yamlLoader->getFileData($this->dbAccessFile);
    }
}