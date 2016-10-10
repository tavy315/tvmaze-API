<?php
namespace Tavy315\TVMaze;

/**
 * Class TVProduction
 *
 * @package Tavy315\TVMaze
 */
class TVProduction
{
    /** @var int */
    public $id;

    /** @var string */
    public $url;

    /** @var string */
    public $name;

    /** @var array */
    public $images;

    /** @var string */
    public $mediumImage;

    /** @var string */
    public $originalImage;

    /**
     * @param array $data
     */
    public function __construct($data)
    {
        $this->id = $data['id'];
        $this->url = $data['url'];
        $this->name = $data['name'];
        $this->images = $data['image'];
        $this->mediumImage = $data['image']['medium'];
        $this->originalImage = $data['image']['original'];
    }
}
