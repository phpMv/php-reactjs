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
	 * Tests ReactJS::createComponent()
	 */
	public function testCreateComponent() {
		$this->assertEquals('', $this->react->compile());
		$compo = $this->react->createComponent('MyCompo');
		$compo->addConstructor("console.log('super');");
		$compo->addMethod('method', 'alert(a);alert(b);', 'a', 'b');
		$this->assertEquals("<script>class MyCompo extends React.Component {\nconstructor(props){\tsuper(props);\nconsole.log('super');\n}\nmethod(a,b){\nalert(a);alert(b);\n}\n}</script>", $this->react->compile());
		$this->react->renderComponent("MyCompo", "#root");
		$this->assertEquals("class MyCompo extends React.Component {\nconstructor(props){\n\tsuper(props);\nconsole.log('super');\n}\nmethod(a,b){\nalert(a);alert(b);\n}\n}const domContainer = document.querySelector('#root');\nReactDOM.render(React.createElement('mycompo',[]), domContainer);", $this->react->compile());
	}

	/**
	 * Tests ReactJS::compile()
	 */
	public function testCompile() {
		$this->assertEquals('', $this->react->compile());
		$this->react->renderComponent("<button />", "#root");

		$this->assertEquals("<script>const domContainer = document.querySelector('#root');\nReactDOM.render(React.createElement('button',[]), domContainer);</script>", $this->react->compile());
	}
}

