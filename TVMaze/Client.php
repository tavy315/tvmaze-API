<?php
namespace Tavy315\TVMaze;

/**
 * Class Client
 *
 * @package Tavy315\TVMaze
 */
class Client
{
    /**
     * @var TVMaze TVMaze
     */
    public $TVMaze;

    public function __construct()
    {
        $this->TVMaze = new TVMaze();
    }
}
