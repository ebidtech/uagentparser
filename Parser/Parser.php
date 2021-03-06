<?php

/*
 * This file is a part of the user agent parser.
 *
 * (c) 2013 Ebidtech
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace EBT\UAgentParser\Parser;

use EBT\UAgentParser\Configuration\ContainerInterface as ConfContainer;
use EBT\UAgentParser\Exception\ResourceNotFoundException;

/**
 * Class Parser
 */
class Parser implements ParserInterface
{
    const DEFAULT_DEVICE_TYPE_FULL = 'desktop';
    const DEFAULT_BOT_STR = 'Bot';
    const DEFAULT_SIMULATOR_STR = 'Simulator';

    /**
     * @var ConfContainer
     */
    protected $confContainer;

    protected $userAgent;
    protected $os;
    protected $browser;
    protected $deviceType;
    protected $deviceTypeFull;
    protected $brand;
    protected $brandFullName;
    protected $modelName;
    protected $debug = false;

    protected $deviceTypes;
    protected $deviceBrands;
    protected $osShorts;
    protected $desktopOsArray;
    protected $osFamilies;
    protected $browserFamilies;
    protected $browsers;

    /**
     * Constructor
     *
     * @param ConfContainer $confContainer
     */
    public function __construct(ConfContainer $confContainer)
    {
        $this->confContainer = $confContainer;

        $this->deviceTypes = $this->getConfDeviceTypes();
        $this->deviceBrands = $this->getConfDeviceBrands();
        $this->osShorts = $this->getConfOsShorts();
        $this->desktopOsArray = $this->getConfDesktopOs();
        $this->osFamilies = $this->getConfOsFamilies();
        $this->browserFamilies = $this->getConfBrowserFamilies();
        $this->browsers = $this->getConfBrowser();
    }

    /**
     * Sets the debug mode on/off
     *
     * @param $debug
     *
     * @return $this
     */
    public function setDebugMode($debug)
    {
        $this->debug = $debug;
        return $this;
    }

    /**
     * Set User agent string to be parsed
     *
     * @param      $userAgent
     * @param bool $parseAll
     *
     * @return $this
     */
    public function setUserAgent($userAgent, $parseAll = true)
    {
        $this->userAgent = $userAgent;
        if (true == $parseAll) {
            $this->parse();
        }
        return $this;
    }

    /**
     * Returns current user agent string
     *
     * @return string
     */
    public function getUserAgent()
    {
        return $this->userAgent;
    }

    /* -------------------------------- BROWSER RELATED -------------------------------------- */
    /**
     * Returns Browser structure or attribute
     *
     * @param string $attr
     *
     * @return array|string
     *
     * @throws ResourceNotFoundException
     */
    public function getBrowser($attr = '')
    {
        if (!is_array($this->browser)) {
            throw new ResourceNotFoundException('Invalid internal browser structure.');
        }
        if ($attr == '') {
            return $this->browser;
        }
        if (!isset($this->browser[$attr])) {
            throw new ResourceNotFoundException(sprintf('Unable to find %s in browser structure.', $attr));
        }

        return $this->browser[$attr];
    }

    /**
     * Returns browser family
     *
     * @param $browserLabel
     *
     * @return string
     * @throws ResourceNotFoundException
     */
    public function getBrowserFamily($browserLabel)
    {
        foreach ($this->browserFamilies as $browserFamily => $browserShortNames) {
            if (in_array($browserLabel, $browserShortNames)) {
                return $browserFamily;
            }
        }

        throw new ResourceNotFoundException();
    }

    /* -------------------------------- DEVICE RELATED -------------------------------------- */

    /**
     * @return string
     */
    public function getDeviceBrand()
    {
        return $this->brand;
    }

    /**
     * @return string
     */
    public function getDeviceBrandFull()
    {
        return $this->brandFullName;
    }

    /**
     * @return string
     */
    public function getDeviceModelName()
    {
        return $this->modelName;
    }

