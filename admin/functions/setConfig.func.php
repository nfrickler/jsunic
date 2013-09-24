<?php
function setConfig () {
    global $Config;

    // allow changes only, if logged in
    if (!isset($_SESSION['admin_auth']) OR empty($_SESSION['admin_auth']))
	return false;

    // system online?
    $pre_online_status = $Config->get('system_online');

    // validate input and save in config-file
    foreach ($_POST as $index => $value) {

	// validate data
	if (!($value === false) AND empty($value)) continue;

	// is s.th. to save in config-file?
	if (!substr($index, 0, 5) == 'set__') continue;

	// get name of setting
	$name = substr($index, 5);

	// save in config-file
	$Config->set($name, $value);
    }

    // is system offline/online?
    if ($Config->get('system_online') == true) {
	$Config->delete('system_offline_since');
    } elseif ($pre_online_status == true) {
	$Config->set('system_offline_since', date('m/d/y H:i:s'));
    }

    // update installation-progress
    if ($Config->get('installation') < 100) {
	$Config->setArray('installation_progress', 'setConfig', true);
    }

    $_SESSION['admin_info'] = 'INFO__SAVED';
    return true;
}
?>
