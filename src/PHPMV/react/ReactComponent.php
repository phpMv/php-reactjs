<?php
namespace PHPMV\react;

use PHPMV\core\ReactClass;
use PHPMV\utils\JSX;

/**
 * A React component generator.
 * PHPMV\react$ReactComponent
 * This class is part of php-react
 *
 * @author jc
 * @version 1.0.0
 *
 */
class ReactComponent extends ReactClass {

	private $react;

	public function __construct(string $name, ReactJS $react) {
		parent::__construct($name, 'React.Component');
		$this->react = $react;
	}

	/**
	 * Add the constructor.
	 *
	 * @param string $jsBody
	 *        	The Javascript code body
	 */
	public function addConstructor(string $jsBody): void {
		$this->addMethod('constructor', "\tsuper(props);\n" . $jsBody, 'props');
	}

	/**
	 * Add the render method.
	 *
	 * @param string $jsxHtml
	 *        	The JSX code to render
	 * @param string $jsInit
	 *        	Javascript code intialization before render
	 */
	public function addRender(string $jsxHtml, string $jsInit = ''): void {
		$this->addMethod('render', $jsInit . ";return " . JSX::toJs($jsxHtml, $this->react) . ";");
	}
}

