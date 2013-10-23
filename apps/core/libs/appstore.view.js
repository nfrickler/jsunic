/**
 * JavaScript of view "fatal"
 */
function core__appstore__init () {

    // Load path to appstore
    var path = JSunic.Config.get('appstore');
    if (!path) return;

    // Load appstore
    JSunic.load(
	path,
	function (response) {

	    // Clear list div
	    var list = $('#core__appstore__list__div');
	    list.html('<ul id="core__appstore__list" class="core__applist__list"></ul>');
	    list = $('#core__appstore__list');

	    for (var i in response["apps"]) {
		var app = response["apps"][i];
		list.append('<li id="core__appstore__list__li__'+app["name"]+'"><div class="core__applist__list__name">'+app["name"]+'</div><div class="core__applist__list__description">'+app["description"]+'</div></li>');
		$('#core__appstore__list__li__'+app["name"]).click(function () {
		    core__appstore__showapp(app["apppath"]);
		});
	    }
	},
	function (response) {
	    JSunic.error('Connection to AppStore failed!');
	},
	'json'
    );
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
	    $('#core__appinfo__install').click(function () {
		alert('clicked on install');
		core__appinfo__install(App);
	    });
	},
	function (response) {
	    JSunic.error('App not found!');
	}
    );
}
