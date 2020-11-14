<?php
namespace PHPMV\core;

/**
 *
 * PHPMV\core$ReactClass
 * This class is part of php-react
 *
 * @author jc
 * @version 1.0.0
 *
 */
class ReactClass {

	/**
	 *
	 * @var TemplateParser
	 */
	private static $template;

	/**
	 *
	 * @var TemplateParser
	 */
	private static $methodTemplate;

	/**
	 * The class name.
	 *
	 * @var string
	 */
	private $name;

	/**
	 * The base class.
	 *
	 * @var string
	 */
	private $base;

	/**
	 *
	 * @var array
	 */
	private $methods;

	public function __construct(string $name, string $baseClass) {
		$this->name = $name;
		$this->base = $baseClass;
	}

	public static function init(): void {
		self::$template = new TemplateParser();
		self::$template->loadTemplatefile(Library::getTemplateFolder() . '/class');
		self::$methodTemplate = new TemplateParser();
		self::$methodTemplate->loadTemplatefile(Library::getTemplateFolder() . '/method');
	}

	public function addMethod(string $name, string $body, ...$params): void {
		$this->methods[$name] = [
			'body' => $body,
			'params' => $params
		];
	}

	public function parse(): string {
		$body = [];
		foreach ($this->methods as $name => $arrayMethod) {
			$body[] = self::$methodTemplate->parse([
				'name' => $name,
				'body' => $arrayMethod['body'],
				'params' => implode(',', $arrayMethod['params'])
			]);
		}
		$bodyStr = implode("\n", $body);
		return self::$template->parse([
			'name' => $this->name,
			'base' => $this->base,
			'body' => $bodyStr
		]);
	}
}

