
/**
 * Init function to boot up the system
 */
var JSunic;
function init () {

    // Create JSunic object
    JSunic = new JSunic();

    // show login
    JSunic.run("JSunic.appview('users', 'login');");
}

/**
 * JSunic object
 * This object offers the most important methods and attributes
 */
function JSunic () {

    /**
     * Command queue
     */
    this.queue = new Array();

    /**
     * Queued command will be executed only,
     * if ready flag is true
     */
    this.ready = true;

    /**
     * Temporary data of ajax-calls
     */
    this.tmp_id = 0;
    this.tmp_data = "";

    /**
     * Path to data
     */
    this.path = "";

    /**
     * Path to mbr
     */
    this.mbr = "http://localhost/jsunic/services/mbr/";

    /**
     * Path to apps
     */
    this.path_apps = "http://localhost/jsunic/apps/";

    /**
     * Symkey of user
     */
    this.symkey = "";
    this.enc_prefix = '#pref#';
    this.enc_infix = '#infix#';

    /**
     * AES object
     */
    this.aes_bits= 256;
    this.aes = null;

    /**
     * App-View cache
     */
    this.appviewcache = new Array();

    /**
     * Add command to queue
     */
    this.run = run;
    function run (cmd) {
	this.queue.push(cmd);
    }

    /**
     * Run next command in queue
     */
    this._run = _run;
    function _run () {

	// ready?
	if (!this.ready) {
	    setTimeout("JSunic._run();", 100);
	    return;
	}

	// no commands?
	if (this.queue.length < 1) {
	    setTimeout("JSunic._run();", 200);
	    return;
	}

	// get and run next command
	eval(this.queue.shift());
	setTimeout("JSunic._run();", 100);
    }

    /**
     * Save data packet
     */
    this.save = save;
    function save (data, id) {

	// Create new packet, if no id given
	if (!id) id = 0;

	// Encrypt data
	data = this.encrypt(data);

	// Save via ajax-call
	ready = false;
	$.get(
	    this.path+"index.php?data="
		+encodeURIComponent(data)+"&id="+id,
	    {language: "php", version: 5},
	    function(responseText){

		// get id
		this.tmp_id = $(responseText).find("data").text();

		// Set ready
		JSunic.ready = true;
	    },
	    "xml"
	);
    }

    /**
     * Load data packet
     */
    this.get = get;
    function get (id) {
	ready = false;

	// Get data via ajax-call
	$.get(
	    this.path+"index.php?id="+id,
	    {language: "php", version: 5},
	    function (responseText) {
		var data = $(responseText).find("data").text();

		// decrypt data
		data = JSunic.decrypt(data);
		JSunic.tmp_data = data;

		JSunic.ready = true;
	    },
	    "xml"
	);
    }

    /**
     * Log user in
     */
    this.login = login;
    function login (email) {
	ready = false;

	// load MBR (master boot record)
	$.get(
	    this.mbr+"index.php?id="+encodeURIComponent(email),
	    {language: "php", version: 5},
	    function (responseText) {
		var data = $(responseText).find("data").text();

		// decrypt data
		data = JSunic.decrypt(data);
		if (!data) {
		    // login failed!
		    JSunic.error("Login failed!");
		    JSunic.appview('users', 'login');
		    JSunic.ready = true;
		    return;
		}
		JSunic.path = data;
		JSunic.run("JSunic.appview('users', 'desktop');");
		JSunic.info("Login successful.");

		JSunic.ready = true;
	    },
	    "xml"
	);
    }

    /**
     * Register new user
     */
    this.register = register;
    function register (email, mbr) {
	ready = false;

	// encrypt mbr
	mbr = this.encrypt(mbr);

	// load MBR (master boot record)
	$.get(
	    this.mbr+"index.php?id="+encodeURIComponent(email)+
		"&data="+encodeURIComponent(mbr),
	    function (responseText) {
		var data = $(responseText).find("data").text();
		var error = $(responseText).find("error").text();

		// error?
		if (!data && error) {
		    JSunic.error("Registration failed ("+error+")");
		    JSunic.ready = true;
		    return;
		}

		// decrypt data
		data = JSunic.decrypt(data);

		if (!data) {
		    // login failed!
		    JSunic.error("Registration failed!");
		    JSunic.appview('users', 'login');
		    JSunic.ready = true;
		    return;
		}
		JSunic.path = data;
		JSunic.run("JSunic.appview('users', 'login');");
		JSunic.info("Registration successful.");

		JSunic.ready = true;
	    },
	    "xml"
	);
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
     * Start app
     */
    this.app = app;
    function app (name) {
	alert('start app "'+name+'"');
    }

    /**
     * Load app-view
     */
    this.appview = appview;
    function appview (app, view) {

	// Is cached?
	if (app in this.appviewcache && view in this.appviewcache[app]) {
	    $("#root").html(this.appviewcache[app][view]);
	    return;
	}

	// load view
	this.ready = false;
	$.get(
	    this.path_apps+app+"/views/"+view+".htm",
	    function (response) {
		$("#root").html(response);
//		JSunic.appviewcache[app][view] = response;
		JSunic.ready = true;
	    },
	    "html"
	);
    }

    /**
     * Handle errors
     */
    this.error = error;
    function error (msg) {
	alert("Error: "+msg);
    }

    /**
     * Handle infos
     */
    this.info= info;
    function info (msg) {
	alert("Info: "+msg);
    }

    this._run();
};

/**
 * Log user in
 */
function login () {
    var email = document.getElementById("email").value;
    var password = document.getElementById("password").value;

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
    JSunic.run("JSunic.login('"+email+"');");

    return false;
}

/**
 * Register new user
 */
function register () {
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
    JSunic.run("JSunic.register('"+email+"', '"+mbr+"');");

    return false;
}
