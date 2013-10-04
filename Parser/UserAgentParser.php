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
 * Class UserAgentParser
 *
 * @package EBT\Parser
 */
class UserAgentParser implements UserAgentParserInterface
{
    const UNKNOWN = "UNK";
    protected $userAgent;
    protected $os;
    protected $browser;
    protected $device;
    protected $brand;
    protected $model;
    protected $debug = false;

    /**
     * @var ConfContainer
     */
    protected $confContainer;

    /**
     * Constructor
     *
     * @param ConfContainer $confContainer
     */
    public function __construct(ConfContainer $confContainer)
    {
        $this->confContainer = $confContainer;
    }

    /**
     * Return all device types in the configuration
     *
     * @return array
     */
    public function getConfDeviceTypes()
    {
        return $this->confContainer->getMappings()->getDeviceType();
    }

    /**
     * Checks if the device type name exists in the configuration
     *
     * @param $name name to check
     *
     * @return bool
     */
    public function existsConfDeviceType($name)
    {
        return in_array($name, $this->getConfDeviceTypes());
    }

    /**
     * Return all device brands in the configuration
     *
     * @return array
     */
    public function getConfDeviceBrands()
    {
        return $this->confContainer->getMappings()->getDeviceBrand();
    }

    /**
     * Checks if the device brand name exists in the configuration
     *
     * @param $name name to check
     *
     * @return bool
     */
    public function existsConfDeviceBrands($name)
    {
        return in_array($name, $this->getConfDeviceBrands());
    }

    /**
     * Return all OS Short names in the configuration
     *
     * @return array
     */
    public function getConfOsShorts()
    {
        return $this->confContainer->getMappings()->getOsShort();
    }

    /**
     * Checks if the OS Short name exists in the configuration
     *
     * @param $name name to check
     *
     * @return bool
     */
    public function existsConfOsShort($name)
    {
        return in_array($name, $this->getConfOsShorts());
    }

    /**
     * Return all OsFamily names in the configuration
     *
     * @return array
     */
    public function getConfOsFamilies()
    {
        return $this->confContainer->getMappings()->getOsFamily();
    }

    /**
     * Checks if the Os Family name exists in the configuration
     *
     * @param $name name to check
     *
     * @return bool
     */
    public function existsConfOsFamilies($name)
    {
        return in_array($name, $this->getConfOsFamilies());
    }

    /**
     * Return all OS Desktop names in the configuration
     *
     * @return array
     */
    public function getConfDesktopOs()
    {
        return $this->confContainer->getMappings()->getDesktopOs();
    }

    /**
     * Checks if the Desktop Os name exists in the configuration
     *
     * @param $name name to check
     *
     * @return bool
     */
    public function existsConfDesktopOs($name)
    {
        return in_array($name, $this->getConfDesktopOs());
    }

    /**
     * Return all BrowserFamily names in the configuration
     *
     * @return array
     */
    public function getConfBrowserFamilies()
    {
        return $this->confContainer->getMappings()->getBrowserFamily();
    }

    /**
     * Checks if the Browser Family name exists in the configuration
     *
     * @param $name name to check
     *
     * @return bool
     */
    public function existsConfBrowserFamilies($name)
    {
        return in_array($name, $this->getConfBrowserFamilies());
    }

    /**
     * Return all Browser names in the configuration
     *
     * @return array
     */
    public function getConfBrowser()
    {
        return $this->confContainer->getMappings()->getBrowser();
    }

    /**
     * Checks if the Browser Family name exists in the configuration
     *
     * @param $name name to check
     *
     * @return bool
     */
    public function existsConfBrowser($name)
    {
        return in_array($name, $this->getConfBrowser());
    }

