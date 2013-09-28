<?php
$lang = array(

    // errors
    'ERROR__PLEASELOGIN' => 'Bitte logge dich zunächst ein!',
    'ERROR__UNKNOWNERROR' => 'Es ist ein Fehler aufgetreten!',
    'ERROR__LOGINERROR' => 'Beim Login ist ein Fehler aufgetreten!',

    // info
    'INFO__SAVED' => 'Einstellungen gespeichert.',
    'INFO__SETPASSWORD' => 'Bitte lege zunächst ein Passwort für das Backend fest!',

    // showLogin
    'SHOWLOGIN__TITLE' => 'Login',
    'SHOWLOGIN__H1' => 'JS_Admin | Login',
    'SHOWLOGIN__INFOTEXT' => 'Bitte gebe das Administrations-Passwort ein, um das System zu verwalten.',
    'SHOWLOGIN__LEGEND' => 'Bitte Passwort eingeben...',
    'SHOWLOGIN__PASSWORD' => 'Administrations-Passwort',
    'SHOWLOGIN__SUBMIT' => 'Einloggen',

    // setLogin
    'SHOWSETLOGIN__TITLE' => 'Passwort festlegen',
    'SHOWSETLOGIN__H1' => 'JS_Admin | Passwort festlegen',
    'SHOWSETLOGIN__INFOTEXT' => 'Lege hier das Passwort für den Administrationsbereich fest. Der Administrationsbereich wird nur noch über dieses Passwort zugänglich sein. Du kannst das Passwort jederzeit wieder ändern.',
    'SHOWSETLOGIN__LEGEND' => 'Bitte ein gewünschtes Passwort eingeben...',
    'SHOWSETLOGIN__PASSWORD' => 'Administrations-Passwort',
    'SHOWSETLOGIN__SUBMIT' => 'Passwort speichern',

    // showIndex
    'SHOWINDEX__TITLE' => 'Übersicht',
    'SHOWINDEX__H1' => 'JS_Admin | Übersicht',
    'SHOWINDEX__INFOTEXT' => 'Du bist im Administrations-Backend von JSunic. Hier kannst du grundlegende Einstellungen der Software ändern und deren Apps verwalten.',
    'SHOWINDEX__H2_INDEX' => 'Deine Möglichkeiten im Überlick',
    'SHOWINDEX__DT_APPS' => 'Apps verwalten',
    'SHOWINDEX__DD_APPS' => 'Administriere alle Module von JSunic, füge neue hinzu oder lösche welche. Diese Seite bietet dir eine einfache Verwaltung an.',
    'SHOWINDEX__DT_CONFIG' => 'Verwalte die Einstellungen',
    'SHOWINDEX__DD_CONFIG' => 'Ändere grundlegende Einstellungen von JSunic.',
    'SHOWINDEX__DT_TOOLS' => 'Optimiere die Software',
    'SHOWINDEX__DD_TOOLS' => 'Benutze nützliche Werkzeuge zur Optimierung von JSunic.',
    'SHOWINDEX__DT_SETLOGIN' => 'Passwort ändern',
    'SHOWINDEX__DD_SETLOGIN' => 'Ändere das Passwort für dieses Administrations-Backend.',
    'SHOWINDEX__DT_SYSTEMCHECK' => 'System überprüfen',
    'SHOWINDEX__DD_SYSTEMCHECK' => 'Überprüfe die Einstellungen deines Servers und den Status des Systems.',

    // showApps
    'SHOWAPPS__TITLE' => 'Apps',
    'SHOWAPPS__H1' => 'JS_Admin | Apps verwalten',
    'SHOWAPPS__INFOTEXT' => 'Aktiviere und deaktivere hier Apps. Anschließend kannst du JSunic neu bauen und dadurch die Änderungen deinen Nutzern verfügbar machen.',
    'SHOWAPPS__NAME' => 'Appname',
    'SHOWAPPS__VERSION' => 'Version',
    'SHOWAPPS__DESCRIPTION' => 'Beschreibung',
    'SHOWAPPS__STATUS' => 'Status',
    'SHOWAPPS__AUTHOR' => 'Autor',
    'SHOWAPPS__ACTION_DELETE' => 'Löschen',
    'SHOWAPPS__BUILD' => 'JSunic bauen',
    'SHOWAPPS__BUILD_INFOTEXT' => 'Baue die Benutzerumgebung von JSunic. Dies wird alle aktivierten (und nur diese) Apps und Styles den Nutzern zugänglich machen.',
    'SHOWAPPS__NOAPPS' => 'Es wurden keine Apps gefunden!',

    // deleteApp
    'DELETEAPP__ERROR' => 'Fehler beim Löschen!',
    'DELETEAPP__SUCCESS' => 'App gelöscht.',

    // toggleActivated
    'TOGGLEACTIVATED__ERROR' => 'Paket konnte nicht de/aktiviert werden!',
    'TOGGLEACTIVATED__INFO' => 'Paket de/aktiviert.',

    // build
    'BUILD__ERROR' => 'Beim Bauen von JSunic ist ein Fehler aufgetreten!',
    'BUILD__SUCCESS' => 'JSunic erfolgreich gebaut.',

    // showStyles
    'SHOWSTYLES__TITLE' => 'Styles',
    'SHOWSTYLES__H1' => 'JS_Admin | Styles verwalten',
    'SHOWSTYLES__INFOTEXT' => 'Hier siehst du alle Styles auf einen Blick und kannst sie aktivieren/deaktieren oder ganz löschen.',
    'SHOWSTYLES__NAME' => 'Stylename',
    'SHOWSTYLES__VERSION' => 'Version',
    'SHOWSTYLES__DESCRIPTION' => 'Beschreibung',
    'SHOWSTYLES__STATUS' => 'Status',
    'SHOWSTYLES__AUTHOR' => 'Autor',
    'SHOWSTYLES__SUBMIT' => 'Einstellungen speichern',
    'SHOWSTYLES__RESET' => 'Reset',
    'SHOWSTYLES__ID' => 'ID',
    'SHOWSTYLES__ACTION' => 'Aktion',
    'SHOWSTYLES__ACTION_DELETE' => 'Löschen',
    'SHOWSTYLES__ACTION_SETDEFAULT' => 'Als Standard',
    'SHOWSTYLES__NOSTYLES' => 'Es wurden keine Styles gefunden!',

    // deleteStyle
    'DELETESTYLE__ERROR' => 'Fehler beim Löschen!',
    'DELETESTYLE__SUCCESS' => 'Style gelöscht.',

    // showTools
    'SHOWTOOLS__TITLE' => 'Werkzeugkasten',
    'SHOWTOOLS__H1' => 'JS_Admin | Werkzeugkasten',
    'SHOWTOOLS__INFOTEXT' => 'Hier findest du nützliche Werkzeuge für deine JSunic-Installation.',
    'SHOWTOOLS__DT_RESETALL' => 'JSunic zurücksetzen',
    'SHOWTOOLS__DD_RESETALL' => 'Hier kann JSunic auf die "Werkseinstellungen" zurückgesetzt werden. Alle Daten gehen dabei verloren!',

    // showResetAll
    'SHOWRESETALL__TITLE' => 'Alles zurücksetzen',
    'SHOWRESETALL__H1' => 'JS_Admin | Alles zurücksetzen',
    'SHOWRESETALL__INFOTEXT' => 'Mit diesem Tool kann man JSunic komplett zurücksetzen und alle Daten löschen (außer eventuelle Backups im Backup-Ordner). Diese Funktion sollte mit großer Vorsicht verwendet werden und niemals bei einem laufenden System, es sei denn, man möchte es zerstören.',
    'SHOWRESETALL__WARNING' => 'Mit einem Klick auf "SHOWRESETALL__RESETALL", werden alle Daten zerstört!!!',
    'SHOWRESETALL__RESETALL' => 'JSunic jetzt zurücksetzen',

    // resetAll
    'INFO__ALLRESET_SUCCESS' => 'JSunic wurde erfolgreich zurückgesetzt.',

    // showConfig
    'SHOWCONFIG__TITLE' => 'Einstellungen bearbeiten',
    'SHOWCONFIG__H1' => 'JS_Admin | Einstellungen bearbeiten',
    'SHOWCONFIG__INFOTEXT' => 'Verwalte hier die grundlegenden Einstellungen von JSunic.',
    'SHOWCONFIG__LEGEND_ENCRYPTION' => 'Verschlüsselung',
    'SHOWCONFIG__ENCRYPTION_CLASS' => 'Verschlüsselungstyp',
    'SHOWCONFIG__ENCRYPTION_CLASS_INFO' => 'Wähle hier den Verschlüsselungstyp für JSunic aus. Diese Einstellung sollte auf keinen Fall bei einem laufenden System geändert werden, da dies Datenverlust zu Folge haben kann/wird!',
    'SHOWCONFIG__ENCRYPTION_ALGORITHM' => 'Algorithmus',
    'SHOWCONFIG__ENCRYPTION_ALGORITHM_INFO' => 'Wähle einen Verschlüsselungsalgorithmus aus. Diese Einstellung sollte auf keinen Fall bei einem laufenden System geändert werden, da dies Datenverlust zu Folge haben kann/wird!',
    'SHOWCONFIG__ENCRYPTION_MODE' => 'Modus',
    'SHOWCONFIG__ENCRYPTION_MODE_INFO' => 'Wähle einen Verschlüsselungsmodus. Diese Einstellung sollte auf keinen Fall bei einem laufenden System geändert werden, da dies Datenverlust zu Folge haben kann/wird!',
    'SHOWCONFIG__SYSTEM_SECRET' => 'Systemgeheimnis',
    'SHOWCONFIG__SYSTEM_SECRET_INFO' => 'Dies ist ein geheimes Passwort, das für die Verschlüsselung verwendet wird und bei jedem System unterschiedlich sein sollte. Diese Einstellung sollte auf keinen Fall bei einem laufenden System geändert werden, da dies Datenverlust zu Folge haben kann/wird!',
    'SHOWCONFIG__LEGEND_OTHERS' => 'Sonstige Einstellungen',
    'SHOWCONFIG__DEFAULT_LANGUAGE' => 'Standard-Sprache',
    'SHOWCONFIG__DEFAULT_LANGUAGE_INFO' => 'Wähle eine Sprache aus, die das System standardmäßig verwenden soll.',
    'SHOWCONFIG__SYSTEM_EMAIL' => 'System-E-Mail',
    'SHOWCONFIG__SYSTEM_EMAIL_INFO' => 'Von dieser E-Mail-Adresse aus werden System-Nachrichten verschickt.',
    'SHOWCONFIG__SUBMIT' => 'Einstellungen speichern',
    'SHOWCONFIG__RESET' => 'Reset',
    'SHOWCONFIG__NO' => 'Nein',
    'SHOWCONFIG__YES' => 'Ja',
    'SHOWCONFIG__EMAIL_ENABLED' => 'E-Mail aktiviert',
    'SHOWCONFIG__EMAIL_ENABLED_INFO' => 'Ist diese Einstellung deaktivert, so wird das System keine E-Mails versenden. Die IMAP-/POP3-Funktionen sind davon nicht betroffen.',

    'SHOWCONFIG__LEGEND_PATHS' => 'Verzeichnisse',
    'SHOWCONFIG__DOMAIN' => 'Domain',
    'SHOWCONFIG__DOMAIN_INFO' => 'Der Domainname deines Webservers.',
    'SHOWCONFIG__DIR_ADMIN' => 'admin Verzeichnis',
    'SHOWCONFIG__DIR_ADMIN_INFO' => 'Absoluter Pfad zum admin Verzeichnis von JSunic. Nur der Administrator braucht Webzugriff auf dieses Verzeichnis.',
    'SHOWCONFIG__DIR_RUNTIME' => 'runtime Verzeichnis',
    'SHOWCONFIG__DIR_RUNTIME_INFO' => 'Absoluter Pfad zum runtime Verzeichnis von JSunic. Dieses Verzeichnis ist öffentlich.',

    'SHOWCONFIG__SYSTEM_ONLINE' => 'Ist System online?',
    'SHOWCONFIG__SYSTEM_ONLINE_INFO' => 'Über diese Einstellung kann das System vorübergehend offline genommen werden. Alle Zugriffe auf das System werden nach "offline.php" umgeleitet. Diese Einstellung wird auch während des Renderns kurz aktiviert.',
    'SHOWCONFIG__ALLOW_REGISTRATION' => 'Registrierung erlaubt?',
    'SHOWCONFIG__ALLOW_REGISTRATION_INFO' => 'Deaktiviere diese Einstellung, um die Registrierung neuer Mitglieder zu unterbinden. Mitglieder, die bereits registriert sind, können sich ganz normal weiter einloggen.',

    // showSystemCheck
    'SHOWSYSTEMCHECK__TITLE' => 'System überprüfen',
    'SHOWSYSTEMCHECK__H1' => 'JS_Admin | System überprüfen',
    'SHOWSYSTEMCHECK__INFOTEXT' => 'Kann JSunic auf diesem Server problemlos laufen? Könnte man etwas verbessern? Hier findest du Antworten.',
    'SHOWSYSTEMCHECK__FOLDER_RUNTIME' => 'Verzeichnis "runtime" beschreibbar?',
    'SHOWSYSTEMCHECK__FOLDER_RUNTIME_INFO' => 'In diesem Verzeichnis wird JSunic die Programmdateien kompilieren. Dafür muss es in dieses Verzeichnis schreiben können. Bitte setze über einen FTP-Browser deiner Wahl die Verzeichnisrechte auf 755!',
    'SHOWSYSTEMCHECK__PHPVERSION' => 'PHP-Version',
    'SHOWSYSTEMCHECK__PHPVERSION_INFO' => 'Zum Funktionieren braucht JSunic mindestens PHP Version 5.3.',
    'SHOWSYSTEMCHECK__IMAPFUNCTIONS' => 'IMAP-Funktionen installiert?',
    'SHOWSYSTEMCHECK__IMAPFUNCTIONS_INFO' => 'JSunic bietet die Möglichkeit, über IMAP/POP3 auf E-Mail-Accounts zuzugreifen. Dies ist allerdings nur möglich, wenn die IMAP-Funktionen auf dem Server installiert sind. Zwar können diese Möglichkeiten dann nicht ausgeschöpft werden, aber JSunic funktioniert auch ohne diese Funktionen.',
    'SHOWSYSTEMCHECK__FOLDER_DATA' => 'Verzeichnis "data" beschreibbar?',
    'SHOWSYSTEMCHECK__FOLDER_DATA_INFO' => 'Dieses Verzeichnis beinhaltet sämtliche Daten, auf die JSunic zwar zugreifen können muss, die aber nicht im öffentlichen Web liegen müssen/sollten. JSunic benötigt Schreibrechte für dieses Verzeichnis inklusive der Unterverzeichnisse. Bitte setze über einen FTP-Browser deiner Wahl die Verzeichnisrechte auf 755!',

    // pagenotfound
    'PAGENOTFOUND__TITLE' => 'Seite nicht gefunden',
    'PAGENOTFOUND__H1' => 'Seite nicht gefunden!',
    'PAGENOTFOUND__INFOTEXT' => 'Die angeforderte Seite konnte nicht gefunden werden!',

    // html
    'HTML__INSTALLATIONPROGRESS' => 'Installationsfortschritt',
    'HTML__INDEX' => 'Übersicht',
    'HTML__APPS' => 'Apps',
    'HTML__CONFIG' => 'Einstellungen',
    'HTML__STYLES' => 'Styles',
    'HTML__TOOL' => 'Werkzeugkasten',
    'HTML__LOGOUT' => 'Logout',
    'HTML__LOGIN' => 'Login',
    'HTML__INSTALLATION_NEXT' => 'Installation fortsetzen'
);
?>
