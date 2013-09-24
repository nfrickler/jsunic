<?php
function setLogin () {
    global $Config;

    // is password already set?
    if ($Config->get('admin_password')) {

	// allow changes only, if logged in
	if (!isset($_SESSION['admin_auth']) OR empty($_SESSION['admin_auth'])) {
	    $_SESSION['admin_error'] = 'ERROR__PLEASELOGIN';
	    header('Location:?event=showLogin');
	    exit;
	}
    }

    // validate input
    if (!isset($_POST['pass']) OR empty($_POST['pass'])) {
	$_SESSION['admin_error'] = 'ERROR__UNKNOWNERROR';
	header('Location:?event=showSetLogin');
	exit;
    }

    // get password
    $pass = md5(md5($_POST['pass']));

    // set password in config-file
    if (!$Config->set('admin_password', $pass)) {
	// error occurred
	$_SESSION['admin_error'] = 'ERROR__UNKNOWNERROR';
	header('Location:?event=showSetLogin');
	exit;
    }

    // update installation-progress
    if ($Config->get('installation') < 100) {
	$Config->setArray('installation_progress', 'setLogin', true);
    }

    // logout
    unset($_SESSION['admin_auth']);

    $_SESSION['admin_info'] = 'INFO__SAVED';
    header('Location:?event=showLogin');
    exit;
}
?>
