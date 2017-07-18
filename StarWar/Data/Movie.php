<?php
	namespace StarWar\Data;

	use GraphQL\Utils;

	class Movie {
		/** @var string */
		public $id;
		/** @var string */
		public $title;

		/**
		 * Movie constructor.
		 * @param array $data string
		 */
		public function __construct(array $data) {
			Utils::assign($this, $data);
		}
	}
