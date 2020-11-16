<?php
use PHPMV\react\ReactJS;
use function PHPUnit\Framework\assertEquals;

/**
 * ReactJS test case.
 */
class ReactJSTest extends \Codeception\Test\Unit {

	/**
	 *
	 * @var ReactJS
	 */
	protected $react;

	protected function _before() {
		$this->react = new ReactJS();
	}

	protected function _after() {
		$this->react = null;
	}

	/**
	 * Tests ReactJS::renderComponent()
	 */
	public function testRenderComponent() {

		// TODO Auto-generated ReactJSTest::testRenderComponent()
		$this->markTestIncomplete("renderComponent test not implemented");

		ReactJS::renderComponent(/* parameters */);
	}

	/**
	 * Tests ReactJS::createComponent()
	 */
	public function testCreateComponent() {
		// TODO Auto-generated ReactJSTest::testCreateComponent()
		$this->markTestIncomplete("createComponent test not implemented");

		ReactJS::createComponent(/* parameters */);
	}

	/**
	 * Tests ReactJS::compile()
	 */
	public function testCompile() {
		$this->assertEquals('<script></script>', $this->react->compile());
		$this->react->renderComponent("<button />", "#root");

		this . assertEquals("<script>const domContainer = document.querySelector('#root');
		ReactDOM.render(React.createElement('button',[]), domContainer);</script>", $this->react->compile());
	}
}

