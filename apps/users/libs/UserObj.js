/**
 * User object
 * An object as representation of current user
 */
function UserObj () {

    /**
     * Symkey of user
     */
    this.symkey = "";
    this.enc_prefix = '#pref#';
    this.enc_infix = '#infix#';

    /**
     * AES object
     */
    this.aes_bits = 256;
    this.aes = null;

    /**
     * Log user in by loading master boot record (MBR)
     */
    this.login = login;
    function login (email) {

	// Load Mbr
	var Mbr = new MbrObj(JSunic.mbr_path, email);
	Mbr.load(
	    function () {
		JSunic.info("Login successful.");

		// Get Boot object
		JSunic.Boot = new BootObj(Mbr.data);
	    },
	    function () {
		JSunic.fatalError("Failed to load MBR!");
	    }		
	);
    }

    /**
     * Register new user
     */
    this.register = register;
    function register (email) {

	// load MBR (master boot record)
	JSunic.loadOnce(
	    JSunic.mbr_path+"index.php?id="+encodeURIComponent(email)+
		"&data="+encodeURIComponent(1),
	    function (response) {
		var data = $(response).find("data").text();
		var error = $(response).find("error").text();

		// error?
		if (!data && error) {
		    JSunic.error("Registration failed ("+error+")");
		    JSunic.ready = true;
		    return;
		}

		// decrypt data if required
		data = JSunic.decrypt(data);

		if (!data) {
		    // login failed!
		    JSunic.error("Registration failed!");
		    JSunic.app('users', 'register', false);
		    JSunic.ready = true;
		    return;
		}
		JSunic.path = data;
		JSunic.appview('core', 'desktop');
		JSunic.info("Registration successful.");
	    },
	    function (response) {
		JSunic.error("An error occurred during registration!");
	    },
	    'xml'
	);
    }

    /**
     * Log user out
     */
    this.logout = logout;
    function logout () {
	JSunic.User = null;
	this.symkey = false;
	JSunic.info("Logout successful.");
	JSunic.app('users');
    }

    /**
     * Encrypt data
     */
    this.encrypt = encrypt;
    function encrypt (data) {
	if (this.aes == null) this.aes =
	    new pidCrypt.AES.CBC();
	data = this.enc_prefix+this.aes.encryptText(
	    this.enc_infix+data, this.symkey, {nBits: this.aes_bits}
	);
	return data;
    }

    /**
     * Decrypt data
     */
    this.decrypt = decrypt;
    function decrypt (data) {
	if (this.aes == null) this.aes =
	    new pidCrypt.AES.CBC();

	// remove prefix
	if (data.substr(0, this.enc_prefix.length) != this.enc_prefix) {
	    // data not encrypted
	    return data
	}
	data = data.substr(this.enc_prefix.length);

	// decrypt
	data = this.aes.decryptText(
	    data, this.symkey, {nBits: this.aes_bits}
	);

	// Decryption ok?
	if (data.substring(0, this.enc_infix.length) != this.enc_infix) {
	    return null;
	}

	return data.substr(this.enc_infix.length);
    }

    /**
     * Is valid password?
     */
    this.validPassword = validPassword;
    function validPassword (password) {
	// TODO
	if (password.length < 1)
	    return false;
	return true;
    }

    /**
     * Is valid email?
     */
    this.validEmail = validEmail;
    function validEmail (email) {
	// TODO
	if (email.length < 1)
	    return false;
	return true;
    }

    /**
     * Set symkey from password
     */
    this.setSymkey_pass = setSymkey_pass;
    function setSymkey_pass (email, password) {
	var salt = email;
	this.symkey = CryptoJS.PBKDF2(password, salt, { keySize: 512/32 });
    } 
};