    /**
     * Get Type
     *
     * @return string
     * @throws ResourceNotFoundException
     */
    public function getDeviceType()
    {
        if (false === $this->deviceType) {
            throw new ResourceNotFoundException();
        }
        return $this->deviceType;
    }

    /**
     * Get Type full name
     *
     * @return string
     * @throws ResourceNotFoundException
     */
    public function getDeviceTypeFullName()
    {
        if (false === $this->deviceType) {
            throw new ResourceNotFoundException();
        }
        return $this->deviceTypeFull;
    }

    /* -------------------------------- OS RELATED -------------------------------------- */

    /**
     * Get Os
     *
     * @param string $attr
     *
     * @return array|string
     * @throws ResourceNotFoundException
     */
    public function getOs($attr = '')
    {
        if (!is_array($this->os)) {
            throw new ResourceNotFoundException('Invalid internal Os structure.');
        }
        if ($attr == '') {
            return $this->os;
        }
        if (!isset($this->os[$attr])) {
            throw new ResourceNotFoundException(sprintf('Unable to find %s in Os structure.', $attr));
        }
        if ($attr == 'version') {
            $this->os['version'] = $this->os['version'];
        }
        return $this->os[$attr];
    }

    /**
     * Get Os Family
     *
     * @param $osLabel
     *
     * @return string
     * @throws ResourceNotFoundException
     */
    public function getOsFamily($osLabel)
    {
        $osShortName = substr($osLabel, 0, 3);

        foreach ($this->osFamilies as $osFamily => $osShortNames) {
            if (in_array($osShortName, $osShortNames)) {
                return $osFamily;
            }
        }

        throw new ResourceNotFoundException();
    }

    /**
     * Get Os Name From ID
     *
     * @param      $os
     * @param bool $ver
     *
     * @return string
     * @throws ResourceNotFoundException
     */
    public function getOsNameFromId($os, $ver = false)
    {
        $osFullName = array_search($os, $this->osShorts);
        if ($osFullName) {
            if (in_array($os, $this->osFamilies['Windows'])) {
                return $osFullName;
            } else {
                return trim($osFullName . " " . $ver);
            }
        }
        return false;
    }


    /**
     * Parse User agent and fills all internal variables
     *
     * @return $this
     */
    public function parse()
    {
        $this->parseOs();
        if ($this->isBot() || $this->isSimulator()) {
            return $this;
        }

        $this->parseBrowser();

        if ($this->isMobile()) {
            $this->parseMobile();
        } else {
            if (!is_array($this->os)) {
                /* invalid OS means unknown device */
                $this->deviceTypeFull = '';
                $this->deviceType = false;
            } else {
                /* default device - desktop  */
                $this->deviceTypeFull = self::DEFAULT_DEVICE_TYPE_FULL;
                $this->deviceType = array_search($this->deviceTypeFull, $this->deviceTypes);
            }
        }
        if ($this->debug) {
            var_dump($this->brand, $this->modelName, $this->deviceType);
        }
        return $this;
    }


    /**
     * @return bool
     */
    public function isBot()
    {
        $decodedFamily = '';
        try {
            if (array_key_exists($this->getOs('name'), $this->osShorts)) {
                $osShort = $this->osShorts[$this->getOs('name')];
            } else {
                $osShort = '';
            }
        } catch (ResourceNotFoundException $exc) {
            return false;
        }
        foreach ($this->osFamilies as $family => $familyOs) {
            if (in_array($osShort, $familyOs)) {
                $decodedFamily = $family;
                break;
            }
        }

        return $decodedFamily == self::DEFAULT_BOT_STR;
    }

    /**
     * @return bool
     */
    public function isSimulator()
    {
        $decodedFamily = '';
        try {
            if (in_array($this->getOs('name'), $this->osShorts)) {
                $osShort = $this->osShorts[$this->getOs('name')];
            } else {
                $osShort = '';
            }
        } catch (ResourceNotFoundException $exc) {
            return false;
        }
        foreach ($this->osFamilies as $family => $familyOs) {
            if (in_array($osShort, $familyOs)) {
                $decodedFamily = $family;
                break;
            }
        }
        return $decodedFamily == self::DEFAULT_SIMULATOR_STR;
    }

