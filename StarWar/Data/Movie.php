<?php
	namespace StarWar\Data;

	use GraphQL\Utils;

	class Movie {
		public $id;

		public $title;

		public function __construct(array $data) {
			Utils::assign($this, $data);
		}
	}
