/**
 * Index object of contacts app
 */
IndexObj.prototype = new Packet();
function IndexObj (packetId) {
    this.packetId = packetId;

    /**
     * List of objects of this app
     */
    this.objectlist = new Array();

    /**
     * Add object to list
     */
    this.addObj = function (newobject) {
	var packetId = newobject.packetId;

	// Save object
	if (!packetId) {
	    newobject.save(null, null, false);
	    packetId = newobject.packetId;
	}

	// Is not already in Index?
	var found = false;
	for (var i = 0; i < this.objectlist.length; i++) {
	    if (this.objectlist[i].fk_packetId == packetId) {
		found = true;
		break;
	    }
	}
	if (found) return;

	// Save id and index to objectlist
	this.objectlist.push(newobject.getIndex());
	this.objectlist = this.objectlist;
	this.save();
    }

    /**
     * Remove object from list
     */
    this.removeObj = function (myobject) {
	for (var i = 0; i < this.objectlist.length; i++) {
	    if (this.objectlist[i].packetId == myobject.packetId) {
		this.objectlist.slice(i, 1);
	    }
	}
	this.save();
    }

    /**
     * Get all objects of certain type
     */
    this.getObjects = function (type) {
	var out = new Array();
	for (var i = 0; i < this.objectlist.length; i++) {
	    if (this.objectlist[i].type == type) {
		var constr = window[type];
		var newobject = new constr(this.objectlist[i].fk_packetId);
		var exists = false;
		newobject.load(
		    function () {
			exists = true;
		    }
		);
		if (exists) {
		    out.push(newobject);
		}
	    }
	}
	return out;
    }
}
