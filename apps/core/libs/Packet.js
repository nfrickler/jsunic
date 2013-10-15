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
	JSunic.loadOnce(
	    this.path+"index.php?id="+encodeURIComponent(this.id),
	    function (response) {
		var rawdata = $(response).find("data").text();

		// Decrypt data
		this.data = JSunic.decrypt(rawdata);
		if (!this.data) {
		    // login failed!
		    fail_cb();
		    return;
		}

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
    function save () {

    }

    /**
     * Remove this object
     */
    this.remove = remove;
    function remove () {

    }
}
