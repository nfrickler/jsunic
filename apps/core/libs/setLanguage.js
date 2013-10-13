/**
 * Set language in Config
 */
function core__setLanguage () {
    var newlang = $("#core__language").val();
    JSunic.Config.set("lang", newlang);
    $('#core__language option').removeAttr('selected');
    $("#core__language option[value='"+newlang+"']")
	.attr('selected',true);
    JSunic.reload();
    return true;
}
