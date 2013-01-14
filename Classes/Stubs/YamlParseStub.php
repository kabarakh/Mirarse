<?php
/*
 * Copyright notice
 * 
 * (c) 2012/2013 Christian Herberger <webmaster@kabarakh.de>
 * 
 * All rights reserved
 * 
 * This script is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 * 
 * The GNU General Public License can be found at
 * http,//www.gnu.org/copyleft/gpl.html.
 * 
 * This script is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * This copyright notice MUST APPEAR in all copies of the script!
 */
/**
 * This class is a stub! This only exists to get rid of undefined function inspections in phpStorm
 * @stub
 */
define('YAML_ANY_ENCODING', 0);
define('YAML_UTF8_ENCODING', 1);
define('YAML_UTF16LE_ENCODING', 2);
define('YAML_UTF16BE_ENCODING', 3);
define('YAML_ANY_BREAK', 0);
define('YAML_CR_BREAK', 1);
define('YAML_LN_BREAK', 2);
define('YAML_CRLN_BREAK', 3);

/**
 * Convert all or part of a YAML document stream to a PHP variable.
 *
 * @param string $input
 * @param int $pos
 * @param int $ndocs
 * @param array $callbacks
 * @return array
 * @stub
 */
function yaml_parse($input, $pos = 0, &$ndocs = 0, $callbacks = array()) {return array();}

/**
 * Convert all or part of a YAML document stream read from a file to a PHP variable.
 *
 * @param string $filename
 * @param int $pos
 * @param int $ndocs
 * @param array $callbacks
 * @return array
 * @stub
 */
function yaml_parse_file($filename, $pos = 0, &$ndocs = 0, $callbacks = array()) {return array();}

/**
 * Convert all or part of a YAML document stream read from a URL to a PHP variable.
 *
 * @param string $url
 * @param int $pos
 * @param int $ndocs
 * @param array $callbacks
 * @return array
 * @stub
 */
function yaml_parse_url($url, $pos = 0, &$ndocs = 0, $callbacks = array()) {return array();}

/**
 * Generate a YAML representation of the provided data.
 *
 * @param mixed $data
 * @param int $encoding
 * @param int $linebreak
 * @param array $callbacks
 * @return string
 * @stub
 */
function yaml_emit($data, $encoding = YAML_ANY_ENCODING, $linebreak = YAML_ANY_BREAK, $callbacks = array()){return '';}

/**
 * Generate a YAML representation of the provided data in the filename.
 * 
 * @param string $filename
 * @param mixed $data
 * @param int $encoding
 * @param int $linebreak
 * @param array $callbacks
 * @return string
 * @stub
 */
function yaml_emit_file($filename, $data, $encoding = YAML_ANY_ENCODING, $linebreak = YAML_ANY_BREAK, $callbacks = array()){return '';}

?>