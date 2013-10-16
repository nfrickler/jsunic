/**
 * Packet object. This is prototype of all objects that can be saved as packet
 */
function Packet (path, id) {

    /**
     * Storage path
     */
    this.path = path;

    /**
     * ID
     */
    this.id = id;

    /**
     * Decrypted content of packet
     */
    this.data;

    /**
     * Load this object
     */
    this.load = load;
    function load (success_cb, fail_cb) {

	// Fail, if undefined path or id
	if (!this.path || !this.id) {
	    fail_cb();
	    return;
	}

	var Current = this;
	JSunic.loadOnce(
	    this.path+"index.php?id="+encodeURIComponent(this.id),
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

	// Encrypt data
	var jsonstring = JSON.stringify(this);
	jsonstring = JSunic.encrypt(jsonstring);

	var Current = this;
	JSunic.loadOnce(
	    this.path+"index.php?"+
		((this.id) ? "id="+encodeURIComponent(this.id)+"&" : "")+
		"data="+encodeURIComponent(jsonstring),
	    function (response) {
		var rawdata = $(response).find("data").text();
		var error = $(response).find("error").text();

		if (rawdata == 'Updated') {
		    success_cb(0);
		    return;
		}
		if (!isNaN(rawdata)) {
		    Current.id = rawdata;
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
	JSunic.loadOnce(
	    this.path+"index.php?id="+encodeURIComponent(this.id)+"&data=0",
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
}
