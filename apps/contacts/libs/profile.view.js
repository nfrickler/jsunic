/**
 * JavaScript part of view index
 */
function contacts__profile__init () {

    // TODO: define obj
    var obj;

    // Show all attributes of person
    obj.printData($('contacts__profile__attributes'));

    // Make Person editable
    Forms.makeEditable('contacts__profile__attributes');
}
