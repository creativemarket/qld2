<?php
	namespace StarWar\Data;

	/**
	 * Class DataSource
	 *
	 * This is just a simple in-memory data holder for the sake of example.
	 * Data layer for real app may use Doctrine or query the database directly (e.g. in CQRS style)
	 *
	 */
	class DataSource extends \SQLite3 {
		/** location of sqlite3 db */
		const FILENAME = 'starwar.db';

		/**
		 * DataSource constructor.
		 */
		public function __construct() {
			$this->open(self::FILENAME);
		}

		/**
		 * @param $score
		 * @param $userName
		 * @return int
		 */
		public function createScore($score, $userName) {
			$this->exec("INSERT into scores (score, userName) VALUES ('$score','$userName')");
			return $this->lastInsertRowID();
		}

		/**
		 * @param $id
		 * @return character|null
		 */
		public function findCharacter($id) {
			$character = $this->find('characters', $id);
			return new Character($character);
		}

		/**
		 * @param $id
		 * @return movie|null
		 */
		public function findMovie($id) {
			$movie = $this->find('movies', $id);
			return new Movie($movie);
		}

		/**
		 * @param $id
		 * @return quote|null
		 */
		public function findQuote($id) {
			$quote = $this->find('quotes', $id);
			return new Quote($quote);
		}

		/**
		 * @param $id
		 * @return score|null
		 */
		public function findScore($id) {
			$score = $this->find('scores', $id);
			return new Score($score);
		}

		/**
		 * @return array
		 */
		public function findCharacters() {
			$results	= $this->findAll('characters');
			$characters	= [];
			while ($row = $results->fetchArray(SQLITE3_ASSOC)) {
				array_push($characters, new Character($row));
			}
			return $characters;
		}

		/**
		 * @return array
		 */
		public function findMovies() {
			$results	= $this->findAll('movies');
			$movies		= [];
			while ($row = $results->fetchArray(SQLITE3_ASSOC)) {
				array_push($movies, new Movie($row));
			}
			return $movies;
		}

		/**
		 * @return array
		 */
		public function findQuotes() {
			$results	= $this->findAll('quotes');
			$quotes		= [];
			while ($row = $results->fetchArray(SQLITE3_ASSOC)) {
				array_push($quotes, new Quote($row));
			}
			return $quotes;
		}

		/**
		 * @return array
		 */
		public function findScores() {
			$results	= $this->findAll('scores');
			$scores		= [];
			while ($row = $results->fetchArray(SQLITE3_ASSOC)) {
				array_push($scores, new Score($row));
			}
			return $scores;
		}

		/**
		 * @param int
		 * @return array
		 */
		public function findTopScores($limit) {
			$results	= $this->query("SELECT * FROM scores ORDER BY score DESC LIMIT $limit");
			$scores		= [];
			while ($row = $results->fetchArray(SQLITE3_ASSOC)) {
				array_push($scores, new Score($row));
			}
			return $scores;
		}

		/**
		 * @param $limit
		 * @return array
		 */
		public function findQuizQuestions($limit) {
			$results		= $this->query("SELECT * FROM quotes ORDER BY RANDOM() LIMIT $limit");
			$quizQuestions	= [];
			while ($row = $results->fetchArray(SQLITE3_ASSOC)) {
				array_push($quizQuestions, new QuizQuestion(
					['quote' => new Quote($row)]
				));
			}
			return $quizQuestions;
		}

		/**
		 * @param $table
		 * @param $id
		 * @return array
		 */
		private function find($table, $id) {
			$statement = $this->prepare("SELECT * FROM $table WHERE id = :id");
			$statement->bindValue(':id', $id);
			return $statement->execute()->fetchArray(SQLITE3_ASSOC);
		}

		/**
		 * @param $table
		 * @return object
		 */
		private function findAll($table) {
			return $this->query("SELECT * FROM $table");
		}
	}
