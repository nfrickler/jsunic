<?php
function setStyles () {
    global $Config;

    // get styleHandler-object
    $StyleHandler = new StyleHandler();

    // allow only, if logged in
    if (!isset($_SESSION['admin_auth']) OR empty($_SESSION['admin_auth']))
	return false;

    // get input
    $styles_activated = array();
    foreach ($_POST as $index => $value) {
	if (substr($index, 0, 7) != 'style__') continue;
	$styles_activated[] = substr($index, 7);
    }

    // get objects of all styles
    $styles_all = $StyleHandler->getStyles();

    // activate or deactivate styles
    foreach ($styles_all as $index => $Value) {
	$new_status = (in_array($Value->get('id__style'), $styles_activated)) ? true : false;
	if (!$Value->activate($new_status)) return false;
    }

    // set default style
    foreach ($styles_all as $index => $Value) {
	if ($Value->get('is_default')) {
	    $Config->set('default_style', $Value->get('id'));
	}
    }

    // update installation progress
    if ($Config->get('installation') < 100) {
	$Config->setArray('installation_progress', 'setStyles', true);
    }

    $_SESSION['admin_info'] = 'INFO__SETSTYLES_SUCCESS';
    return true;
}
?>