    /**
     * @return bool
     */
    public function isMobile()
    {
        try {
            $isMobile = !$this->isDesktop(true);
        } catch (ResourceNotFoundException $exc) {
            return false;
        }
        return $isMobile;
    }

    /**
     * @param bool $throwException
     *
     * @throws \EBT\UAgentParser\Exception\ResourceNotFoundException|\Exception
     * @return bool
     *
     */
    public function isDesktop($throwException = false)
    {
        $decodedFamily = '';
        try {
            $osName = $this->getOs('name');
        } catch (ResourceNotFoundException $exc) {
            if ($throwException) {
                throw $exc;
            }
            return false;
        }

        if (empty($osName) || empty($this->osShorts[$osName])) {
            return false;
        }

        $osShort = $this->osShorts[$osName];
        foreach ($this->osFamilies as $family => $familyOs) {
            if (in_array($osShort, $familyOs)) {
                $decodedFamily = $family;
                break;
            }
        }
        return in_array($decodedFamily, $this->desktopOsArray);
    }


    /* -------------------------------- PRIVATE / PROTECTED METHODS ----------------------------------- */


    protected function getOsRegexes()
    {
        return $this->confContainer->getExpressions()->getOs();
    }

    protected function getBrowserRegexes()
    {
        return $this->confContainer->getExpressions()->getBrowser();
    }

    protected function getMobileRegexes()
    {
        return $this->confContainer->getExpressions()->getMobile();
    }

    /**
     * Return all device types in the configuration
     *
     * @return array
     */
    protected function getConfDeviceTypes()
    {
        return $this->confContainer->getDefinitions()->getDeviceType();
    }

    /**
     * Checks if the device type name exists in the configuration
     *
     * @param string $name Name to check
     *
     * @return bool
     */
    protected function existsConfDeviceType($name)
    {
        return in_array($name, $this->getConfDeviceTypes());
    }

    /**
     * Return all device brands in the configuration
     *
     * @return array
     */
    protected function getConfDeviceBrands()
    {
        return $this->confContainer->getDefinitions()->getDeviceBrand();
    }

    /**
     * Checks if the device brand name exists in the configuration
     *
     * @param string $name Name to check
     *
     * @return bool
     */
    protected function existsConfDeviceBrands($name)
    {
        return in_array($name, $this->getConfDeviceBrands());
    }

    /**
     * Return all OS Short names in the configuration
     *
     * @return array
     */
    protected function getConfOsShorts()
    {
        return $this->confContainer->getDefinitions()->getOsShort();
    }

    /**
     * Checks if the OS Short name exists in the configuration
     *
     * @param string $name Name to check
     *
     * @return bool
     */
    protected function existsConfOsShort($name)
    {
        return in_array($name, $this->getConfOsShorts());
    }

    /**
     * Return all OsFamily names in the configuration
     *
     * @return array
     */
    protected function getConfOsFamilies()
    {
        return $this->confContainer->getDefinitions()->getOsFamily();
    }

    /**
     * Checks if the Os Family name exists in the configuration
     *
     * @param string $name Name to check
     *
     * @return bool
     */
    protected function existsConfOsFamilies($name)
    {
        return in_array($name, $this->getConfOsFamilies());
    }

    /**
     * Return all OS Desktop names in the configuration
     *
     * @return array
     */
    protected function getConfDesktopOs()
    {
        return $this->confContainer->getDefinitions()->getDesktopOs();
    }

    /**
     * Checks if the Desktop Os name exists in the configuration
     *
     * @param string $name Name to check
     *
     * @return bool
     */
    protected function existsConfDesktopOs($name)
    {
        return in_array($name, $this->getConfDesktopOs());
    }

    /**
     * Return all BrowserFamily names in the configuration
     *
     * @return array
     */
    protected function getConfBrowserFamilies()
    {
        return $this->confContainer->getDefinitions()->getBrowserFamily();
    }

