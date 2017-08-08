<?php
	namespace StarWar\Data;

	use GraphQL\Utils;

	class Score {
		/** @var integer */
		public $id;

		/** @var integer */
		public $score;

		/** @var string */
		public $userName;

		/**
		 * Score constructor.
		 * @param array $data
		 */
		public function __construct(array $data) {
			Utils::assign($this, $data);
		}
	}
