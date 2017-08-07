<?php

	namespace StarWar\Data;

	require __DIR__ . '/../../vendor/autoload.php';

	//	Delete existing db to seed cleanly
	if (file_exists(DataSource::FILENAME)) unlink(DataSource::FILENAME);

	$db = new DataSource();

	// Create tables
	$db->exec("
		CREATE TABLE movies (
			`id`	INTEGER PRIMARY KEY AUTOINCREMENT,
    		`title`	VARCHAR NOT NULL UNIQUE
		);"
	);

	$db->exec("
		CREATE TABLE characters (
			`id`	INTEGER PRIMARY KEY AUTOINCREMENT,
    		`name`	VARCHAR NOT NULL UNIQUE
		);"
	);

	$db->exec("
		CREATE TABLE quotes (
			`id`			INTEGER PRIMARY KEY AUTOINCREMENT,
    		`text`			VARCHAR NOT NULL UNIQUE,
    		`movieId`		INTEGER REFERENCES movies(id),
    		`characterId`	INTEGER REFERENCES characters(id)
		);"
	);

	$db->exec("
		CREATE TABLE scores (
			`id`		INTEGER PRIMARY KEY AUTOINCREMENT,
    		`score`		INTEGER,
    		`userName`	VARCHAR NOT NULL
		);"
	);

	// Add data to tables
	$movies = [
		'Episode IV: A New Hope',
		'Episode V: The Empire Strikes Back',
		'Episode VI: Return of the Jedi',
		'Episode I: The Phantom Menace',
		'Episode II: Attack of the Clones',
		'Episode III: Revenge of the Sith',
		'Episode VII: The Force Awakens',
		'Episode VIII: The Last Jedi',
		'Rogue One',
	];
	$movieIds = [];
	foreach ($movies as $movie) {
		$db->exec("INSERT into movies (title) VALUES ('$movie')");
		$movieIds[$movie] = $db->lastInsertRowID();
	};

	$characters = [
		'Rey',
		'Leia Organa',
		'Maz Kanata',
		'Han Solo',
		'Yoda',
		'Luke Skywalker',
		'Palpatine',
		'Qui-Gon Jinn',
		'Count Dooku',
		'Chirrut Imwe',
		'Jyn Erso',
	];
	$charIds = [];
	foreach ($characters as $character) {
		$db->exec("INSERT into characters (name) VALUES ('$character')");
		$charIds[$character] = $db->lastInsertRowID();
	};

	$quotes = [
		[
			'text'			=> 'The garbage will do',
			'movieId'		=> $movieIds['Episode VII: The Force Awakens'],
			'characterId'	=> $charIds['Rey'],
		],
		[
			'text'			=> 'The saber. Take it.',
			'movieId'		=> $movieIds['Episode VII: The Force Awakens'],
			'characterId'	=> $charIds['Maz Kanata'],
		],
		[
			'text'			=> 'I like that Wookie',
			'movieId'		=> $movieIds['Episode VII: The Force Awakens'],
			'characterId'	=> $charIds['Maz Kanata'],
		],
		[
			'text'			=> 'Into the garbage chute, fly boy.',
			'movieId'		=> $movieIds['Episode IV: A New Hope'],
			'characterId'	=> $charIds['Leia Organa'],
		],
		[
			'text'			=> 'It\'s a wonder you\'re still alive.',
			'movieId'		=> $movieIds['Episode IV: A New Hope'],
			'characterId'	=> $charIds['Leia Organa'],
		],
		[
			'text'			=> 'Will someone get this big walking carpet out of my way?',
			'movieId'		=> $movieIds['Episode IV: A New Hope'],
			'characterId'	=> $charIds['Leia Organa'],
		],
		[
			'text'     		=> 'Never tell me the odds!',
			'movieId'  		=> $movieIds['Episode V: The Empire Strikes Back'],
			'characterId'	=> $charIds['Han Solo'],
		],
		[
			'text'      	=> 'Why, you stuck-up, half-witted, scruffy-looking nerf herder!',
			'movieId'   	=> $movieIds['Episode V: The Empire Strikes Back'],
			'characterId' 	=> $charIds['Leia Organa'],
		],
		[
			'text'      	=> 'Do. Or do not. There is no try.',
			'movieId'  	 	=> $movieIds['Episode V: The Empire Strikes Back'],
			'characterId' 	=> $charIds['Yoda'],
		],
		[
			'text'     	 	=> 'You\'ve failed, your highness.',
			'movieId'  	 	=> $movieIds['Episode VI: Return of the Jedi'],
			'characterId' 	=> $charIds['Luke Skywalker'],
		],
		[
			'text'      	=> 'There\'s always a bigger fish.',
			'movieId'   	=> $movieIds['Episode I: The Phantom Menace'],
			'characterId' 	=> $charIds['Qui-Gon Jinn'],
		],
		[
			'text'      	=> 'Now, young Skywalker, you will die.',
			'movieId'   	=> $movieIds['Episode VI: Return of the Jedi'],
			'characterId' 	=> $charIds['Palpatine'],
		],
		[
			'text'      	=> 'What if I told you that the Republic was now under the control of a Dark Lord of the Sith?',
			'movieId'   	=> $movieIds['Episode II: Attack of the Clones'],
			'characterId' 	=> $charIds['Count Dooku'],
		],
		[
			'text'      	=> 'The dark side of the Force is a pathway to many abilities some consider to be unnatural.',
			'movieId'   	=> $movieIds['Episode III: Revenge of the Sith'],
			'characterId' 	=> $charIds['Palpatine'],
		],
		[
			'text'      	=> 'You know, no matter how much we fought, I\'ve always hated watching you leave.',
			'movieId'   	=> $movieIds['Episode VII: The Force Awakens'],
			'characterId' 	=> $charIds['Leia Organa'],
		],
		[
			'text'      	=> 'I\'m one with the Force, and the Force is with me.',
			'movieId'   	=> $movieIds['Rogue One'],
			'characterId' 	=> $charIds['Chirrut Imwe'],
		],
		[
			'text'      	=> 'I\'ve never had the luxury of political opinions.',
			'movieId'   	=> $movieIds['Rogue One'],
			'characterId' 	=> $charIds['Jyn Erso'],
		],
	];
	foreach ($quotes as $quote) {
		$args = array_map(function ($str) use ($db) {
			return $db->escapeString($str);
		}, $quote);
		$db->exec("
			INSERT into quotes (text, movieId, characterId) 
			VALUES ('" . join("','", $args) . "')
		");
	};

	$scores = [
		[
			'score' => 10,
			'userName' => 'NSJ',
		],
		[
			'score' => 3,
			'userName' => 'NSJ',
		],
		[
			'score' => 9,
			'userName' => 'EYD',
		],
		[
			'score' => 10,
			'userName' => 'EYD',
		],
		[
			'score' => 1,
			'userName' => 'ODG',
		],
		[
			'score' => 5,
			'userName' => 'ODG',
		],
	];
	foreach ($scores as $score) {
		$db->createScore($score['score'], $score['userName']);
	}

	// Print results
//	print_r($db->findMovies());
//	print_r($db->findCharacters());
//	print_r($db->findQuotes());
	print_r($db->findScores());
