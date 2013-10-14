<?php

/*
 * This file is a part of the user agent parser.
 *
 * (c) 2013 Ebidtech
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace EBT\UAgentParser\Core;

use EBT\UAgentParser\Entities\Browser\Browser;
use EBT\UAgentParser\Entities\Os\Os;
use EBT\UAgentParser\Entities\Device\Device;
use EBT\UAgentParser\Exception\ResourceNotFoundException;
use EBT\UAgentParser\Exception\InvalidUserAgentStrException;
use EBT\UAgentParser\Parser\Parser;
use EBT\UAgentParser\Configuration\Container as ConfContainer;
use EBT\UAgentParser\Mapper\Mapper;
use EBT\UAgentParser\Configuration\YamlFileLoader;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Loader\LoaderResolver;
use Symfony\Component\Config\Loader\DelegatingLoader;
use EBT\UAgentParser\Entities\Browser\BrowserInterface;
use EBT\UAgentParser\Entities\Device\DeviceInterface;
use EBT\UAgentParser\Entities\Os\OsInterface;
use EBT\UAgentParser\Entities\Browser\Family\Family as BrowserFamily;
use EBT\UAgentParser\Entities\Os\Family\Family as OsFamily;
use EBT\UAgentParser\Entities\Device\Brand\Brand as DeviceBrand;

use EBT\UAgentParser\Entities\Device\Type\Type as DeviceType;

/**
 * Class UserAgentParser
 */
class UserAgentParser implements UserAgentParserInterface
{
    const MAP_NAME_BROWSER = 'browser';
    const MAP_NAME_BROWSER_FAMILY = 'browser_family';
    const MAP_NAME_DESKTOP_OS = 'desktop_os';
    const MAP_NAME_DEVICE_BRAND = 'device_brand';
    const MAP_NAME_DEVICE_TYPE = 'device_type';
    const MAP_NAME_OS_FAMILY = 'os_family';
    const MAP_NAME_OS_SHORT = 'os_short';
    const USER_AGENT_STRING_MIN_LENGTH = 10;


    /**
     * @var ConfContainer
     */
    protected $confContainer;

    /**
     * @var Parser
     */
    protected $parser;

    /**
     * @var Mapper
     */
    protected $mapper;

    /**
     * @var BrowserInterface
     */
    protected $browser;

    /**
     * @var DeviceInterface
     */
    protected $device;

    /**
     * @var OsInterface
     */
    protected $os;

    protected $rebuildBrowser = true;
    protected $rebuildDevice = true;
    protected $rebuildOs = true;


    /**
     * Constructor
     *
     * @param null $userAgent
     */
    public function __construct($userAgent = null)
    {
        $this->confContainer = new ConfContainer();
        $yfl = new YamlFileLoader($this->confContainer, new FileLocator($this->getConfigPath()));
        $loaderResolver = new LoaderResolver(array($yfl));
        $delegatingLoader = new DelegatingLoader($loaderResolver);
        $delegatingLoader->load($this->getConfigFile());
        $this->parser = new Parser($this->confContainer);
        $this->mapper = new Mapper();
        $this->mapper->setMap(self::MAP_NAME_BROWSER, $this->confContainer->getMappings()->getBrowser());
        $this->mapper->setMap(self::MAP_NAME_BROWSER_FAMILY, $this->confContainer->getMappings()->getBrowserFamily());
        $this->mapper->setMap(self::MAP_NAME_DESKTOP_OS, $this->confContainer->getMappings()->getDesktopOs());
        $this->mapper->setMap(self::MAP_NAME_DEVICE_BRAND, $this->confContainer->getMappings()->getDeviceBrand());
        $this->mapper->setMap(self::MAP_NAME_DEVICE_TYPE, $this->confContainer->getMappings()->getDeviceType());
        $this->mapper->setMap(self::MAP_NAME_OS_FAMILY, $this->confContainer->getMappings()->getOsFamily());
        $this->mapper->setMap(self::MAP_NAME_OS_SHORT, $this->confContainer->getMappings()->getOsShort());
        $this->browser = new Browser();
        $this->device = new Device();
        $this->os = new Os();
        if (!is_null($userAgent)) {
            $this->setUserAgent($userAgent);
        }
    }

    /**
     * Returns config path
     *
     * @return string
     */
    public function getConfigPath()
    {
        return __DIR__ . '/../Resources/config/';
    }

    /**
     * Returns main config file
     *
     * @return string
     */
    public function getConfigFile()
    {
        return 'config.yml';
    }

