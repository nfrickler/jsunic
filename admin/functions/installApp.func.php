<?php
function installApp () {
    global $Config, $Parser, $AppHandler;

    // get Parser object
    $AppHandler = new ts_AppHandler();
    $modules_all = $AppHandler->getApps(true);
    $Parser = new ts_Parser($Config->get('prefix'), $modules_all, $Config->get('debug_mode'));

    // get id__module
    $id__module = (isset($_GET['id']) AND is_numeric($_GET['id'])) ? $_GET['id'] : 0;
    if (empty($id__module)) return true;

    // get module-object
    $App = new ts_App($id__module);

    // install
    if (!$App->installApp()) {
	// error
	$_SESSION['admin_error'] = 'ERROR__INSTALLAPP';
	return false;
    }

    $_SESSION['admin_info'] = 'INFO__INSTALLAPP';
    return true;
}
?>
