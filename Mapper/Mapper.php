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

use EBT\UAgentParser\Exception\ResourceNotFoundException;

/**
 * Class Mapper
 *
 * @package EBT\Mapper
 */
class Mapper implements MapperInterface
{
    /**
     * @var array
     */
    protected $maps;

    public function __constructor()
    {
        $this->maps = array();
    }


    /**
     * @var ConfContainer
     */
    protected $confContainer;

    /**
     * Gets the destination data for specified source
     *
     * @param      $source
     *
     * @return array
     * @throws \EBT\UAgentParser\Exception\ResourceNotFoundException
     **/
    public function getTo($source)
    {
        $results = array();

        foreach ($this->maps as $mapName => $mapValues) {
            try {
                $results[] = $this->searchMap($mapName, $source);
            } catch (ResourceNotFoundException $e) {
                // just check at the end
            }

        }
        if (empty($results)) {
            throw new ResourceNotFoundException('Source %s was not found in any map.');
        }
        return $results;
    }

    /**
     * Gets the source data for specified destination
     *
     * @param      $destination
     *
     * @return array
     * @throws \EBT\UAgentParser\Exception\ResourceNotFoundException
     */
    public function getFrom($destination)
    {
        $results = array();

        foreach ($this->maps as $mapName => $mapValues) {
            try {
                $results[] = $this->reverseMap($mapName, $destination);
            } catch (ResourceNotFoundException $e) {
                // just check at the end
            }

        }
        if (empty($results)) {
            throw new ResourceNotFoundException('Destination %s was not found in any map.');
        }
        return $results;
    }

    /**
     * Gets the destination data for specified source
     *
     * @param      $source
     * @param null $mapName
     *
     * @return Object
     */
    public function getToInMap($source, $mapName)
    {
        return $this->searchMap($mapName, $source);
    }

    /**
     * Gets the source data for specified destination
     *
     * @param      $destination
     * @param null $mapName
     *
     * @return Object
     */
    public function getFromInMap($destination, $mapName)
    {
        return $this->reverseMap($mapName, $destination);
    }

    /**
     * Sets a map
     *
     * @param $mapName
     * @param $mappingTable
     *
     * @return MapperInterface
     *
     * @throws \InvalidArgumentException
     */
    public function setMap($mapName, $mappingTable)
    {
        if (!is_array($mappingTable)) {
            throw new \InvalidArgumentException(
                sprintf('mappingTable must be an array, %s given.', gettype($mappingTable)
                ));
        }
        $this->maps[$mapName] = $mappingTable;
    }

    /**
     * Gets a specified map
     *
     * @param $mapName
     *
     * @return Array
     */
    public function getMap($mapName)
    {
        return $this->maps[$mapName];
    }

    /**
     * Gets all maps
     *
     * @return Array
     */
    public function getAllMaps()
    {
        return $this->maps;
    }

    /**
     * Searches for a key in a map
     *
     * @param $mapName
     * @param $key
     *
     * @return mixed
     * @throws \EBT\UAgentParser\Exception\ResourceNotFoundException
     */
    protected function searchMap($mapName, $key)
    {
        if (!array_key_exists($mapName, $this->maps)) {
            throw new ResourceNotFoundException(sprintf('Map %s was not found.', $mapName));
        }
        if (!array_key_exists($key, $this->maps[$mapName])) {
            throw new ResourceNotFoundException(sprintf('Key %s was not found in %s.', $key, $mapName));
        }
        return $this->maps[$mapName][$key];
    }

    /**
     * Search for a value for a given key
     *
     * @param $mapName
     * @param $value
     *
     * @return mixed
     * @throws \EBT\UAgentParser\Exception\ResourceNotFoundException
     */
    protected function reverseMap($mapName, $value)
    {
        if (!array_key_exists($mapName, $this->maps)) {
            throw new ResourceNotFoundException(sprintf('Map %s was not found.', $mapName));
        }
        $key = array_search($value, $this->maps[$mapName]);
        if (!$key) {
            throw new ResourceNotFoundException(sprintf('Value %s was not found in %s.', $value, $mapName));
        }
        return $key;
    }


}