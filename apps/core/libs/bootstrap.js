/**
 * This file bootstraps JSunic
 */
var JSunic;
window.onload = function () {
    window.onload = undefined;

    // Create JSunic object
    JSunic = new JSunicObj();
    JSunic.log('Bootstrapping...');

    // Load config.json
    JSunic.Config.load();

    // Load language
    JSunic.loadLanguage('core');

    // Parse HTML
    $('body').html(JSunic.parse($('body').html()));
    $('title').html(JSunic.parse($('title').html()));

    // Listen for hashcode changes to enable Ajax links
    jQuery(window).on('hashchange', function(){
	JSunic.open(location.hash);
    });

    // Open requested link
    JSunic.open(location.hash);
}
