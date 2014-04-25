<?php

/*
 * This file is a part of the user agent parser.
 *
 * (c) 2013 Ebidtech
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace EBT\UAgentParser\Exception;

/**
 * {@inheritDoc}
 */
class InvalidArgumentException extends \InvalidArgumentException
{
    /**
     * @param $userAgent
     *
     * @return InvalidArgumentException
     */
    public static function userAgent($userAgent)
    {
        return new static(sprintf('User agent "%s" is not valid', $userAgent));
    }
}
