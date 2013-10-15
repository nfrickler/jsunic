/**
 * Save path to storage location
 */
function core__bootinit () {
    var boot_path = document.getElementById("core__bootinit__path").value;
    JSunic.Boot.addStorage(boot_path);
    JSunic.Boot.setMBR(boot_path);
    return false;
}
