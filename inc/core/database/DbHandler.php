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


class DbHandler
{
    private $dbh;

    private $dsn        = NULL;

    private $error;

    private $stmt;

    public $query;

    /**
     * DbHandler constructor.
     * @param string $dbType
     * @param array  $dbAccess
     * @return bool
     */
    public function __construct(string $dbType = 'postgresql', array $dbAccess = array())
    {
        if(
            !isset( $dbAccess['host'] ) ||
            !isset( $dbAccess['port'] ) ||
            !isset( $dbAccess['table'] ) ||
            !isset( $dbAccess['user'] ) ||
            !isset( $dbAccess['password'] )
        )
        {
            $dbAccessFileLoader = new DbAccessFileLoader();

            $dbAccess   = $dbAccessFileLoader->getDbAccessArray();
        }

        $dbType             = strtolower($dbType);

        if(
            !isset( $dbAccess['host'] ) ||
            !isset( $dbAccess['port'] ) ||
            !isset( $dbAccess['table'] ) ||
            !isset( $dbAccess['user'] ) ||
            !isset( $dbAccess['password'] )
        )
        {
            return False;
        }

        switch ($dbType)
        {
            case 'postgresql':
                $this->connectPostgreSQL($dbAccess);
                break;
            default:
                $this->connectPostgreSQL($dbAccess);
        }

        try
        {
            $this->dbh = new \PDO($this->dsn);
        }

        catch(\PDOException $e)
        {
            $this->error = $e->getMessage();
        }

        return True;
    }

    /**
     * @param array $dbAccess
     */
    private function connectPostgreSQL(array $dbAccess)
    {
        $this->dsn  = "pgsql:host=".$dbAccess['host'].";port=5432;dbname=".$dbAccess['table'].";user=".$dbAccess['user'].";password=".$dbAccess['password'];
    }

    /**
     * @param string $query
     */
    public function query(string $query)
    {
        $this->query    = $query;
    }

    /**
     * @return bool
     */
    public function execute()
    {
        $this->stmt     = $this->dbh->prepare($this->query);

        return $this->stmt->execute();
    }

    /**
     * @param string $paramter
     * @param string $value
     * @param bool   $quotes
     */
    public function bind(string $paramter, string $value, bool $quotes = True)
    {
        $this->replaceBind($paramter, $value, $quotes);
    }

    /**
     * @param string $param
     * @param string $value
     * @param bool   $quotas
     */
    public function replaceBind(string $param, string $value, bool $quotas)
    {
        $replace        = $quotas === true ? "'".$value."'" : $value;

        $this->query    = str_replace($param, $replace, $this->query);
    }

    /**
     * @return array
     */
    public function getSingleArray()
    {
        return $this->getSingle();
    }

    /**
     * @return array
     */
    private function getSingle()
    {
        $this->execute();

        return $this->stmt->fetch(\PDO::FETCH_ASSOC);;
    }

    /**
     * @return array
     */
    public function getResultArray()
    {
        return $this->getResults();
    }

    /**
     * @return array
     */
    private function getResults()
    {
        $this->execute();

        return $this->stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

}