    /**
     * Sets the user agent string
     *
     * @param $userAgent
     *
     * @return UserAgentParserInterface
     */
    public function setUserAgent($userAgent)
    {
        if ($userAgent != $this->parser->getUserAgent()) {
            $this->parser->setUserAgent($userAgent);
            $this->rebuildBrowser = true;
            $this->rebuildDevice = true;
            $this->rebuildOs = true;
        }
        return $this;
    }

    /**
     * Returns Browser
     *
     * @return BrowserInterface
     * @throws \EBT\UAgentParser\Exception\InvalidUserAgentStrException
     */
    public function getBrowser()
    {
        if (is_null($this->parser->getUserAgent()) ||
            strlen($this->parser->getUserAgent()) < self::USER_AGENT_STRING_MIN_LENGTH
        ) {
            throw new InvalidUserAgentStrException();
        }
        if ($this->rebuildBrowser) {
            $shortName = self::getFromArray($this->parser->getBrowser(), 'short_name');
            $this->browser
                ->setNameShort($shortName)
                ->setName(self::getFromArray($this->parser->getBrowser(), 'name'))
                ->setId($this->mapper->getToInMap($shortName, self::MAP_NAME_BROWSER));
            $famShortName = $this->parser->getBrowserFamily($shortName);
            $bFam = new BrowserFamily();
            $bFam->setNameShort($famShortName)
                ->setName($famShortName)
                ->setId($this->mapper->getToInMap($famShortName, self::MAP_NAME_BROWSER_FAMILY));
            $this->browser->setFamily($bFam);
            $this->rebuildBrowser = false;
        }
        return $this->browser;
    }

    /**
     * Returns Device
     *
     * @return DeviceInterface
     * @throws \EBT\UAgentParser\Exception\InvalidUserAgentStrException
     */
    public function getDevice()
    {
        if (is_null($this->parser->getUserAgent()) ||
            strlen($this->parser->getUserAgent()) < self::USER_AGENT_STRING_MIN_LENGTH
        ) {
            throw new InvalidUserAgentStrException();
        }
        if ($this->rebuildDevice) {
            $dBrand = new DeviceBrand();
            $dType = new DeviceType();
            if ($this->parser->isMobile()) {
                $this->device
                    ->setNameShort('NA')/* TODO  - for now just working with raw device name */
                    ->setName($this->parser->getDeviceModelName())
                    ->setId(0);
                /* TODO */
                $dBrand->setNameShort($this->parser->getDeviceBrand())
                    ->setName($this->parser->getDeviceBrandFull())
                    ->setId($this->mapper->getToInMap($this->parser->getDeviceBrand(), self::MAP_NAME_DEVICE_BRAND));
            } else {
                $this->device
                    ->setNameShort('NA')
                    ->setName('NA')
                    ->setId(0);
                $dBrand->setNameShort('NA')
                    ->setName('NA')
                    ->setId(0);
            }
            $dType->setName($this->parser->getDeviceTypeFullName())
                ->setNameShort($this->parser->getDeviceType())
                ->setId($this->mapper->getToInMap($this->parser->getDeviceType(), self::MAP_NAME_DEVICE_TYPE));
            $this->device->setBrand($dBrand);
            $this->device->setType($dType);
            $this->rebuildDevice = false;
        }

        return $this->device;
    }

    /**
     * Returns Os
     *
     * @return OsInterface
     * @throws \EBT\UAgentParser\Exception\InvalidUserAgentStrException
     */
    public function getOs()
    {
        if (is_null($this->parser->getUserAgent()) ||
            strlen($this->parser->getUserAgent()) < self::USER_AGENT_STRING_MIN_LENGTH
        ) {
            throw new InvalidUserAgentStrException();
        }
        if ($this->rebuildOs) {
            $name = self::getFromArray($this->parser->getOs(), 'name');
            $shortName = self::getFromArray($this->parser->getOs(), 'short_name');
            $this->os
                ->setNameShort($shortName)
                ->setName($name)
                ->setId($this->mapper->getToInMap($name, self::MAP_NAME_OS_SHORT));
            $famShortName = $this->parser->getOsFamily($shortName);
            $oFam = new OsFamily();
            $oFam->setNameShort($famShortName)
                ->setName($famShortName)
                ->setId($this->mapper->getToInMap($famShortName, self::MAP_NAME_OS_FAMILY));
            $this->os->setFamily($oFam);
            $this->rebuildOs = false;
        }
        return $this->os;
    }


    /**
     * Get value from an array
     *
     * @param $arr
     * @param $key
     *
     * @return mixed
     * @throws ResourceNotFoundException
     */
    protected static function getFromArray($arr, $key)
    {
        if (is_array($arr) && array_key_exists($key, $arr)) {
            return $arr[$key];
        } else {
            throw new ResourceNotFoundException;
        }
    }
}
