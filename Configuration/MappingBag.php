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
     * Sets browser Mappings
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
     * Set browser family Mappings
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
     * sets device brands Mappings
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
     * Sets device types Mappings
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
     * Set Os short names Mappings
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
     * Sets desktop Os names Mappings
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
     * sets Os family names Mappings
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
     * Gets all browser Mappings
     *
     * @return array
     */
    public function getBrowser()
    {
        return $this->browserMappings;
    }

    /**
     * Gets all browser family Mappings
     *
     * @return array
     */
    public function getBrowserFamily()
    {
        return $this->browserFamilyMappings;
    }

    /**
     * Gets all device brand Mappings
     *
     * @return array
     */
    public function getDeviceBrand()
    {
        return $this->deviceBrandMappings;
    }

    /**
     * Gets all device type Mappings
     *
     * @return array
     */
    public function getDeviceType()
    {
        return $this->deviceTypeMappings;
    }

    /**
     * Gets all os short names Mappings
     *
     * @return array
     */
    public function getOsShort()
    {
        return $this->osShortMappings;
    }

    /**
     * Gets all desktop os names Mappings
     *
     * @return array
     */
    public function getDesktopOs()
    {
        return $this->desktopOsMappings;
    }

    /**
     * Gets all os family names Mappings
     *
     * @return array
     */
    public function getOsFamily()
    {
        return $this->osFamilyMappings;
    }
}