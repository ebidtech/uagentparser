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

use EBT\UAgentParser\Entities\Entity;
use EBT\UAgentParser\Entities\Browser\Family\FamilyInterface;
use EBT\UAgentParser\Entities\Os\OsInterface;

/**
 * Class Browser
 */
class Browser extends Entity implements BrowserInterface
{
    /**
     * @var FamilyInterface
     */
    protected $family;

    /**
     * @return FamilyInterface
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
