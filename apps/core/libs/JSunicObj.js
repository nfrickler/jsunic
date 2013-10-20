/**
 * JSunic object
 * This is the core object of JSunic and provides the basic functionality
 */
function JSunicObj () {

    /**
     * Current version of JSunic
     */
    this.version = "JSunic 0.1";

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
     * Path to boot packet
     */
    this.boot_path;

    /**
     * Boot object
     */
    this.Boot = null;

    /**
     * Path to mbr service
     */
    this.mbr_path = "http://localhost/jsunic/services/mbr/";

    /**
     * MBR object
     */
    this.Mbr = null;

    /**
     * Path to apps
     */
    this.path_apps = "http://localhost/jsunic/apps/";

    /**
     * Array of language replacements
     */
    this.lang_translations = new Array();

    /**
     * Current app and template
     */
    this.current_app;
    this.current_view;

    /**
     * App-View cache
     */
    this.appviewcache = new Array();

    /**
     * List of ajax requests and responses
     */
    this.ajax_req = new Array();

    /**
     * Config object
     */
    this.Config = new ConfigObj("config.json");

    /**
     * User object (will be set at login)
     */
    this.User;

    /**
     * Save data packet via ajax call
     */
    this.save = save;
    function save (data, id) {

	// Create new packet, if no id given
	if (!id) id = 0;

	// Encrypt data
	data = User.encrypt(data);

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
     * Encrypt data of User
     */
    this.encrypt = encrypt;
    function encrypt (data) {
	if (this.User) return this.User.encrypt(data);
	this.fatalError("Encryption not ready!");
    }

    /**
     * Decrypt data of User
     */
    this.decrypt = decrypt;
    function decrypt (data) {
	if (this.User) return this.User.decrypt(data);
	this.fatalError("Decryption not ready!");
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
     * Start app
     */
    this.app = app;
    function app (name) {
	this.current_app = name;

	// load app
	this.loadOnce(
	    this.path_apps+name+"/"+name+".min.js",
	    function (response) {
		// Run init
		eval(name+"__init();");
	    },
	    function (response) {
		JSunic.error("Failed to load app!");
	    },
	    'script'
	);
    }

    /**
     * Load app-view
     */
    this.appview = appview;
    function appview (app, view, content) {
	if (typeof content === 'undefined') content = true;
	this.current_app = app;
	this.current_view = view;

	// load view
	this.loadOnce(
	    this.path_apps+app+"/views/"+view+".htm",
	    function (response) {
		if (content) {
		    $("#content").html(response);
		    $("#root").css("display", "block");
		    $("#rootpopup").css("display", "none");
		} else {
		    $("#rootpopup").html(response);
		    $("#root").css("display", "none");
		    $("#rootpopup").css("display", "block");
		}

		// Try to run JavaScript code of view
		var isfkt = false;
		var initname = app+'__'+view+'__init'
		eval('if (typeof '+initname+' === "function") isfkt = true;');
		// TODO: Replace setTimeout with sth. better
		// Function must be called _after_ page has been loaded!
		if (isfkt) setTimeout(initname+'();', 100);

		JSunic.loadLanguage(app);
	    },
	    function (response) {
		JSunic.error("Failed to load view!");
	    },
	    'html'
	);
    }

    /**
     * Reload current view
     */
    this.reload = reload;
    function reload () {
	this.appview(this.current_app, this.current_view);
    }

    /**
     * Parse current HTML
     */
    this.parseHTML = parseHTML;
    function parseHTML () {

	// Set language in document
	document.body.innerHTML =
	    JSunic.parseHTML_language(document.body.innerHTML);

	// Set language in title
	document.title = JSunic.parseHTML_language(document.title);
    }

    /**
     * Parse input for language replacements
     */
    this.parseHTML_language = parseHTML_language;
    function parseHTML_language (input) {
	return input.replace(
	    /\b[A-Z][A-Z0-9_]+\b/g, function(match, contents, offset, s) {
		if (match == "JSUNIC__VERSION") return JSunic.version;
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
    function loadLanguage (app, language) {
	if (typeof language === 'undefined') language = false;
	if (!language) language = JSunic.Config.get("lang");
	this.loadOnce(
	    this.path_apps+app+"/lang/"+language+".js",
	    function (response) {
		// load language in lang_translations
		$.extend(JSunic.lang_translations, lang);
		JSunic.parseHTML();
		JSunic.ready = true;
	    },
	    function (response) {

		// Fallback to english
		if (language != "en") {
		    JSunic.loadLanguage(app, "en");
		    return;
		}

		// Error: Language files not available!
		alert('error: '+response);
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
     * Fatal errors. Exit JSunic
     */
    this.fatalError = fatalError;
    function fatalError (msg) {

	// TODO: remove alert (debugging only)
	alert('FatalError: '+msg);
	return;

	location.href = '?app=core&event=fatal&error='
	    +encodeURIComponent(msg);
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
    function loadOnce (uri, success_cb, fail_cb, type, async) {
	if (typeof async === 'undefined') async = true;

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
	this.load(uri, success_cb, fail_cb, type, async);
	return true;
    }

    /**
     * Wrapper for ajax calls
     */
    this.load = load;
    function load (uri, success_cb, fail_cb, type, async) {
	if (typeof async === 'undefined') async = true;

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
	    async: async,
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
		var req = JSunic.getAjax(uri);
		if (req) {
		    req.ok = -1;
		    req.response = response;
		    if (fail_cb) fail_cb(response);
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

    /**
     * Convert packetId to path
     */
    this.packetId2path = packetId2path;
    function packetId2path (packetId) {
	if (this.Boot) return this.Boot.packetId2path(packetId);
	return packetId;
    }
};
