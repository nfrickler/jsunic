/**
 * JavaScript part of view index
 */
function contacts__form_person__init () {

    // Get empty Person object
    var obj = new Contacts__PersonObj();

    // Show all attributes of person
    obj.printData($('#contacts__form_person__attributes'));

    // Make Person editable
    var Forms = new FormsObj();
    Forms.makeEditable('#contacts__form_person__attributes');
}