    /**
     * {@inheritDoc}
     */
    public function parse()
    {
        $this->parseOs();
        if ($this->isBot() || $this->isSimulator())
            return;

        $this->parseBrowser();

        if ($this->isMobile()) {
            $this->parseMobile();
        } else {
            $this->device = array_search('desktop', $this->getConfDeviceTypes());
        }
        if ($this->debug) {
            var_dump($this->brand, $this->model, $this->device);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function setUserAgent($userAgent, $parseAll = True)
    {
        $this->userAgent = $userAgent;
        if ($parseAll) {
            $this->parse();
        }

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function isBot()
    {
        $decodedFamily = '';
        $osShort = $this->getConfOsShorts();
        if (in_array($this->getOs('name'), $osShort)) {
            $osShort = $osShort[$this->getOs('name')];
        } else {
            $osShort = '';
        }
        foreach ($this->getConfOsFamilies() as $family => $familyOs) {
            if (in_array($osShort, $familyOs)) {
                $decodedFamily = $family;
                break;
            }
        }

        return $decodedFamily == 'Bot';
    }

    /**
     * {@inheritDoc}
     */
    public function isSimulator()
    {
        $decodedFamily = '';
        $osShort = $this->getConfOsShorts();
        if (in_array($this->getOs('name'), $osShort)) {
            $osShort = $osShort[$this->getOs('name')];
        } else {
            $osShort = '';
        }
        foreach ($this->getConfOsFamilies() as $family => $familyOs) {
            if (in_array($osShort, $familyOs)) {
                $decodedFamily = $family;
                break;
            }
        }
        return $decodedFamily == 'Simulator';
    }

    /**
     * {@inheritDoc}
     */
    public function isMobile()
    {
        return !$this->isDesktop();
    }

    /**
     * {@inheritDoc}
     */
    public function isDesktop()
    {
        $osName = $this->getOs('name');
        $osShort = $this->getConfOsShorts();
        if (empty($osName) || empty($osShort[$osName])) {
            return false;
        }

        $osShort = $this->getConfOsShorts($osName);
        foreach ($this->getConfOsFamilies() as $family => $familyOs) {
            if (in_array($osShort, $familyOs)) {
                $decodedFamily = $family;
                break;
            }
        }
        return in_array($decodedFamily, $this->getConfDesktopOs());
    }

    /**
     * {@inheritDoc}
     */
    public function getOs($attr = '')
    {
        if ($attr == '') {
            return $this->os;
        }

        if (!isset($this->os[$attr])) {
            return self::UNKNOWN;
        }

        if ($attr == 'version') {
            $this->os['version'] = $this->os['version'];
        }
        return $this->os[$attr];
    }

    /**
     * {@inheritDoc}
     */
    public function getBrowser($attr = '')
    {
        if ($attr == '') {
            return $this->browser;
        }

        if (!isset($this->browser[$attr])) {
            return self::UNKNOWN;
        }

        return $this->browser[$attr];
    }

    /**
     * {@inheritDoc}
     */
    public function getDevice()
    {
        return $this->device;
    }

    /**
     * {@inheritDoc}
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * {@inheritDoc}
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * {@inheritDoc}
     */
    public function getUserAgent()
    {
        return $this->userAgent;
    }

    /**
     * {@inheritDoc}
     */
    public function getOsFamily($osLabel)
    {
        $osShortName = substr($osLabel, 0, 3);

        foreach ($this->getConfOsFamilies() as $osFamily => $osShortNames) {
            if (in_array($osShortName, $osShortNames)) {
                return $osFamily;
            }
        }

        return 'Other';
    }

    /**
     * {@inheritDoc}
     */
    public function getBrowserFamily($browserLabel)
    {
        foreach ($this->getConfBrowserFamilies() as $browserFamily => $browserShortNames) {
            if (in_array($browserLabel, $browserShortNames)) {
                return $browserFamily;
            }
        }

        return 'Other';
    }

    /**
     * {@inheritDoc}
     */
    public function getOsNameFromId($os, $ver = false)
    {
        $osFullName = array_search($os, $this->getConfOsShorts());
        if ($osFullName) {
            if (in_array($os, $this->getConfOsFamilies('Windows'))) {
                return $osFullName;
            } else {
                return trim($osFullName . " " . $ver);
            }
        }
        return false;
    }

    /**
     * ParseOs
     */
    protected function parseOs()
    {
        foreach ($this->confContainer->getExpressions()->getOs() as $osRegex) {
            $matches = $this->matchUserAgent($osRegex['regex']);
            if ($matches)
                break;
        }

        if (!$matches)
            return;

        if (in_array($osRegex['name'], $this->getConfOsShorts())) {
            $short = $this->getConfOsShorts($osRegex['name']);
        } else {
            $short = 'UNK';
        }

        $this->os = array(
            'name' => $this->buildOsName($osRegex['name'], $matches),
            'short_name' => $short,
            'version' => $this->buildOsVersion($osRegex['version'], $matches)
        );

        if (array_key_exists($this->os['name'], $this->getConfOsShorts())) {
            $this->os['short_name'] = $this->getConfOsShorts($this->os['name']);
        }
    }

    /**
     * Parse Browser
     */
    protected function parseBrowser()
    {
        foreach ($this->confContainer->getExpressions()->getBrowser() as $browserRegex) {
            $matches = $this->matchUserAgent($browserRegex['regex']);
            if ($matches)
                break;
        }

        if (!$matches)
            return;

        if (in_array($browserRegex['name'], $this->getConfBrowser())) {
            $short = array_search($browserRegex['name'], $this->getConfBrowser());
        } else {
            $short = 'XX';
        }

        $this->browser = array(
            'name' => $this->buildBrowserName($browserRegex['name'], $matches),
            'short_name' => $short,
            'version' => $this->buildBrowserVersion($browserRegex['version'], $matches)
        );
    }

    /**
     * Parse Mobile
     */
    protected function parseMobile()
    {
        $mobileRegexes = $this->confContainer->getExpressions()->getMobile();
        $this->parseBrand($mobileRegexes);
        $this->parseModel($mobileRegexes);
    }

    /**
     * Parse Brand
     *
     * @param $mobileRegexes
     */
    protected function parseBrand($mobileRegexes)
    {
        foreach ($mobileRegexes as $brand => $mobileRegex) {
            $matches = $this->matchUserAgent($mobileRegex['regex']);
            if ($matches)
                break;
        }

        if (!$matches)
            return;
        $this->brand = array_search($brand, $this->getConfDeviceBrands());
        $this->fullName = $brand;

        if (isset($mobileRegex['device'])) {
            $this->device = array_search($mobileRegex['device'], $this->getConfDeviceTypes());
        }

        if (isset($mobileRegex['model'])) {
            $this->model = $this->buildModel($mobileRegex['model'], $matches);
        }
    }

    /**
     * Parse Model
     *
     * @param $mobileRegexes
     */
    protected function parseModel($mobileRegexes)
    {
        if (empty($this->brand) || !empty($this->model))
            return;

        foreach ($mobileRegexes[$this->fullName]['models'] as $modelRegex) {
            $matches = $this->matchUserAgent($modelRegex['regex']);
            if ($matches)
                break;
        }

        if (!$matches) {
            return;
        }

        $this->model = $this->buildModel($modelRegex['model'], $matches);

        if (isset($modelRegex['device'])) {
            $this->device = array_search($modelRegex['device'], $this->getConfDeviceTypes());
        }
    }

    /**
     * Match User Agent
     *
     * @param $regex
     *
     * @return bool
     */
    protected function matchUserAgent($regex)
    {
        $regex = '/' . str_replace('/', '\/', $regex) . '/i';

        if (preg_match($regex, $this->userAgent, $matches)) {
            return $matches;
        }

        return false;
    }

    /**
     * Build OS Name
     *
     * @param $osName
     * @param $matches
     *
     * @return type
     */
    protected function buildOsName($osName, $matches)
    {
        return $this->buildByMatch($osName, $matches);
    }

    /**
     * Build Os Version
     *
     * @param $osVersion
     * @param $matches
     *
     * @return mixed
     */
    protected function buildOsVersion($osVersion, $matches)
    {
        $osVersion = $this->buildByMatch($osVersion, $matches);

        $osVersion = $this->buildByMatch($osVersion, $matches, '2');

        $osVersion = str_replace('_', '.', $osVersion);

        return $osVersion;
    }

    /**
     * Build Browser Name
     *
     * @param $browserName
     * @param $matches
     *
     * @return type
     */
    protected function buildBrowserName($browserName, $matches)
    {
        return $this->buildByMatch($browserName, $matches);
    }

    /*
     * Build Browser Version
     */
    protected function buildBrowserVersion($browserVersion, $matches)
    {
        $browserVersion = $this->buildByMatch($browserVersion, $matches);

        $browserVersion = $this->buildByMatch($browserVersion, $matches, '2');

        $browserVersion = str_replace('_', '.', $browserVersion);

        return $browserVersion;
    }

    /**
     * Build Model
     *
     * @param $model
     * @param $matches
     *
     * @return mixed
     */
    protected function buildModel($model, $matches)
    {
        $model = $this->buildByMatch($model, $matches);

        $model = $this->buildByMatch($model, $matches, '2');

        $model = $this->buildModelExceptions($model);

        $model = str_replace('_', ' ', $model);

        return $model;
    }

    /**
     * Build Model Exceptions
     *
     * @param $model
     *
     * @return string
     */
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
        if (strpos($item, '$' . $nb) === false)
            return $item;

        $replace = isset($matches[$nb]) ? $matches[$nb] : '';
        return trim(str_replace('$' . $nb, $replace, $item));
    }

    /**
     * Return a key from an array or full array if no key specified
     *
     * @param      $source
     * @param      $key
     * @param bool $returnNullWhenNotFound
     *
     * @return array|null
     * @throws \InvalidArgumentException
     * @throws ResourceNotFoundException
     */
    protected function getExistingGeneral($source, $key, $returnNullWhenNotFound = false)
    {
        if (!is_array($source) || $source == array()) {
            $valueType = gettype($source);
            $type = ($valueType == 'array') ? 'empty array' : $valueType;

            throw new \InvalidArgumentException(
                sprintf(
                    '%s() expects parameter "%s" to be array not empty, "%s" given.',
                    __METHOD__,
                    1,
                    $type
                )
            );
        }
        if (is_null($key)) {
            return $source;
        } else {
            if (array_key_exists($key, $source)) {
                return $source[$key];
            } else {
                if(!$returnNullWhenNotFound){
                    throw new ResourceNotFoundException('Unable to find key: ' . $key);
                }else{
                    return null;
                }

            }
        }
    }

}