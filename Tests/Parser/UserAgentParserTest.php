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
use EBT\UAgentParser\Parser\UserAgentParser;

/**
 * Class UserAgentParserTest
 *
 * @package EBT\Tests\Unit
 */
class UserAgentParserTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var ConfContainer
     */
    protected $confContainer;

    public function setUp()
    {
        $this->confContainer = new ConfContainer();
        $yfl = new YamlFileLoader($this->confContainer, new FileLocator(__DIR__ . '/../../Resources/config/'));
        $loaderResolver = new LoaderResolver(array($yfl));
        $delegatingLoader = new DelegatingLoader($loaderResolver);
        $delegatingLoader->load('config.yml');
        parent::setUp();
    }

    /**
     * testGetOs
     *
     * @group unit
     */
    public function testGetOs()
    {
        $uaStr = 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) ';
        $uaStr .= 'Chrome/29.0.1547.76 Safari/537.36';
        $ua = new UserAgentParser($this->confContainer);
        $ua->setUserAgent($uaStr);
        $b = $ua->getOs();
        $this->assertEquals('Linux', $b['name']);
    }

    /**
     * testGetBrowser
     *
     * @group unit
     */
    public function testGetBrowser()
    {
        $uaStr = 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) ';
        $uaStr .= 'Chrome/29.0.1547.76 Safari/537.36';
        $ua = new UserAgentParser($this->confContainer);
        $ua->setUserAgent($uaStr);
        $b = $ua->getBrowser();
        $this->assertEquals('Chrome', $b['name']);
    }
}
