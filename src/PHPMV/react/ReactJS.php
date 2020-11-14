<?php
namespace PHPMV\react;

use PHPMV\core\TemplateParser;
use PHPMV\utils\JSX;

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
	 * @var TemplateParser
	 */
	private static $renderTemplate;

	/**
	 * Initialize templates.
	 */
	public static function init(): void {
		self::$renderTemplate = new TemplateParser();
		self::$renderTemplate->loadTemplatefile(Library::getTemplateFolder() . '/renderComponent');
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
		return self::$renderTemplate->parse([
			'selector' => $selector,
			'component' => JSX::toJs($jsxHtml)
		]);
	}

	/**
	 * Create and return a new ReactComponent.
	 *
	 * @param string $name
	 * @return ReactComponent
	 */
	public static function createComponent(string $name): ReactComponent {
		return new ReactComponent($name);
	}
}

