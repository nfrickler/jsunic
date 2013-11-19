/**
 * Request object
 * This object represents a JSunic request and offers easy access to the
 * parameters
 */
function RequestObj(i_link) {
    var link = i_link;
    var appname;
    var viewname;
    var params = {};

    /**
     * Init request
     */
    var _init = function () {
	var appcode = link.split('&');

	appname = (appcode.length > 0) ? appcode[0] : '#core';
	if (!appname || appname == '#') appname = '#core';
	appname = appname.substr(1);
	viewname = (appcode.length > 1) ? appcode[1] : undefined;

	// Save params
	if (appcode.length > 2) {
	    appcode.splice(0,2);
	    for (var i = 0; i < appcode.length; i++) {
		var splitted = appcode[i].split('=', 2);
		params[_uri2value(splitted[0])] = (splitted.length > 1)
		    ? _uri2value(splitted[1]) : true;
	    }
	}
    }

    /**
     * Custom URI to value converter
     */
    var _uri2value = function (input) {
	return _normalize(decodeURIComponent(input));
    }

    /**
     * Normalize input
     */
    var _normalize = function (input) {
	var Regex = /[^\s\.\?\!,a-zA-Z0-9_=#-]/g;
	input = input.replace(Regex, "?");
	return input;
    }

    /**
     * Open requested page
     */
    this.open = function () {
	if (viewname) {
	    JSunic.log('Open view "'+appname+'__'+viewname+'"');
	    JSunic.appview(appname, viewname, this.param('rootpopup'));
	} else {
	    JSunic.log('Open App "'+appname+'"');
	    JSunic.app(appname);
	}
    }

    /**
     * Get parameter
     */
    this.param = function (name) {
	return params[name];
    }

    /**
     * Get link
     */
    this.getLink = function () {
	return link;
    }

    _init();
}
