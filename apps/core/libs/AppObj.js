/**
 * App object
 */
function AppObj (apppath) {

    /**
     * Path of app
     */
    this.apppath = apppath;

    /**
     * Load app information
     */
    this.load = load;
    function load (success_cb, fail_cb) {
	var Current = this;
	JSunic.load(
	    apppath+"appinfo.json",
	    function (response) {
		$.extend(true, Current, response);
		success_cb();
	    },
	    function (response) {
		// App not found!
		fail_cb();
	    },
	    undefined,
	    false
	);
    }
}
