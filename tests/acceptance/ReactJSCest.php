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

		// tests
		public function tryToHelloMessage(AcceptanceTester $I) {
			$I->amGoingTo('/HelloMessage');
			$I->wait(10);
			$I->canSee('Salut Thierry');
		}
	}
}