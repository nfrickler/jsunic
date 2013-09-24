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

    /** Array holding information about this packet from version.xml
     * @var array $infofile
     */
    protected $infofile = array();

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
	return $this->getInfo('name');
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
    public function getInfo ($name, $refresh = false) {

	// Refresh?
	if ($refresh) $this->info = array();

	// Return from cache
	if (isset($this->info, $this->info[$name]) AND
	    !empty($this->info[$name])
	) return $this->info[$name];

	// Load from version.xml
	if (!file_exists($this->getPath().'/version.xml'))
	    return NULL;
	$xmldata = XmlHandler::readAll($this->getPath().'/version.xml');

	// Save data in $this->info
	$this->info = array();
	foreach ($xmldata as $index => $values) {
	    $this->info[$values['tag']] = $values['value'];
	}

	// Return requested data
	if (isset($this->info[$name])) return $this->info[$name];

	return NULL;
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
}
?>
