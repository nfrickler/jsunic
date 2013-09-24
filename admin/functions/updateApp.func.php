<?php
function updateApp () {
    global $Config, $Parser;

    // get Parser object
    $AppHandler = new ts_AppHandler();
    $apps_all = $AppHandler->getApps(true);
    $Parser = new ts_Parser($Config->get('prefix'), $apps_all, $Config->get('debug_mode'));

    // get id__app
    $id__app = (isset($_GET['id']) AND is_numeric($_GET['id'])) ? $_GET['id'] : 0;
    if (empty($id__app)) return true;

    // get app-object
    $App = new ts_App($id__app);

    // update
    if (!$App->updateApp()) {
	// error
	$_SESSION['admin_error'] = 'ERROR__UPDATEAPP';
	return false;
    }

    $_SESSION['admin_info'] = 'INFO__UPDATEAPP';
    return true;
}
?>
