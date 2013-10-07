
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
    this.get = get;
    function get (name) {
	return this.config[name];
    }

    /**
     * Set setting
     */
    this.set = set;
    function set (name, value) {
	if (!this.config) this.load();
	this.config[name] = value;
    }

    /**
     * Load configuration from config file
     */
    this.load = load;
    function load () {
	JSunic.loadOnce(
	    this.path,
	    function (response) {
		JSunic.Config.config = response;
	    },
	    function (response) {
		document.write(
		    "Installation is incomplete (config missing)!");
	    },
	    'json',
	    true
	);
    }
}
