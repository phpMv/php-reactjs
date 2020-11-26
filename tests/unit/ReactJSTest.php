<?php
use PHPMV\react\ReactJS;
use function PHPUnit\Framework\assertEquals;

if (! class_exists(ReactJSTest::class)) {

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

		protected function assertEqualsIgnoreNewLines($expected, $actual) {
			$this->assertEquals(trim(preg_replace('/\R+/', '', $expected)), trim(preg_replace('/\R+/', '', $actual)));
		}

		/**
		 * Tests ReactJS::createComponent()
		 */
		public function testCreateComponent() {
			$this->assertEquals('', $this->react->compile());
			$compo = $this->react->createComponent('MyCompo');
			$compo->addConstructor('console.log("super");');
			$compo->addMethod('method', 'alert(a);alert(b);', 'a', 'b');
			$compo->addRender('<div>
        <div className="status">{status}</div>
        <div className="board-row">
          {this.renderSquare(0)}
          {this.renderSquare(1)}
          {this.renderSquare(2)}
        </div>
        <div className="board-row">
          {this.renderSquare(3)}
          {this.renderSquare(4)}
          {this.renderSquare(5)}
        </div>
        <div className="board-row" value="{this.props.squares[i]}"
        onClick="{() => this.props.onClick(i)}">
          {this.renderSquare(6)}
          {this.renderSquare(7)}
          {this.renderSquare(8)}
        </div>
      </div>');
			$this->assertEqualsIgnoreNewLines('<script>class MyCompo extends React.Component {
constructor(props){
	super(props);
console.log("super");
}
method(a,b){
alert(a);alert(b);
}
render(){
;return React.createElement("div",[],React.createElement("div",{
    "className": "status"
},status),React.createElement("div",{
    "className": "board-row"
},this.renderSquare(0),this.renderSquare(1),this.renderSquare(2)),React.createElement("div",{
    "className": "board-row"
},this.renderSquare(3),this.renderSquare(4),this.renderSquare(5)),React.createElement("div",{
    "className": "board-row",
    "value": this.props.squares[i],
    "onClick": () => this.props.onClick(i)
},this.renderSquare(6),this.renderSquare(7),this.renderSquare(8)));
}
}</script>', $this->react->compile());
			$this->react->renderComponent("<MyCompo/>", "#root");
			$this->assertEqualsIgnoreNewLines('<script>class MyCompo extends React.Component {
constructor(props){
	super(props);
console.log("super");
}
method(a,b){
alert(a);alert(b);
}
render(){
;return React.createElement("div",[],React.createElement("div",{
    "className": "status"
},status),React.createElement("div",{
    "className": "board-row"
},this.renderSquare(0),this.renderSquare(1),this.renderSquare(2)),React.createElement("div",{
    "className": "board-row"
},this.renderSquare(3),this.renderSquare(4),this.renderSquare(5)),React.createElement("div",{
    "className": "board-row",
    "value": this.props.squares[i],
    "onClick": () => this.props.onClick(i)
},this.renderSquare(6),this.renderSquare(7),this.renderSquare(8)));
}
}const domContainer = document.querySelector("#root");
ReactDOM.render(React.createElement(MyCompo,[]), domContainer);</script>', $this->react->compile());
		}

		/**
		 * Tests ReactJS::compile()
		 */
		public function testCompile() {
			$this->assertEquals('', $this->react->compile());
			$this->react->renderComponent("<button />", "#root");

			$this->assertEqualsIgnoreNewLines('<script>const domContainer = document.querySelector("#root");
ReactDOM.render(React.createElement("button",[]), domContainer);</script>', $this->react->compile());
		}
	}
}