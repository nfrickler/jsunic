<?php
/**
 * Static class to handle files and folders
 */
class FileHandler {

    /** Get subfolders
     * @param string $path
     *	Path to base folder
     *
     * @return array
     */
    public static function getSubfolders ($path) {
	$subfolders = array();

	// validate input
	if (!is_dir($path)) return array();

	// get subfolders
	$openfolder = opendir($path);
	while ($thefile = readdir($openfolder)) {
	    if ($thefile == '.' OR $thefile == '..' OR !is_dir("$path/$thefile")) continue;
	    $subfolders[] = $thefile;
	}
	closedir($openfolder);

	return $subfolders;
    }

    /** Get files within folder
     * @param string $path
     *	Path to base folder
     *
     * @return array
     */
    public static function getSubfiles ($path) {
	$subfiles = array();

	// validate input
	if (!is_dir($path)) return array();

	// get subfiles
	$openfolder = opendir($path);
	while ($thefile = readdir($openfolder)) {
	    if ($thefile == '.' OR $thefile == '..' OR is_dir($path.'/'.$thefile)) continue;
	    $subfiles[] = $thefile;
	}
	closedir($openfolder);

	return $subfiles;
    }

    /** Move folder including all it subfolders and -files
     * @param string $source
     *	Path of source folder
     * @param string $destination
     *	Path of destination folder (will be created, if nonexistent)
     * @param bool $files_only
     *	Move subfiles only (no subdirectories will be copied)?
     * @param bool|string $prefix
     *	Prefix for all files being moved
     *
     * @return bool
     */
    public static function copyFolder ($source, $destination, $files_only = false, $prefix = false) {

	// check source and destination-folders
	if (!is_dir($source)) return true;
	if (!is_dir($destination) AND !self::createFolder($destination)) return false;

	// move all subfiles
	$subfiles = self::getSubfiles($source);
	foreach ($subfiles as $index => $value) {
	    $dst_name = (!empty($prefix)) ? $prefix.$value : $value;
	    copy($source.'/'.$value, $destination.'/'.$dst_name);
	}

	// move all subfolders
	if (!$files_only) {
	    $subfolders = self::getSubfolders($source);
	    foreach ($subfolders as $index => $value) {
		if (!self::copyFolder($source.'/'.$value, $destination.'/'.$value))
		    return false;
	    }
	}

	return true;
    }

    /** Move file to other destination
     * @param string $source
     *	Path of source file
     * @param string $destination
     *	Path of destination file
     *
     * @return bool
     */
    public static function moveFile ($source, $destination) {
	if (!file_exists($source)) return false;
	return copy($source, $destination);
    }

    /** Delete folder and all it's subfolders and -files
     * @param string $path
     *	Path of folder to delete
     *
     * @return bool
     */
    public static function deleteFolder ($path) {

	// does source exist?
	if (!is_dir($path)) return true;

	// empty folder
	if (!self::emptyFolder($path)) return false;

	// delete folder
	if (!@rmdir($path)) return false;

	return true;
    }

    /** Empty folder and delete all it's subfolders and -files
     * @param string $path
     *	Path of folder to empty
     *
     * @return bool
     */
    public static function emptyFolder ($path) {

	// does source exist?
	if (!is_dir($path) OR !is_dir($path)) return true;

	// remove all subfiles
	$subfiles = self::getSubfiles($path);
	foreach ($subfiles as $index => $value) {
	    @unlink($path.'/'.$value);
	}

	// remove all subfolders
	$subfolders = self::getSubfolders($path);
	foreach ($subfolders as $index => $value) {
	    if (!self::deleteFolder($path.'/'.$value)) return false;
	}

	return true;
    }

    /** Create folder, if not exists
     * @param string $path
     *	Absolute path of folder
     *
     * @return bool
     */
    public static function createFolder ($path) {

	// is folder?
	if (is_dir($path)) return true;

	// get all single folders
	$folders = explode('/', $path);

	// get last existing folder
	$current = $path;
	$to_add = array();
	while (!empty($current)) {

	    // is path?
	    if (is_dir($current)) break;

	    // cut current
	    $to_remove = substr(strrchr($current, '/'),1);
	    $to_add[] = $to_remove;
	    $current = substr($current, 0, (strlen($current) - strlen($to_remove) - 1));
	}

	// create missing folders
	$to_add = array_reverse($to_add);
	foreach ($to_add as $index => $value) {
	    $current.= '/'.$value;
	    if (!is_dir($current) and !mkdir($current)) {
		die('Could not create folder '.$current);
		return false;
	    }
	}

	return true;
    }

    /** Write content to file
     * @param string $path
     *	Path of file
     * @param string $content
     *	Content to write to file
     * @param bool $overwrite
     *	Overwrite file, if already exists?
     *
     * @return bool
     */
    public static function writeFile ($path, $content, $overwrite = false) {

	// create folder
	$path_folder = substr($path, 0, (strlen($path) - strlen(basename($path)) - 1));
	self::createFolder($path_folder);

	// open file
	$filemode = ($overwrite or !file_exists($path)) ? "w" : "a";
	$file = fopen($path, $filemode);

	// write content to file
	if (!$file OR (fwrite($file, $content)) === false) return false;

	// close file
	fclose($file);

	return true;
    }

    /** Read content of file
     * @param string $path
     *	Path of file
     * @param bool $as_array
     *	Return content as array of lines?
     *
     * @return bool
     */
    public static function readFile ($path, $as_array = false) {

	// overwrite?
	if (!file_exists($path)) return ($as_array) ? array() : '';

	// read file
	$content = file($path);

	// return
	return ($as_array) ? $content : trim(implode('', $content));
    }
}
?>
