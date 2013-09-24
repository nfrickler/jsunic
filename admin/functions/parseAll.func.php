<?php
function parseAll () {
    global $Config, $ModuleHandler, $Log;

    // allow only, if logged in
    if (!isset($_SESSION['admin_auth']) OR empty($_SESSION['admin_auth']))
	return false;

    // reset session var, if accessing page normally
    if (!isset($_GET['call'])) {
	unset($_SESSION['parseAll__call']);
    }

    // set global Objects
    global $SubcodeHandler, $Parser, $USERSYSTEM;

    // is first call or a consecutive one?
    if (isset($_SESSION['parseAll__call']) AND !empty($_SESSION['parseAll__call'])) {
	// is consecutive call
	$call_num = $_SESSION['parseAll__call']['num'];
	$SubcodeHandler = $_SESSION['parseAll__call']['SubcodeHandler'];
	$USERSYSTEM = $_SESSION['parseAll__call']['USERSYSTEM'];
	$Parser = $_SESSION['parseAll__call']['Parser'];
	$modules_all = $_SESSION['parseAll__call']['modules_all'];
	$pre_system_online = $_SESSION['parseAll__call']['pre_system_online'];
    } else {
	// is first call
	$call_num = 0;
	$SubcodeHandler = new ts_SubcodeHandler();
	$modules_all = $ModuleHandler->getModules(true);
	$Parser = new ts_Parser($Config->get('prefix'), $modules_all, $Config->get('debug_mode'));
	$USERSYSTEM = 0;
	$pre_system_online = false;
    }

    if ($call_num == 0) {

	// log
	$Log->doLog(3, "Rendering: remove old files");

	// all directories and files that will be recreated
	$dir_runtime = $Config->get('dir_runtime');
	$rc_dirs = array(
	    $Config->get('dir_runtime').'/classes',
	    $Config->get('dir_runtime').'/functions',
	    $Config->get('dir_runtime').'/templates',
	    $Config->get('dir_runtime').'/files',
	    $Config->get('dir_runtime').'/static',
	    $Config->get('dir_runtime').'/lang',
	    $Config->get('dir_runtime').'/javascript',
	    $Config->get('dir_runtime').'/xmlResponses',
	    $Config->get('dir_runtime').'/help'
	);
	$rc_files = array(
	    $Config->get('dir_runtime').'/index.php',
	    $Config->get('dir_runtime').'/ajax.php',
	    $Config->get('dir_runtime').'/init.php',
	    $Config->get('dir_runtime').'/offline.php',
	    $Config->get('dir_runtime').'/webdav.php',
	    $Config->get('dir_runtime').'/file.php'
	);

	// set system as offline
	$pre_system_online = $Config->get('system_online');
	$Config->set('system_online', false);
	$Config->set('system_offline_since', date('m/d/y H:i:s'));

	// backup current runtime
	/*
	if (!ts_BackupHandler::backupRuntime(true)) {
	    $_SESSION['admin_error'] = 'ERROR__RENDER (backup runtime dir)';
	    return false;
	}
	 */

	// delete all dirs and files which will be recreated
	foreach ($rc_dirs as $index => $value) {
	    if (!ts_FileHandler::emptyFolder($value)) {
		$_SESSION['admin_error'] = 'ERROR__RENDER (empty runtime dirs)';
		return false;
	    }
	}
	foreach ($rc_files as $index => $value) {
	    if (file_exists($value)) unlink($value);
	}

    } elseif ($call_num > 0 AND $call_num <= count($modules_all)) {

	// render all activated modules
	$call_counter = 0;
	$counter = 0;
	foreach ($modules_all as $index => $Value) {
	    $counter++;

	    // skip those, already parsed
	    if ($counter < $call_num) continue;

	    // parse module
	    if (!$Value->parse()) {
		$_SESSION['admin_error'] = 'ERROR__RENDER (module: '.$Value->getInfo('name').')';
		return false;
	    }
	    $call_counter++;

	    // always parse 2 modules at a time
	    if ($call_counter <= 1) {
		$call_num++;
		continue;
	    }

	    break;
	}

    } else {

	// log
	$Log->doLog(3, "Rendering: finish");

	// USERSYSTEM set?
	if (!$USERSYSTEM) {
	    $_SESSION['admin_error'] = 'ERROR__RENDER (usersystem is missing!)';
	    return false;
	}

	// render subcodes
	if (!$SubcodeHandler->parseAll()) {
	    $_SESSION['admin_error'] = 'ERROR__RENDER (subfunction-parsing)';
	    return false;
	}

	// render all activated styles
	$StyleHandler = new ts_StyleHandler();
	$styles_all = $StyleHandler->getStyles(true);
	$selected_default_style = $Config->get('default_style');
	$is_default_style = false;
	foreach ($styles_all as $index => $Value) {
	    if ($selected_default_style and
		$Value->getInfo('id') == $selected_default_style
	    ) $is_default_style = true;
	    if (!$Value->parse()) {
		$_SESSION['admin_error'] = 'ERROR__RENDER (style: '.$Value->getInfo('name').')';
		return false;
	    }
	}

	// set default style, if missing
	if (!$is_default_style) {
	    $first_style = array_shift($styles_all);
	    $Config->set('default_style', $first_style->getInfo('id'));
	}

	// make sure, a default-style is chosen
	$StyleHandler->validateDefault();

	// move special files to runtime root
	$special_files = array(
	    'index.php',
	    'ajax.php',
	    'webdav.php',
	    'offline.php',
	    'init.php',
	    'file.php'
	);
	foreach ($special_files as $index => $value) {
	    if (file_exists($Config->get('dir_runtime')."/static/$value") and !ts_FileHandler::moveFile($Config->get('dir_runtime')."/static/$value", $Config->get('dir_runtime')."/$value")) {
		$_SESSION['admin_error'] = 'ERROR__RENDER (copy special files "'.$value.'")';
		return false;
	    }
	}

	// config
	$config = '<?php include "'.$Config->get('dir_data').'/config.php"; ?>';
	if (!ts_FileHandler::writeFile($Config->get('dir_runtime').'/config.php', $config, 1)) {
	    $_SESSION['admin_error'] = 'ERROR__RENDER (write config)';
	    return false;
	}

	// reset system_online
	$Config->set('system_online', $pre_system_online);

	// update installation-progress
	if ($Config->get('installation') < 100) {
	    $Config->setArray('installation_progress', 'parseAll', true);
	}

	$_SESSION['admin_info'] = 'INFO__RENDER_SUCCESS';
    }

    // update call-progress
    if ($call_num > (count($modules_all)+2)) {
	// finished
	unset($_SESSION['parseAll__call']);
    } else {
	// save vars
	if (!isset($_SESSION['parseAll__call']) OR empty($_SESSION['parseAll__call']))
	    $_SESSION['parseAll__call'] = array();
	$_SESSION['parseAll__call']['num'] = $call_num + 1;
	$_SESSION['parseAll__call']['SubcodeHandler'] = $SubcodeHandler;
	$_SESSION['parseAll__call']['USERSYSTEM'] = $USERSYSTEM;
	$_SESSION['parseAll__call']['Parser'] = $Parser;
	$_SESSION['parseAll__call']['modules_all'] = $modules_all;
	$_SESSION['parseAll__call']['pre_system_online'] = $pre_system_online;

	// redirect to next
	header('Location:?event=parseAll&call='.$call_num);
	exit;
    }

    return true;
}
?>
