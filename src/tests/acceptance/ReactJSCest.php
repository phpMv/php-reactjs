<?php
include_once 'tests/acceptance/BaseAcceptance.php';

if (! class_exists('\\ReactJSCest')) {

	class ReactJSCest extends BaseAcceptance {

		public function _before(AcceptanceTester $I) {}

		// tests
		public function tryToTest(AcceptanceTester $I) {
			$I->amOnPage('/');
			$I->canSee('Hello React !');
		}

		// tests
		public function tryToHelloMessage(AcceptanceTester $I) {
			$I->amOnPage('/HelloMessage');
			$I->wait(2);
			$I->canSee('Salut Thierry', 'body');
		}

		// tests
		public function tryToTodoApp(AcceptanceTester $I) {
			$I->amOnPage('/TodoApp');
			$I->wait(2);
			$I->canSee('Que faut-il faire ?', 'body');
			$I->fillField('#new-todo', 'Café');
			$I->click('#btAdd');
			$I->canSeeNumberOfElements('li', 1);
			$I->canSee('Café', 'li');

			$I->fillField('#new-todo', 'Thé');
			$I->click('#btAdd');
			$I->canSeeNumberOfElements('li', 2);
			$I->canSee('Thé', 'li');
		}

		// tests
		public function tryToRemarkable(AcceptanceTester $I) {
			$I->amOnPage('/Remarkable');
			$I->wait(2);
			$I->canSee('Entrée', 'body');
			$I->canSee('monde', 'strong');
			$I->canSeeNumberOfElements('h1', 0);
			$I->fillField('#markdown-content', '# Test de h1');
			$I->canSeeNumberOfElements('h1', 1);
			$I->canSee('Test de h1', 'h1');
		}
	}
}