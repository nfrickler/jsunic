<?php
/**
 * Class to handle Packet objects
 */
abstract class PacketHandler {

    /** Array of all existing objects
     * @var array $list
     */
    protected $list;

    /**
     * Directory where

    /**
     * Get path to dir containing objects
     */
    abstract public function getPath();

    /** Get all objects
     * @param bool $force_update
     *	Force to update cache
     *
     * @return array
     */
    public function getList ($force_update = false) {
	global $Config;

	// Return from cache
	if (!$force_update AND isset($this->list) AND !empty($this->list))
	    return $this->list;

	// Get all subfolders
	$subfolders = FileHandler::getSubfolders($this->getPath());
	if (!is_array($subfolders)) return false;

	// Create one object per subfolder
	$this->list = array();
	foreach ($subfolders as $index => $value) {
	    $this->list[$value] = $this->getObject($value);
	}

	// sort
	ksort($this->list);

	return $this->list;
    }

    /**
     * Get object
     * @var string $name
     *  Name of object
     *
     * @return Object
     */
    abstract public function getObject ($name);

    /**
     * Get object with certain name
     */
    public function get ($name) {
	$list = $this->getList();
	return (isset($list[$name])) ? $list[$name] : NULL;
    }
}
?>
