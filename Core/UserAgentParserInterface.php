<?php

/*
 * This file is a part of the user agent parser.
 *
 * (c) 2013 Ebidtech
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace EBT\UAgentParser\Core;

use EBT\UAgentParser\Entities\Browser\BrowserInterface;
use EBT\UAgentParser\Entities\Device\DeviceInterface;
use EBT\UAgentParser\Entities\Os\OsInterface;

interface UserAgentParserInterface
{
    /**
     * Returns config path
     *
     * @return string
     */
    public function getConfigPath();

    /**
     * Returns main config file
     *
     * @return string
     */
    public function getConfigFile();

    /**
     * Sets the user agent string
     *
     * @param $userAgent
     *
     * @return UserAgentParserInterface
     */
    public function setUserAgent($userAgent);

    /**
     * Returns Browser
     *
     * @return BrowserInterface
     * @throws \EBT\UAgentParser\Exception\InvalidUserAgentStrException
     */
    public function getBrowser();

    /**
     * Returns Device
     *
     * @return DeviceInterface
     * @throws \EBT\UAgentParser\Exception\InvalidUserAgentStrException
     */
    public function getDevice();

    /**
     * Returns Os
     *
     * @return OsInterface
     * @throws \EBT\UAgentParser\Exception\InvalidUserAgentStrException
     */
    public function getOs();
}
