<?php
function resetAll () {
    global $Database;
    global $Config;

    // allow changes only, if logged in
    if (!isset($_SESSION['admin_auth']) OR empty($_SESSION['admin_auth']))
	return false;

    // uninstall all modules
    // TODO

    // delete all runtime- and user-files
    // TODO

    // delete main tables
    $sql_0 = "DROP TABLE IF EXISTS #__modules, #__languages;";
    $result_0 = $Database->doDelete($sql_0);
    if (!$result_0) return false;

    // reset installation-progress
    $Config->delete('installation_progress');

    $_SESSION['admin_info'] = 'INFO__ALLRESET_SUCCESS';
    return true;
}
?>
