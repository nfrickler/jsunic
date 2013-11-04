/**
 * JavaScript of view "appstore"
 */
function core__appstore__init () {

    // Load path to appstore
    var path = JSunic.Config.get('appstore');
    if (!path) return;

    // Add all installed apps to list
    if (JSunic.Boot.apps.length) {
	$('#core__appstore__installed__list').html("<ul></ul>");
	for (var i in JSunic.Boot.apps) {
	    core__appstore__addapp(
		JSunic.Boot.apps[i], $('#core__appstore__installed__list ul'));
	}
    }

    // Load appstore
    JSunic.load(
	path,
	function (response) {

	    // Clear list div
	    var list = $('#core__appstore__list__div');
	    list.html('<ul id="core__appstore__list" class="core__applist__list"></ul>');
	    list = $('#core__appstore__list');

	    // Remove all Apps from list that are installed already
	    var response_apps = new Array();
	    for (var i in response['apps']) {
		var apparr = response["apps"][i];
		var App = new AppObj(apparr.apppath);
		App.name = i;
		App.pubname = apparr.name;
		App.description = apparr.description;

		if (!App.isInstalled()) {
		    response_apps.push(App);
		}
	    }

	    if (response_apps.length) {
		$('#core__appstore__featured__list').html('<ul></ul>');
		for (var i in response_apps) {
		    core__appstore__addapp(
			response_apps[i], $('#core__appstore__featured__list ul'));
		}
	    }
	},
	function (response) {
	    JSunic.error('Connection to AppStore failed!');
	},
	'json'
    );
}

/**
 * Add App to list
 */
function core__appstore__addapp (App, list) {
    list.append('<li id="core__appstore__list__li__'+App.name+'"><div class="core__applist__list__name">'+App.name+'</div><div class="core__applist__list__description">'+App.description+'</div></li>');
$('#core__appstore__list__li__'+App.name).click(function () {
	core__appstore__showapp(App.apppath);
    });
}

/**
 * Show information about selected app
 */
function core__appstore__showapp (apppath) {

    // Download app information
    var App = new AppObj(apppath);
    App.load(
	function () {
	    core__appstore__appinfo(App);
	},
	function () {
	    JSunic.error("App not found!");
	}
    );
}

/** 
 * Show information about app (path given)
 */
function core__appstore__form__path__submit () {
    var path = $('#core__appstore__path').val();
    core__appstore__showapp(path);
}

/**
 * Show appinfo
 */
function core__appstore__appinfo (App) {
    JSunic.loadview(
	'core', 'appinfo',
	function (response) {
	    $('#content').append(JSunic.parse(response));
	    $('#core__appinfo__h1').html(App.name);
	    $('#core__appinfo__description').html(App.description);

	    $('#core__appinfo__quit').click(function () {
		$('#core__appinfo').remove();
	    });

	    if (App.isInstalled()) {
		$('#core__appinfo__install').html(JSunic.parse('CORE__APPINFO__UNINSTALL'));
		$('#core__appinfo__install').click(function () {
		    core__appinfo__uninstall(App);
		});
	    } else {
		$('#core__appinfo__install').click(function () {
		    core__appinfo__install(App);
		});
	    }
	},
	function (response) {
	    JSunic.error('App not found!');
	}
    );
}
