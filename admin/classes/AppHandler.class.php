<?php
/**
 * Class to handle App objects
 */
class AppHandler extends PacketHandler {

    /**
     * Get path to directory containing apps
     *
     * @return string
     */
    public function getPath () {
	global $Config;
	return $Config->get('dir_root').'/apps/';
    }

    /** Get all objects
     * @param bool $force_update
     *	Force to update cache
     *
     * @return array
     */
    public function getList ($force_update = false) {
	parent::getList($force_update);

	usort($this->list, array($this, 'cb_sortByDependencies'));
	$this->list = array_reverse($this->list);

	return $this->list;
    }

    /** Get order of app A and app B concerning dependencies
     * @param App $modA
     *	App A
     * @param App $modB
     *	App B
     *
     * @return int
     */
    public function cb_sortByDependencies ($modA, $modB) {
	$nameA = $modA->getInfo('name');
	$nameB = $modB->getInfo('name');

	// Does modA depend on modB?
	if ($this->dependOn($modA, $modB)) {
	    return -1;
	}

	// Does modB depend on modA?
	if ($this->dependOn($modB, $modA)) {
	    return 1;
	}

	return 0;
    }

    /** Does A depend on B?
     * @param App $modA
     *	App A
     * @param App $modB
     *	App B
     * @param int $loop
     *	Loop prevention (stop after 30 dependencies)
     *
     * @return bool
     */
    public function dependOn ($modA, $modB, $loop = 0) {
	$loop++;
	if ($loop >= 30) die(
	    "AppHandler: Dependency loop detected! Check dependencies!"
	);
	if (!$modA or !$modB) return false;

	// get name of B
	$nameB = $modB->getInfo('name');

	// get dependencies of A
	$deps = $modA->getInfo('dependencies');

	// A has no deps?
	if (empty($deps)) return false;

	// Check if B is within deps
	foreach ($deps as $index => $values) {
	    if ($values['value'] == $nameB) {
		return true;
	    }
	}

	// Check reverse if B is within deps of deps
	foreach ($deps as $index => $values) {
	    if ($this->dependOn($this->getApp($values['value']), $modB)) {
		return true;
	    }
	}

	return false;
    }

    /**
     * Get object
     * @var string $name
     *  Name of object
     *
     * @return Object
     */
    public function getObject ($name) {
	return new App($name);
    }
}
?>
