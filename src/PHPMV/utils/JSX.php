<?php
namespace PHPMV\utils;

use PHPMV\js\JavascriptUtils;
use PHPMV\react\ReactJS;

/**
 * PHPMV\utils$JSX
 * This class is part of Ubiquity
 *
 * @author jc
 * @version 1.0.0
 *
 */
class JSX {

	private static function getName($name) {
		return ReactJS::$components[$name] ?? "'$name'";
	}

	private static $attributes = [
		'classname' => 'className'
	];

	public static $reactCreateElement = 'React.createElement';

	public static function toJs(string $html): string {
		\libxml_use_internal_errors(true);
		$dom = new \DOMDocument('1.0', 'UTF-8');
		$dom->loadHTML($html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
		return self::nodeToJs($dom->documentElement);
	}

	private static function nodeToJs(\DOMNode $root): string {
		$attributes = [];
		$children = [];
		$name = $root->nodeName;

		if ($root->hasAttributes()) {
			$attrs = $root->attributes;

			foreach ($attrs as $i => $attr) {
				$attributes[self::$attributes[$attr->name] ?? $attr->name] = $attr->value;
			}
		}

		$childNodes = $root->childNodes;

		for ($i = 0; $i < $childNodes->length; $i ++) {
			$child = $childNodes->item($i);
			if ($child->nodeType == XML_TEXT_NODE) {
				$children[] = "`" . \trim($child->nodeValue) . "`";
			} else {
				$children[] = self::nodeToJs($child);
			}
		}
		$childrenStr = '';
		if (count($children) > 0) {
			$childrenStr = ',' . implode(',', $children);
		}
		return self::$reactCreateElement . "(" . self::getName($name) . "," . JavascriptUtils::toJSON($attributes) . "$childrenStr)";
	}
}

