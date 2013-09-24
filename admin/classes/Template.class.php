<?php
/**
 * Template class for backend
 */
class Template {

    /** Path to template file
     * @var string $path
     */
    protected $path;

    /** Name of template
     * @var string $template
     */
    protected $template;

    /** Data for template
     * @var array $data
     */
    protected $data;

    /** Cache
     * @var array $cache
     */
    protected $cache;

    /** Constructor
     * @param string $template
     *	Name of template
     * @param string $design
     *	Name of design
     */
    public function __construct ($template = false, $design = 0) {
	global $TemplateEngine;

	// get input
	$this->template = $template;

	// get data for template
	if (isset($TemplateEngine->data[$template])) {
	    $this->data = $TemplateEngine->data[$template];

	} else {
	    $this->data = array();
	}
    }

    /** Display template
     * @param string $path
     *	Path of template file
     * @param bool $return_error
     *	Return error? (OR return false)
     *
     * @return bool
     */
    public function includeTemplate ($path = false, $return_error = true) {

	// set path
	if ($path == false) $path = 'templates/'.$this->template.'.tpl.php';

	// try to include
	if (file_exists($path)) {
	    include $path;
	} else {
	    // template does not exist
	    echo '<p class="error">Template does not exist! (path: '.$path.')</p>';
	}

	return true;
    }

    /** Display other template
     * @param string $template
     *	Name of template
     * @param bool|array $data
     *	Data for template
     *
     * @return bool
     */
    public function display ($template, $data = false) {
	global $TemplateEngine;

	// get template to include
	$activated = $TemplateEngine->getActivatedTemplates();
	if (empty($template) AND isset($activated['html'], $activated['html'][0])) {
	    $template = $activated['html'][0];
	}

	// get template-object
	$template = new Template($template);

	// display template
	$template->includeTemplate();

	return true;
    }

    /** Print value from $this->data
     * @param string $name
     *	Name of data (true will return all data)
     *
     * @return bool
     */
    public function setVar ($name) {

	// set value
	$this->set($this->getVar($name));
	return;
    }

    /** Get value from $this->data
     * @param string $name
     *	Name of data (true will return all data)
     *
     * @return bool
     */
    public function getVar ($name) {

	// check name
	if (!isset($name) OR empty($name)) return false;

	// return  values
	if ($name === true) return $this->data;
	if (isset($this->data[$name])) return $this->data[$name];

	return false;
    }

    /** Parse for output (language- and bbcode-replacements)
     * @param string $text
     *	Text to parse
     * @param 0|array $vars
     *	Variables to replace in lang-string
     * @param bool $doEcho
     *	Display text (return otherwise)?
     * @param bool $doEscape
     *	Escape single and double quotes?
     *
     * @return bool
     */
    public function set ($text, $vars = 0, $doEcho = true, $doEscape = false) {
	global $TemplateEngine;

	// replace language
	$text = $TemplateEngine->parse($text, $doEscape);

	// validate that $vars is an array
	if ($vars === 0) $vars = array();
	if (!is_array($vars)) $vars = array($vars);
	$this->cache['vars'] = $vars;

	// replace variables (#...#)
	$text = preg_replace_callback('$#([0-9a-zA-zöäüÖÄÜ]+)#$Us', array($this, 'replaceVar'), $text);

	// get new lines and trim finally
	$text = nl2br($text);
	$text = str_replace('\r\n', '<br />', $text);
	$text = str_replace('\n\n', '<br />', $text);
	$text = trim($text);

	// echo or return
	if ($doEcho == true) {
	    // echo and return
	    echo $text;
	    return '';
	} else {
	    // return
	    return $text;
	}
    }

    /** Get lang-var (callback function)
     * @param array $in
     *	[1] -> number (+1) of lang-var
     *
     * @return string
      */
    private function replaceVar ($in) {

	// get index
	$in = str_replace('#', '', $in[1]);

	// check, if replacement exists and return
	if (isset($this->cache['vars'][$in])) return $this->set($this->cache['vars'][$in], false, false);
	if (isset($this->data[$in])) return $this->set($this->data[$in], false, false);
	return '?error?';
    }
}
?>
