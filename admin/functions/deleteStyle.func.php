<?php
function deleteStyle () {

    // Get name
    $name = (isset($_GET['name'])) ? $_GET['name'] : '';
    if (empty($name)) return true;

    // Get Style object
    $Style = new Style($name);

    // Delete Style
    if (!$Style->delete()) {
	$_SESSION['admin_error'] = 'DELETESTYLE__ERROR';
	return false;
    }

    $_SESSION['admin_info'] = 'DELETESTYLE__SUCCESS';
    return true;
}
?>
