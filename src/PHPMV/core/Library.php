<?php
namespace PHPMV\core;

/**
 * PHPMV\core$Library
 * This class is part of php-ajax
 *
 * @author jc
 * @version 1.0.0
 *
 */
class Library {

	public static $revision = 1;

	public const VERSION = '0.0.0';

	public static function getTemplateFolder() {
		return \dirname(__FILE__) . '/templates/rev' . self::$revision;
	}
}

