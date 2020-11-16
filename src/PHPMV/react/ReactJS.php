<?php
namespace PHPMV\react;

use PHPMV\core\TemplateParser;
use PHPMV\utils\JSX;
use PHPMV\js\JavascriptUtils;
use PHPMV\core\ReactLibrary;

/**
 * The ReactJS service for PHP.
 * PHPMV\react$ReactJS
 * This class is part of php-reactjs
 *
 * @author jc
 * @version 1.0.0
 *
 */
class ReactJS {

	/**
	 *
	 * @var array
	 */
	private $operations;

	public $components;

	/**
	 *
	 * @var TemplateParser
	 */
	private $renderTemplate;

	/**
	 * Initialize templates.
	 */
	public function __construct() {
		$this->operations = [];
		$this->components = [];
		$this->renderTemplate = new TemplateParser();
		$this->renderTemplate->loadTemplatefile(ReactLibrary::getTemplateFolder() . '/renderComponent');
		ReactComponent::init();
	}

	/**
	 * Insert a react component in the DOM.
	 *
	 * @param string $jsxHtml
	 * @param string $selector
	 * @return string
	 */
	public function renderComponent(string $jsxHtml, string $selector): string {
		return ($this->operations[] = function () use ($selector, $jsxHtml) {
			return $this->renderTemplate->parse([
				'selector' => $selector,
				'component' => JSX::toJs($jsxHtml)
			]);
		})();
	}

	/**
	 * Create and return a new ReactComponent.
	 *
	 * @param string $name
	 * @param bool $compile
	 * @return ReactComponent
	 */
	public function createComponent(string $name, $compile = true): ReactComponent {
		$compo = new ReactComponent($name);
		$this->components[\strtolower($name)] = $name;
		if ($compile) {
			$this->operations[] = function () use ($compo) {
				return $compo->parse();
			};
		}
		return $compo;
	}

	/**
	 * Generate the javascript code.
	 *
	 * @return string
	 */
	public function compile(): string {
		$script = '';
		foreach ($this->operations as $op) {
			$script .= $op();
		}
		return JavascriptUtils::wrapScript($script);
	}

	public function __toString() {
		return $this->compile();
	}
}

