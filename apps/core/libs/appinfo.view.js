/**
 * JavaScript of view "appinfo"
 */
function core__appinfo__install (App) {
    JSunic.Boot.addApp(App);
    JSunic.info("App installed.");
    JSunic.appview("core", "appstore");
}
