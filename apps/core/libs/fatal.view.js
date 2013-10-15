/**
 * JavaScript of view "fatal"
 */
function core__fatal__init () {
    var Input = new InputObj();
    var msg = Input.get("error");
    if (msg) {
	document.getElementById('core__fatal__errorinfo').innerHTML = msg;
    }
}
