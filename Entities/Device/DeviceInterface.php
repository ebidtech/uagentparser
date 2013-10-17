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

use EBT\UAgentParser\Entities\EntityInterface;
use EBT\UAgentParser\Entities\Device\Brand\BrandInterface;
use EBT\UAgentParser\Entities\Device\Type\TypeInterface;

/**
 * Interface DeviceInterface
 */
interface DeviceInterface extends EntityInterface
{
    /**
     * @return BrandInterface
     */
    public function getBrand();

    /**
     * @param BrandInterface $brand
     *
     * @return DeviceInterface
     */
    public function setBrand(BrandInterface $brand);

    /**
     * @return TypeInterface
     */
    public function getType();

    /**
     * @param TypeInterface $type
     *
     * @return DeviceInterface
     */
    public function setType(TypeInterface $type);
}
