<?php
/**
 * Parser class offering methods for parsing modules and styles
 */
class Parser {

    /** Prefix
     * @var string $prefix
     */
    private $prefix;

    /** Debug mode on or off
     * @var bool $debug_mode
     */
    private $debug_mode;

    /** Available modules
     * @var array $modules
     */
    private $modules;

    /** Flags of current file
     * @var array $flags
     */
    private $flags;

    /** id__module of current module
     * @var int $current_module
     */
    private $current_module;

    /** Constructor
     * @param string $prefix
     *	Prefix
     * @param array $modules_all
     *	Array with all module objects
     * @param bool $debug_mode
     *	Do not replace language?
     */
    public function __construct ($prefix, $modules_all, $debug_mode = false) {

	// init
	$this->prefix = $prefix;
	$this->modules = array();
	$this->debug_mode = $debug_mode;

	// save modules
	foreach ($modules_all as $index => $Value) {
	    $this->modules[$Value->getInfo('name')] = array(
		'id__module' => $Value->getInfo('id__module'),
		'nameid' => $Value->getInfo('nameid')
	    );
	}
    }

    /** Set current module
     * @param int $id__module
     *	id__module of current module, the content belongs to
     *
     * @return string
     */
    public function setModule ($id__module) {

	// validate
	if (!is_numeric($id__module) OR empty($id__module)) return false;

	// save
	$this->current_module = $id__module;

	return true;
    }

    /** Read flags from content of file
     * @param string $content
     *	Content of file
     *
     * @return array
     */
    public function getFlags ($content) {
	$content = $this->removeBom($content);
	$this->flags = array();

	// extract header
	$cache = explode('<?php', $content);
	$cache = explode('-->', $cache[0]);
	$cache = explode('<!--', $cache[0]);

	// is header?
	if (count($cache) < 2) return array();

	// split header
	$cache = explode('|', $cache[1]);

	// get flags
	$flags = str_replace(' ', '', trim($cache[0]));
	$flags = (array) $flags;
	foreach ($flags as $index => $value) {
	    if (empty($value)) continue;
	    $this->flags[$value] = $value;
	}

	return $this->flags;
    }

    /** Parse file
     * @param string $content
     *	Content of file to parse
     * @param bool $trim_flags
     *	Remove flags?
     * @param bool $is_javascript
     *	Is javascript content?
     *
     * @return string
     */
    public function parse ($content, $trim_flags = true, $is_javascript = false) {

	// set flags
	$this->getFlags($content);
	$content = $this->removeBom($content);
	$is_sensitive = (isset($this->flags['s'])) ? true : false;

	// replace
	// language-replacement has to be before modul-replacement!
	$content = $this->replaceLang($content);
	$content = $this->replacePreffix($content);
	$content = $this->replaceModule($content);
	if (!isset($this->flags['p']) AND !$this->debug_mode) {
	    $content = $this->_trim($content, $is_sensitive, $is_javascript);
	} else {
	    $content = $this->_trimFlags($content);
	}

	// add flags again?
	if (!$trim_flags) {

	    // recreate flag-comment
	    $content_flags = '<!-- ';
	    foreach ($this->flags as $index => $value) {
		$content_flags.= $index;
	    }
	    $content_flags.= ' | -->'.chr(10);

	    // add to content
	    $content = $content_flags.$content;
	}

	return $content;
    }

    /** Set line markers
     * @param string|array $content
     *	Content of file to parse
     * @param bool $get_string
     *	Return string?
     *
     * @return string
     */
    public function setLineMarkers ($content, $get_string = false) {

	// get array
	$was_string = false;
	if (!is_array($content)) {
	    $was_string = true;
	    $content = explode(chr(10), $content);
	}

	// append marker to the end of each line
	$counter = 0;
	foreach ($content as $in => $val) {
	    $content[$in].= '{line_'.$counter.'}';
	    $counter++;
	}

	// convert back to string?
	if ($was_string OR $get_string) {
	    $content = implode('', $content);
	}

	return $content;
    }

    /** Strip line markers
     * @param string|array $content
     *	Content of file to parse
     *
     * @return string
     */
    public function stripLineMarkers ($content) {

	// get string
	$was_array = false;
	if (is_array($content)) {
	    $was_array = true;
	    $content = implode(chr(10), $content);
	}

	// strip line markers
	$content = preg_replace('#\{line_[0-9]*\}#Usi', '', $content);

	// convert back to array?
	if ($was_array) {
	    $content = explode(chr(10), $content);
	}

	return $content;
    }

    /** Replace language
     * @param string $content
     *	Content of file to parse
     *
     * @return string
     */
    public function replaceLang ($content) {
	return preg_replace_callback(
	    '#(\{(\$[\$a-z_0-9]*\$|)[A-Z_][A-Z0-9_]*\})#U',
	    array($this, '_replaceLangCb'),
	    $content
	);
    }

