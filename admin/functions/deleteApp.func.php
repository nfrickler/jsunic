<?php
function deleteApp () {

    // get id__module
    $id__module = (isset($_GET['id']) AND is_numeric($_GET['id'])) ? $_GET['id'] : 0;
    if (empty($id__module)) return true;

    // get module-object
    $App = new App($id__module);

    // delete
    if (!$App->deleteApp()) {
	// error
	$_SESSION['admin_error'] = 'ERROR__DELETEAPP';
	return false;
    }

    $_SESSION['admin_info'] = 'INFO__DELETEAPP';
    return true;
}
?>
