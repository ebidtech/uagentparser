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

interface MappingBagInterface
{
    /**
     * Sets browser mappings
     *
     * @param $browserMappings
     *
     * @return MappingBagInterface
     */
    public function setBrowser($browserMappings);

    /**
     * Set browser family mappings
     *
     * @param $browserFamilyMappings
     *
     * @return MappingBagInterface
     */
    public function setBrowserFamily($browserFamilyMappings);

    /**
     * sets device brands mappings
     *
     * @param $deviceBrands
     *
     * @return MappingBagInterface
     */
    public function setDeviceBrand($deviceBrands);

    /**
     * Sets device types mappings
     *
     * @param $deviceTypes
     *
     * @return MappingBagInterface
     */
    public function setDeviceType($deviceTypes);

    /**
     * Set Os short names mappings
     *
     * @param $osShorts
     *
     * @return MappingBagInterface
     */
    public function setOsShort($osShorts);

    /**
     * Sets desktop Os names mappings
     *
     * @param $desktopOs
     *
     * @return MappingBagInterface
     */
    public function setDesktopOs($desktopOs);

    /**
     * sets Os family names mappings
     *
     * @param $osFamilies
     *
     * @return MappingBagInterface
     */
    public function setOsFamily($osFamilies);

    /**
     * Gets all browser mappings
     *
     * @return array
     */
    public function getBrowser();

    /**
     * Gets all browser family mappings
     *
     * @return array
     */
    public function getBrowserFamily();

    /**
     * Gets all device brand mappings
     *
     * @return array
     */
    public function getDeviceBrand();

    /**
     * Gets all device type mappings
     *
     * @return array
     */
    public function getDeviceType();

    /**
     * Gets all os short names mappings
     *
     * @return array
     */
    public function getOsShort();

    /**
     * Gets all desktop os names mappings
     *
     * @return array
     */
    public function getDesktopOs();

    /**
     * Gets all os family names mappings
     *
     * @return array
     */
    public function getOsFamily();
}
