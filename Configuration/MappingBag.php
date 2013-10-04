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

use EBT\UAgentParser\Configuration\MappingBagInterface;

class MappingBag implements MappingBagInterface
{
    protected $browserMappings;
    protected $browserFamilyMappings;
    protected $deviceBrandMappings;
    protected $deviceTypeMappings;
    protected $osShortMappings;
    protected $desktopOsMappings;
    protected $osFamilyMappings;

    /**
     * Sets browser mappings
     *
     * @param $browserMappings
     *
     * @return MappingBagInterface
     */
    public function setBrowser($browserMappings)
    {
        $this->browserMappings = $browserMappings;
        return $this;
    }

    /**
     * Set browser family mappings
     *
     * @param $browserFamilyMappings
     *
     * @return MappingBagInterface
     */
    public function setBrowserFamily($browserFamilyMappings)
    {
        $this->browserFamilyMappings = $browserFamilyMappings;
        return $this;
    }

    /**
     * sets device brands mappings
     *
     * @param $deviceBrandMappings
     *
     * @return MappingBagInterface
     */
    public function setDeviceBrand($deviceBrandMappings)
    {
        $this->deviceBrandMappings = $deviceBrandMappings;
        return $this;
    }

    /**
     * Sets device types mappings
     *
     * @param $deviceTypeMappings
     *
     * @return MappingBagInterface
     */
    public function setDeviceType($deviceTypeMappings)
    {
        $this->deviceTypeMappings = $deviceTypeMappings;
        return $this;
    }

    /**
     * Set Os short names mappings
     *
     * @param $osShortMappings
     *
     * @return MappingBagInterface
     */
    public function setOsShort($osShortMappings)
    {
        $this->osShortMappings = $osShortMappings;
        return $this;
    }

    /**
     * Sets desktop Os names mappings
     *
     * @param $desktopOsMappings
     *
     * @return MappingBagInterface
     */
    public function setDesktopOs($desktopOsMappings)
    {
        $this->desktopOsMappings = $desktopOsMappings;
        return $this;
    }

    /**
     * sets Os family names mappings
     *
     * @param $osFamilyMappings
     *
     * @return MappingBagInterface
     */
    public function setOsFamily($osFamilyMappings)
    {
        $this->osFamilyMappings = $osFamilyMappings;
        return $this;
    }

    /**
     * Gets all browser mappings
     *
     * @return array
     */
    public function getBrowser()
    {
        return $this->browserMappings;
    }

    /**
     * Gets all browser family mappings
     *
     * @return array
     */
    public function getBrowserFamily()
    {
        return $this->browserFamilyMappings;
    }

    /**
     * Gets all device brand mappings
     *
     * @return array
     */
    public function getDeviceBrand()
    {
        return $this->deviceBrandMappings;
    }

    /**
     * Gets all device type mappings
     *
     * @return array
     */
    public function getDeviceType()
    {
        return $this->deviceTypeMappings;
    }

    /**
     * Gets all os short names mappings
     *
     * @return array
     */
    public function getOsShort()
    {
        return $this->osShortMappings;
    }

    /**
     * Gets all desktop os names mappings
     *
     * @return array
     */
    public function getDesktopOs()
    {
        return $this->desktopOsMappings;
    }

    /**
     * Gets all os family names mappings
     *
     * @return array
     */
    public function getOsFamily()
    {
        return $this->osFamilyMappings;
    }
}