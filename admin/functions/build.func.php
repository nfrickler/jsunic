<?php
function build () {
    global $Config, $AppHandler, $Log;

    // Allow only, if logged in
    if (!isset($_SESSION['admin_auth']) OR empty($_SESSION['admin_auth']))
	return false;

    // Build all activated apps
    $AppHandler = new AppHandler();
    foreach ($AppHandler->getList() as $index => $Value) {
	if ($Value->get('activated') and !$Value->build()) {
	    $_SESSION['admin_error'] = 'BUILD__ERROR';
	    return false;
    }
    }

    // Build all activated styles
    $StyleHandler = new AppHandler();
    foreach ($StyleHandler->getList() as $index => $Value) {
	if ($Value->get('activated') and !$Value->build()) {
	    $_SESSION['admin_error'] = 'BUILD__ERROR';
	    return false;
	}
    }

    $_SESSION['admin_info'] = 'BUILD__SUCCESS';
    return true;
}
?>
