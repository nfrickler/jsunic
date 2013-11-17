/**
 * JavaScript part of view form_contact
 */
function contacts__form_contact__init () {
    var Forms = new FormsObj();

    // Get empty Contact object
    var obj = new Contacts__ContactObj();

    // Show all attributes of contact
    Forms.printForm('#contacts__form_contact__attributes', obj);

    // Make Contact editable
    Forms.makeNew('#contacts__form_contact__attributes', obj);

    // Save all
    $('#contacts__form_contact__submit').click(function () {
	$('#contacts__form_contact__attributes input').each(function () {
	    jQuery(this).trigger({ type : 'keypress', which : 13 });
	}); 
    });
}
