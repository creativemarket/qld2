<?php
	namespace StarWar\Type;

	use StarWar\Data\QuizAnswer;
	use StarWar\Data\QuizQuestion;
	use StarWar\Data\DataSource;
	use StarWar\Data\Buffer\Character;
	use StarWar\Types;
	use GraphQL\Deferred;
	use GraphQL\Type\Definition\ObjectType;
	use GraphQL\Type\Definition\ResolveInfo;

	class QuizQuestionType extends ObjectType {

		/**
		 * @return QuizQuestionType
		 */
		public function __construct() {
			$config = [
				'name' => 'QuizQuestion',
				'fields' => function () {
					return [
						'quote' => [
							'type' => Types::quote(),
							'description' => 'All that is really needed here is the `text`',
						],
						'characters' => [
							'type' => Types::listOf(Types::quizAnswer()),
							'description' => 'The characters and movies are currently problematic because the correct answer will always be first',
						],
						'movies' => [
							'type' => Types::listOf(Types::quizAnswer()),
							'description' => 'The characters and movies are currently problematic because the correct answer will always be first',
						],
					];
				},
				'resolveField' => function ($value, $args, $context, ResolveInfo $info) {
					$method = 'resolve' . ucfirst($info->fieldName);
					if (method_exists($this, $method)) {
						return $this->{$method}($value, $args, $context, $info);
					} else {
						return $value->{$info->fieldName};
					}
				},
			];
			parent::__construct($config);
		}

		/**
		 * @param QuizQuestion $question
		 * @return Deferred
		 */
		public function resolveCharacters(QuizQuestion $question) {
			$quote			= $question->quote;
			$characterId	= $quote->characterId;
			$characterIds	= [$characterId];

			while (count(array_unique($characterIds)) < 3) {
//				Not ideal, but for the moment we know there are only 11 Characters in the db
				array_push($characterIds, rand(1, 11));
			}
			$characterIds = array_unique($characterIds);

			Character::add($quote->id, $characterIds);

			return new Deferred(function () use ($quote) {
				Character::loadBuffered();

				$characterIds	= Character::idsForQuote($quote->id);
				$characters		= Character::get($characterIds);

				$quizAnswers = array_map(function ($character) use ($quote) {
					$isCorrect = $character['id'] === $quote->characterId;
					return new QuizAnswer(
						['answer' => $character['name'], 'isCorrect' => $isCorrect]
					);
				}, $characters);

				return $quizAnswers;
			});
		}

		/**
		 * @param QuizQuestion $question
		 * @return array
		 */
		public function resolveMovies(QuizQuestion $question) {
			$movieId = $question->quote->movieId;
			$movie = $this->db()->findMovie($movieId);
			$movies = [new QuizAnswer(['answer' => $movie->title, 'isCorrect' => true])];

			$randMovies = $this->db()->query("SELECT * FROM movies ORDER BY RANDOM() LIMIT 3");

			while ($row = $randMovies->fetchArray(SQLITE3_ASSOC)) {
				if ($row['id'] !== $movieId && count($movies) < 3) {
					array_push($movies, new QuizAnswer(
						['answer' => $row['title'] , 'isCorrect' => false])
					);
				}
			}
			return $movies;
		}

		/**
		 * @return DataSource
		 */
		private function db() {
			return new DataSource();
		}
	}
