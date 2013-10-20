/**
 * Save path to storage location
 */
function core__bootinit () {
    var boot_path = $("#core__bootinit__path").val();
    JSunic.Boot.addStorage(boot_path);

    JSunic.Boot.save(
	function () {
	    JSunic.Boot.updateMBR(
		function () {
		    JSunic.info("MBR saved.");
		    JSunic.appview('core', 'desktop');
		},
		function () {
		    JSunic.info("Failed to update MBR!");
		}
	    );
	},
	function () {
	    JSunic.info("Boot packet could not be saved!");
	}
    );

    return false;
}
