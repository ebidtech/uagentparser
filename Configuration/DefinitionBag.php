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

class DefinitionBag implements DefinitionBagInterface
{
    /**
     * @var array
     */
    protected $browserDefinitions;

    /**
     * @var array
     */
    protected $browserFamilyDefinitions;

    /**
     * @var array
     */
    protected $deviceBrandDefinitions;

    /**
     * @var array
     */
    protected $deviceTypeDefinitions;

    /**
     * @var array
     */
    protected $osShortDefinitions;

    /**
     * @var array
     */
    protected $desktopOsDefinitions;

    /**
     * @var array
     */
    protected $osFamilyDefinitions;

    /**
     * Sets browser Definitions
     *
     * @param array $browserDefinitions
     *
     * @return DefinitionBagInterface
     */
    public function setBrowser(array $browserDefinitions)
    {
        $this->browserDefinitions = $browserDefinitions;
        return $this;
    }

    /**
     * Set browser family Definitions
     *
     * @param array $browserFamilyDefinitions
     *
     * @return DefinitionBagInterface
     */
    public function setBrowserFamily(array $browserFamilyDefinitions)
    {
        $this->browserFamilyDefinitions = $browserFamilyDefinitions;
        return $this;
    }

    /**
     * sets device brands Definitions
     *
     * @param array $deviceBrandDefinitions
     *
     * @return DefinitionBagInterface
     */
    public function setDeviceBrand(array $deviceBrandDefinitions)
    {
        $this->deviceBrandDefinitions = $deviceBrandDefinitions;
        return $this;
    }

    /**
     * Sets device types Definitions
     *
     * @param array $deviceTypeDefinitions
     *
     * @return DefinitionBagInterface
     */
    public function setDeviceType(array $deviceTypeDefinitions)
    {
        $this->deviceTypeDefinitions = $deviceTypeDefinitions;
        return $this;
    }

    /**
     * Set Os short names Definitions
     *
     * @param array $osShortDefinitions
     *
     * @return DefinitionBagInterface
     */
    public function setOsShort(array $osShortDefinitions)
    {
        $this->osShortDefinitions = $osShortDefinitions;
        return $this;
    }

    /**
     * Sets desktop Os names Definitions
     *
     * @param array $desktopOsDefinitions
     *
     * @return DefinitionBagInterface
     */
    public function setDesktopOs(array $desktopOsDefinitions)
    {
        $this->desktopOsDefinitions = $desktopOsDefinitions;
        return $this;
    }

    /**
     * sets Os family names Definitions
     *
     * @param array $osFamilyDefinitions
     *
     * @return DefinitionBagInterface
     */
    public function setOsFamily(array $osFamilyDefinitions)
    {
        $this->osFamilyDefinitions = $osFamilyDefinitions;
        return $this;
    }

    /**
     * Gets all browser Definitions
     *
     * @return array
     */
    public function getBrowser()
    {
        return $this->browserDefinitions;
    }

    /**
     * Gets all browser family Definitions
     *
     * @return array
     */
    public function getBrowserFamily()
    {
        return $this->browserFamilyDefinitions;
    }

    /**
     * Gets all device brand Definitions
     *
     * @return array
     */
    public function getDeviceBrand()
    {
        return $this->deviceBrandDefinitions;
    }

    /**
     * Gets all device type Definitions
     *
     * @return array
     */
    public function getDeviceType()
    {
        return $this->deviceTypeDefinitions;
    }

    /**
     * Gets all os short names Definitions
     *
     * @return array
     */
    public function getOsShort()
    {
        return $this->osShortDefinitions;
    }

    /**
     * Gets all desktop os names Definitions
     *
     * @return array
     */
    public function getDesktopOs()
    {
        return $this->desktopOsDefinitions;
    }

    /**
     * Gets all os family names Definitions
     *
     * @return array
     */
    public function getOsFamily()
    {
        return $this->osFamilyDefinitions;
    }
}
