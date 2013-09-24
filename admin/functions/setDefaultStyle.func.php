<?php
function setDefaultStyle () {
    global $Config;

    // get id__style
    $id__style = (isset($_GET['id']) AND is_numeric($_GET['id']))
	? $_GET['id'] : 0;
    if (empty($id__style)) return true;

    // delete
    if ($Config->set('default_style', $id__style)) {
	// error
	$_SESSION['admin_error'] = 'ERROR__SETDEFAULTSTYLE';
	return false;
    }

    $_SESSION['admin_info'] = 'INFO__SETDEFAULTSTYLE';
    return true;
}
?>
