<?php
namespace Tavy315\TVMaze;

/**
 * Class TVShow
 *
 * @package Tavy315\TVMaze
 */
class TVShow extends TVProduction
{
    /** @var string */
    public $type;

    /** @var */
    public $language;

    /** @var */
    public $genres;

    /** @var */
    public $status;

    /** @var */
    public $runtime;

    /** @var */
    public $premiered;

    /** @var */
    public $rating;

    /** @var */
    public $weight;

    /** @var array */
    public $network_array;

    /** @var */
    public $network;

    /** @var string */
    public $webChannel;

    /** @var string */
    public $externalIDs;

    /** @var string */
    public $summary;

    /** @var string */
    public $nextAirDate;

    /** @var bool|string */
    public $airTime;

    /** @var bool|string */
    public $airDay;

    /** @var AKA[] */
    public $akas;

    /** @var string */
    public $country;

    /**
     * @param array $data
     */
    public function __construct($data)
    {
        parent::__construct($data);

        $this->type = $data['type'];
        $this->language = $data['language'];
        $this->genres = $data['genres'];
        $this->status = $data['status'];
        $this->runtime = $data['runtime'];
        $this->premiered = $data['premiered'];
        $this->rating = $data['rating'];
        $this->weight = $data['weight'];
        $this->network_array = $data['network'];
        $this->network = $data['network']['name'];
        $this->webChannel = $data['webChannel'];
        $this->country = $data['network']['country']['code'];
        if (count($data['webChannel']) > 0) {
            $this->country = $data['webChannel']['country']['code'];
        }
        $this->externalIDs = $data['externals'];
        $this->summary = strip_tags($data['summary']);
        $this->akas = (isset($data['_embedded']['akas']) ? $data['_embedded']['akas'] : null);

        $current_date = date('Y-m-d');
        if (!empty($data['_embedded']['episodes'])) {
            foreach ($data['_embedded']['episodes'] as $episode) {
                if ($episode['airdate'] >= $current_date) {
                    $this->nextAirDate = $episode['airdate'];
                    $this->airTime = $episode['airtime'];
                    $this->airDay = $episode['airdate'];
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
