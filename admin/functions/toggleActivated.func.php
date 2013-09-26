<?php
function toggleActivated () {

    // Allow only, if logged in
    if (!isset($_SESSION['admin_auth']) OR empty($_SESSION['admin_auth']))
	return false;

    // get name and type
    $type = (isset($_GET['type']) and $_GET['type'] == 'app')
	? 'app' : 'style';
    $name = (isset($_GET['name'])) ? $_GET['name'] : '';
    if (empty($name)) {
	$_SESSION['admin_error'] = 'TOGGLEACTIVATED__ERROR';
	return false;
    }

    // get object
    $Obj = NULL;
    switch ($type) {
    case 'app':
	$Obj = new App($name);
	break;
    case 'style':
	$Obj = new Style($name);
	break;
    default:
	$_SESSION['admin_error'] = 'TOGGLEACTIVATED__ERROR';
	return false;
    }

    // Toggle
    if (!$Obj->toggleActivated()) {
	// error
	$_SESSION['admin_error'] = 'TOGGLEACTIVATED__ERROR';
	return false;
    }

    $_SESSION['admin_info'] = 'TOGGLEACTIVATED__INFO';
    header('Location:?event=show'.(($type == 'app') ? 'Apps' : 'Styles'));
    exit;
}
?>
