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

use EBT\UAgentParser\Configuration\ExpressionBagInterface;

class ExpressionBag implements ExpressionBagInterface
{
    protected $browserExpressions;
    protected $mobileExpressions;
    protected $osExpressions;

    /**
     * Gets all browser expressions
     *
     * @return array
     */
    public function getBrowser()
    {
        return $this->browserExpressions;
    }

    /**
     * Gets all mobile expressions
     *
     * @return array
     */
    public function getMobile()
    {
        return $this->mobileExpressions;
    }

    /**
     * Gets all Os expressions
     * @return array
     */
    public function getOs()
    {
        return $this->osExpressions;
    }

    /**
     * Set browser expressions
     *
     * @param $browserExpressions
     *
     * @return ExpressionBagInterface
     */
    public function setBrowser($browserExpressions)
    {
        $this->browserExpressions = $browserExpressions;
    }

    /**
     * Set mobile expressions
     *
     * @param $mobileExpressions
     *
     * @return ExpressionBagInterface
     */
    public function setMobile($mobileExpressions)
    {
        $this->mobileExpressions = $mobileExpressions;
    }

    /**
     * Set Os expressions
     *
     * @param $osExpressions
     *
     * @return ExpressionBagInterface
     */
    public function setOs($osExpressions)
    {
        $this->osExpressions = $osExpressions;
    }
}