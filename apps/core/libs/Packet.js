/**
 * Packet object. This is prototype of all objects that can be saved as packet
 */
function Packet (packetId) {

    /**
     * PacketId
     */
    this.packetId = packetId;

    /**
     * Object information
     */
    this.data = [
	/*
	{
	    "type": "text",
	    "id": "uniqueid",
	    "name": "Displayname",
	    "description": "Some description of this data",
	    "value": "The data",
	},
	*/
    ];

    /**
     * Object links to other objects
     */
    this.olinks = [
	/*
	{
	    "name": "Example link",
	    "packetId": 0,
	    "description": "This is an example",
	},
	*/
    ];

    /**
     * Load this object
     */
    this.load = function (success_cb, fail_cb) {
	if (typeof success_cb == 'undefined') {
	    success_cb = function () { return; }
	}
	if (typeof fail_cb == 'undefined') {
	    fail_cb = function () { return; }
	}

	// Get path
	var path = JSunic.packetId2path(this.packetId);
	if (!path) {
	    fail_cb();
	    return;
	}

	var Current = this;
	JSunic.loadOnce(
	    path,
	    function (response) {
		var rawdata = $(response).find("data").text();

		// Get json
		rawdata = JSunic.decrypt(rawdata);
		if (!rawdata) {
		    // login failed!
		    fail_cb();
		    return;
		}

		// Parse json and add to this object
		var data = JSON.parse(rawdata);
		$.extend(true, Current, data);

		success_cb();
	    },
	    function (response) {
		fail_cb();
	    },
	    'xml',
	    false
	);
    }

    /**
     * Save attribute
     */
    this.saveAttribute = function (name, value) {
	var found = false;
	for (var i = 0; i < this.data.length; i++) {
	    if (this.data[i].id == name) {
		this.data[i].value = value;
		found = true;
		break;
	    }
	}
	if (!found) {
	    this.data.push({
		'name': name,
		'value': value,
	    });
	}
	this.save();
    }

    /**
     * Get attributes
     */
    this.getAttributes = function () {
	return this.data;
    }

    /**
     * Get certain attribute
     */
    this.getAttribute = function (id) {
	for (var i = 0; i < this.data.length; i++) {
	    if (this.data[i].id == id) {
		return this.data[i];
	    }
	}
	return undefined;
    }

    /**
     * Save this object
     */
    this.save = function (success_cb, fail_cb, async) {
	if (typeof success_cb == 'undefined')
	    success_cb = function () { return; }
	if (typeof fail_cb == 'undefined')
	    fail_cb = function () { return; }

	// Get path
	if (!this.packetId) this.packetId = 0;
	var path = JSunic.packetId2path(this.packetId);
	if (!path) {
	    fail_cb();
	    return;
	}

	// Encrypt data
	this.classname = this.constructor;
	var jsonstring = JSON.stringify(this, function (name, value) {
	    if (name == "packetId")
		return undefined;
	    if (name.substr(0,2) == '__')
		return undefined;
	    return value;
	});
	jsonstring = JSunic.encrypt(jsonstring);

	var Current = this;
	JSunic.loadOnce(
	    path+"&data="+encodeURIComponent(jsonstring),
	    function (response) {
		var rawdata = $(response).find("data").text();
		var error = $(response).find("error").text();

		if (rawdata == 'Updated') {
		    success_cb(0);
		    return;
		}
		if (!isNaN(rawdata)) {
		    Current.packetId += ">"+rawdata;

		    success_cb(rawdata);
		    return;
		}

		fail_cb(error);
	    },
	    function (response) {
		fail_cb(response);
	    },
	    'xml',
	    false
	);
    }

    /**
     * Remove this object
     */
    this.remove = function (success_cb, fail_cb) {
	if (typeof success_cb == 'undefined')
	    success_cb = function () { return; }
	if (typeof fail_cb == 'undefined')
	    fail_cb = function () { return; }

	// Get path
	var path = JSunic.packetId2path(this.packetId);
	if (!path) {
	    fail_cb();
	    return;
	}

	JSunic.loadOnce(
	    path+"&data=0",
	    function (response) {
		var rawdata = $(response).find("data").text();

		if (rawdata == 'Deleted') {
		    success_cb();
		    return;
		}

		fail_cb();
	    },
	    function (response) {
		fail_cb();
	    },
	    'xml'
	);
    }

    /**
     * Get index of this object
     */
    this.getIndex = function () {
	return {
	    "packetId": this.packetId,
	};
    }
}
