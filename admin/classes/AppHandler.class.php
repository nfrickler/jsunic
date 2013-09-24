<?php
/**
 * Class to load all apps
 */
class AppHandler {

    /** App objects of all existing apps
     * @var array $apps
     */
    private $apps;

    /** Validate source code
     * @param bool $force_update
     *	Force to get new list from database (not a cached one from obj-var)
     *
     * @return array
     */
    public function getApps ($force_update = false) {
	global $Config;

	// already in obj-var?
	if (!$force_update AND isset($this->apps) AND !empty($this->apps))
	    return $this->apps;

	// get available sources
	$subfolders = FileHandler::getSubfolders($Config->get('dir_root').'/apps/');
	if (!is_array($subfolders)) return false;

	// get app-objects and save them in obj-var
	$apps_files = array();
	foreach ($subfolders as $index => $value) {
	    $apps_files[] = new App($value);
	}

	// add already deleted apps and rearrange
	$this->apps = array();
	foreach ($apps_files as $index => $Value) {
	    $this->apps[$Value->getInfo('name')] = $Value;
	}

	// sort
	ksort($this->apps);

	// sort apps by dependencies
	usort($this->apps, array($this, 'cb_sortByDependencies'));
	$this->apps = array_reverse($this->apps);

	return $this->apps;
    }

    /** Get app by name
     * @param string $name
     *	Name of app
     *
     * @return object
     */
    public function getApp ($name) {
	return (isset($this->apps[$name])) ? $this->apps[$name] : NULL;
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
	//var_dump("Compare: $nameA <=> $nameB");

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
}
?>
