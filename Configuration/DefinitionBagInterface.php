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
     * @param array $browserDefinitions
     *
     * @return DefinitionBagInterface
     */
    public function setBrowser(array $browserDefinitions);

    /**
     * Set browser family definitions
     *
     * @param array $browserFamilyDefinitions
     *
     * @return DefinitionBagInterface
     */
    public function setBrowserFamily(array $browserFamilyDefinitions);

    /**
     * sets device brands definitions
     *
     * @param array $deviceBrands
     *
     * @return DefinitionBagInterface
     */
    public function setDeviceBrand(array $deviceBrands);

    /**
     * Sets device types definitions
     *
     * @param array $deviceTypes
     *
     * @return DefinitionBagInterface
     */
    public function setDeviceType(array $deviceTypes);

    /**
     * Set Os short names definitions
     *
     * @param array $osShorts
     *
     * @return DefinitionBagInterface
     */
    public function setOsShort(array $osShorts);

    /**
     * Sets desktop Os names definitions
     *
     * @param array $desktopOs
     *
     * @return DefinitionBagInterface
     */
    public function setDesktopOs(array $desktopOs);

    /**
     * sets Os family names definitions
     *
     * @param array $osFamilies
     *
     * @return DefinitionBagInterface
     */
    public function setOsFamily(array $osFamilies);

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
