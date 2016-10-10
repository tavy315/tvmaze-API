<?php
/*
 * Create a new Client object that will allow us to access all the api's functionality
 */
$client = new Tavy315\TVMaze\TVMazeClient();

/*
 * List of some methods that you can use. Others will be included in more formal documentation
 */
$client->search('Arrow');

//Return the most relevant tv show to the given input
$client->singleSearch('The Walking Dead');

//Allows show lookup by using TVRage or TheTVDB ID
$client->getShowBySiteID('TVRage', 33272);

//Return all possible actors relating to the given input
$client->getPersonByName('Nicolas Cage');

//Return all the shows in the given country and/or date
$client->getSchedule();

//Return all information about a show given the show ID
$client->getShowByShowID(1);

//Return all seasons for a show given the show ID
$client->getSeasonsByShowID(1);

//Return a single seasons information for a show given the show ID and season number
$client->getSeasonByShowID(1, 2);

//Return all episodes for a show given the show ID
$client->getEpisodesByShowID(1);

//Returns a single episodes information by its show ID, season and episode numbers
$client->getEpisodeByNumber(1, 2, 11);

//Return the cast for a show given the show ID
$client->getCastByShowID(1);

//Return a master list of TVMazes shows given the page number
$client->getAllShowsByPage(2);

//Return an actor given their ID
$client->getPersonByID(50);

//Return an array of all the shows a particular actor has been in
$client->getCastCreditsByID(25);

//Return an array of all the positions a particular actor has been in
$client->getCrewCreditsByID(100);
