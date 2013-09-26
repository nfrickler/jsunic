<?php
function deleteApp () {

    // Get name of app
    $name = (isset($_GET['name'])) ? $_GET['name'] : '';
    if (empty($name)) return true;

    // get App object
    $App = new App($name);

    // delete
    if (!$App->delete()) {
	$_SESSION['admin_error'] = 'DELETEAPP__ERROR';
	return false;
    }

    $_SESSION['admin_info'] = 'DELETEAPP__SUCCESS';
    return true;
}
?>
