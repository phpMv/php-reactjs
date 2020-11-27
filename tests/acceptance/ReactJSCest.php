<?php
include_once 'tests/acceptance/BaseAcceptance.php';

if (! class_exists('\\ReactJSCest')) {

	class ReactJSCest extends BaseAcceptance {

		public function _before(AcceptanceTester $I) {}

		// tests
		public function tryToTest(AcceptanceTester $I) {
			$I->amGoingTo('/');
			$I->canSee('Hello React !');
		}
	}
}