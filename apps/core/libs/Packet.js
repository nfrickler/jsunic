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
    this.load = load;
    function load (success_cb, fail_cb) {

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
	    'xml'
	);
    }

    /**
     * Save this object
     */
    this.save = save;
    function save (success_cb, fail_cb, async) {
	if (typeof success_cb == 'undefined') {
	    success_cb = function () { return; }
	}
	if (typeof fail_cb == 'undefined') {
	    fail_cb = function () { return; }
	}

	// Get path
	if (!this.packetId) this.packetId = 0;
	var path = JSunic.packetId2path(this.packetId);
	if (!path) {
	    fail_cb();
	    return;
	}

	// Encrypt data
	var jsonstring = JSON.stringify(this, function (name, value) {
	    if (name == "packetId")
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
	    async
	);
    }

    /**
     * Remove this object
     */
    this.remove = remove;
    function remove () {

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
    this.getIndex = getIndex;
    function getIndex () {
	return {
	    "packetId": this.packetId,
	};
    }

    /**
     * Print table of contents
     */
    this.printData = printData;
    function printData (div) {
	div.html('');
	div.append('<table>');
	for (var i = 0; i < this.data.length; i++) {
	    var dataobj = this.data[i];
	    div.append(
		'<tr id="'+dataobj.id+'">'+
		'    <th>'+dataobj.name+'</th>'+
		'    <td>'+dataobj.value+'</td>'+
		'</tr>'
	    );
	}
	div.append('</table>');
    }
}
