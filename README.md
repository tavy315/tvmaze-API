# TVMaze API PHP wrapper

An easier way to interact with TVMaze's endpoints. Developed in PHP.

### Installing VIA Composer
`composer require tavy315/tvmaze-api dev-master`

### Goal
 * The goal of this API Wrapper is to turn TVMaze's endpoints into something more object orientated and readable
 * Provide a simple, open source project that anybody can contribute to

Supported Methods with full example below. Simple example found in Examples.php.

```php
<?php

    $client = new Tavy315\TVMaze\TVMazeClient();
    
    /*
     * List of simple ways you can interact with the api
     */
     
    //Return all tv shows relating to the given input
    $client->search("Arrow");
    
    //Return the most relevant tv show to the given input
    $client->singleSearch("The Walking Dead");
    
    //Allows show lookup by using TVRage or TheTVDB ID
    $client->getShowBySiteID("TVRage", 33272);

    //Return all possible actors relating to the given input
    $client->getPersonByName("Nicolas Cage");
    
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
    
```

### Open Source Projects using this

 * [nZEDb](https://github.com/nZEDb/nZEDb) Website Link: http://www.nzedb.com/
 * [newznab-tmux](https://github.com/DariusIII/newznab-tmux)
