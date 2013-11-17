/**
 * JavaScript part of view login
 */
function users__login__init () {
    $('#users__login__form').submit(function (e) {
	e.preventDefault();
	users__login();
	return false;
    });
}

function users__login () {
    var email = $('#users__login__email').val();
    var password = $('#users__login__password').val();
    JSunic.User = new UserObj();

    // Validate email + password!
    if (!JSunic.User.validEmail(email) ||
	!JSunic.User.validPassword(password)
    ) {
	JSunic.error("Missing email or password!");
	return false;
    }

    // generate symkey
    JSunic.User.setSymkey_pass(email, password);

    // try to log in
    JSunic.User.login(email);
}
