<?php
namespace PHPMV\react;

use PHPMV\core\ReactClass;
use PHPMV\utils\JSX;

/**
 * PHPMV\react$ReactComponent
 * This class is part of php-react
 *
 * @author jc
 * @version 1.0.0
 *
 */
class ReactComponent extends ReactClass {

	public function __construct(string $name) {
		parent::__construct($name, 'React.Component');
	}

	public function addConstructor($jsBody) {
		$this->addMethod('constructor', "\tsuper(props);\n" . $jsBody, 'props');
	}

	public function addRender(string $jsxHtml) {
		$this->addMethod('render', JSX::toJs($jsxHtml));
	}
}