    /** Replace language replacements (callback function)
     * @param array $input
     *	Input from callback
     *
     * @return string
     */
    private function _replaceLangCb ($input) {
	$input_delimiter_1 = substr($input[0], 0, 1);
	$input_delimiter_2 = substr($input[0], -1);
	$input = substr($input[0], 1, (strlen($input[0]) - 2));

	// replace module
	if (!strstr('$', $input)) {
	    $input = 'mod'.$this->current_module.'__'.$input;
	} else {
	    $input = $this->replaceModule($input);
	}
	$input = strtoupper($input);

	// return, but in upper-case
	return $input_delimiter_1.$input.$input_delimiter_2;
    }

    /** Replace language
     * @param string $content
     *	Content of file to parse
     * @param int $id__module
     *	id__module of current module, the content belongs to
     *
     * @return string
     */
    public function replaceModule ($content, $id__module = false) {

	// set module
	$this->setModule($id__module);

	// validate id__module
	if (empty($this->current_module) OR !is_numeric($this->current_module)) return false;

	// replace
	$content = str_replace('$$$', 'mod'.$this->current_module.'__', $content);
	$content = preg_replace_callback('#(\$[a-zA-Z0-9_]*\$)#Ui', array($this, '_replaceModulCb'), $content);

	return $content;
    }

    /** Replace module (callback function)
     * @param array $input
     *	Input from callback
     *
     * @return string
     */
    private function _replaceModulCb ($input) {
	$input = substr($input[0], 1, (strlen($input[0]) - 2));

	// with id or without?
	$cache = explode('__', $input);
	if (count($cache) == 2) {
	    // with nameid

	    // find module
	    foreach ($this->modules as $index => $value) {
		if ($index == strtolower($cache[0]) AND $value['nameid'] == strtolower($cache[1])) {
		    // match
		    $out = 'mod'.$value['id__module'].'__';
		    if (ctype_upper($input)) {
			return strtoupper($out);
		    } else {
			return $out;
		    }
		}
	    }
	} else {
	    // no nameid

	    // find module
	    foreach ($this->modules as $index => $value) {
		if ($index == strtolower($cache[0])) {
		    // match
		    $out = 'mod'.$value['id__module'].'__';
		    if (ctype_upper($input)) {
			return strtoupper($out);
		    } else {
			return $out;
		    }
		}
	    }
	}

	// no match
	return $input;
    }

    /** Replace database prefix
     * @param string $content
     *	Content of file to parse
     * @param int $id__module
     *	id__module of current module, the content belongs to
     *
     * @return string
     */
    public function replacePreffix ($content, $id__module = false) {

	// set module
	$this->setModule($id__module);

	// replace and return
	return str_replace('#__', $this->prefix, $content);
    }

    /** Remove BOM
     * @param string $input
     *	Input string
     *
     * @return string
     */
    public function removeBom ($input) {
	$input = trim($input);

	// remove bom if neccessary (php5 only, php6 should be able to handle this)
	if (substr($input, 0, 3) == pack('CCC', 0xef,0xbb,0xbf)) {
	    $input = substr($input ,3);
	}

	return trim($input);
    }

    /** Trim code
     * @param string $content
     *	Content of file to parse
     * @param bool $is_sensitive
     *	Skip problematic things?
     * @param bool $force
     *	Force trimming
     *
     * @return string
     */
    public function trim ($content, $is_sensitive = false, $force = false) {
	$content = $this->removeBom($content);

	// get flags
	$this->getFlags($content);

	// skip, if in debug mode
	if (isset($this->flags['p']) OR (!$force AND $this->debug_mode)) {

	    // strip parser-flags only
	    $content = $this->_trimFlags($content);

	    return $content;
	}

	// trim content
	$content = $this->_trim($content, $is_sensitive);

	return $content;
    }

    /** Remove flags from output
     * @param string $content
     *	Content of file to parse
     *
     * @return string
     */
    private function _trimFlags ($content) {
	$content = $this->removeBom($content);

	// are flags?
	if (substr($content, 0, 4) != '<!--') return $content;

	$cache = explode('-->', $content);
	unset($cache[0]);
	$content = implode('-->', $cache);

	return trim($content);
    }

    /** Trim code
     * @param string $content
     *	Content of file to parse
     * @param bool $is_sensitive
     *	Skip problematic things?
     * @param bool $is_javascript
     *	Is javascript content?
     *
     * @return string
     */
    private function _trim ($content, $is_sensitive = false, $is_javascript = false) {

	// skip, if in debug mode
	if (isset($this->flags['p'])) {

	    // strip parser-flags only
	    $content = $this->_trimFlags($content);

	    return $content;
	}

	// skip multi-line comments
	$content = preg_replace('#/\*(.*)\*/#Us', '', $content);

	// strip on-line comments
	if (!$is_sensitive) {
	    if ($is_javascript) {
		// strip one-line comments
		$content = $this->js_stripOneLineComments(array($content));
	    } else {
		// strip one-line comments within javascript
		$content = preg_replace_callback('#\<script type="text\/javascript"\>(.*)\<\/script\>#Usi', array($this, 'js_stripOneLineComments'), $content);

		// strip one-line comments
		$content = $this->stripOneLineComments($content);
	    }
	}

	// parse content
	$pattern = array();
	$replacement = array();

	// skip new lines and tabs
	if (!$is_sensitive) {
	    $pattern[] = '#(\n\r|\n|\r|\t)#Usi';
	    $replacement[] = ' ';

	    // skip double spaces
	    $pattern[] = '#(\s[\s]+)#si';
	    $replacement[] = ' ';
	}

	$pattern[] = '#\<\?php[\s|\t]*\?\>#Usi';
	$replacement[] = '';

	$pattern[] = '#\<\!--.*--\>#Usi';
	$replacement[] = '';

	// replace
	$content = preg_replace($pattern, $replacement, $content);

	return trim($content);
    }

