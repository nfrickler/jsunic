<?php
/**
 * Template engine class for backend
 */
class TemplateEngine {

    /** Path to template file
     * @var string $lang
     */
    private $lang = array();

    /** Activated templates
     * @var array $activatedTemplates
     */
    public $activatedTemplates = array();

    /** Default object for special operations
     * @var object $dTemplate
     */
    private $dTemplate;

    /** Constructor
     * @param string $design
     *	Name of design
     */
    public function __construct ($design = 0) {
	global $Config;

	// get default template-object
	$this->dTemplate = new Template();

	// get language
	if (!isset($_SESSION['lang'])) {
	    $_SESSION['lang'] = $Config->get('default_language');
	    if (empty($_SESSION['lang'])) $_SESSION['lang']  = 'en';
	}
    }

    /** Activate template for output
     * @param string $template
     *	Name of template
     * @param bool|array $data
     *	Data for template
     *
     * @return bool
     */
    public function activate ($template, $data = false) {

	// set template
	$this->activatedTemplates['html'] = array($template);

	// add data
	$this->setData($template, $data);

	// check, if template really exist
	$path = 'templates/'.$template.'.tpl.php';
	if (!file_exists($path)) {
	    return false;
	}

	return true;
    }

    /** Save data
     * @param string|bool $template
     *	Template, data are for (false: reset all data; true: get all data from session)
     * @param string $data
     *	Data to save
     *
     * @return string
     */
    public function setData ($template, $data = false) {

	// handle true and false
	if ($template === false) {

	    // reset data
	    $this->data = array();

	    return true;
	} else {

	    // return, if empty template
	    if (empty($template)) return false;

	    // in array
	    if (!is_array($data)) $data = array($data);

	    // check, if data for this template already exist
	    if (isset($this->data[$template])) {
		// merge data
		$this->data[$template] = array_merge($this->data[$template], $data);
	    } else {
		// add data
		$this->data[$template] = $data;
	    }
	}

	return true;
    }

    /** Save data
     * @param string $template
     *	Template to fetch data for
     * @param string $name
     *	Name of data
     *
     * @return string
     */
    public function getData ($template, $name = false) {

	// check, if data for template exists
	if (!isset($this->data[$template])) return false;

	// check, if to return all
	if ($name === true) return $this->data[$template];

	// check, if data with name $name exists and return them
	if (is_array($this->data[$template])
		AND isset($this->data[$template][$name])) return $this->data[$template][$name];

	return false;
    }

    /** Parse output text
     * @param string $text
     *	Text to be parsed
     * @param bool $doEscape
     *	Escape single and double quotes?
     *
     * @return string
     */
    public function parse ($text, $doEscape = false) {

	// replace language
	$text = $this->replaceLang($text, $doEscape);

	return $text;
    }

    /** Skip language placeholders
     * @param string $text
     *	Text to be parsed
     * @param bool $doEscape
     *	Escape single and double quotes?
     * @param int $nested
     *	Maximal number of recursive calls for nested language replacements
     *
     * @return string
     */
    public function replaceLang ($text, $doEscape = false, $nested = 0) {
	global $TSunic;

	// set regex
	$regex = '#\b([A-Z_ÄÖÜ][A-Z_ÄÖÜ0-9]+)\b#Us';

	// skip, if no matches
	$matches_pre_count = preg_match_all($regex, $text, $matches_pre, PREG_SET_ORDER);
	if (empty($matches_pre_count)) {
	    // no matches
	    return $text;
	}

	// extract language
	$text = preg_replace_callback(
	    $regex,
	    array($this, 'getLang'),
	    $text
	);

	// return text, if nested >= 5 (prevent infinite loop)
	$nested++;
	if ($nested >= 5) return $text;

	// check, if all replacements done
	$matches_post_count = preg_match_all($regex, $text, $matches_post, PREG_SET_ORDER);
	if (empty($matches_post_count)) {
	    // no matches
	    return $text;
	}

	// replace (recursive)
	return $this->replaceLang($text, $doEscape, $nested);
    }

    /** Get language replacements
     * @param string $index
     *	Language placeholder
     *
     * @return string
     */
    public function getLang ($index) {
	$index = $index[0];

	// check, if replacement already loaded
	if (!isset($this->lang, $this->lang[$index])) {

	    // load language-replacements from file
	    $this->loadLanguage($index);
	}

	// check, if replacement is available
	if (!isset($this->lang[$index])) {
	    // no replacement
	    return $index;
	} else {
	    // replace placeholder
	    $out =  $this->lang[$index];

	    return $out;
	}

	return $text;
    }

    /** Get language replacements
     * @param string $input
     *	Language placeholder or module
     * @param bool|string $lang
     *	Set language to include
     * @param bool $returnOnFail
     *	Return, if include fails?
     *
     * @return bool
     */
    public function loadLanguage ($input, $lang = false, $returnOnFail = false) {
	global $Config;

	// get languages
	$chosen_lang = $_SESSION['lang'];
	$default_lang = $Config->get('default_language');

	// try to include lang-file
	$path = 'templates/lang/'.$chosen_lang.'.lang.php';
	if (file_exists($path)) {
	    include $path;
	} else {
	    $path = 'templates/lang/'.$default_lang.'.lang.php';
	    if (file_exists($path)) {
		include $path;
	    } else {
		// lang-file not available
		return false;
	    }
	}

	// add language-vars
	if (isset($lang) AND is_array($lang))
	    $this->lang = array_merge($this->lang, $lang);
	$lang = false;

	return false;
    }

    /** Display output
     * @param bool|string $template
     *	Name of first template
     *
     * @return bool
     */
    public function display ($template = false) {

	// get template
	if ($template === false) $template = 'html';

	// get template object of first template to display
	$firstTemplate = new Template($template);

	// load templates
	$firstTemplate->includeTemplate();

	return true;
    }

    /** Get activated templates
     *
     * @return array
     */
    public function getActivatedTemplates () {

	// return (array)
	return $this->activatedTemplates;
    }

    /** Clear all activated templates
     *
     * @return bool
     */
    public function clearActivatedTemplates () {

	// clear templates
	$this->activatedTemplates = array();

	return true;
    }
}
?>
