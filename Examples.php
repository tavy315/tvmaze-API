<?php
/*
 * Create a new Client object that will allow us to access all the api's functionality
 */
$client = new Tavy315\TVMaze\Client;

/*
 * List of some methods that you can use. Others will be included in more formal documentation
 */
$client->TVMaze->search('Arrow');

//Return the most relevant tv show to the given input
$client->TVMaze->singleSearch('The Walking Dead');

//Allows show lookup by using TVRage or TheTVDB ID
$client->TVMaze->getShowBySiteID('TVRage', 33272);

//Return all possible actors relating to the given input
$client->TVMaze->getPersonByName('Nicolas Cage');

//Return all the shows in the given country and/or date
$client->TVMaze->getSchedule();

//Return all information about a show given the show ID
$client->TVMaze->getShowByShowID(1);

//Return all seasons for a show given the show ID
$client->TVMaze->getSeasonsByShowID(1);

//Return a single seasons information for a show given the show ID and season number
$client->TVMaze->getSeasonByShowID(1, 2);

//Return all episodes for a show given the show ID
$client->TVMaze->getEpisodesByShowID(1);

//Returns a single episodes information by its show ID, season and episode numbers
$client->TVMaze->getEpisodeByNumber(1, 2, 11);

//Return the cast for a show given the show ID
$client->TVMaze->getCastByShowID(1);

//Return a master list of TVMazes shows given the page number
$client->TVMaze->getAllShowsByPage(2);

//Return an actor given their ID
$client->TVMaze->getPersonByID(50);

//Return an array of all the shows a particular actor has been in
$client->TVMaze->getCastCreditsByID(25);

//Return an array of all the positions a particular actor has been in
$client->TVMaze->getCrewCreditsByID(100);
