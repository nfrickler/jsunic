/**
 * Index object of contacts app
 */
IndexObj.prototype = new Packet();
function IndexObj () {

    /**
     * List of objects of this app
     */
    this.objectlist = new Array();

    /**
     * Add object to list
     */
    this.addObj = addObj;
    function addObj (newobject) {

	// Save object
	newobject.save(null, null, false);

	// Save id and index to objectlist
	this.objectlist.push(newobject.getIndex());
    }

    /**
     * Remove object from list
     */
    this.removeObj = removeObj;
    function removeObj (myobject) {
	for (var i = 0; i < this.objectlist.length; i++) {
	    if (this.objectlist[i].packetId == myobject.packetId) {
		this.objectlist.slice(i, 1);
	    }
	}
    }

    /**
     * Get all objects of certain type
     */
    this.getObjects = getObjects;
    function getObjects (type) {
	var out = new Array();
	for (var i = 0; i < this.objectlist.length; i++) {
	    if (this.objectlist[i].type == type) {
		out.push(this.objectlist[i]);
	    }
	}
	return out;
    }
}
