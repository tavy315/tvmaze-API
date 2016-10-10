<?php
namespace Tavy315\TVMaze;

class AKA
{
    /**
     * @param array $data
     */
    public function __construct($data)
    {
        $this->akas = !empty($data['name']) ? $data['name'] : '';
    }
}
