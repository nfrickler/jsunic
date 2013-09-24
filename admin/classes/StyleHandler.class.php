<?php
/**
 * Class to handle Style objects in general
 */
class StyleHandler {

    /** Style objects of all existing styles
     * @var array $styles
     */
    private $styles;

    /** Make sure that a default style has been set
     *
     * @return bool
     */
    public function validateDefault () {

	// get all styles
	$styles = $this->getStyles();

	// is default?
	$no = true;
	$possible_default = false;
	foreach ($styles as $index => $Value) {
	    if ($Value->getInfo('is_default')) {
		$no = false;
	    } elseif ($Value->getStatus() == 5 OR $Value->getStatus() == 9) {
		$possible_default = $Value;
	    }
	}

	// set a random one, if possible
	if ($no AND $possible_default) {
	    $possible_default->setAsDefault();
	}

	return true;
    }

    /** Get all styles
     * @param bool $force_update
     *	Force to get new list from database (not a cached one from obj-var)?
     *
     * @return array
     */
    public function getStyles ($force_update = false) {
	global $Database, $Config;

	// already in obj-var?
	if (!$force_update AND isset($this->styles) AND !empty($this->styles)) return $this->styles;

	// get available sources
	$subfolders = FileHandler::getSubfolders($Config->get('dir_root').'/styles');
	if (!is_array($subfolders)) return false;

	// get style objects and save them in obj-var
	$style_files = array();
	foreach ($subfolders as $index => $value) {
	    $style_files[] = new Style(false, $value);
	}

	// add already deleted styles
	$this->styles = array();
	foreach ($style_files as $index => $Value) {
	    $this->styles[$Value->getInfo('name').'__'.$Value->getInfo('nameid')] = $Value;
	}

	// sort
	ksort($this->styles);

	return $this->styles;
    }
}
?>
