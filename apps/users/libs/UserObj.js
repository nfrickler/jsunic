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
    this.login = function (email) {

	// Load Mbr
	JSunic.Mbr = new MbrObj();
	JSunic.Mbr.setPacketId(JSunic.mbr_path, email);
	var success = false;
	JSunic.Mbr.load(
	    function () { success = true; }
	);
	if (!success) return false;

	// Get Boot object
	JSunic.Boot = new BootObj(JSunic.Mbr.boot_packetId,
	    JSunic.Mbr.boot_path);
	JSunic.Boot.load();

	return true;
    }

    /**
     * Register new user
     */
    this.register = function (email) {

	// Load Mbr
	JSunic.Mbr = new MbrObj();
	JSunic.Mbr.setPacketId(JSunic.mbr_path, email);
	JSunic.Mbr.save(
	    function () {
		JSunic.info("Registration successful.");

		// Get Boot object
		JSunic.Boot = new BootObj(JSunic.Mbr.boot_packetId,
		    JSunic.Mbr.boot_path);
		JSunic.Boot.load();
	    },
	    function () {
		JSunic.error("Registration failed!");
	    }
	);
    }

    /**
     * Log user out
     */
    this.logout = function () {
	JSunic.User = null;
	this.symkey = false;
	JSunic.info("Logout successful.");
	JSunic.open('#users');
    }

    /**
     * Encrypt data
     */
    this.encrypt = function (data) {

	// TODO: Enable encryption again (disabled for debugging)
	return data;

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
    this.decrypt = function (data) {
	if (this.aes == null) this.aes =
	    new pidCrypt.AES.CBC();

	// remove prefix
	if (data.substr(0, this.enc_prefix.length) != this.enc_prefix) {
	    // data not encrypted
	    // TODO: We should enforce encryption here!
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
    this.validPassword = function (password) {
	// TODO
	if (password.length < 1)
	    return false;
	return true;
    }

    /**
     * Is valid email?
     */
    this.validEmail = function (email) {
	// TODO
	if (email.length < 1)
	    return false;
	return true;
    }

    /**
     * Set symkey from password
     */
    this.setSymkey_pass = function (email, password) {
	var salt = email;
	this.symkey = CryptoJS.PBKDF2(password, salt, { keySize: 512/32 });
    }
};
