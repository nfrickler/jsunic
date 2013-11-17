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
    $('#contacts__form_contact__submit').click(function (e) {
	e.preventDefault();
	$('#contacts__form_contact__attributes input').each(function () {
	    jQuery(this).trigger({ type : 'keypress', which : 13 });
	}); 
    });

    // Edit all
    $('#contacts__form_contact__editall').click(function (e) {
	e.preventDefault();
	$('#contacts__form_contact__attributes tr').dblclick();
    });

    // Delete
    $('#contacts__form_contact__delete').click(function (e) {
	e.preventDefault();
	obj.remove(
	    function () {
		JSunic.info('CONTACTS__FORM_CONTACT__DELETE__SUCCESS');
		JSunic.appview('contacts', 'index');
	    },
	    function () {
		JSunic.info('CONTACTS__FORM_CONTACT__DELETE__ERROR');
	    }
	);
    });
}
