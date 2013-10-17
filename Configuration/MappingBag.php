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

class MappingBag implements MappingBagInterface
{
    /**
     * @var array
     */
    protected $browserMappings;

    /**
     * @var array
     */
    protected $browserFamilyMappings;

    /**
     * @var array
     */
    protected $deviceBrandMappings;

    /**
     * @var array
     */
    protected $deviceTypeMappings;

    /**
     * @var array
     */
    protected $osShortMappings;

    /**
     * @var array
     */
    protected $desktopOsMappings;

    /**
     * @var array
     */
    protected $osFamilyMappings;

    /**
     * Sets browser Mappings
     *
     * @param array $browserMappings
     *
     * @return MappingBagInterface
     */
    public function setBrowser(array $browserMappings)
    {
        $this->browserMappings = $browserMappings;
        return $this;
    }

    /**
     * Set browser family Mappings
     *
     * @param array $browserFamilyMappings
     *
     * @return MappingBagInterface
     */
    public function setBrowserFamily(array $browserFamilyMappings)
    {
        $this->browserFamilyMappings = $browserFamilyMappings;
        return $this;
    }

    /**
     * sets device brands Mappings
     *
     * @param array $deviceBrandMappings
     *
     * @return MappingBagInterface
     */
    public function setDeviceBrand(array $deviceBrandMappings)
    {
        $this->deviceBrandMappings = $deviceBrandMappings;
        return $this;
    }

    /**
     * Sets device types Mappings
     *
     * @param array $deviceTypeMappings
     *
     * @return MappingBagInterface
     */
    public function setDeviceType(array $deviceTypeMappings)
    {
        $this->deviceTypeMappings = $deviceTypeMappings;
        return $this;
    }

    /**
     * Set Os short names Mappings
     *
     * @param array $osShortMappings
     *
     * @return MappingBagInterface
     */
    public function setOsShort(array $osShortMappings)
    {
        $this->osShortMappings = $osShortMappings;
        return $this;
    }

    /**
     * Sets desktop Os names Mappings
     *
     * @param array $desktopOsMappings
     *
     * @return MappingBagInterface
     */
    public function setDesktopOs(array $desktopOsMappings)
    {
        $this->desktopOsMappings = $desktopOsMappings;
        return $this;
    }

    /**
     * sets Os family names Mappings
     *
     * @param array $osFamilyMappings
     *
     * @return MappingBagInterface
     */
    public function setOsFamily(array $osFamilyMappings)
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