    /**
     * Checks if the Browser Family name exists in the configuration
     *
     * @param string $name Name to check
     *
     * @return bool
     */
    protected function existsConfBrowserFamilies($name)
    {
        return in_array($name, $this->getConfBrowserFamilies());
    }

    /**
     * Return all Browser names in the configuration
     *
     * @return array
     */
    protected function getConfBrowser()
    {
        return $this->confContainer->getDefinitions()->getBrowser();
    }

    /**
     * Checks if the Browser Family name exists in the configuration
     *
     * @param string $name Name to check
     *
     * @return bool
     */
    protected function existsConfBrowser($name)
    {
        return in_array($name, $this->getConfBrowser());
    }

    /**
     * Parse OS
     *
     * @return bool
     */
    protected function parseOs()
    {
        $matches = false;

        foreach ($this->getOsRegexes() as $osRegex) {
            $matches = $this->matchUserAgent($osRegex['regex']);
            if ($matches) {
                break;
            }
        }

        if (!$matches) {
            return false;
        }

        if (in_array($osRegex['name'], $this->osShorts)) {
            $short = $this->osShorts[$osRegex['name']];
        } else {
            $short = 'UNK';
        }

        $this->os = array(
            'name' => $this->buildOsName($osRegex['name'], $matches),
            'short_name' => $short,
            'version' => $this->buildOsVersion($osRegex['version'], $matches)
        );

        if (array_key_exists($this->os['name'], $this->osShorts)) {
            $this->os['short_name'] = $this->osShorts[$this->os['name']];
        }

        return true;
    }

    /**
     * Parse Browser
     *
     * @return bool
     */
    protected function parseBrowser()
    {
        $matches = false;

        foreach ($this->getBrowserRegexes() as $browserRegex) {
            $matches = $this->matchUserAgent($browserRegex['regex']);
            if ($matches) {
                break;
            }
        }

        if (!$matches) {
            return false;
        }

        if (in_array($browserRegex['name'], $this->browsers)) {
            $short = array_search($browserRegex['name'], $this->browsers);
        } else {
            $short = 'NA';
        }

        $this->browser = array(
            'name' => $this->buildBrowserName($browserRegex['name'], $matches),
            'short_name' => $short,
            'version' => $this->buildBrowserVersion($browserRegex['version'], $matches)
        );

        return true;
    }

    /**
     * Parse Mobile
     */
    protected function parseMobile()
    {
        $mobileRegexes = $this->getMobileRegexes();
        $this->parseBrand($mobileRegexes);
        $this->parseModel($mobileRegexes);
    }

    /**
     * Parse Brand
     *
     * @param array $mobileRegexes
     *
     * @return bool
     */
    protected function parseBrand($mobileRegexes)
    {
        $matches = false;

        foreach ($mobileRegexes as $brand => $mobileRegex) {
            $matches = $this->matchUserAgent($mobileRegex['regex']);
            if ($matches) {
                break;
            }
        }

        if (!$matches) {
            return false;
        }
        $this->brand = array_search($brand, $this->deviceBrands);
        $this->brandFullName = $brand;

        if (isset($mobileRegex['device'])) {
            $this->deviceTypeFull = $mobileRegex['device'];
            $this->deviceType = array_search($this->deviceTypeFull, $this->deviceTypes);
        }

        if (isset($mobileRegex['model'])) {
            $this->modelName = $this->buildModel($mobileRegex['model'], $matches);
        }

        return true;
    }

    /**
     * Parse Model
     *
     * @param array $mobileRegexes
     *
     * @return bool
     */
    protected function parseModel($mobileRegexes)
    {
        $matches = false;

        if (empty($this->brand) || !empty($this->modelName)) {
            return false;
        }

        foreach ($mobileRegexes[$this->brandFullName]['models'] as $modelRegex) {
            $matches = $this->matchUserAgent($modelRegex['regex']);
            if ($matches) {
                break;
            }
        }

        if (!$matches) {
            return false;
        }

        $this->modelName = $this->buildModel($modelRegex['model'], $matches);

        if (isset($modelRegex['device'])) {
            $this->deviceTypeFull = $modelRegex['device'];
            $this->deviceType = array_search($this->deviceTypeFull, $this->deviceTypes);
        }

        return true;
    }

