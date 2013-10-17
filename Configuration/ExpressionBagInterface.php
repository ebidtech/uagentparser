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

interface ExpressionBagInterface
{
    /**
     * Gets all browser expressions
     *
     * @return array
     */
    public function getBrowser();

    /**
     * Gets all mobile expressions
     *
     * @return array
     */
    public function getMobile();


    /**
     * Gets all Os expressions
     * @return array
     */
    public function getOs();

    /**
     * Set browser expressions
     *
     * @param array $browserExpressions
     *
     * @return ExpressionBagInterface
     */
    public function setBrowser(array $browserExpressions);

    /**
     * Set mobile expressions
     *
     * @param array $mobileExpressions
     *
     * @return ExpressionBagInterface
     */
    public function setMobile(array $mobileExpressions);

    /**
     * Set Os expressions
     *
     * @param array $osExpressions
     *
     * @return ExpressionBagInterface
     */
    public function setOs(array $osExpressions);
}
