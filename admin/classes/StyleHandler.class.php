<?php
/**
 * Class to handle Style objects
 */
class StyleHandler extends PacketHandler {

    /**
     * Get path to directory containing styles
     *
     * @return string
     */
    public function getPath () {
	global $Config;
	return $Config->get('dir_root').'/styles/';
    }

    /**
     * Set default style
     *
     * @return bool
     */
    public function setDefault ($name) {
	global $Config;

	// Does style exist?
	if (!$this->get($name)) return false;

	// Save in Config
	$Config->set('default_style', $name);

	return true;
    }

    /**
     * Get default style
     *
     * @return string
     */
    public function getDefault () {
	global $Config;
	return $Config->get('default_style');
    }

    /**
     * Get object
     * @var string $name
     *  Name of object
     *
     * @return Object
     */
    public function getObject ($name) {
	return new Style($name);
    }
}
?>
