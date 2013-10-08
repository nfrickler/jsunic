/**
 * Log user in
 */
function users__login () {
    var email = document.getElementById("email").value;
    var password = document.getElementById("password").value;
    JSunic.User = new UserObj();

    // Validate email + password!
    if (password.length < 1 || email.length < 1) {
	JSunic.error("Missing email or password!");
	return false;
    }
    // TODO

    // generate symkey
    var salt = email;
    JSunic.symkey = CryptoJS.PBKDF2(password, salt, { keySize: 512/32 });

    // try to log in
    JSunic.User.login(email);

    return false;
}
