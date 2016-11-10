<?php
namespace Tavy315\TVMaze;

class TVMazeClient
{
    const API_URL = 'http://api.tvmaze.com';

    /**
     * Takes in a show name
     * Outputs array of all the related shows for that given name
     *
     * @param $show_name
     *
     * @return array
     */
    public function search($show_name)
    {
        $relevant_shows = false;
        $url = self::API_URL . '/search/shows?q=' . rawurlencode($show_name);

        $shows = $this->getFile($url);

        if (is_array($shows)) {
            $relevant_shows = [];
            foreach ($shows as $series) {
                $TVShow = new TVShow($series['show']);
                $relevant_shows[] = $TVShow;
            }
        }

        return $relevant_shows;
    }

    /**
     * Takes in a show name with optional modifiers (episodes)
     * Outputs array of the MOST related shows for that given name
     *
     * @param $show_name
     *
     * @return array
     */
    public function singleSearch($show_name)
    {
        $url = self::API_URL . '/singlesearch/shows?q=' . rawurlencode($show_name) . '&embed=episodes';
        $shows = $this->getFile($url);

        $episode_list = [];
        foreach ($shows['_embedded']['episodes'] as $episode) {
            $ep = new Episode($episode);
            $episode_list[] = $ep;
        }

        $TVShow = new TVShow($shows);

        return [ $TVShow, $episode_list ];
    }

    /**
     * Takes in a show name with optional modifiers (akas)
     * Outputs array of the MOST related show for that given name
     *
     * @param $show_name
     *
     * @return array
     */
    public function singleSearchAkas($show_name)
    {
        $TVShow = false;
        $url = self::API_URL . '/singlesearch/shows?q=' . rawurlencode($show_name) . '&embed=akas';
        $shows = $this->getFile($url);

        if (is_array($shows)) {
            $TVShow = new TVShow($shows);
        }

        return [ $TVShow ];
    }

    /**
     * Allows show lookup by using TVRage or TheTVDB ID
     * site is the string of the website (either 'tvrage' or 'thetvdb') and the id is the id of the show on that respective site
     *
     * @param $site
     * @param $ID
     *
     * @return TVShow
     */
    public function getShowBySiteID($site, $ID)
    {
        $site = strtolower($site);
        $url = self::API_URL . '/lookup/shows?' . $site . '=' . $ID;
        $show = $this->getFile($url);

        return new TVShow($show);
    }

    /**
     * Takes in an actors name and outputs their actor object
     *
     * @param $name
     *
     * @return array
     */
    public function getPersonByName($name)
    {
        $name = strtolower($name);
        $url = self::API_URL . '/search/people?q=' . $name;
        $person = $this->getFile($url);

        $people = [];
        foreach ($person as $peeps) {
            $people[] = new Actor($peeps['person']);
        }

        return $people;
    }

    /**
     * TODO: this still needs to be done
     *
     * @param null $country
     * @param null $date
     *
     * @return array
     */
    public function getSchedule($country = null, $date = null)
    {
        if ($country != null && $date != null) {
            $url = self::API_URL . '/schedule?country=' . $country . '&date=' . $date;
        } else {
            if ($country == null && $date != null) {
                $url = self::API_URL . '/schedule?date=' . $date;
            } else {
                if ($country != null && $date == null) {
                    $url = self::API_URL . '/schedule?country=' . $country;
                } else {
                    $url = self::API_URL . '/schedule';
                }
            }
        }

        $schedule = $this->getFile($url);

        $show_list = [];
        foreach ($schedule as $episode) {
            $ep = new Episode($episode);
            $show = new TVShow($episode['show']);
            array_push($show_list, $show, $ep);
        }

        return $show_list;
    }

    /**
     * Takes in a show ID and outputs the TVShow Object
     *
     * @param      $ID
     * @param null $embed_seasons
     *
     * @return array
     */
    public function getShowByShowID($ID, $embed_seasons = null)
    {
        if ($embed_seasons === true) {
            $url = self::API_URL . '/shows/' . $ID . '?embed=seasons';
        } else {
            $url = self::API_URL . '/shows/' . $ID;
        }

        $show = $this->getFile($url);

        $seasons = [];
        if ($embed_seasons === true) {
            foreach ($show['_embedded']['seasons'] as $season) {
                $s = new Season($season);
                array_push($seasons, [ $s ]);
            }
        }

        $TVShow = new TVShow($show);

        return $embed_seasons === true ? [ $TVShow, $seasons ] : [ $TVShow ];
    }

    /**
     * Takes in a show ID and outputs the AKA Object
     *
     * @param   $ID
     *
     * @return array
     */
    public function getShowAKAs($ID)
    {
        $url = self::API_URL . '/shows/' . $ID . '/akas';

        $akas = $this->getFile($url);

        $AKA = new AKA($akas);

        if (!empty($akas['name'])) {
            return $AKA;
        }

        return false;
    }

    /**
     * Takes in a show ID and outputs all the episode objects for that show in an array
     *
     * @param $ID
     *
     * @return array
     */
    public function getEpisodesByShowID($ID)
    {
        $url = self::API_URL . '/shows/' . $ID . '/episodes';

        $episodes = $this->getFile($url);

        $allEpisodes = [];
        foreach ($episodes as $episode) {
            $ep = new Episode($episode);
            $allEpisodes[] = $ep;
        }

        return $allEpisodes;
    }

