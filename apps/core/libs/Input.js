/**
 * Input class
 * A class for accessing input values (e.g. GET parameters)
 */
function InputObj() {

    /**
     * Get get value
     *
     * @return mix
     */
    this.get = get;
    function get (name) {
	var query = window.location.search.substring(1);
	var vars = query.split("&");

	// Extract requested variable
	for (var i=0; i < vars.length; i++) {
	    var pair = vars[i].split("=");
	    if (decodeURIComponent(pair[0]) == name) {
		return normalize(decodeURIComponent(pair[1]));
	    }
	}

	return false;
    }

    /**
     * Normalize input
     *
     * @return mix
     */
    this.normalize = normalize;
    function normalize (input) {
	var Regex = /[^\s\.\?\!,a-zA-Z0-9_-]/g;
	input = input.replace(Regex, "?");
	return input;
    }
}
