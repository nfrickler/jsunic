<?php
/**
 * Static class to handle xml files
 */
class XmlHandler {

    /** Get content of xml file as array
     * @param string $path
     *	Path to xml file
     *
     * @return array
     */
    public static function readAll ($path) {
	$output = array();

	// load content of XML file
	if (!file_exists($path)) return false;
	$Xml = simplexml_load_file($path);

	return ($Xml) ? self::xml2array($Xml) : array();
    }

    /** Convert Xml Object to array
     * @param object $Xml
     *	Xml object
     *
     * @return array
     */
    public static function xml2array ($Xml) {
	$out = array();
	foreach ($Xml as $element) {

	    // create new array element
	    $arr = array();
	    $arr['tag'] = $element->getName();

	    // get all attributes
	    $arr['attrs'] = array();
	    foreach ($element->attributes() as $index => $value) {
		$arr['attrs'][$index] = "$value";
	    }

	    // get value
	    if ($element->count()) {
		$arr['value'] = self::xml2array($element);
	    } else {
		$arr['value'] = "$element";
	    }
	    $out[] = $arr;
	}
	return $out;
    }
}
?>
