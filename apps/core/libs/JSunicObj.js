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
    this.save = function (data, id) {

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
    this.encrypt = function (data) {
	if (this.User) return this.User.encrypt(data);
	this.fatalError("Encryption not ready!");
    }

    /**
     * Decrypt data of User
     */
    this.decrypt = function (data) {
	if (this.User) return this.User.decrypt(data);
	this.fatalError("Decryption not ready!");
    }

    /**
     * Has user access to specified view?
     * If not redirect to login
     */
    this.access = function (app, view, param) {
	// TODO: App specific access handling
	if (app == 'users' && (view == 'login' || view == 'register'))
	    return true;

	// Is logged in?
	if (!this.Boot) {
	    JSunic.open('#users&login&redirect='+
		encodeURIComponent(btoa(request.getLink())));
	    return false;
	}

	return true;
    }

    /**
     * Load data packet via ajax call
     */
    this.get = function (id) {
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
     * Open link (#appname&viewname&param1=value1&param2=value2)
     */
    this.open = function (hashcode) {
	request = new RequestObj(hashcode);
	request.open();
    }

    /**
     * Get current request
     */
    this.getRequest = function () {
	return request;
    }

    /**
     * Start app
     */
    this.app = function (name, doInit) {
	if (typeof doInit == 'undefined') doInit = true;
	this.current_app = name;

	// Load <<app>>.min.js
	this.loadOnce(
	    this.path_apps+name+"/"+name+".min.js",
	    function (response) {
	    },
	    function (response) {
		JSunic.error("Failed to load app!");
	    },
	    'script',
	    false
	);

	// Run init function
	if (doInit) eval(name+'__init();');
    }

    /**
     * Load app-view
     */
    this.appview = function (app, view, isRootpopup) {
	if (!this.access(app, view)) return false;
	if (typeof isRootpopup === 'undefined') content = false;
	this.current_app = app;
	this.current_view = view;

	// Load app
	this.app(app, false);

	// Load language
	JSunic.loadLanguage(app);

	// Load view
	this.loadview(
	    app,
	    view,
	    function (response) {

		// Set view as content
		$('#content').html(JSunic.parse(response));

		// Try to run JavaScript code of view
		var initname = app+'__'+view+'__init';
		if (typeof window[initname] === "function") {
		    window[initname]();
		}
	    },
	    function (response) {
		JSunic.error("Failed to load view!");
	    }
	);
    }

    /**
     * Load appview
     */
    this.loadview = function (app, view, success_cb, fail_cb) {
	this.loadOnce(
	    this.path_apps+app+"/views/"+view+".htm",
	    success_cb,
	    fail_cb,
	    'html'
	);
    }

    /**
     * Reload current view
     */
    this.reload = function () {
	request.open();
    }

    /**
     * Parse input and insert language
     */
    this.parse = function (input) {
	if (!input) return '';
	return JSunic.parseHTML_language(input);
    }

    /**
     * Parse input for language replacements
     */
     this.parseHTML_language = function (input) {
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
    this.loadLanguage = function (app, language) {
	if (typeof language === 'undefined') language = false;
	if (!language) language = JSunic.Config.get("lang");
	this.loadOnce(
	    this.path_apps+app+"/lang/"+language+".js",
	    function (response) {
		// load language in lang_translations
		$.extend(JSunic.lang_translations, lang);
	    },
	    function (response) {

		// Fallback to english
		if (language != "en") {
		    JSunic.loadLanguage(app, "en");
		    return;
		}

		// Error: Language files not available!
		JSunic.error("Missing english language file for app '"+app+"'");
	    },
	    undefined,
	    false
	);
    }

    /**
     * Handle errors
     */
    this.error = function (msg) {
	this.log(msg);
	alert("Error: "+msg);
    }

    /**
     * Log message
     */
    this.log = function (msg) {
	console.log(msg);
    }

    /**
     * Fatal errors. Exit JSunic
     */
    this.fatalError = function (msg) {

	// TODO: remove alert (debugging only)
	alert('FatalError: '+msg);
	return;

	location.href = '?app=core&event=fatal&error='
	    +encodeURIComponent(msg);
    }

    /**
     * Handle infos
     */
    this.info = function (msg) {
	this.log(msg);
	alert("Info: "+msg);
    }

    /**
     * Wrapper for ajax calls, that should only be called once
     */
    this.loadOnce = function (uri, success_cb, fail_cb, type, async) {
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
    this.load = function (uri, success_cb, fail_cb, type, async) {
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
	   // TODO: enable async
	   // async: async,
	    async: false,
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
    this.getAjax = function (uri) {
	for (var i in this.ajax_req) {
	    if (this.ajax_req[i].uri == uri) {
		return this.ajax_req[i];
	    }
	}
    }

    /**
     * Convert packetId to path
     */
    this.packetId2path = function (packetId) {
	if (this.Boot) return this.Boot.packetId2path(packetId);
	return packetId;
    }
};
