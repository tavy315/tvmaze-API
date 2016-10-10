<?php
namespace Tavy315\TVMaze;

/**
 * Class Episode
 *
 * @package Tavy315\TVMaze
 */
class Season extends TVProduction
{
    /** @var */
    public $number;

    /** @var */
    public $episodeOrder;

    /** @var string */
    public $premiereDate;

    /** @var string */
    public $endDate;

    /** @var */
    public $network;

    /** @var string */
    public $webChannel;

    /** @var string */
    public $summary;

    /**
     * @param array $data
     */
    public function __construct($data)
    {
        parent::__construct($data);

        $this->number = $data['number'];
        $this->episodeOrder = $data['episodeOrder'];
        $this->premiereDate = $data['premiereDate'];
        $this->endDate = $data['endDate'];
        $this->network = $data['network'];
        $this->webChannel = $data['webChannel'];
        $this->summary = strip_tags($data['summary']);
    }
}