    protected function matchUserAgent($regex)
    {
        $regex = '/' . str_replace('/', '\/', $regex) . '/i';

        if (preg_match($regex, $this->userAgent, $matches)) {
            return $matches;
        }

        return false;
    }

    protected function buildOsName($osName, $matches)
    {
        return $this->buildByMatch($osName, $matches);
    }

    protected function buildOsVersion($osVersion, $matches)
    {
        $osVersion = $this->buildByMatch($osVersion, $matches);

        $osVersion = $this->buildByMatch($osVersion, $matches, '2');

        $osVersion = str_replace('_', '.', $osVersion);

        return $osVersion;
    }

    protected function buildBrowserName($browserName, $matches)
    {
        return $this->buildByMatch($browserName, $matches);
    }

    protected function buildBrowserVersion($browserVersion, $matches)
    {
        $browserVersion = $this->buildByMatch($browserVersion, $matches);

        $browserVersion = $this->buildByMatch($browserVersion, $matches, '2');

        $browserVersion = str_replace('_', '.', $browserVersion);

        return $browserVersion;
    }

    protected function buildModel($model, $matches)
    {
        $model = $this->buildByMatch($model, $matches);

        $model = $this->buildByMatch($model, $matches, '2');

        $model = $this->buildModelExceptions($model);

        $model = str_replace('_', ' ', $model);

        return $model;
    }

    protected function buildModelExceptions($model)
    {
        if ($this->brand == 'O2') {
            $model = preg_replace('/([a-z])([A-Z])/', '$1 $2', $model);
            $model = ucwords(str_replace('_', ' ', $model));
        }

        return $model;
    }

    /**
     * This method is used in this class for processing results of pregmatch
     * results into string containing recognized information.
     *
     * General algorithm:
     * Parsing UserAgent string consists of trying to match it against list of
     * regular expressions for three different information:
     * browser + version,
     * OS + version,
     * device manufacturer + model.
     *
     * After match has been found iteration stops, and results are processed
     * by buildByMatch.
     * As $item we get decoded name (name of browser, name of OS, name of manufacturer).
     * In array $match we recieve preg_match results containing whole string matched at index 0
     * and following matches in further indexes. Desired action now is to concatenate
     * decoded name ($item) with matches found. First step is to append first found match,
     * which is located in index=1 (that's why $nb is 1 by default).
     * In other cases, where whe know that preg_match may return more than 1 result,
     * we call buildByMatch with $nb = 2 or more, depending on what will be returned from
     * regular expression.
     *
     * Example:
     * We are parsing UserAgent of Firefox 20.0 browser.
     * UserAgentParserEnhanced calls buildBrowserName() and buildBrowserVersion() in order
     * to retrieve those information.
     * In buildBrowserName() we only have one call of buildByMatch, where passed argument
     * is regular expression testing given string for browser name. In this case, we are only
     * interrested in first hit, so no $nb parameter will be set to 1. After finding match, and calling
     * buildByMatch - we will receive just the name of browser.
     *
     * Also after decoding browser we will get list of regular expressions for this browser name
     * testing UserAgent string for version number. Again we iterate over this list, and after finding first
     * occurence - we break loop and proceed to build by match. Since browser regular expressions can
     * contain two hits (major version and minor version) in function buildBrowserVersion() we have
     * two calls to buildByMatch, one without 3rd parameter, and second with $nb set to 2.
     * This way we can retrieve version number, and assign it to object property.
     *
     * In case of mobiles.yml this schema slightly varies, but general idea is the same.
     *
     * @param        $item
     * @param        $matches
     * @param string $nb
     *
     * @return string
     */
    protected function buildByMatch($item, $matches, $nb = '1')
    {
        if (false === strpos($item, '$' . $nb)) {
            return $item;
        }

        $replace = isset($matches[$nb]) ? $matches[$nb] : '';

        return trim(str_replace('$' . $nb, $replace, $item));
    }
}
