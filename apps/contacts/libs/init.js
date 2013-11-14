/**
 * Init function
 */
function contacts__init () {

    // Init Index
    JSunic.addIndex('contacts', new Contacts__IndexObj());

    // Goto Index
    JSunic.appview("contacts", "index");
}
