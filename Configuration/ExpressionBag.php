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
    /**
     * @var array
     */
    protected $browserExpressions;

    /**
     * @var array
     */
    protected $mobileExpressions;

    /**
     * @var array
     */
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
     *
     * @return array
     */
    public function getOs()
    {
        return $this->osExpressions;
    }

    /**
     * Set browser expressions
     *
     * @param array $browserExpressions
     *
     * @return ExpressionBagInterface
     */
    public function setBrowser(array $browserExpressions)
    {
        $this->browserExpressions = $browserExpressions;
    }

    /**
     * Set mobile expressions
     *
     * @param array $mobileExpressions
     *
     * @return ExpressionBagInterface
     */
    public function setMobile(array $mobileExpressions)
    {
        $this->mobileExpressions = $mobileExpressions;
    }

    /**
     * Set Os expressions
     *
     * @param array $osExpressions
     *
     * @return ExpressionBagInterface
     */
    public function setOs(array $osExpressions)
    {
        $this->osExpressions = $osExpressions;
    }
}
