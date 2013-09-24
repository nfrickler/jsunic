<?php
/**
 * Abstract packet module
 */
abstract class Packet {

    /** Name of packet
     * @var string $path
     */
    protected $name;

    /** Array holding information about this packet from version.xml
     * @var array $infofile
     */
    protected $infofile = array();

    /** Constructor
     * @param int $id
     *	Id of packet
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

    /** Get/update path to packet
     * @param string $name
     *	Name of packet
     * @param bool $save
     *	Save path in obj-var (or return path)?
     *
     * @return string|bool
     */
    abstract protected function _getPath ($name, $save);

    /** Convert name to id (add Style to database if not exists)
     *
     * @return bool
     */
    abstract protected function _findId ();

    /* ######################### handle packet ########################## */

    /** Get info about packet
     * @param string $name
     *	Name of information to gather
     * @param bool $refresh
     *	Refresh cached infos?
     *
     * @return mix
     */
    abstract public function getInfo ($name, $refresh);

    /** Get info from version.xml
     * @param string $name
     *	Name of information to gather
     * @param bool $refresh
     *	Refresh cached infos?
     *
     * @return mix
     */
    public function getInfofile ($name, $refresh = false) {

	// refresh?
	if ($refresh) $this->infofile = array();

	// check, if requested info is already in $this->info
	if (
	    isset($this->infofile, $this->infofile[$name]) AND
	    !empty($this->infofile[$name])
	) return $this->infofile[$name];

	// load from version-file
	if (!$this->path OR !file_exists($this->path.'/version.xml')) return NULL;
	$xmldata = XmlHandler::readAll($this->path.'/version.xml');

	// read data in infofile
	foreach ($xmldata as $index => $values) {
	    $this->infofile[$values['tag']] = $values['value'];
	}

	// try again to return requested info
	if (isset($this->infofile, $this->infofile[$name]))
	    return $this->infofile[$name];
	return NULL;
    }

    /** Is valid packet object?
     *
     * @return bool
     */
    public function isValid () {
	if (is_dir($this->path) AND $this->is_valid) return true;
	return false;
    }
}
?>
