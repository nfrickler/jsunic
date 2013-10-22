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
		    alert('show app');
		});
	    }

	},
	function (response) {
	    JSunic.error('Connection to AppStore failed!');
	},
	'json'
    );
}
