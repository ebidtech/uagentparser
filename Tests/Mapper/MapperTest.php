<?php
/*
 * This file is a part of the user agent parser.
 *
 * (c) 2013 Ebidtech
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace EBT\UAgentParser\Tests\Mapper;

use EBT\UAgentParser\Configuration\Container as ConfContainer;
use EBT\UAgentParser\Configuration\YamlFileLoader;
use EBT\UAgentParser\Mapper\Mapper;
use PHPUnit_Framework_TestCase;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Loader\LoaderResolver;
use Symfony\Component\Config\Loader\DelegatingLoader;


/**
 * Class MapperTest
 *
 * @group unit
 * @package EBT\Tests\Unit
 */
class MapperTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var ConfContainer
     */
    protected $confContainer;

    public function setUp()
    {
        parent::setUp();
        $this->confContainer = new ConfContainer();
        $yfl = new YamlFileLoader($this->confContainer, new FileLocator(__DIR__ . '/../../Resources/config/'));
        $loaderResolver = new LoaderResolver(array($yfl));
        $delegatingLoader = new DelegatingLoader($loaderResolver);
        $delegatingLoader->load('config.yml');
    }

    /**
     * Test Browser Mapping
     */
    public function testBrowserMapping()
    {
        $m1 = new Mapper();
        $m1->setMap('browser', $this->confContainer->getMappings()->getBrowser());
        $m1->setMap('browser_family', $this->confContainer->getMappings()->getBrowserFamily());
        $to = $m1->getToInMap('AB', 'browser');
        $this->assertEquals(1, $to);
        $to = $m1->getTo('AB');
        $this->assertEquals(array(1), $to);
    }

    /**
     * Test Browser Reverse Mapping
     */
    public function testBrowserReverseMapping()
    {
        $m1 = new Mapper();
        $m1->setMap('browser', $this->confContainer->getMappings()->getBrowser());
        $m1->setMap('browser_family', $this->confContainer->getMappings()->getBrowserFamily());
        $to = $m1->getFromInMap(1, 'browser');
        $this->assertEquals('AB', $to);
        $to = $m1->getFrom(1);
        $this->assertEquals(array('AB', 'Android Browser'), $to);
    }

    /**
     * Tests not found in any map.
     *
     * @expectedException \EBT\UAgentParser\Exception\ResourceNotFoundException
     */
    public function testNotFoundInAnyMap()
    {
        $m1 = new Mapper();
        $m1->setMap('browser', $this->confContainer->getMappings()->getBrowser());
        $m1->setMap('browser_family', $this->confContainer->getMappings()->getBrowserFamily());
        $m1->getTo('XXXX');
    }

    /**
     * Test all Mappings
     */
    public function testAllMappings()
    {
        $m1 = new Mapper();
        $m1->setMap('browser', $this->confContainer->getMappings()->getBrowser());
        $m1->setMap('browser_family', $this->confContainer->getMappings()->getBrowserFamily());
        $m1->setMap('desktop_os', $this->confContainer->getMappings()->getDesktopOs());
        $m1->setMap('device_brand', $this->confContainer->getMappings()->getDeviceBrand());
        $m1->setMap('device_type', $this->confContainer->getMappings()->getDeviceType());
        $m1->setMap('os_family', $this->confContainer->getMappings()->getOsFamily());
        $m1->setMap('os_short', $this->confContainer->getMappings()->getOsShort());
        $this->assertEquals('AB', $m1->getFromInMap(1, 'browser'));
        $this->assertEquals('Android Browser', $m1->getFromInMap(1, 'browser_family'));
        $this->assertEquals('IBM', $m1->getFromInMap(1, 'desktop_os'));
        $this->assertEquals('AC', $m1->getFromInMap(1, 'device_brand'));
        $this->assertEquals('desktop', $m1->getFromInMap(1, 'device_type'));
        $this->assertEquals('Android', $m1->getFromInMap(1, 'os_family'));
        $this->assertEquals('AIX', $m1->getFromInMap(1, 'os_short'));
    }

}
