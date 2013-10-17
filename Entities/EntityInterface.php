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
 * Interface EntityInterface
 */
interface EntityInterface
{
    /**
     * @return int
     *
     * @throws \EBT\UAgentParser\Exception\ResourceNotFoundException
     */
    public function getId();

    /**
     * @return string
     *
     * @throws \EBT\UAgentParser\Exception\ResourceNotFoundException
     */
    public function getName();

    /**
     * @return string
     *
     * @throws \EBT\UAgentParser\Exception\ResourceNotFoundException
     */
    public function getNameShort();

    /**
     * @param $id
     *
     * @return EntityInterface
     */
    public function setId($id);

    /**
     * @param $name
     *
     * @return EntityInterface
     */
    public function setName($name);

    /**
     * @param $nameShort
     *
     * @return EntityInterface
     */
    public function setNameShort($nameShort);
}
