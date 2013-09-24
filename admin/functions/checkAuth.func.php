<?php
function checkAuth () {
    global $Config;

    // is password set?
    if ($Config->get('admin_password') === NULL) {
	// redirect to set-password-page
	$_SESSION['admin_info'] = 'INFO__SETPASSWORD';
	header('Location:?event=showSetLogin');
	exit;
    }

    // tries to log in?
    if (isset($_GET['event']) AND $_GET['event'] == 'doLogin') {
	// login

	// validate input
	if (!isset($_POST['pass'])) {
	    $_SESSION['admin_error'] = 'ERROR__LOGINERROR';
	    header('Location:?event=showLogin');
	    exit;
	}

	// validate password
	if (md5(md5($_POST['pass'])) != $Config->get('admin_password')) {
	    $_SESSION['admin_error'] = 'ERROR__LOGINERROR';
	    header('Location:?event=showLogin');
	    exit;
	}

	// successful login
	$_SESSION['admin_auth'] = true;
    }

    // is logged in?
    if (!isset($_SESSION['admin_auth']) OR empty($_SESSION['admin_auth'])) {
	// redirect to login-page
	header('Location:?event=showLogin');
	exit;
    }

    return true;
}
?>
