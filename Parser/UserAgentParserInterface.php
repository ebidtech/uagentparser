<?php

/*
 * This file is a part of the user agent parser.
 *
 * (c) 2013 Ebidtech
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace EBT\UAgentParser\Parser;

/**
 * Class UserAgentParserInterface
 *
 * @package EBT\Parser
 */
interface UserAgentParserInterface
{

    /**
     * Return all device types in the configuration
     *
     * @return array
     */
    public function getConfDeviceTypes();

    /**
     * Checks if the device type name exists in the configuration
     *
     * @param $name name to check
     *
     * @return bool
     */
    public function existsConfDeviceType($name);

    /**
     * Return all device brands in the configuration
     *
     * @return array
     */
    public function getConfDeviceBrands();

    /**
     * Checks if the device brand name exists in the configuration
     *
     * @param $name name to check
     *
     * @return bool
     */
    public function existsConfDeviceBrands($name);

    /**
     * Return all OS Desktop names in the configuration
     *
     * @return array
     */
    public function getConfDesktopOs();

    /**
     * Checks if the Desktop Os name exists in the configuration
     *
     * @param $name name to check
     *
     * @return bool
     */
    public function existsConfDesktopOs($name);

    /**
     * Return all OS Short names in the configuration
     *
     * @return array
     */
    public function getConfOsShorts();

    /**
     * Checks if the OS Short name exists in the configuration
     *
     * @param $name name to check
     *
     * @return bool
     */
    public function existsConfOsShort($name);

    /**
     * Return all OsFamily names in the configuration
     *
     * @return array
     */
    public function getConfOsFamilies();

    /**
     * Checks if the Os Family name exists in the configuration
     *
     * @param $name name to check
     *
     * @return bool
     */
    public function existsConfOsFamilies($name);

    /**
     * Return all BrowserFamily names in the configuration
     *
     * @return array
     */
    public function getConfBrowserFamilies();

    /**
     * Checks if the Browser Family name exists in the configuration
     *
     * @param $name name to check
     *
     * @return bool
     */
    public function existsConfBrowserFamilies($name);

    /**
     * Return all Browser names in the configuration
     *
     * @return array
     */
    public function getConfBrowser();

    /**
     * Checks if the Browser Family name exists in the configuration
     *
     * @param $name name to check
     *
     * @return bool
     */
    public function existsConfBrowser($name);

    /**
     * Parses user agent and fills all internal values
     */
    public function parse();

    /**
     * Set User agent string to be parsed
     *
     * @param      $userAgent
     * @param bool $parseAll
     *
     * @return $this
     */
    public function setUserAgent($userAgent, $parseAll);

    /**
     * Check if user agent is a bot
     *
     * @return bool true if user agent is a bot
     */
    public function isBot();

    /**
     * Check if user agent is a simulator
     *
     * @return bool
     */
    public function isSimulator();

    /**
     * Check if user agent is a mobile
     *
     * @return bool
     */
    public function isMobile();

    /**
     * Check if user agent is a Desktop
     *
     * @return bool
     */
    public function isDesktop();

    /**
     * Get OS
     *
     * @param string $attr
     *
     * @return array
     */
    public function getOs($attr);

    /**
     * Get Browser
     *
     * @param string $attr
     *
     * @return array
     */
    public function getBrowser($attr);

    /**
     * Get Device
     *
     * @return array
     */
    public function getDevice();

    /**
     * Get Brand
     *
     * @return array
     */
    public function getBrand();

    /**
     * Get Model
     *
     * @return array
     */
    public function getModel();

    /**
     * Get current User Agent
     *
     * @return string
     */
    public function getUserAgent();

    /**
     * Gets the OS Family
     *
     * @param $osLabel
     *
     * @return array
     */
    public function getOsFamily($osLabel);

    /**
     * Gets the Browser Family
     *
     * @param $browserLabel
     *
     * @return array
     */
    public function getBrowserFamily($browserLabel);

    /**
     * Gets the OS Name from ID
     *
     * @param $os
     * @param $ver
     *
     * @return array
     */
    public function getOsNameFromId($os, $ver);

}