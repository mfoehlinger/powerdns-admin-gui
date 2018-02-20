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

namespace inc\core\loader;


class refelctionLoader
{
    private $reflectionMethod;

    private $class;

    private $data;

    /**
     * refelctionLoader constructor.
     * @param string $class
     * @param string $function
     * @param array  $data
     * @throws \ReflectionException
     */

    public function __construct(string $class, string $function,array $data = array())
    {
        $this->class            = $class;

        $this->data             = $data;

        $this->reflectionMethod = new \ReflectionMethod($this->class, $function);
    }

    /**
     * @return mixed
     */
    public function invokde()
    {
        return $this->reflectionMethod->invokeArgs(new $this->class, array($this->data));
    }
}