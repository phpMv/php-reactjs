<?php
namespace PHPMV\react;

use PHPMV\core\TemplateParser;
use PHPMV\utils\JSX;
use PHPMV\js\JavascriptUtils;
use PHPMV\core\ReactLibrary;

/**
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
	private static $operations = [];

	/**
	 *
	 * @var TemplateParser
	 */
	private static $renderTemplate;

	/**
	 * Initialize templates.
	 */
	public static function init(): void {
		self::$renderTemplate = new TemplateParser();
		self::$renderTemplate->loadTemplatefile(ReactLibrary::getTemplateFolder() . '/renderComponent');
		ReactComponent::init();
	}

	/**
	 * Insert a react component in the DOM.
	 *
	 * @param string $jsxHtml
	 * @param string $selector
	 * @return string
	 */
	public static function renderComponent(string $jsxHtml, string $selector): string {
		return (self::$operations[] = function () use ($selector, $jsxHtml) {
			self::$renderTemplate->parse([
				'selector' => $selector,
				'component' => JSX::toJs($jsxHtml)
			]);
		})();
	}

	/**
	 * Create and return a new ReactComponent.
	 *
	 * @param string $name
	 * @return ReactComponent
	 */
	public static function createComponent(string $name): ReactComponent {
		$compo = new ReactComponent($name);
		self::$operations[] = function () use ($compo) {
			return $compo->parse();
		};
		return $compo;
	}

	public static function compile() {
		$script = '';
		foreach (self::$operations as $op) {
			$script .= $op();
		}
		return JavascriptUtils::wrapScript($script);
	}
}