    /** Skip all one-line comments in javascript (callback)
     * @param string $content
     *	Content to parse
     *
     * @return string
     */
    public function js_stripOneLineComments ($content) {
	$content = $content[0];

	// strip on-line comments
	$content = $this->stripOneLineComments($content, false);

	return trim($content);
    }

    /** Skip all one-line comments
     * @param string $content
     *	Content to parse
     * @param bool $is_php
     *	Is php code (or we will not search for php-tags)?
     *
     * @return string
     */
    public function stripOneLineComments ($content, $is_php = true) {

	// new line before and after php-tags
	$content = str_replace('<?php', chr(10).'<?php'.chr(10), $content);
	$content = str_replace('?>', chr(10).'?>'.chr(10), $content);
?><?php

	// new line before double slashs
	$content = str_replace('//', chr(10).'//', $content);

	// explode in single lines
	$cache_content = explode(chr(10), $content);

	$in_php = false;
	$in_single_quotes = false;
	$in_double_quotes = false;
//	$empty_lines_pre = 0;
	foreach ($cache_content as $index => $value) {

	    // count and skip empty lines
    //	if ($empty_lines_pre < 0) $empty_lines_pre = 0;
	    if (trim($value) === '') {
    //	    $empty_lines_pre++;
		unset($cache_content[$index]);
		continue;
	    } else {
    //	    $empty_lines_pre = $empty_lines_pre * (-1);
	    }
	    $value = trim($value);
	    $cache_content[$index] = trim($cache_content[$index]);

	    // if is_php, skip all other content
	    if ($is_php == true) {
		// check, if within php-tags
		if (preg_match('#\<\?php#', $value) != 0
			AND $in_single_quotes == false
			AND $in_double_quotes == false) {
		    $in_php = true;
		} elseif (preg_match('#(\?\>)#', $value) != 0
			AND $in_single_quotes == false
			AND $in_double_quotes == false) {
		    $in_php = false;
		}

		// skip, if not in php-tags
		if ($in_php === false) continue;
	    }

	    // skip one-line comments
	    if (substr($value, 0, 2) == '//') {

		// check, if within string
		if ($in_single_quotes == true OR $in_double_quotes == true) {
		    // no comment; within quotes -> add to previous line

		    $cache_content[($index-1)].= $value;
		} else {

		}
		$cache_content[$index] = '';
		unset($cache_content[$index]);
		continue;
	    }

	    // check, if string ends/beginns in this line
	    $cache_value = $value;
	    while ($cache_value != '') {
		if ($in_single_quotes == true) {
		    if (substr_count($cache_value, "'") > 0) {
			if (strpos($cache_value, "'") == 0 OR substr($cache_value, (strpos($cache_value, "'")-1), 1) != chr(92)) {
			    // single quote is not escaped
			    $in_single_quotes = false;
			}
			// get rest of string
			$cache_value = substr($cache_value, (strpos($cache_value, "'")+1));
		    } else {
			// whole line within string
			$cache_value = '';
		    }
		} elseif ($in_double_quotes == true) {

		    if (substr_count($cache_value, '"') > 0) {
			if (strpos($cache_value, '"') == 0 OR substr($cache_value, (strpos($cache_value, '"')-1), 1) != chr(92)) {
			    // double quotes are not escaped
			    $in_double_quotes = false;
			}
			// get rest of string
			$cache_value = substr($cache_value, (strpos($cache_value, '"')+1));
		    } else {
			// whole line within string
			$cache_value = '';
		    }
		} else {

		    // check, if any quotes in line
		    if (substr_count($cache_value, '"') != 0
			    OR substr_count($cache_value, "'") != 0) {

			// get first quote
			if (substr_count($cache_value, '"') == 0
			    OR (substr_count($cache_value, '"') != 0
				AND substr_count($cache_value, "'") != 0
				AND strpos($cache_value, "'") < strpos($cache_value, '"'))) {
			    // single quote first
			    $cache_value = substr($cache_value, (strpos($cache_value, "'")+1));
			    $in_single_quotes = true;

			} else {
			    // double quote first

			    $cache_value = substr($cache_value, (strpos($cache_value, '"')+1));
			    $in_double_quotes = true;
			}
		    } else {

			// no quote remaining
			$cache_value = '';
		    }
		}
	    }
	}

	// implode content
	$content = implode(' ', $cache_content);

	return $content;
    }
}
?>
