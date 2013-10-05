/**
 * Init function to boot up the system
 */
var JSunic;
function core__init () {

    // Create JSunic object
    JSunic = new JSunicObj();

    // App or event given?
    var Input = new InputObj();
    var in_app = Input.get("app");
    var in_event = Input.get("event");

    if (in_app && in_event) {
	// Load requested event
	JSunic.appview(in_app, in_event);
    } else {
	// Start users app
	JSunic.app('users');
    }
}
