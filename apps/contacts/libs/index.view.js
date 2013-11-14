/**
 * JavaScript part of view profile
 */
function contacts__index__init () {
    var Index = JSunic.getIndex('contacts');

    if (!Index) {
	JSunic.error("No index found!");
    }

    // Show list of all contacts
    var personlist = Index.getObjects();
    for (var i = 0; i < personlist.length; i++) {
	var cur = personlist[i];
	var newid = 'contacts__index__list__'+cur.id;
	$('#contacts__index__list').append(
	    '<tr id="'+newid+'">'+
	    '    <th>'+cur.name+'</th>'+
	    '</tr>'
	);

	// Click on person to show full profile
	$('#'+newid).click(function () {
	    JSunic.appview('contacts', 'profile');
	});
    }

    $('#contacts__index__addprofile').click(function () {
	JSunic.appview('contacts', 'form_person');
    });
}
