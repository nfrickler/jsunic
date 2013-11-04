/**
 * Boot packet
 */
BootObj.prototype = new Packet();
function BootObj (packetId, path) {
    this.packetId = packetId;

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
    if (path) this.storages.push(path);

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
	var Boot = this;
	BootObj.prototype.load.call(
	    this,
	    function (response) {
		JSunic.appview('core', 'desktop');
		Boot.updateNavigation();
	    },
	    function (response) {
		// No Boot packet found. Init new one...
		Boot.init();
	    }
	);
    }

    /**
     * Update navigation
     */
    this.updateNavigation = updateNavigation;
    function updateNavigation () {

	// Clear navigation
	$('#core__index__navig__apps li').remove();

	// Recreate navigation
	var naviglist = $('#core__index__navig__apps');
	for (var i = 0; i < this.apps.length; i++) {
	    var id = "core__index__navig__apps__"+this.apps[i].name;
	    naviglist.append("<li id='"+id+"'><a href='#'>"+this.apps[i].pubname+"</a></li>");
	    var name = this.apps[i].name;
	    $("#"+id+" a").click(function () {
		JSunic.app(name);
	    });
	}
    }

    /**
     * Add storage location
     */
    this.addStorage = addStorage;
    function addStorage (path) {
	this.storages.push(path);
    }

    /**
     * Add App
     */
    this.addApp = addApp;
    function addApp (App) {
	this.apps.push(App);
	this.save();
	this.updateNavigation();
    }

    /**
     * Remove App
     */
    this.removeApp = removeApp;
    function removeApp (App) {
	this.apps.splice(this.apps.indexOf(App), 1);
	this.save();
	this.updateNavigation();
    }

    /**
     * Set path to MBR
     */
    this.updateMBR = updateMBR;
    function updateMBR (success_cb, fail_cb) {

	// Save location of Boot in Mbr
	var packetPath = this.packetId2path(this.packetId);
	var splitted = packetPath.split('?');
	JSunic.Mbr.boot_path = splitted[0];
	JSunic.Mbr.boot_packetId = this.packetId;
	JSunic.Mbr.save(
	    success_cb,
	    fail_cb
	);

	// TODO: Delete old mbr
    }

    /**
     * Convert packetId to path
     */
    this.packetId2path = packetId2path;
    function packetId2path (packetId) {

	// New packetId
	if (!packetId) {
	    return this.storages[0]+'?';
	}

	// Split packetId (storageId>ObjectId)
	var splitted = packetId.split('>');
	if (splitted.length < 2) return packetId;
	if (isNaN(splitted[0]) || isNaN(splitted[1])) return false;

	// Return path
	if (!this.storages[splitted[0]]) return false;
	return this.storages[splitted[0]]+'?id='+splitted[1];
    }
}
