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

    // Load config.json
    JSunic.Config.load();

    // Load language
    JSunic.loadLanguage('core');

    // Parse HTML
    $('body').html(JSunic.parse($('body').html()));
    $('title').html(JSunic.parse($('title').html()));

    if (in_app && in_event) {
	// Load requested event
	JSunic.appview(in_app, in_event);
    } else {
	// Start users app
	JSunic.app('users');
    }
}
