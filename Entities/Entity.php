<?php
/*
 * This file is a part of the user agent parser.
 *
 * (c) 2013 Ebidtech
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace EBT\UAgentParser\Entities;

/**
 * Class Entity
 */
abstract class Entity implements EntityInterface
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $nameShort;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getNameShort()
    {
        return $this->nameShort;
    }

    /**
     * @param $id
     *
     * @return EntityInterface
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @param $name
     *
     * @return EntityInterface
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @param $nameShort
     *
     * @return EntityInterface
     */
    public function setNameShort($nameShort)
    {
        $this->nameShort = $nameShort;
        return $this;
    }
}
