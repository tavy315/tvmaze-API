<?php
namespace Tavy315\TVMaze;

/**
 * Class TVShow
 *
 * @package Tavy315\TVMaze
 */
class TVShow extends TVProduction
{
    /** @var bool|string */
    public $airDay;

    /** @var bool|string */
    public $airTime;

    /** @var AKA[] */
    public $akas;

    /** @var string */
    public $country;

    /** @var string */
    public $externals;

    /** @var */
    public $genres;

    /** @var */
    public $language;

    /** @var */
    public $network;

    /** @var array */
    public $network_array;

    /** @var string */
    public $nextAirDate;

    /** @var */
    public $premiered;

    /** @var */
    public $rating;

    /** @var */
    public $runtime;

    /** @var */
    public $status;

    /** @var string */
    public $summary;

    /** @var string */
    public $type;

    /** @var string */
    public $webChannel;

    /** @var */
    public $weight;

    /**
     * @param array $data
     */
    public function __construct($data)
    {
        parent::__construct($data);

        $this->akas = (isset($data['_embedded']['akas']) ? $data['_embedded']['akas'] : null);
        $this->country = $data['network']['country']['code'];
        if (count($data['webChannel']) > 0) {
            $this->country = $data['webChannel']['country']['code'];
        }
        $this->externals = $data['externals'];
        $this->genres = $data['genres'];
        $this->language = $data['language'];
        $this->network = $data['network']['name'];
        $this->network_array = $data['network'];
        $this->premiered = $data['premiered'];
        $this->rating = $data['rating'];
        $this->runtime = $data['runtime'];
        $this->status = $data['status'];
        $this->summary = strip_tags($data['summary']);
        $this->type = $data['type'];
        $this->webChannel = $data['webChannel'];
        $this->weight = $data['weight'];

        $currentDate = date('Y-m-d');
        if (!empty($data['_embedded']['episodes'])) {
            foreach ($data['_embedded']['episodes'] as $episode) {
                if ($episode['airdate'] >= $currentDate) {
                    $this->airDay = $episode['airdate'];
                    $this->airTime = $episode['airtime'];
                    $this->nextAirDate = $episode['airdate'];
                    break;
                }
            }
        }
    }

    /**
     * This function is used to check whether or not the object contains any data
     *
     * @return bool
     */
    public function isEmpty()
    {
        return ($this->id == null || $this->id == 0 && $this->url == null && $this->name == null);
    }
}
