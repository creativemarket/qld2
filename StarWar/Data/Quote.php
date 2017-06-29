<?php
	namespace StarWar\Data;

	use GraphQL\Utils;

	class Quote {
		public $id;

		public $characterId;

		public $movieId;

		public $parentId;

		public $body;

		public function __construct(array $data) {
			Utils::assign($this, $data);
		}
	}
