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

use EBT\UAgentParser\Configuration\DefinitionBagInterface;

class DefinitionBag implements DefinitionBagInterface
{
    protected $browserDefinitions;
    protected $browserFamilyDefinitions;
    protected $deviceBrandDefinitions;
    protected $deviceTypeDefinitions;
    protected $osShortDefinitions;
    protected $desktopOsDefinitions;
    protected $osFamilyDefinitions;

    /**
     * Sets browser Definitions
     *
     * @param $browserDefinitions
     *
     * @return DefinitionBagInterface
     */
    public function setBrowser($browserDefinitions)
    {
        $this->browserDefinitions = $browserDefinitions;
        return $this;
    }

    /**
     * Set browser family Definitions
     *
     * @param $browserFamilyDefinitions
     *
     * @return DefinitionBagInterface
     */
    public function setBrowserFamily($browserFamilyDefinitions)
    {
        $this->browserFamilyDefinitions = $browserFamilyDefinitions;
        return $this;
    }

    /**
     * sets device brands Definitions
     *
     * @param $deviceBrandDefinitions
     *
     * @return DefinitionBagInterface
     */
    public function setDeviceBrand($deviceBrandDefinitions)
    {
        $this->deviceBrandDefinitions = $deviceBrandDefinitions;
        return $this;
    }

    /**
     * Sets device types Definitions
     *
     * @param $deviceTypeDefinitions
     *
     * @return DefinitionBagInterface
     */
    public function setDeviceType($deviceTypeDefinitions)
    {
        $this->deviceTypeDefinitions = $deviceTypeDefinitions;
        return $this;
    }

    /**
     * Set Os short names Definitions
     *
     * @param $osShortDefinitions
     *
     * @return DefinitionBagInterface
     */
    public function setOsShort($osShortDefinitions)
    {
        $this->osShortDefinitions = $osShortDefinitions;
        return $this;
    }

    /**
     * Sets desktop Os names Definitions
     *
     * @param $desktopOsDefinitions
     *
     * @return DefinitionBagInterface
     */
    public function setDesktopOs($desktopOsDefinitions)
    {
        $this->desktopOsDefinitions = $desktopOsDefinitions;
        return $this;
    }

    /**
     * sets Os family names Definitions
     *
     * @param $osFamilyDefinitions
     *
     * @return DefinitionBagInterface
     */
    public function setOsFamily($osFamilyDefinitions)
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
