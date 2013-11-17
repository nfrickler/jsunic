/**
 * JavaScript part of view register
 */
function users__register__init () {
    $('#users__register__form').submit(function (e) {
	e.preventDefault();
	users__register();
    });
}

function users__register () {
    var email = $('#users__login__email').val();
    var password = $('#users__login__password').val();
    JSunic.User = new UserObj();

    // Validate email + password!
    if (!JSunic.User.validEmail(email) ||
	!JSunic.User.validPassword(password)
    ) {
	JSunic.error("Invalid e-mail or password!");
	return false;
    }

    // generate symkey
    JSunic.User.setSymkey_pass(email, password);

    // try to log in
    JSunic.User.register(email);
}
