<?php
	namespace StarWar\Type;

	use StarWar\Data\QuizAnswer;
	use StarWar\Data\QuizQuestion;
	use StarWar\Data\DataSource;
	use StarWar\Data\Buffer\Character;
	use StarWar\Data\Buffer\Movie;
	use StarWar\Types;
	use GraphQL\Deferred;
	use GraphQL\Type\Definition\ObjectType;
	use GraphQL\Type\Definition\ResolveInfo;

	class QuizQuestionType extends ObjectType {

		/**
		 * Not ideal, but for the moment we know there are only 11 Characters in the db
		 * @var int
		 */
		public $maxCharacters = 11;
		/**
		 * Not ideal, but for the moment we know there are only 9 Movies in the db
		 * @var int
		 */
		public $maxMovies = 9;
		/** @var int */
		public $maxAnswers = 3;

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

// TODO: stop unique checking so much
			while (count(array_unique($characterIds)) < $this->maxAnswers) {
				array_push($characterIds, rand(1, $this->maxCharacters));
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
		 * @return Deferred
		 */
		public function resolveMovies(QuizQuestion $question) {
			$quote		= $question->quote;
			$movieId	= $quote->movieId;
			$movieIds	= [$movieId];

// TODO: stop unique checking so much
			while (count(array_unique($movieIds)) < $this->maxAnswers) {
				array_push($movieIds, rand(1, $this->maxMovies));
			}
			$movieIds = array_unique($movieIds);

			Movie::add($quote->id, $movieIds);

			return new Deferred(function () use ($quote) {
				Movie::loadBuffered();

				$movieIds	= Movie::idsForQuote($quote->id);
				$movies		= Movie::get($movieIds);

				$quizAnswers = array_map(function($movie) use ($quote) {
					$isCorrect = $movie['id'] === $quote->movieId;
					return new QuizAnswer(
						['answer' => $movie['title'], 'isCorrect' => $isCorrect]
					);
				}, $movies);

				return $quizAnswers;
			});
		}

		/**
		 * @return DataSource
		 */
		private function db() {
			return new DataSource();
		}
	}
