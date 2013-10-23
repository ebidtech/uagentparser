<?php
/*
 * This file is a part of the user agent parser.
 *
 * (c) 2013 Ebidtech
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace EBT\UAgentParser\Tests\Parser;

use EBT\UAgentParser\Configuration\Container as ConfContainer;
use EBT\UAgentParser\Configuration\YamlFileLoader;
use PHPUnit_Framework_TestCase;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Loader\LoaderResolver;
use Symfony\Component\Config\Loader\DelegatingLoader;
use EBT\UAgentParser\Parser\Parser;

/**
 * Class UserAgentParserTest
 *
 * @group unit
 */
class UserAgentParserTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var ConfContainer
     */
    protected $confContainer;

    /**
     * @var Parser
     */
    protected $ua;

    public function setUp()
    {
        parent::setUp();
        $this->confContainer = new ConfContainer();
        $yfl = new YamlFileLoader($this->confContainer, new FileLocator(__DIR__ . '/../../Resources/config/'));
        $loaderResolver = new LoaderResolver(array($yfl));
        $delegatingLoader = new DelegatingLoader($loaderResolver);
        $delegatingLoader->load('config.yml');
        $this->ua = new Parser($this->confContainer);
    }

    /**
     * Test if Definitions are being read from YAML
     */
    public function testDefArrays()
    {
        $this->assertTrue(is_array($this->confContainer->getDefinitions()->getDeviceType()));
        $this->assertTrue(is_array($this->confContainer->getDefinitions()->getDeviceBrand()));
        $this->assertTrue(is_array($this->confContainer->getDefinitions()->getOsShort()));
        $this->assertTrue(is_array($this->confContainer->getDefinitions()->getDesktopOs()));
        $this->assertTrue(is_array($this->confContainer->getDefinitions()->getOsFamily()));
        $this->assertTrue(is_array($this->confContainer->getDefinitions()->getBrowserFamily()));
        $this->assertTrue(is_array($this->confContainer->getDefinitions()->getBrowser()));
    }

    /**
     * testGetOs
     */
    public function testGetOs()
    {
        $uaStr = 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) ';
        $uaStr .= 'Chrome/29.0.1547.76 Safari/537.36';
        $this->ua->setUserAgent($uaStr);
        $b = $this->ua->getOs();
        $this->assertEquals('Linux', $b['name']);
        $this->assertEquals('LIN', $b['short_name']);
    }

    /**
     * testGetBrowser
     */
    public function testGetBrowser()
    {
        $uaStr = 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) ';
        $uaStr .= 'Chrome/29.0.1547.76 Safari/537.36';
        $this->ua->setUserAgent($uaStr);
        $b = $this->ua->getBrowser();
        $this->assertEquals('Chrome', $b['name']);
        $this->assertEquals('CH', $b['short_name']);
    }

    /**
     * test if is a Bot
     */
    public function testIsBot()
    {
        $uaStr = 'Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)';
        $this->ua->setUserAgent($uaStr);
        $this->assertTrue($this->ua->isBot());
    }

    /**
     * test if is mobile
     */
    public function testIsMobile()
    {
        $uaStr = 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) ';
        $uaStr .= 'Chrome/29.0.1547.76 Safari/537.36';
        $this->ua->setUserAgent($uaStr);
        $this->assertFalse($this->ua->isMobile());
        $uaStr = 'Mozilla/5.0 (iPhone; CPU iPhone OS 5_0 like Mac OS X) AppleWebKit/534.46 ';
        $uaStr .= '(KHTML, like Gecko) Version/5.1 Mobile/9A334 Safari/7534.48.3';
        $this->ua->setUserAgent($uaStr);
        $this->assertTrue($this->ua->isMobile());
    }
}
