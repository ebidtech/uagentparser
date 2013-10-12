<?php
/*
 * This file is a part of the user agent parser.
 *
 * (c) 2013 Ebidtech
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace EBT\UAgentParser\Entities\Device;

use EBT\UAgentParser\Entities\Entity;
use EBT\UAgentParser\Entities\Device\Brand\BrandInterface;
use EBT\UAgentParser\Entities\Device\Type\TypeInterface;

/**
 * Class Device
 *
 * @package EBT\Entities
 */
class Device extends Entity implements DeviceInterface
{
    /**
     * @var BrandInterface
     */
    protected $brand;

    /**
     * @var TypeInterface
     */
    protected $type;

    /**
     * @return BrandInterface
     *
     * @throws \EBT\UAgentParser\Exception\ResourceNotFoundException
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * @param BrandInterface $brand
     *
     * @return DeviceInterface
     */
    public function setBrand(BrandInterface $brand)
    {
        $this->brand = $brand;
        return $this;
    }

    /**
     * @return TypeInterface
     *
     * @throws \EBT\UAgentParser\Exception\ResourceNotFoundException
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param TypeInterface $type
     *
     * @return DeviceInterface
     */
    public function setType(TypeInterface $type)
    {
        $this->type = $type;
        return $this;
    }
}