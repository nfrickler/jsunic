<?php
/**
 * Abstract packet module
 */
class Packet {

    /**
     * Directory relative to root directory, where packets are found
     * @var string $dir
     */
    protected $dir = "";

    /** Name of packet
     * @var string $path
     */
    protected $name;

    /**
     * SimpleXML Object containing all data of this object
     * @var SimpleXML
     */
    protected $Xml;

    /** Constructor
     * @param string $name
     *	Name of packet
     */
    public function __construct ($name = false) {
	// save name
	$this->name = $name;
    }

    /** Get printable name of this object
     *
     * @return string
     */
    public function getName () {
	return $this->get('name');
    }

    /**
     * Get path of packet
     *
     * @return string
     */
    protected function getPath () {
	global $Config;
	return $Config->get('dir_root').'/'.$this->dir.'/'.$this->name;
    }

    /** Get info from version.xml
     * @param string $name
     *	Name of information to gather
     * @param bool $refresh
     *	Refresh cached infos?
     *
     * @return mix
     */
    public function get ($name, $refresh = false) {

	// Load version.xml
	if (!$this->load()) return NULL;

	// Find and return value
	foreach ($this->Xml->children() as $value) {
	    if ($value->getName() == $name) {
		$v = "$value";
		if ($v === 'true') $v = true;
		if ($v === 'false') $v = false;
		return $v;
	    }
	}

	return NULL;
    }

    /**
     * Set value
     *
     * @return bool
     */
    public function set ($name, $newvalue) {

	// Load version.xml
	if (!$this->load()) return false;

	$done = false;
	if ($newvalue === true) $newvalue = 'true';
	if ($newvalue === false) $newvalue = 'false';
	if ($this->Xml->$name) {
	    $this->Xml->$name = $newvalue;
	} else {
	    $this->Xml->addChild($name, $newvalue);
	}
	return $this->save();
    }

    /**
     * Update version.xml
     *
     * @return bool
     */
    public function save () {
	$this->Xml->asXml($this->getPath().'/version.xml');
	return true;
    }

    /**
     * Load version.xml into object
     *
     * @return bool
     */
    public function load () {
	if (isset($this->Xml) and !empty($this->Xml)) return true;
	if (!file_exists($this->getPath().'/version.xml')) {
	    return false;
	}
	$this->Xml = simplexml_load_file($this->getPath().'/version.xml');
	return true;
    }

    /**
     * Is valid packet object?
     *
     * @return bool
     */
    public function isValid () {
	return (is_dir($this->getPath())) ? true : false;
    }

    /**
     * Get status of this packet
     *
     * return string
     */
    public function getStatus () {

	// TODO

	return "invalid";
    }

    /**
     * Toggle activate status
     *
     * @return bool
     */
    public function toggleActivate () {
	$current = $this->get('activated');
	return $this->set('activated', !$this->get('activated'));
    }
}
?>
