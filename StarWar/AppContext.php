<?php
	namespace StarWar;

	use StarWar\Data\DataSource;
	use StarWar\Data\Character;
	use GraphQL\Utils;

	/**
	 * Class AppContext
	 * Instance available in all GraphQL resolvers as 3rd argument
	 */
	class AppContext {
		/**
		 * @var string
		 */
		public $rootUrl;

		/**
		 * @var Character
		 */
		public $viewer;

		/**
		 * @var \mixed
		 */
		public $request;
	}
