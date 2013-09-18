
/**
 * Init function to boot up the system
 */
var JSunic;
function init () {

    // Create JSunic object
    JSunic = new JSunicObj();

    // show login
    JSunic.appview('users', 'login');
}

/**
 * JSunic object
 * This object offers the most important methods and attributes
 */
function JSunicObj () {

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
     * Time of idle
     */
    this.idle= 0;

    /**
     * Path to mbr
     */
    this.mbr = "http://localhost/jsunic/services/mbr/";

    /**
     * Path to apps
     */
    this.path_apps = "http://localhost/jsunic/apps/";

    /**
     * Selected language
     */
    this.lang = "en";

    /**
     * Array of language replacements
     */
    this.lang_translations = new Array();

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
     * List of ajax requests and responses
     */
    this.ajax_req = new Array();

    /**
     * Save data packet via ajax call
     */
    this.save = save;
    function save (data, id) {

	// Create new packet, if no id given
	if (!id) id = 0;

	// Encrypt data
	data = this.encrypt(data);

	// Save data
	this.loadOnce(
	    this.path+"index.php?data="
		+encodeURIComponent(data)+"&id="+id,
	    function (response) {
		// get id
		this.tmp_id = $(response).find("data").text();
	    },
	    function (response) {
		JSunic.error("Failed to save data!");
	    },
	    'xml'
	);
    }

    /**
     * Load data packet via ajax call
     */
    this.get = get;
    function get (id) {
	this.loadOnce(
	    this.path+"index.php?id="+id,
	    function (response) {
		var data = $(response).find("data").text();

		// decrypt data
		data = JSunic.decrypt(data);
		JSunic.tmp_data = data;
	    },
	    function (response) {
		JSunic.error("Failed to load data!");
	    },
	    'xml'
	);
    }

    /**
     * Log user in by loading master boot record (MBR)
     */
    this.login = login;
    function login (email) {
	this.loadOnce(
	    this.mbr+"index.php?id="+encodeURIComponent(email),
	    function (response) {
		var data = $(response).find("data").text();

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
		JSunic.appview('users', 'desktop');
		JSunic.info("Login successful.");
	    },
	    function (response) {
		JSunic.fatalError("Failed to load MBR!");
	    },
	    'xml'
	);
    }

    /**
     * Register new user
     */
    this.register = register;
    function register (email, mbr) {

	// encrypt mbr
	mbr = this.encrypt(mbr);

	// load MBR (master boot record)
	this.loadOnce(
	    this.mbr+"index.php?id="+encodeURIComponent(email)+
		"&data="+encodeURIComponent(mbr),
	    function (response) {
		var data = $(response).find("data").text();
		var error = $(response).find("error").text();

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
		JSunic.appview('users', 'login');
		JSunic.info("Registration successful.");
	    },
	    function (response) {
		JSunic.error("An error occurred during registration!");
	    },
	    'xml'
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

	// load view
	this.loadOnce(
	    this.path_apps+app+"/views/"+view+".htm",
	    function (response) {
		$("#root").html(response);
		JSunic.loadLanguage(app);
	    },
	    function (response) {
		JSunic.error("Failed to load view!");
	    },
	    'html'
	);
    }

    /**
     * Parse current HTML
     */
    this.parseHTML = parseHTML;
    function parseHTML () {
	// Set language
	document.body.innerHTML = document.body.innerHTML.replace(
	    /\b[A-Z][A-Z0-9_]+\b/g, function(match, contents, offset, s) {
		if (match in JSunic.lang_translations) {
		    return JSunic.lang_translations[match];
		}
		return match;
	    }
	);
    }

    /**
     * Load language
     */
    this.loadLanguage = loadLanguage;
    function loadLanguage (app) {

	this.loadOnce(
	    this.path_apps+app+"/lang/"+this.lang+".js",	
	    function (response) {
		// load language in lang_translations
		$.extend(JSunic.lang_translations, lang);
		JSunic.parseHTML();
		JSunic.ready = true;
	    },
	    function (response) {
		alert('error: '+msg);
	    }
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
     * Fatale errors. Exit JSunic
     */
    this.error = error;
    function fatalError (msg) {
	alert("Fatal error: "+msg);
	location.href = '?';
    }

    /**
     * Handle infos
     */
    this.info= info;
    function info (msg) {
	alert("Info: "+msg);
    }


    /**
     * Wrapper for ajax calls, that should only be called once
     */
    this.loadOnce = loadOnce;
    function loadOnce (uri, success_cb, fail_cb, type) {

	// Check, if already loaded
	for (var i in this.ajax_req) {
	    if (i.uri == uri) {
		if (i.success) {
		    success_cb(i.response);
		} else {
		    success_cb(i.fail_cb);
		}
		return true;
	    }
	}

	// Load
	this.load(uri, success_cb, fail_cb, type);
	return true;
    }

    /**
     * Wrapper for ajax calls
     */
    this.load = load;
    function load (uri, success_cb, fail_cb, type) {

	// Delete old requests
	var ajax = this.getAjax(uri);
	if (ajax) ajax = {};

	// Create new request
	this.ajax_req.push({
	    uri: uri,
	    success_cb: success_cb,
	    fail_cb: fail_cb,
	    type: type,
	    ok: 0,
	});

	$.ajax({
	    url: uri,
	    dataType: type,
	    success: function (response) {
		var req = JSunic.getAjax(uri);
		if (req) {
		    req.ok = 1;
		    req.response = response;
		    if (success_cb) success_cb(response);
		}
		/* discard */
	    },
	    error: function (response) {
		if (req) {
		    req.ok = -1;
		    req.response = response;
		    if (error_cb) error_cb(response);
		}
		/* discard */
	    }
	});
    }

    /**
     * Get ajax object to uri
     */
    this.getAjax = getAjax;
    function getAjax (uri) {
	for (var i in this.ajax_req) {
	    if (this.ajax_req[i].uri == uri) {
		return this.ajax_req[i];
	    }
	}
    }
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
    JSunic.login(email);

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
    JSunic.register(email, mbr);

    return false;
}

/**
 * Remove duplicate elements in array
 */
function arrayUnique (array) {
    var a = array.concat();
    for(var i = 0; i < a.length; i++) {
	for(var j = i+1; j < a.length; j++) {
	    if(a[i] === a[j])
		a.splice(j--, 1);
	}
    }

    return a;
};
