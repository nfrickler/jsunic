<?php
/**
 * Class representing an App
 */
class App extends Packet {

    /**
     * Directory of apps
     * @var string $dir
     */
    protected $dir = "apps";

    /**
     * Build process
     *
     * @return bool
     */
    public function build () {
	$path_min = $this->getPath()."/".$this->get('name').".min.js";

	// Create minimized js file
	$content = "/* This file merges all libs of this app */\n";
	if (!FileHandler::writeFile($path_min, $content, true)) {
	    return false;
	}

	// Merge all javascript files into one
	$path_libs = $this->getPath()."/libs/";
	$files = FileHandler::getSubfiles($path_libs);

	// Sort files by name
	sort($files);

	foreach ($files as $index => $value) {

	    // Skip temporary files
	    if (substr($value, -4) == ".swp") continue;

	    $content = FileHandler::readFile($path_libs.$value);
	    if (!FileHandler::writeFile($path_min, "\n".$content, false)) {
		return false;
	    }
	}

	return true;
    }
}
?>
