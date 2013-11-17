
function ConfigObj (path) {

    /**
     * Path to server config-file
     */
    this.path = path;

    /**
     * Configuration settings
     */
    this.config = new Array();

    /**
     * Get setting
     */
    this.get = function (name) {
	return this.config[name];
    }

    /**
     * Set setting
     */
    this.set = function (name, value) {
	if (!this.config) this.load();
	this.config[name] = value;
    }

    /**
     * Load configuration from config file
     */
    this.load = function () {
	JSunic.loadOnce(
	    this.path,
	    function (response) {
		JSunic.Config.config = response;
		JSunic.Config.initLanguage();
	    },
	    function (response) {
		document.write(
		    "Installation is incomplete (config missing)!");
	    },
	    'json',
	    false
	);
    }

    /**
     * Preset language with browser language
     */
    this.initLanguage = function () {
	var fulllang = navigator.language || navigator.userLanguage;
	var splitted = fulllang.split("-");
	var newlang = splitted[0];
	this.set("lang", newlang);

	$('#core__language option').removeAttr('selected');
	$("#core__language option[value='"+newlang+"']")
	    .attr('selected',true);
    }
}
