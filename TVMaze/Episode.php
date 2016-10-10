<?php
namespace Tavy315\TVMaze;

/**
 * Class Episode
 *
 * @package Tavy315\TVMaze
 */
class Episode extends TVProduction
{
    /** @var */
    public $season;

    /** @var */
    public $number;

    /** @var string */
    public $airdate;

    /** @var string */
    public $airtime;

    /** @var */
    public $airstamp;

    /** @var */
    public $runtime;

    /** @var string */
    public $summary;

    /**
     * @param $data
     */
    public function __construct($data)
    {
        parent::__construct($data);

        $this->season = $data['season'];
        $this->number = $data['number'];
        $this->airdate = $data['airdate'];
        $this->airtime = $data['airtime'];
        $this->airstamp = $data['airstamp'];
        $this->runtime = $data['runtime'];
        $this->summary = strip_tags($data['summary']);
    }
}
