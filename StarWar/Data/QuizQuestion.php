<?php
	namespace StarWar\Data;

	use GraphQL\Utils;

	class QuizQuestion {
		/** @var object */
		public $quote;

		/** @var array */
		public $characters;

		/** @var array */
		public $movies;

		/**
		 * QuizQuestion constructor.
		 * @param array $data
		 */
		public function __construct(array $data) {
			Utils::assign($this, $data);
		}
	}
