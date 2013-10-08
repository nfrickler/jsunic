/**
 * Register new user
 */
function users__register () {
    var email = document.getElementById("email").value;
    var password = document.getElementById("password").value;
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

    return false;
}
