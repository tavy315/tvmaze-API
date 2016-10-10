<?php
namespace Tavy315\TVMaze;

/**
 * Class Crew
 *
 * @package Tavy315\TVMaze
 */
class Crew
{
    /** @var string */
    public $type;

    /**
     * @param array $data
     */
    public function __construct($data)
    {
        $this->type = $data['type'];
    }
}
