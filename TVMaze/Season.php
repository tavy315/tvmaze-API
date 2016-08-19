<?php
/**
 * Created by PhpStorm.
 * User: joshpinkney
 * Date: 9/15/15
 * Time: 2:13 PM
 */

namespace JPinkney\TVMaze;

/**
 * Class Episode
 *
 * @package JPinkney\TVMaze
 */
class Season extends TVProduction {

	/**
	 * @var
	 */
	public $number;
    /**
	 * @var
	 */
	public $episodeOrder;
	/**
	 * @var
	 */
	public $premiereDate;
	/**
	 * @var
	 */
	public $endDate;
	/**
	 * @var
	 */
	public $network;
	/**
	 * @var
	 */
	public $webChannel;
	/**
	 * @var string
	 */
	public $summary;

	/**
	 * @param $season_data
	 */
	function __construct($season_data){
		parent::__construct($season_data);
		$this->number = $season_data['number'];
		$this->episodeOrder = $season_data['episodeOrder'];
		$this->premiereDate = $season_data['premiereDate'];
		$this->endDate = $season_data['endDate'];
		$this->network = $season_data['network'];
		$this->webChannel = $season_data['webChannel'];
		$this->summary = strip_tags($season_data['summary']);
	}

};

?>
