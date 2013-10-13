/**
 * Log user in
 */
function users__login () {
    var email = document.getElementById("users__login__email").value;
    var password = document.getElementById("users__login__password").value;
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

    return false;
}
