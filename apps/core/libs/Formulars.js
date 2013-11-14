/**
 * Static class offering supporting classes for forms
 */
function FormsObj () {

    /**
     * Make all values of form editable
     */
    this.makeEditable = makeEditable;
    function makeEditable (tableid) {

	$('#'+tableid+' td').dblclick(function () {
	    var origvalue = $(this).text();

	    $(this).html('<input type="text" value="'+origvalue+'" />');
	    $(this).children().first().focus();

	    $(this).children().first().keypress(function (e) {
		if (e.which == 13) {
		    var newContent = $(this).val();
		    $(this).parent().text(newContent);

		    // TODO Save new value in Packet
		}
	    });
	});

    }
}
