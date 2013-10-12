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
 * Class ParserInterface
 *
 * @package EBT\Parser
 */
interface ParserInterface
{
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
     * Get Device Model
     *
     * @return string
     */
    public function getDeviceModelName();

    /**
     * Get Brand
     *
     * @return string
     */
    public function getDeviceBrand();

    /**
     * Get Type
     *
     * @return string
     */
    public function getDeviceType();

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