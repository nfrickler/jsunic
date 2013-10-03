/**
 * Init function to boot up the system
 */
var JSunic;
function core__init () {

    // Create JSunic object
    JSunic = new JSunicObj();

    // Start users app
    JSunic.app('users');
}
