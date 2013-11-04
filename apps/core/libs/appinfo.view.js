/**
 * JavaScript of view "appinfo"
 */
function core__appinfo__install (App) {
    JSunic.Boot.addApp(App);
    JSunic.info("App installed.");
    JSunic.appview("core", "appstore");
}

function core__appinfo__uninstall (App) {
    JSunic.Boot.removeApp(App);
    JSunic.info("App uninstalled.");
    JSunic.appview("core", "appstore");
}
