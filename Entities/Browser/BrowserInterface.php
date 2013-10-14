<?php
/*
 * This file is a part of the user agent parser.
 *
 * (c) 2013 Ebidtech
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace EBT\UAgentParser\Entities\Browser;

use EBT\UAgentParser\Entities\EntityInterface;
use EBT\UAgentParser\Entities\Browser\Family\FamilyInterface;

/**
 * Interface BrowserInterface
 *
 * @package EBT\Entities
 */
interface BrowserInterface extends EntityInterface
{
    /**
     * @return FamilyInterface
     *
     * @throws \EBT\UAgentParser\Exception\ResourceNotFoundException
     */
    public function getFamily();

    /**
     * @param FamilyInterface $family
     *
     * @return BrowserInterface
     */
    public function setFamily(FamilyInterface $family);
}
