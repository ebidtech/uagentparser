<?php
/*
 * This file is a part of the user agent parser.
 *
 * (c) 2013 Ebidtech
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace EBT\UAgentParser\Entities\Os;

use EBT\UAgentParser\Entities\Os\Family\FamilyInterface;
use EBT\UAgentParser\Entities\Entity;

    /**
 * Class Operating System
 *
 * @package EBT\Entities
 */
class Os extends Entity implements OsInterface
{
    /**
     * @var FamilyInterface
     */
    protected $family;

    /**
     * @return FamilyInterface
     *
     * @throws \EBT\UAgentParser\Exception\ResourceNotFoundException
     */
    public function getFamily()
    {
        return $this->family;
    }

    /**
     * @param FamilyInterface $family
     *
     * @return OsInterface
     */
    public function setFamily(FamilyInterface $family)
    {
        $this->family = $family;
        return $this;
    }
}
