<?php
namespace PHPMV\utils;

use PHPMV\js\JavascriptUtils;

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
		if (\ucfirst($name) === $name) {
			return $name;
		}
		return "'$name'";
	}

	public static $reactCreateElement = 'React.createElement';

	public static function loadHtml(string $html): string {
		$dom = new \DOMDocument('1.0', 'UTF-8');
		$dom->loadHTML($html);
		return self::toJs($dom->documentElement->lastChild->firstChild);
	}

	public static function toJs(\DOMNode $root): string {
		$attributes = [];
		$children = [];
		$name = $root->nodeName;

		if ($root->hasAttributes()) {
			$attrs = $root->attributes;

			foreach ($attrs as $i => $attr) {
				$attributes[$attr->name] = $attr->value;
			}
		}

		$childNodes = $root->childNodes;

		for ($i = 0; $i < $childNodes->length; $i ++) {
			$child = $childNodes->item($i);
			if ($child->nodeType == XML_TEXT_NODE) {
				$children[] = "`{$child->nodeValue}`";
			} else {
				$children[] = self::toJs($child);
			}
		}
		$childrenStr = '';
		if (count($children) > 0) {
			$childrenStr = ',' . implode(',', $children);
		}
		return self::$reactCreateElement . "(" . self::getName($name) . "," . JavascriptUtils::toJSON($attributes) . "$childrenStr)";
	}
}

