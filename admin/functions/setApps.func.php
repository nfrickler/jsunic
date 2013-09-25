<?php
function setApps () {
    global $Config;
    global $AppHandler;

    // allow only, if logged in
    if (!isset($_SESSION['admin_auth']) OR empty($_SESSION['admin_auth']))
	return false;

    // get input
    $apps_activated = array();
    foreach ($_POST as $index => $value) {
	if (substr($index, 0, 8) != 'app__') continue;
	$apps_activated[] = substr($index, 8);
    }

    // get objects of all apps
    $apps_all = $AppHandler->getApps();

    // activate or deactivate apps
    foreach ($apps_all as $index => $Value) {
	$new_status = (in_array($Value->get('id__app'), $apps_activated)) ? true : false;
	if (!$Value->activate($new_status)) return false;
    }

    // update installation-progress
    if ($Config->get('installation') < 100) {
	$Config->setArray('installation_progress', 'setApps', true);
    }

    $_SESSION['admin_info'] = 'INFO__SETAPPS_SUCCESS';
    return true;
}
?>
