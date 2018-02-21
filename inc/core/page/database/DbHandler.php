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

namespace inc\core\page\database;


class DbHandler
{
    private $dbHandler;

    private $dbFilesDir;

    /**
     * DbHandler constructor.
     */
    public function __construct()
    {
        $this->dbHandler    = new \inc\core\database\DbHandler();

        $this->dbFilesDir   = __DIR__.DIRECTORY_SEPARATOR.'files'.DIRECTORY_SEPARATOR;
    }

    /**
     * @return array
     */
    public function getAllSystemUrls()
    {
        $this->dbHandler->queryFile($this->dbFilesDir.__FUNCTION__.'.select');

        $result = $this->dbHandler->getResultArray();

        return $result;
    }

    public function getDefaultSystemFallback()
    {
        $this->dbHandler->queryFile($this->dbFilesDir.__FUNCTION__.'.select');

        $result = $this->dbHandler->getSingleArray();

        return $result;
    }
}