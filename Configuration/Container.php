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
use EBT\UAgentParser\Configuration\DefinitionBagInterface;
use EBT\UAgentParser\Configuration\MappingBagInterface;

class Container implements ContainerInterface
{
    /**
     * @var ExpressionBagInterface
     */
    protected $expressionsBag;

    /**
     * @var DefinitionBagInterface
     */
    protected $definitionsBag;

    /**
     * @var MappingBagInterface
     */
    protected $mappingsBag;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->expressionsBag = new ExpressionBag();
        $this->definitionsBag = new DefinitionBag();
        $this->mappingsBag = new MappingBag();
    }

    /**
     * Gets all expressions
     *
     * @return ExpressionBagInterface
     */
    public function getExpressions()
    {
        return $this->expressionsBag;
    }

    /**
     * Sets all the expressions
     *
     * @param ExpressionBagInterface $expressions
     *
     * @return ContainerInterface
     */
    public function setExpressions(ExpressionBagInterface $expressions)
    {
        $this->expressionsBag = $expressions;
    }

    /**
     * Gets all definitions
     *
     * @return DefinitionBagInterface
     */
    public function getDefinitions()
    {
        return $this->definitionsBag;
    }

    /**
     * Sets all the definitions
     *
     * @param DefinitionBagInterface $definitions
     *
     * @return ContainerInterface
     */
    public function setDefinitions(DefinitionBagInterface $definitions)
    {
        $this->definitionsBag = $definitions;
    }

    /**
     * Gets all mappings
     *
     * @return MappingBagInterface
     */
    public function getMappings()
    {
        return $this->mappingsBag;
    }

    /**
     * Sets all the mappings
     *
     * @param MappingBagInterface $mappings
     *
     * @return ContainerInterface
     */
    public function setMappings(MappingBagInterface $mappings)
    {
        $this->mappingsBag = $mappings;
    }
}