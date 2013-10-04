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

interface ContainerInterface
{
    /**
     * Gets all expressions
     *
     * @return ExpressionBagInterface
     */
    public function getExpressions();

    /**
     * Sets all the expressions
     *
     * @param ExpressionBagInterface $expressions
     *
     * @return ContainerInterface
     */
    public function setExpressions(ExpressionBagInterface $expressions);

    /**
     * Gets all mappings
     *
     * @return MappingBagInterface
     */
    public function getMappings();

    /**
     * Sets all the mappings
     *
     * @param MappingBagInterface $mappings
     *
     * @return ContainerInterface
     */
    public function setMappings(MappingBagInterface $mappings);
}