<?php
/*
 * This file is a part of the user agent parser.
 *
 * (c) 2013 Ebidtech
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace EBT\UAgentParser\Tests\Core;

use PHPUnit_Framework_TestCase;
use EBT\UAgentParser\Core\UserAgentParser;


/**
 * Class UserAgentParserTest
 *
 * @group   functional
 */
class UserAgentParserTest extends PHPUnit_Framework_TestCase
{

    /**
     * Test Browser related methods
     *
     */
    public function testBrowser()
    {
        $uaStr = 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) ';
        $uaStr .= 'Chrome/29.0.1547.76 Safari/537.36';
        $uap = new UserAgentParser($uaStr);
        $this->assertEquals('Chrome', $uap->getBrowser()->getName());
        $this->assertEquals('CH', $uap->getBrowser()->getNameShort());
        $this->assertEquals(13, $uap->getBrowser()->getId());
        $this->assertEquals('Chrome', $uap->getBrowser()->getFamily()->getName());
        $this->assertEquals('Chrome', $uap->getBrowser()->getFamily()->getNameShort());
        $this->assertEquals(3, $uap->getBrowser()->getFamily()->getId());

        $uaStr = 'Mozilla/5.0 (iPhone; CPU iPhone OS 5_0 like Mac OS X) AppleWebKit/534.46 ';
        $uaStr .= '(KHTML, like Gecko) Version/5.1 Mobile/9A334 Safari/7534.48.3';
        $uap->setUserAgent($uaStr);
        $this->assertEquals('Mobile Safari', $uap->getBrowser()->getName());
        $this->assertEquals('MF', $uap->getBrowser()->getNameShort());
        $this->assertEquals(49, $uap->getBrowser()->getId());
        $this->assertEquals('Safari', $uap->getBrowser()->getFamily()->getName());
        $this->assertEquals('Safari', $uap->getBrowser()->getFamily()->getNameShort());
        $this->assertEquals(10, $uap->getBrowser()->getFamily()->getId());
    }

    /**
     * Test OS related methods
     *
     */
    public function testOs()
    {
        $uaStr = 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) ';
        $uaStr .= 'Chrome/29.0.1547.76 Safari/537.36';
        $uap = new UserAgentParser($uaStr);
        $this->assertEquals('Linux', $uap->getOs()->getName());
        $this->assertEquals('LIN', $uap->getOs()->getNameShort());
        $this->assertEquals(24, $uap->getOs()->getId());
        $this->assertEquals('Linux', $uap->getOs()->getFamily()->getName());
        $this->assertEquals('Linux', $uap->getOs()->getFamily()->getNameShort());
        $this->assertEquals(12, $uap->getOs()->getFamily()->getId());

        $uaStr = 'Mozilla/5.0 (iPhone; CPU iPhone OS 5_0 like Mac OS X) AppleWebKit/534.46 ';
        $uaStr .= '(KHTML, like Gecko) Version/5.1 Mobile/9A334 Safari/7534.48.3';
        $uap->setUserAgent($uaStr);
        $this->assertEquals('iOS', $uap->getOs()->getName());
        $this->assertEquals('IOS', $uap->getOs()->getNameShort());
        $this->assertEquals(74, $uap->getOs()->getId());
        $this->assertEquals('iOS', $uap->getOs()->getFamily()->getName());
        $this->assertEquals('iOS', $uap->getOs()->getFamily()->getNameShort());
        $this->assertEquals(11, $uap->getOs()->getFamily()->getId());
    }

    /**
     * Test Device related methods
     *
     */
    public function testDevice()
    {
        $uaStr = 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) ';
        $uaStr .= 'Chrome/29.0.1547.76 Safari/537.36';
        $uap = new UserAgentParser($uaStr);
        $this->assertEquals('NA', $uap->getDevice()->getName());
        $this->assertEquals('NA', $uap->getDevice()->getNameShort());
        $this->assertEquals(0, $uap->getDevice()->getId());
        $this->assertEquals('NA', $uap->getDevice()->getBrand()->getName());
        $this->assertEquals('NA', $uap->getDevice()->getBrand()->getNameShort());
        $this->assertEquals(0, $uap->getDevice()->getBrand()->getId());
        $this->assertEquals('desktop', $uap->getDevice()->getType()->getName());
        $this->assertEquals('desktop', $uap->getDevice()->getType()->getNameShort());
        $this->assertEquals(1, $uap->getDevice()->getType()->getId());

        $uaStr = 'Mozilla/5.0 (iPhone; CPU iPhone OS 5_0 like Mac OS X) AppleWebKit/534.46 ';
        $uaStr .= '(KHTML, like Gecko) Version/5.1 Mobile/9A334 Safari/7534.48.3';
        $uap = new UserAgentParser($uaStr);
        $this->assertEquals('iPhone', $uap->getDevice()->getName());
        $this->assertEquals('NA', $uap->getDevice()->getNameShort());
        $this->assertEquals(0, $uap->getDevice()->getId());
        $this->assertEquals('Apple', $uap->getDevice()->getBrand()->getName());
        $this->assertEquals('AP', $uap->getDevice()->getBrand()->getNameShort());
        $this->assertEquals(5, $uap->getDevice()->getBrand()->getId());
        $this->assertEquals('smartphone', $uap->getDevice()->getType()->getName());
        $this->assertEquals('smartphone', $uap->getDevice()->getType()->getNameShort());
        $this->assertEquals(2, $uap->getDevice()->getType()->getId());

        $uaStr  = 'Mozilla/5.0 (Linux; U; Android 4.0.4; en-gb; GT-I9300 Build/IMM76D) ';
        $uaStr .='AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30';
        $uap = new UserAgentParser($uaStr);
        $this->assertEquals('GT-I9300', $uap->getDevice()->getName());
        $this->assertEquals('NA', $uap->getDevice()->getNameShort());
        $this->assertEquals(0, $uap->getDevice()->getId());
        $this->assertEquals('Samsung', $uap->getDevice()->getBrand()->getName());
        $this->assertEquals('SA', $uap->getDevice()->getBrand()->getNameShort());
        $this->assertEquals(75, $uap->getDevice()->getBrand()->getId());
        $this->assertEquals('smartphone', $uap->getDevice()->getType()->getName());
        $this->assertEquals('smartphone', $uap->getDevice()->getType()->getNameShort());
        $this->assertEquals(2, $uap->getDevice()->getType()->getId());


    }
}
