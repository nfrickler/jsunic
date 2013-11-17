/**
 * Static class offering supporting classes for forms
 */
function FormsObj () {

    /**
     * Print table of contents
     */
    this.printForm = function (tableid, obj) {
	var table = $(tableid);
	table.html('');
	var attributes = obj.getAttributes();
	for (var i = 0; i < attributes.length; i++) {
	    var dataobj = attributes[i];
	    table.append(
		'<tr id="'+dataobj.id+'">'+
		'    <th>'+JSunic.parse(dataobj.name)+'</th>'+
		'    <td>'+JSunic.parse(dataobj.value)+'</td>'+
		'</tr>'
	    );
	}
    }

    /**
     * Make all values of form editable
     */
    this.makeEditable = function (tableid, obj) {

	$(tableid+' td').dblclick(function () {
	    var origvalue = $(this).text();

	    $(this).html('<input type="text" value="'+origvalue+'" />');
	    var input = $(this).children().first();
	    input.focus();

	    // Save by pressing enter
	    input.keypress(function (e) {
		if (e.which == 13) {
		    var newContent = $(this).val();
		    var name = $(this).closest('tr').attr('id');
		    $(this).parent().text(newContent);
		    obj.saveAttribute(name, newContent);
		}
	    });
	});

    }

    /**
     * Make all attributes editable and show input box
     */
    this.makeNew = function (tableid, obj) {
	this.makeEditable(tableid, obj);
	$(tableid+' td').dblclick();
    }
}
