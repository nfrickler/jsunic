/**
 * Boot packet
 */
BootObj.prototype = new Packet();
function BootObj (packetId, path) {
    this.packetId = packetId;

    /**
     * Index object list
     */
    this.index = {};
    this.__index = {};

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
    this.init = function () {
	// Show bootinit
	JSunic.open('#core&bootinit');
    }

    /**
     * Load configuration from config file
     */
    this.load = function () {
	var Boot = this;
	BootObj.prototype.load.call(
	    this,
	    function (response) {
		JSunic.open('#core&desktop');
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
    this.updateNavigation = function () {

	// Clear navigation
	$('#core__index__navig__apps li').remove();

	// Recreate navigation
	var naviglist = $('#core__index__navig__apps');
	for (var i = 0; i < this.apps.length; i++) {
	    var id = "core__index__navig__apps__"+this.apps[i].name;
	    naviglist.append(
		'<li id="'+id+'"><a href="#'+this.apps[i].name+'">'+
		this.apps[i].pubname+'</a></li>'
	    );
	}
    }

    /**
     * Add storage location
     */
    this.addStorage = function (path) {
	this.storages.push(path);
    }

    /**
     * Add App
     */
    this.addApp = function (App) {
	this.apps.push(App);
	this.save();
	this.updateNavigation();
    }

    /**
     * Remove App
     */
    this.removeApp = function (App) {
	this.apps.splice(this.apps.indexOf(App), 1);
	this.save();
	this.updateNavigation();
    }

    /**
     * Set path to MBR
     */
    this.updateMBR = function (success_cb, fail_cb) {

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
    this.packetId2path = function (packetId) {

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

    /**
     * Get Index object of App
     */
    this.appIndex = function (app) {
	if (!this.index[app]) {
	    this.__index[app] = new IndexObj();
	    this.__index[app].save();
	    this.index[app] = this.__index[app].packetId;
	    this.save();
	}
	if (!this.__index[app]) {
	    this.__index[app] = new IndexObj(this.index[app]);
	    this.__index[app].load();
	}
	return this.__index[app];
    }
}
