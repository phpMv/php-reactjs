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

	public static $reactCreateElement = 'React.createElement';

	private static $jsDetect = [
		'onBlur' => 0,
		'onChange' => 0,
		'onDblclick' => 0,
		'onClick' => 0,
		'value' => 0
	];

	private static function getName(string $name, ReactJS $react): string {
		return $react->components[$name] ?? '"' . $name . '"';
	}

	private static $attributes = [
		'classname' => 'className',
		'onblur' => 'onBlur',
		'onclick' => 'onClick',
		'onchange' => 'onChange'
	];

	private static function cleanJSONFunctions(string $json): string {
		return \str_replace([
			'"!!%',
			'%!!"'
		], '', $json);
	}

	private static function hasBraces(string $str): bool {
		return (\substr($str, 0, 1) === '{' && \substr($str, - 1) === '}');
	}

	private static function nodeToJs(\DOMNode $root, ?ReactJS $react): string {
		$attributes = [];
		$name = $root->nodeName;

		if ($root->hasAttributes()) {
			$attrs = $root->attributes;

			foreach ($attrs as $i => $attr) {
				$attrName = self::$attributes[$attr->name] ?? $attr->name;
				$attrValue = $attr->value;
				if (isset(self::$jsDetect[$attrName])) {
					if (self::hasBraces($attrValue)) {
						$attrValue = \substr($attrValue, 1, - 1);
					}
					$attributes[$attrName] = '!!%' . $attrValue . '%!!';
				} else {
					$attributes[$attrName] = $attrValue;
				}
			}
		}
		$childrenStr = self::getChildrenStr($root, $react);
		return self::$reactCreateElement . "(" . ((isset($react)) ? self::getName($name, $react) : $name) . "," . self::cleanJSONFunctions(JavascriptUtils::toJSON($attributes)) . "$childrenStr)";
	}

	private static function getChildrenStr(\DOMNode $root, ?ReactJS $react): string {
		$children = [];

		$childNodes = $root->childNodes;

		for ($i = 0; $i < $childNodes->length; $i ++) {
			$child = $childNodes->item($i);
			if ($child->nodeType == XML_TEXT_NODE) {
				$v = \trim($child->nodeValue);
				if ($v != null) {
					$parts = \preg_split('@(\{.*?\})@', $v, null, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);
					if (\count($parts) > 0) {
						foreach ($parts as $ev) {
							if (self::hasBraces($ev)) {
								$children[] = \substr($ev, 1, - 1);
							} elseif (\trim($ev) != null) {
								$children[] = '"' . $ev . '"';
							}
						}
					} else {
						$children[] = "`$v`";
					}
				}
			} else {
				$children[] = self::nodeToJs($child, $react);
			}
		}
		return (count($children) > 0) ? (',' . implode(',', $children)) : '';
	}

	public static function toJs(string $html, ?ReactJS $react = null): string {
		\libxml_use_internal_errors(true);
		$dom = new \DOMDocument('1.0', 'UTF-8');
		$dom->loadHTML($html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
		return self::nodeToJs($dom->documentElement, $react);
	}
}
