<?php

/*
 * This file is a part of the user agent parser.
 *
 * (c) 2013 Ebidtech
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace EBT\UAgentParser\Mapper;

/**
 * Class MapperInterface
 */
interface MapperInterface
{
    /**
     * Gets the destination data for specified source searching in all Maps
     *
     * @param      $source
     *
     * @return array
     */
    public function getTo($source);

    /**
     * Gets the source data for specified destination searching in all Maps
     *
     * @param      $destination
     *
     * @return array
     */
    public function getFrom($destination);

    /**
     * Gets the destination data for specified source
     *
     * @param      $source
     * @param null $mapName
     *
     * @return Object|array
     */
    public function getToInMap($source, $mapName);

    /**
     * Gets the source data for specified destination
     *
     * @param      $destination
     * @param null $mapName
     *
     * @return Object|array
     */
    public function getFromInMap($destination, $mapName);

    /**
     * Sets a map
     *
     * @param string $mapName
     * @param array $mappingTable
     *
     * @return MapperInterface
     */
    public function setMap($mapName, array $mappingTable);

    /**
     * Gets a specified map
     *
     * @param $mapName
     *
     * @return array
     */
    public function getMap($mapName);

    /**
     * Gets all maps
     *
     * @return array
     */
    public function getAllMaps();
}
