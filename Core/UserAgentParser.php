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
use Symfony\Component\Config\Definition\Exception\Exception;
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
    const USER_AGENT_NULL_ID = 0;
    const USER_AGENT_NULL_STR = 'NA';
    const USER_AGENT_NULL_STR_LONG = 'Not Available';
    const USER_AGENT_UNKNOWN_ID = 1;
    const USER_AGENT_UNKNOWN_STR = 'UNK';
    const USER_AGENT_UNKNOWN_STR_LONG = 'Unknown';

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

    /**
     * @var bool
     */
    protected $rebuildBrowser = true;

    /**
     * @var bool
     */
    protected $rebuildDevice = true;

    /**
     * @var bool
     */
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
            $this->rebuildBrowser = $this->rebuildDevice = $this->rebuildOs = true;
            $this->parser = new Parser($this->confContainer);
            $this->browser = new Browser();
            $this->device = new Device();
            $this->os = new Os();
            $this->parser->setUserAgent($userAgent);
        }
        return $this;
    }

    /**
     * Returns Browser
     *
     * @param bool $throwExceptionIfNotFound
     *
     * @throws InvalidUserAgentStrException
     * @throws ResourceNotFoundException
     *
     * @return BrowserInterface
     *
     */
    public function getBrowser($throwExceptionIfNotFound = false)
    {
        if (is_null($this->parser->getUserAgent()) ||
            strlen($this->parser->getUserAgent()) < self::USER_AGENT_STRING_MIN_LENGTH
        ) {
            throw new InvalidUserAgentStrException();
        }

        if ($this->rebuildBrowser) {
            try {
                $browserStruct = $this->parser->getBrowser();
                $browserShortName = self::getFromArray($browserStruct, 'short_name');
                $browserName = self::getFromArray($browserStruct, 'name');
                $browserId = $this->mapper->getToInMap($browserShortName, self::MAP_NAME_BROWSER);
            } catch (ResourceNotFoundException $exc) {
                if ($throwExceptionIfNotFound) {
                    throw $exc;
                } else {
                    $browserShortName = self::USER_AGENT_UNKNOWN_STR;
                    $browserName = self::USER_AGENT_UNKNOWN_STR_LONG;
                    $browserId = self::USER_AGENT_UNKNOWN_ID;
                }
            }

            $this->browser
                ->setNameShort($browserShortName)
                ->setName($browserName)
                ->setId($browserId);

            try {
                $famShortName = $famName = $this->parser->getBrowserFamily($browserShortName);
                $famId = $this->mapper->getToInMap($famShortName, self::MAP_NAME_BROWSER_FAMILY);

            } catch (ResourceNotFoundException $exc) {
                if ($throwExceptionIfNotFound) {
                    throw $exc;
                } else {
                    $famShortName = self::USER_AGENT_UNKNOWN_STR;
                    $famName = self::USER_AGENT_UNKNOWN_STR_LONG;
                    $famId = self::USER_AGENT_UNKNOWN_ID;
                }
            }
            /* create browser family  */
            $bFam = new BrowserFamily();
            $bFam->setNameShort($famShortName)
                ->setName($famName)
                ->setId($famId);
            $this->browser->setFamily($bFam);
            $this->rebuildBrowser = false;
        }

        return $this->browser;
    }

    /**
     * Returns Device
     *
     * @param bool $throwExceptionIfNotFound
     *
     * @throws InvalidUserAgentStrException
     * @throws ResourceNotFoundException
     * @return DeviceInterface
     */
    public function getDevice($throwExceptionIfNotFound = false)
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
                    ->setNameShort(self::USER_AGENT_UNKNOWN_STR) /* TODO  - for now just working with raw device name */
                    ->setName($this->parser->getDeviceModelName())
                    ->setId(self::USER_AGENT_UNKNOWN_ID);
                try {
                    $deviceBrandShort = $this->parser->getDeviceBrand();
                    $deviceBrandFull = $this->parser->getDeviceBrandFull();
                    $deviceBrandId = $this->mapper->getToInMap($deviceBrandShort, self::MAP_NAME_DEVICE_BRAND);
                } catch (ResourceNotFoundException $exc) {
                    if ($throwExceptionIfNotFound) {
                        throw $exc;
                    } else {
                        $deviceBrandShort = self::USER_AGENT_UNKNOWN_STR;
                        $deviceBrandFull = self::USER_AGENT_UNKNOWN_STR_LONG;
                        $deviceBrandId = self::USER_AGENT_UNKNOWN_ID;
                    }
                }
                $dBrand->setNameShort($deviceBrandShort)
                    ->setName($deviceBrandFull)
                    ->setId($deviceBrandId);

            } else {
                /* When this is not a device return NULL/Not Available */
                $this->device
                    ->setNameShort(self::USER_AGENT_NULL_STR)
                    ->setName(self::USER_AGENT_NULL_STR_LONG)
                    ->setId(self::USER_AGENT_NULL_ID);
                $dBrand->setNameShort(self::USER_AGENT_NULL_STR)
                    ->setName(self::USER_AGENT_NULL_STR_LONG)
                    ->setId(self::USER_AGENT_NULL_ID);
            }

            /* DEVICE TYPE */
            try {
                $deviceTypeShort = $this->parser->getDeviceType();
                $deviceTypeFull = $this->parser->getDeviceTypeFullName();
                $deviceTypedId = $this->mapper->getToInMap($deviceTypeShort, self::MAP_NAME_DEVICE_TYPE);

            } catch (ResourceNotFoundException $exc) {
                if ($throwExceptionIfNotFound) {
                    throw $exc;
                } else {
                    $deviceTypeShort = self::USER_AGENT_UNKNOWN_STR;
                    $deviceTypeFull = self::USER_AGENT_UNKNOWN_STR_LONG;
                    $deviceTypedId = self::USER_AGENT_UNKNOWN_ID;
                }
            }
            $dType->setName($deviceTypeFull)
                ->setNameShort($deviceTypeShort)
                ->setId($deviceTypedId);
            $this->device->setBrand($dBrand);
            $this->device->setType($dType);
            $this->rebuildDevice = false;
        }

        return $this->device;
    }

    /**
     * Returns Os
     *
     * @param bool $throwExceptionIfNotFound
     *
     * @throws InvalidUserAgentStrException
     * @throws ResourceNotFoundException
     * @return OsInterface
     */
    public function getOs($throwExceptionIfNotFound = false)
    {
        if (is_null($this->parser->getUserAgent()) ||
            strlen($this->parser->getUserAgent()) < self::USER_AGENT_STRING_MIN_LENGTH
        ) {
            throw new InvalidUserAgentStrException();
        }

        if ($this->rebuildOs) {

            try {
                $osStruct = $this->parser->getOs();
                $osName = self::getFromArray($osStruct, 'name');
                $osShortName = self::getFromArray($osStruct, 'short_name');
                $osId = $this->mapper->getToInMap($osName, self::MAP_NAME_OS_SHORT);
            } catch (ResourceNotFoundException $exc) {
                if ($throwExceptionIfNotFound) {
                    throw $exc;
                } else {
                    $osShortName = self::USER_AGENT_UNKNOWN_STR;
                    $osName = self::USER_AGENT_UNKNOWN_STR_LONG;
                    $osId = self::USER_AGENT_UNKNOWN_ID;
                }
            }
            $this->os
                ->setNameShort($osShortName)
                ->setName($osName)
                ->setId($osId);
            try {
                $famShortName = $famName = $this->parser->getOsFamily($osShortName);
                $famId = $this->mapper->getToInMap($famShortName, self::MAP_NAME_OS_FAMILY);
            } catch (ResourceNotFoundException $exc) {
                if ($throwExceptionIfNotFound) {
                    throw $exc;
                } else {
                    $famShortName = self::USER_AGENT_UNKNOWN_STR;
                    $famName = self::USER_AGENT_UNKNOWN_STR_LONG;
                    $famId = self::USER_AGENT_UNKNOWN_ID;
                }
            }
            $oFam = new OsFamily();
            $oFam->setNameShort($famShortName)
                ->setName($famName)
                ->setId($famId);
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
