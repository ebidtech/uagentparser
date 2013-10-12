<?php

/*
 * This file is a part of the user agent parser.
 *
 * (c) 2013 Ebidtech
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace EBT\UAgentParser\Configuration;

interface DefinitionBagInterface
{
    /**
     * Sets browser definitions
     *
     * @param $browserDefinitions
     *
     * @return DefinitionBagInterface
     */
    public function setBrowser($browserDefinitions);

    /**
     * Set browser family definitions
     *
     * @param $browserFamilyDefinitions
     *
     * @return DefinitionBagInterface
     */
    public function setBrowserFamily($browserFamilyDefinitions);

    /**
     * sets device brands definitions
     *
     * @param $deviceBrands
     *
     * @return DefinitionBagInterface
     */
    public function setDeviceBrand($deviceBrands);

    /**
     * Sets device types definitions
     *
     * @param $deviceTypes
     *
     * @return DefinitionBagInterface
     */
    public function setDeviceType($deviceTypes);

    /**
     * Set Os short names definitions
     *
     * @param $osShorts
     *
     * @return DefinitionBagInterface
     */
    public function setOsShort($osShorts);

    /**
     * Sets desktop Os names definitions
     *
     * @param $desktopOs
     *
     * @return DefinitionBagInterface
     */
    public function setDesktopOs($desktopOs);

    /**
     * sets Os family names definitions
     *
     * @param $osFamilies
     *
     * @return DefinitionBagInterface
     */
    public function setOsFamily($osFamilies);

    /**
     * Gets all browser definitions
     *
     * @return array
     */
    public function getBrowser();

    /**
     * Gets all browser family definitions
     *
     * @return array
     */
    public function getBrowserFamily();

    /**
     * Gets all device brand definitions
     *
     * @return array
     */
    public function getDeviceBrand();

    /**
     * Gets all device type definitions
     *
     * @return array
     */
    public function getDeviceType();

    /**
     * Gets all os short names definitions
     *
     * @return array
     */
    public function getOsShort();

    /**
     * Gets all desktop os names definitions
     *
     * @return array
     */
    public function getDesktopOs();

    /**
     * Gets all os family names definitions
     *
     * @return array
     */
    public function getOsFamily();

}