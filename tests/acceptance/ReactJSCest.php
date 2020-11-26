<?php
include_once 'tests/acceptance/BaseAcceptance.php';

if (! class_exists(ReactJSCest::class)) {

	class ReactJSCest extends BaseAcceptance {

		public function _before(AcceptanceTester $I) {}

		// tests
		public function tryToTest(AcceptanceTester $I) {}
	}
}