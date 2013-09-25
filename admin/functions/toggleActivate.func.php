<?php
function toggleActivate () {

    // get id__module
    $type = (isset($_GET['type']) and $_GET['type'] == 'app')
	? 'app' : 'style';
    $name = (isset($_GET['name'])) ? $_GET['name'] : '';
    if (empty($name)) {
	$_SESSION['admin_error'] = 'ERROR__TOGGLEACTIVATE';
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
	$_SESSION['admin_error'] = 'ERROR__TOGGLEACTIVATE';
	return false;
    }

    // Toggle
    if (!$Obj->toggleActivate()) {
	// error
	$_SESSION['admin_error'] = 'ERROR__TOGGLEACTIVATE';
	return false;
    }

    $_SESSION['admin_info'] = 'INFO__TOGGLEACTIVATE';
    header('Location:?event=show'.(($type == 'app') ? 'Apps' : 'Styles'));
    exit;
}
?>
