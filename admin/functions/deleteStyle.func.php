<?php
function deleteStyle () {

    // get id__style
    $id__style = (isset($_GET['id']) AND is_numeric($_GET['id'])) ? $_GET['id'] : 0;
    if (empty($id__style)) return true;

    // get style-object
    $Style = new Style($id__style);

    // delete
    if (!$Style->deleteStyle()) {
	// error
	$_SESSION['admin_error'] = 'ERROR__DELETESTYLE';
	return false;
    }

    $_SESSION['admin_info'] = 'INFO__DELETESTYLE';
    return true;
}
?>
