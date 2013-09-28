<?php
$lang = array(

    // errors
    'ERROR__PLEASELOGIN' => 'Please log in!',
    'ERROR__UNKNOWNERROR' => 'An error occurred!',
    'ERROR__LOGINERROR' => 'An error occurred while logging in!',

    // info
    'INFO__SAVED' => 'Saved successfully.',
    'INFO__SETPASSWORD' => 'Please choose a password for the software-backend first!',

    // showLogin
    'SHOWLOGIN__TITLE' => 'Login',
    'SHOWLOGIN__H1' => 'JS_Admin | Login',
    'SHOWLOGIN__INFOTEXT' => 'Please enter the backend-password to enter the administration backend!',
    'SHOWLOGIN__LEGEND' => 'Please enter password...',
    'SHOWLOGIN__PASSWORD' => 'Backend password',
    'SHOWLOGIN__SUBMIT' => 'Log in',

    // setLogin
    'SHOWSETLOGIN__TITLE' => 'Set password',
    'SHOWSETLOGIN__H1' => 'JS_Admin | Set password',
    'SHOWSETLOGIN__INFOTEXT' => 'Please set a new password for the administration backend. This password can be changed within the backend as often as you like.',
    'SHOWSETLOGIN__LEGEND' => 'Please enter a new password',
    'SHOWSETLOGIN__PASSWORD' => 'Backend password',
    'SHOWSETLOGIN__SUBMIT' => 'Save password',

    // showIndex
    'SHOWINDEX__TITLE' => 'Index',
    'SHOWINDEX__H1' => 'JS_Admin | Index',
    'SHOWINDEX__INFOTEXT' => 'You are in the administration-backend of JSunic. This backend enables you to administrate JSunic easily.',
    'SHOWINDEX__H2_INDEX' => 'This backend enables you to...',
    'SHOWINDEX__DT_APPS' => 'Administrate apps',
    'SHOWINDEX__DD_APPS' => 'Manage all modules of JSunic and parse the software.',
    'SHOWINDEX__DT_CONFIG' => 'Change configuration',
    'SHOWINDEX__DD_CONFIG' => 'Change basic configuration of JSunic.',
    'SHOWINDEX__DT_TOOLS' => 'Optimize the software',
    'SHOWINDEX__DD_TOOLS' => 'Use usefull tools to optimize your installation',
    'SHOWINDEX__DT_SETLOGIN' => 'Change password',
    'SHOWINDEX__DD_SETLOGIN' => 'Change password for administration backend.',
    'SHOWINDEX__DT_SYSTEMCHECK' => 'Check system',
    'SHOWINDEX__DD_SYSTEMCHECK' => 'Check environment of the system.',

    // showApps
    'SHOWAPPS__TITLE' => 'Apps',
    'SHOWAPPS__H1' => 'JS_Admin | Administrate apps',
    'SHOWAPPS__INFOTEXT' => 'Activate and deactivate apps on this page. Afterwards you have to (re)build JSunic to make the changes effective for your users.',
    'SHOWAPPS__NAME' => 'Name of app',
    'SHOWAPPS__VERSION' => 'Version',
    'SHOWAPPS__DESCRIPTION' => 'Description',
    'SHOWAPPS__STATUS' => 'Status',
    'SHOWAPPS__AUTHOR' => 'Author',
    'SHOWAPPS__ACTION_DELETE' => 'Delete',
    'SHOWAPPS__BUILD' => 'Build JSunic',
    'SHOWAPPS__BUILD_INFOTEXT' => 'Build the runtime environment of JSunic. This will make all activated (and only these) apps and styles usable for your users.',
    'SHOWAPPS__NOAPPS' => 'No apps found!',

    // deleteApp
    'DELETEAPP__ERROR' => 'An error occurred during deletion!',
    'DELETEAPP__SUCCESS' => 'App removed.',

    // toggleActivated
    'TOGGLEACTIVATED__ERROR' => 'Packet could not be de/activated!',
    'TOGGLEACTIVATED__INFO' => 'Packet de/activated.',

    // build
    'BUILD__ERROR' => 'An error occurred during build process!',
    'BUILD__SUCCESS' => 'JSunic build successfully.',

    // showStyles
    'SHOWSTYLES__TITLE' => 'Styles',
    'SHOWSTYLES__H1' => 'JS_Admin | Administrate styles',
    'SHOWSTYLES__INFOTEXT' => 'All styles on one page. Here you can administrate all styles in your style-directory.',
    'SHOWSTYLES__NAME' => 'Name of style',
    'SHOWSTYLES__VERSION' => 'Version',
    'SHOWSTYLES__DESCRIPTION' => 'Description',
    'SHOWSTYLES__STATUS' => 'Status',
    'SHOWSTYLES__AUTHOR' => 'Author',
    'SHOWSTYLES__ACTION_DELETE' => 'Delete',
    'SHOWSTYLES__ACTION_SETDEFAULT' => 'As default',
    'SHOWSTYLES__NOSTYLES' => 'No styles found!',

    // deleteStyle
    'DELETESTYLE__ERROR' => 'An error occurred!',
    'DELETESTYLE__SUCCESS' => 'Style removed.',

    // showTools
    'SHOWTOOLS__TITLE' => 'Tools',
    'SHOWTOOLS__H1' => 'JS_Admin | Tools',
    'SHOWTOOLS__INFOTEXT' => 'This tools can help you with your JSunic installation.',
    'SHOWTOOLS__DT_RESETALL' => 'Reset JSunic',
    'SHOWTOOLS__DD_RESETALL' => 'This tool enables you to reset JSunic completely. All data of your current installation will be lost afterwards!',

    // showResetAll
    'SHOWRESETALL__TITLE' => 'Reset all',
    'SHOWRESETALL__H1' => 'JS_Admin | Reset all',
    'SHOWRESETALL__INFOTEXT' => 'This tool enables you to reset JSunic conpletely. All data of your current installation will be lost and can not be recovered!',
    'SHOWRESETALL__WARNING' => 'With clicking on "SHOWRESETALL__RESETALL" all data will be destroyed!!!',
    'SHOWRESETALL__RESETALL' => 'Reset JSunic now',

    // resetAll
    'INFO__ALLRESET_SUCCESS' => 'JSunic has been resetted successfully.',

    // showConfig
    'SHOWCONFIG__TITLE' => 'Edit configuration',
    'SHOWCONFIG__H1' => 'JS_Admin | Edit configuration',
    'SHOWCONFIG__INFOTEXT' => 'Change the configuration of JSunic easily via this formular.',
    'SHOWCONFIG__LEGEND_DATABASE' => 'Database',
    'SHOWCONFIG__LEGEND_ENCRYPTION' => 'Encryption',
    'SHOWCONFIG__ENCRYPTION_CLASS' => 'Encryption type',
    'SHOWCONFIG__ENCRYPTION_CLASS_INFO' => 'Choose an encryption type. Do not change this password on a running system, causing serious damage to your data.',
    'SHOWCONFIG__ENCRYPTION_ALGORITHM' => 'Algorithm',
    'SHOWCONFIG__ENCRYPTION_ALGORITHM_INFO' => 'Choose an encryption algorithm. Do not change this password on a running system, causing serious damage to your data.',
    'SHOWCONFIG__ENCRYPTION_MODE' => 'Mode',
    'SHOWCONFIG__ENCRYPTION_MODE_INFO' => 'Choose an encryption mode. Do not change this password on a running system, causing serious damage to your data.',
    'SHOWCONFIG__SYSTEM_SECRET' => 'System secret',
    'SHOWCONFIG__SYSTEM_SECRET_INFO' => 'This is a secret password probably unique to every system that is used for encryption. Do not change this password on a running system, causing serious damage to your data.',
    'SHOWCONFIG__LEGEND_OTHERS' => 'Other settings',
    'SHOWCONFIG__DEFAULT_LANGUAGE' => 'Default language',
    'SHOWCONFIG__DEFAULT_LANGUAGE_INFO' => 'Choose a default language.',
    'SHOWCONFIG__SYSTEM_EMAIL' => 'System e-mail',
    'SHOWCONFIG__SYSTEM_EMAIL_INFO' => 'This is the sender attached to e-mails sent by php\'s mail-function.',
    'SHOWCONFIG__SUBMIT' => 'Save configuration',
    'SHOWCONFIG__RESET' => 'Reset',
    'SHOWCONFIG__DEBUG_MODE' => 'Debug mode',
    'SHOWCONFIG__DEBUG_MODE_INFO' => '"Yes" means that the parser will not compress files, what simplifies debugging.',
    'SHOWCONFIG__NO' => 'No',
    'SHOWCONFIG__YES' => 'Yes',
    'SHOWCONFIG__EMAIL_ENABLED' => 'E-mail activated?',
    'SHOWCONFIG__EMAIL_ENABLED_INFO' => 'With this setting disabled JSunic will not send e-mails via php\'s mail-function.',

    'SHOWCONFIG__LEGEND_PATHS' => 'Directories',
    'SHOWCONFIG__DOMAIN' => 'Domain',
    'SHOWCONFIG__DOMAIN_INFO' => 'The domain of your webserver.',
    'SHOWCONFIG__DIR_ADMIN' => 'admin directory',
    'SHOWCONFIG__DIR_ADMIN_INFO' => 'Absolute path to admin directory of JSunic. Only administrator needs web access to this directory.',
    'SHOWCONFIG__DIR_RUNTIME' => 'runtime directory',
    'SHOWCONFIG__DIR_RUNTIME_INFO' => 'Absolute path to runtime directory of JSunic. This is the public directory.',

    'SHOWCONFIG__SYSTEM_ONLINE' => 'System online?',
    'SHOWCONFIG__SYSTEM_ONLINE_INFO' => 'Switch to "No", if you want to take the system offline. This configuration is also used during parsing the software.',
    'SHOWCONFIG__ALLOW_REGISTRATION' => 'Allow registration?',
    'SHOWCONFIG__ALLOW_REGISTRATION_INFO' => 'Deactivate this option to disallow new users to register. Already registered users can still login normally.',

    // showSystemCheck
    'SHOWSYSTEMCHECK__TITLE' => 'Check system',
    'SHOWSYSTEMCHECK__H1' => 'JS_Admin | Check system',
    'SHOWSYSTEMCHECK__INFOTEXT' => 'Is JSunic likely to run on this system properly? Check it now!',
    'SHOWSYSTEMCHECK__FOLDER_RUNTIME' => 'Write access for folder "runtime"?',
    'SHOWSYSTEMCHECK__FOLDER_RUNTIME_INFO' => 'This folder contains the runtime-environment and will be created by parsing the software in the backend. JSunic needs to have write access to this folder so please set file options in your ftp-browser to 755!',
    'SHOWSYSTEMCHECK__PHPVERSION' => 'PHP version',
    'SHOWSYSTEMCHECK__PHPVERSION_INFO' => 'To work properly, JSunic needs at least PHP version 5.3.',
    'SHOWSYSTEMCHECK__IMAPFUNCTIONS' => 'IMAP-Functions available?',
    'SHOWSYSTEMCHECK__IMAPFUNCTIONS_INFO' => 'JSunic can enable you to access your mails via IMAP or POP3. Therefore, the IMAP-Functions have to be installed on the server. Nevertheless, JSunic will work properly also without these functions.',
    'SHOWSYSTEMCHECK__FOLDER_DATA' => 'Write access for folder "data"?',
    'SHOWSYSTEMCHECK__FOLDER_DATA_INFO' => 'This folder contains all data, which do not require web-access. JSunic needs write access to this folder so please set file options in your ftp-browser to 755!',

    // pagenotfound
    'PAGENOTFOUND__TITLE' => 'Page not found',
    'PAGENOTFOUND__H1' => 'Page not found!',
    'PAGENOTFOUND__INFOTEXT' => 'The requested page has not been found!',

    // html
    'HTML__INSTALLATIONPROGRESS' => 'Installation progress',
    'HTML__INDEX' => 'Index',
    'HTML__APPS' => 'Apps',
    'HTML__CONFIG' => 'Configuration',
    'HTML__STYLES' => 'Styles',
    'HTML__TOOL' => 'Tools',
    'HTML__LOGOUT' => 'Logout',
    'HTML__LOGIN' => 'Login',
    'HTML__INSTALLATION_NEXT' => 'Resume installation'
);
?>
