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

use Symfony\Component\Config\Loader\FileLoader;
use Symfony\Component\Config\FileLocatorInterface;
use Symfony\Component\Yaml\Yaml;

class YamlFileLoader extends FileLoader
{
    protected $container;

    /**
     * Constructor
     *
     * @param ContainerInterface   $container
     * @param FileLocatorInterface $locator
     */
    public function __construct(ContainerInterface $container, FileLocatorInterface $locator)
    {
        $this->container = $container;

        parent::__construct($locator);
    }

    /**
     * Loads a Yaml file.
     *
     * @param mixed  $file The resource
     * @param string $type The resource type
     *
     * @return array|null The YAML converted to a PHP array
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function load($file, $type = null)
    {
        $path = $this->locator->locate($file);
        $content = Yaml::parse($path);

        // empty file
        if (null === $content) {
            return null;
        }

        // imports
        $this->parseImports($content, $file);

        return $content;
    }

    /**
     * Returns true if this class supports the given resource.
     *
     * @param mixed  $resource A resource
     * @param string $type     The resource type
     *
     * @return Boolean true if this class supports the given resource, false otherwise
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function supports($resource, $type = null)
    {
        return is_string($resource) && 'yml' === pathinfo($resource, PATHINFO_EXTENSION);
    }

    /**
     * Parses all imports
     *
     * @param array  $content
     * @param string $file
     */
    private function parseImports($content, $file)
    {
        if (!isset($content['imports'])) {
            return;
        }

        foreach ($content['imports'] as $import) {
            $this->setCurrentDir(dirname($file));
            $content = $this->import(
                $import['resource'],
                null,
                isset($import['ignore_errors']) ? (Boolean) $import['ignore_errors'] : false,
                $file
            );

            // parameters
            if (isset($content['parameters'])) {
                foreach ($content['parameters'] as $key => $value) {
                    $this->setContainer($key, $value);

                }
            }

        }
    }

    /**
     * @param string $key
     * @param array $value
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    private function setContainer($key, array $value)
    {
        switch ($key) {
            case 'uap_expression_browser':
                $this->container->getExpressions()->setBrowser($value);
                break;
            case 'uap_expression_mobile':
                $this->container->getExpressions()->setMobile($value);
                break;
            case 'uap_expression_os':
                $this->container->getExpressions()->setOs($value);
                break;
            case 'uap_definition_browser':
                $this->container->getDefinitions()->setBrowser($value);
                break;
            case 'uap_definition_browser_family':
                $this->container->getDefinitions()->setBrowserFamily($value);
                break;
            case 'uap_definition_device_type':
                $this->container->getDefinitions()->setDeviceType($value);
                break;
            case 'uap_definition_device_brand':
                $this->container->getDefinitions()->setDeviceBrand($value);
                break;
            case 'uap_definition_os_family':
                $this->container->getDefinitions()->setOsFamily($value);
                break;
            case 'uap_definition_desktop_os':
                $this->container->getDefinitions()->setDesktopOs($value);
                break;
            case 'uap_definition_os_short':
                $this->container->getDefinitions()->setOsShort($value);
                break;
            case 'uap_mapping_browser':
                $this->container->getMappings()->setBrowser($value);
                break;
            case 'uap_mapping_browser_family':
                $this->container->getMappings()->setBrowserFamily($value);
                break;
            case 'uap_mapping_device_type':
                $this->container->getMappings()->setDeviceType($value);
                break;
            case 'uap_mapping_device_brand':
                $this->container->getMappings()->setDeviceBrand($value);
                break;
            case 'uap_mapping_os_family':
                $this->container->getMappings()->setOsFamily($value);
                break;
            case 'uap_mapping_desktop_os':
                $this->container->getMappings()->setDesktopOs($value);
                break;
            case 'uap_mapping_os_short':
                $this->container->getMappings()->setOsShort($value);
                break;
        }
    }
}
