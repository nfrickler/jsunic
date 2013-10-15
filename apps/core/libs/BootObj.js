/**
 * Boot packet
 */
BootObj.prototype = new Packet();
function BootObj (path, id) {
    this.path = path;
    this.id = id;

    /**
     * Symkey of user
     */
    this.symkey;

    /**
     * Pubkey of user
     */
    this.pubkey;

    /**
     * Privkey of user
     */
    this.privkey;

    /**
     * Installed Apps
     */
    this.apps = new Array();

    /**
     * Storage locations
     */
    this.storages = new Array();

    /**
     * Initialize Boot
     */
    this.init = init;
    function init () {
	// Show bootinit
	JSunic.appview('core', 'bootinit');
    }

    /**
     * Load configuration from config file
     */
    this.load = load;
    function load () {
	BootObj.prototype.load.call(
	    this,
	    function (response) {
		$.extend(this, this, response);
		alert('Boot loaded');
		JSunic.appview('core', 'desktop');
	    },
	    function (response) {
		// No Boot packet found. Init new one...
		JSunic.Boot.init();
	    }
	);
    }

    /**
     * Add storage location
     */
    this.addStorage = addStorage;
    function addStorage (path) {
	this.storages.push(path);
    }

    /**
     * Set path to MBR
     */
    this.setMBR = setMBR;
    function setMBR (path) {
	this.path = path;
	this.resave();

    }

    this.load();
}
