/**
 * JavaScript part of view profile
 */
function contacts__index__init () {
    var Index = JSunic.Boot.appIndex('contacts');

    if (!Index) {
	JSunic.error("No index found!");
    }

    // Get all contacts
    var contactlist = Index.getObjects('Contacts__ContactObj');
    var attrlist = ['firstname', 'lastname', 'dateofbirth'];
    var tableobj = $('#contacts__index__list');

    // Print table header
    if (contactlist.length > 0) {
	var cur = contactlist[0];
	tableobj.append('<tr>');
	$.each(attrlist, function (index, value) {
	    tableobj.append('    <th>'+JSunic.parse(cur.getAttribute(value).name)+'</th>');
	});
	tableobj.append('</tr>');
    }

    // Print contact list
    for (var i = 0; i < contactlist.length; i++) {
	var cur = contactlist[i];
	var newid = 'contacts__index__list__'+cur.packetId;
	tableobj.append('<tr id="'+newid+'">');
	$.each(attrlist, function (index, value) {
	    var attrval = cur.getAttribute(value).value;
	    if (typeof attrval == 'undefined') {
		tableobj.append('<td>&nbsp;</td>');
	    } else {
		tableobj.append('<td>'+attrval+'</td>');
	    }
	});
	tableobj.append('</tr>');

	// Click on contact to show full profile
	$('#'+newid).click(function () {
	    JSunic.appview('contacts', 'profile');
	});
    }

    $('#contacts__index__addcontact').click(function () {
	JSunic.appview('contacts', 'form_contact');
    });
}
