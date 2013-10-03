/**
 * Register new user
 */
function users__register () {
    var email = document.getElementById("email").value;
    var password = document.getElementById("password").value;
    var mbr = document.getElementById("mbr").value;

    // Validate email + password + mbr!
    if (password.length < 1 || email.length < 1 || mbr.length < 1) {
	JSunic.error("Missing email, password or data service!");
	return false;
    }
    // TODO

    // generate symkey
    var salt = email;
    JSunic.symkey = CryptoJS.PBKDF2(password, salt, { keySize: 512/32 });

    // try to log in
    JSunic.register(email, mbr);

    return false;
}