    /**
     * Returns a single episodes information by its show ID, season and episode numbers
     *
     * @param $ID
     * @param $season
     * @param $episode
     *
     * @return Episode|mixed
     */
    public function getEpisodeByNumber($ID, $season, $episode)
    {
        $ep = false;
        $url = self::API_URL . '/shows/' . $ID . '/episodebynumber?season=' . $season . '&number=' . $episode;
        $response = $this->getFile($url);
        if (is_array($response)) {
            $ep = new Episode($response);
        }

        return $ep;
    }

    /**
     * Returns episodes for a given show ID and ISO 8601 airdate
     *
     * @param $ID
     * @param $airdate
     *
     * @return Episode|mixed
     */
    public function getEpisodesByAirdate($ID, $airdate)
    {
        $url = self::API_URL . '/shows/' . $ID . '/episodesbydate?date=' . date('Y-m-d', strtotime($airdate));
        $episodes = $this->getFile($url);

        $allEpisodes = [];
        if (is_array($episodes)) {
            foreach ($episodes as $episode) {
                $ep = new Episode($episode);
                $allEpisodes[] = $ep;
            }
        }

        return $allEpisodes;
    }

    /**
     * Takes in a show ID and outputs season number info
     *
     * @param $ID
     *
     * @return object
     */
    public function getSeasonByShowID($ID, $season)
    {
        $url = self::API_URL . '/shows/' . $ID . '/seasons';
        $getSeasons = $this->getFile($url);

        foreach ($getSeasons as $seasons) {
            if ($seasons['number'] == (int) $season) {
                return new Season($seasons);
            }
        }

        return null;
    }

    /**
     * Takes in a show ID and outputs all of the seasons info
     *
     * @param $ID
     *
     * @return array
     */
    public function getSeasonsByShowID($ID)
    {
        $url = self::API_URL . '/shows/' . $ID . '/seasons';
        $seasons = $this->getFile($url);

        $output = [];
        foreach ($seasons as $season) {
            $s = new Season($season);
            array_push($output, $season);
        }

        return $output;
    }

    /**
     * Takes in a show ID and outputs all of the cast members in the form (actor, character)
     *
     * @param $ID
     *
     * @return array
     */
    public function getCastByShowID($ID)
    {
        $url = self::API_URL . '/shows/' . $ID . '/cast';
        $people = $this->getFile($url);

        $cast = [];
        foreach ($people as $person) {
            $actor = new Actor($person['person']);
            $character = new Character($person['character']);
            array_push($cast, [ $actor, $character ]);
        }

        return $cast;
    }

    /**
     * Gets a list of all shows in the database. Page number is optional (caps display at 250 results)
     *
     * @param null $page
     *
     * @return array
     */
    public function getAllShowsByPage($page = null)
    {
        if ($page == null) {
            $url = self::API_URL . '/shows';
        } else {
            $url = self::API_URL . '/shows?page=' . $page;
        }

        $shows = $this->getFile($url);
        if (false === $shows) {
            return false; 
        }

        $relevant_shows = [];
        foreach ($shows as $series) {
            $TVShow = new TVShow($series);
            $relevant_shows[] = $TVShow;
        }

        return $relevant_shows;
    }

    /**
     * Gets an actor by their ID
     *
     * @param $ID
     *
     * @return Actor
     */
    public function getPersonByID($ID)
    {
        $url = self::API_URL . '/people/' . $ID;
        $show = $this->getFile($url);

        return new Actor($show);
    }

    /**
     * Gets an array of all the shows a particular actor has been in
     *
     * @param $ID
     *
     * @return array
     */
    public function getCastCreditsByID($ID)
    {
        $url = self::API_URL . '/people/' . $ID . '/castcredits?embed=show';
        $castCredit = $this->getFile($url);

        $shows_appeared = [];
        foreach ($castCredit as $series) {
            $TVShow = new TVShow($series['_embedded']['show']);
            $shows_appeared[] = $TVShow;
        }

        return $shows_appeared;
    }

    /**
     * Gets the position worked at the tv show in a tuple with the tvshow
     *
     * @param $ID
     *
     * @return array
     */
    public function getCrewCreditsByID($ID)
    {
        $url = self::API_URL . '/people/' . $ID . '/crewcredits?embed=show';
        $crewCredit = $this->getFile($url);

        $shows_appeared = [];
        foreach ($crewCredit as $series) {
            $position = $series['type'];
            $TVShow = new TVShow($series['_embedded']['show']);
            array_push($shows_appeared, [ $position, $TVShow ]);
        }

        return $shows_appeared;
    }

    /**
     * Function used to get the data from the URL and return the results in an array
     *
     * @param $url
     *
     * @return mixed
     */
    private function getFile($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        $result = curl_exec($ch);
        curl_close($ch);

        $response = json_decode($result, true);
        if (is_array($response) && count($response) > 0 && (!isset($response['status']) || $response['status'] != '404')) {
            return $response;
        } else {
            return false;
        }
    }
}
