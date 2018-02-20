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


use inc\lib\yaml\Spyc;

class yamlLoader
{
    public function __construct()
    {
    }

    /**
     * @param string $file
     * @return bool|mixed|array
     */
    public function getFileData(string $file)
    {
        $file       = str_replace(array('/','\\'),array(DIRECTORY_SEPARATOR,DIRECTORY_SEPARATOR),$file);

        if( !file_exists( $file ) )
        {
            return False;
        }

        $content    = file_get_contents($file);

        $content    = $this->prepairFileContent($content);

        return $this->getYamlArray($content);
    }

    /**
     * @param string $content
     * @return mixed
     */
    private function prepairFileContent(string $content)
    {
        return str_replace("\t","    ", $content);
    }

    /**
     * @param string $content
     * @return mixed
     */
    private function getYamlArray(string $content)
    {
        return Spyc::YAMLLoad($content);
    }
}