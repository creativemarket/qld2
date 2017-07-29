<?php
	namespace StarWar\Data;

	use GraphQL\Utils;

	class QuizAnswer {
		/** @var string */
		public $answer;

		/** @var boolean */
		public $isCorrect;

		/**
		 * QuizAnswer constructor.
		 * @param array $data
		 */
		public function __construct(array $data) {
			Utils::assign($this, $data);
		}
	}
