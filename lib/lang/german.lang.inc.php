<?php
/* GERMAN language */
/* 
Translator: Tobias Zeumer
Version:		Senayan3 Stable10 Patch1
Date:       2009-08-20
Contact:    tzeumer@verweisungsform.de

Notes:      - Some translations are "hidden" in the sysconfig.inc.php file.
            - See end of this file for some kind of "rough" dictionary
            - If you want to change anything: make your life easier by looking (searching) for the longest phrase ;)
            - "Aller Anfang ist schwer" ;)
*/


/* COMMON */
define('lang_sys_common_data_not_exists', 'FEHLER! Daten sind nicht vorhanden');
define('lang_sys_common_unauthorized', 'Sie sind nicht authorisiert diesen Bereich einzusehen');
define('lang_sys_common_no_privilege', 'Sie verfügen nicht über ausreichende Rechte um diesen Bereich einzusehen');
define('lang_sys_common_timeout', 'Die Sitzungsdauer ihrer Anmeldung ist inzwischen abgelaufen!');
define('lang_sys_common_welcome', 'Willkommen im Bibliotheksmanagementsystem. Sie sind derzeitig angmeldet als ');
define('lang_sys_common_overdue', 'Derzeit fallen bei <strong>{num_overdue}</strong> Bibliotheksmitgliederen Mahngebühren an. Nähere Informationen entnehmen Sie bitte dem Punkt <b>Mahngebühren</b> im Modul <b>Ausleihe</b>');
define('lang_sys_common_gd_not_loaded', '<strong>PHP GD</strong>-Erweiterung ist nicht installiert. Wenn die Anwendung Vorschaubilder und Barcodes erzeugen können soll, installieren Sie diese Erweiterung bitte.');
define('lang_sys_common_gd_freetype_not_loaded', '<strong>Freetype</strong>-Unterstützung ist nicht aktiviert in der PHP GD-Erweiterung. Verwenden oder erstellen Sie bitte eine Version (Build) der PHP GD-Erweiterung mit Freetype-Unterstützung, da die Anwendung andernfalls keine Barcodes erstellen kann.');
define('lang_sys_common_imagedir_unwritable', '<strong>Images</strong>-Verzeichnis und darunter liegende Verzeichnisse sind nicht beschreibbar. Bitte gestatten Sie den Schreibzugriff indem Sie die entsprechende Berechtigung setzen. Andernfalls ist es Ihnen nicht möglich Bilder hochzuladen und Barcodes zu erstellen');
define('lang_sys_common_uploaddir_unwritable', '<strong>File upload</strong>-Verzeichnis ist nicht beschreibbar. Bitte gestatten Sie den Schreibzugriff (eingeschlossen der darunter liegenden Verzeichnisse) indem Sie die entsprechende Berechtigung setzen. Andernfalls ist es Ihnen nicht möglich Dateien hochzuladen, sowie Berichtsdateien und Datenbanksicherungen zu erstellen.');
define('lang_sys_common_repodir_unwritable', '<strong>Repository</strong>-Verzeichnis ist nicht beschreibbar. Bitte gestatten Sie den Schreibzugriff (eingeschlossen der darunter liegenden Verzeichnisse) indem Sie die entsprechende Berechtigung setzen. Andernfalls ist es Ihnen nicht möglich zu Titelaufnahmen Anhänge hinzuzufügen.'); //? (bibliographic attachments)
define('lang_sys_common_dompdfdir_unwritable', '<strong>{dompdf_libdir}</strong>-Verzeichnis ist nicht beschreibbar. Bitte gestatten Sie den Schreibzugriff (eingeschlossen der darunter liegenden Verzeichnisse) indem Sie die entsprechende Berechtigung setzen, da die Anwendung andernfalls keine PDF-Dateien erstellen kann.');
define('lang_sys_common_mysqldump_not_found', 'Die Pfadangabe für die <strong>mysqldump</strong>-Anwendung ist inkorrekt! Bitte prüfen Sie die Konfigurationsdatei, da Sie andernfalls keine Datenbanksicherungen durchführen können.');
define('lang_sys_common_tools', 'Werkzeuge');
define('lang_sys_common_confirm_delete_selected', 'Wollen Sie die ausgewählten Daten wirklich LÖSCHEN?');
define('lang_sys_common_button_delete_selected', 'Auswahl löschen');
define('lang_sys_common_holiday_set_error', 'Höchstens 6 Tage können als Ruhetage festgelegt sein!');
define('lang_sys_common_language_select', 'Sprache wählen');
define('lang_sys_common_no_privilage', 'Sie verfügen nicht über ausreichende Rechte für den Zugriff auf diesen Bereich!');
define('lang_sys_common_year', 'Jahr');
define('lang_sys_common_month', 'Monat');
define('lang_sys_common_date', 'Datum');
# template
define('lang_template_topmenu_1','Startseite');
define('lang_template_topmenu_2','Über die Bibliothek'); //? (Library Information)
define('lang_template_topmenu_3','Hilfe zur Suche');
define('lang_template_topmenu_4','Mitarbeiter-ANMELDUNG'); //? (Librarian LOGIN)
define('lang_template_simple_search','Einfache Suche');
define('lang_template_adv_search','Erweiterte Suche');
# login and logout
define('lang_sys_login_javastatus','Ihr Browser unterstützt keine JavaScript oder die Unterstützung wurde deaktiviert. JavaScript ist für diese Anwendung erforderlich!');
define('lang_sys_login_alert', 'Bitte geben Sie einen gültigen Benutzernamne und ein gültiges Passwort an');
define('lang_sys_login_alert_ok', 'Willkommen im Bibliotheksmanagementsystem, ');
define('lang_sys_login_alert_fail', 'Benutzername oder Passwort sind inkorrekt. ZUGRIFF VERWEIGERT');
define('lang_sys_logout_alert', 'Sie wurden vom Bibliotheksmanagementsystem abgemeldet');
# system module submenu
define('lang_sys_mod', 'System');
define('lang_sys_configuration', 'Systemkonfiguration');
define('lang_sys_configuration_titletag', 'Globale Systemeinstellungen konfigurieren');
define('lang_sys_configuration_description', 'Globale Anwendungseinstellungen anpassen');
define('lang_sys_modules', 'Module');
define('lang_sys_modules_titletag', 'Anwendungsmodule konfigurieren');
define('lang_sys_modules_new_add', 'Neues Modul');
define('lang_sys_modules_list', 'Module ansehen');
define('lang_sys_user', 'Systembenutzer');
define('lang_sys_user_titletag', 'Systembenutzer oder Bibliotheksangestellte verwalten');
define('lang_sys_user_new_add', 'Neuer Benutzer');
define('lang_sys_user_list', 'Benutzer ansehen');
define('lang_sys_group', 'Benutzergruppe');
define('lang_sys_group_titletag', 'Benutzergruppen für Systembenutzer verwalten');
define('lang_sys_group_new_add', 'Neue Benutzergruppe');
define('lang_sys_group_list', 'Benutzergruppen ansehen');
define('lang_sys_holiday', 'Ruhetageinstellungen');
define('lang_sys_holiday_titletag', 'Legen sie Ruhetage oder -zeiträume fest, an denen die Bibliothek geschlossen ist (und während derer Leihfristen nicht überzogen werden können)');
define('lang_sys_barcodes', 'Barcodegenerator');
define('lang_sys_barcodes_titletag', 'Barcodegenerator');
define('lang_sys_barcodes_description', 'Geben Sie Barcodebezeichnungen in eines oder mehrere der Textfelder ein und klicken Sie dann den Button');
define('lang_sys_syslog', 'Systemlog');
define('lang_sys_syslog_titletag', 'System Log der Anwendung betrachten');
define('lang_sys_backup', 'Datenbanksicherung');
define('lang_sys_backup_titletag', 'Datenbank der Anwendung sichern');
define('lang_sys_backup_new_add', 'Neue Sicherung erstellen');
define('lang_sys_content', 'Inhaltsbereiche'); //? (Content)
define('lang_sys_content_titletag', 'Inhaltsbereiche der Webseite');
# form button
define('lang_sys_common_form_save', 'Speichern');
define('lang_sys_common_form_update', 'Aktualisieren');
define('lang_sys_common_form_cancel', 'Abbrechen');
define('lang_sys_common_form_delete', 'Datensatz löschen');
define('lang_sys_common_form_search', 'Suche'); /* proposed */
define('lang_sys_common_form_search_field', 'Suchen'); /* proposed */
define('lang_sys_common_form_save_change', 'Speichern'); /* proposed */
define('lang_sys_common_form_report','Bericht herunterladen');
# datagrid form
define('lang_sys_common_form_checkbox_all', 'Alle anwählen');
define('lang_sys_common_form_uncheckbox_all', 'Alle abwählen');
define('lang_sys_common_form_delete_selected', 'Ausgewählte Daten löschen');
define('lang_sys_common_form_confirm_delete', 'Wollen Sie die ausgewählten Daten wirklich löschen?');
define('lang_sys_common_edit_titletag', 'Click for detail or edit this Record'); //? //-
# display search data
define('lang_sys_common_search_result_info', '<strong>{result->num_rows}</strong> Ergebnisse gefunden für die Suchbegriffe');
define('lang_sys_common_paging_first', 'Erste Seite');
define('lang_sys_common_paging_last', 'Letzte Seite');
define('lang_sys_common_paging_prev', 'Vorherige');
define('lang_sys_common_paging_next', 'Nächste');
# application user form
define('lang_sys_user_field_login_username', 'Anmeldename');
define('lang_sys_user_field_realname', 'Name');
define('lang_sys_user_field_password', 'Passwort');
define('lang_sys_user_field_password_confirm', 'Passwort bestätigen');
# content form
define('lang_sys_content_field_title', 'Titel der Seite');
define('lang_sys_content_field_path', 'Pfad (darf nicht bereits verwendet werden)');
define('lang_sys_content_field_desc', 'Seiteninhalt');
define('lang_sys_content_new_add', 'Neue Seite');
define('lang_sys_content_list', 'Seiten ansehen');
define('lang_sys_content_alert_noempty', 'Titel und Pfad müssen angegeben sein!');
define('lang_sys_content_common_last_update', 'Letzte Aktualisierung ');
define('lang_sys_content_common_edit_info', 'Sie sind im Begriff folgende Seite zu aktualisieren ');
define('lang_sys_content_alert_save_ok', 'Seite wurde gespeichert');
define('lang_sys_content_alert_save_fail', 'Speicherung der Seite FEHLGESCHLAGEN!');
define('lang_sys_content_alert_update_ok', 'Seite wurde aktualisiert');
define('lang_sys_content_alert_update_fail', 'Aktualisierung der Seite FEHLGESCHLAGEN!');

/* Global Configuration */
define('lang_sys_conf_alert_save', 'Einstellungen gespeichert. Seite wird aktualisiert');
define('lang_sys_conf_form_button_save', 'Einstellungen speichern');
define('lang_sys_conf_form_field_library', 'Bibliotheksname');
define('lang_sys_conf_form_field_library_subname', 'Namenszusatz');
define('lang_sys_conf_form_field_public_template', 'Template öffentlicher Bereich');
define('lang_sys_conf_form_field_admin_template', 'Template administrativer Bereich');
define('lang_sys_conf_form_field_language', 'Standardsprache'); //?
define('lang_sys_conf_form_field_opac_result', 'Zahl anzuzeigender Sammlungen in der OPAC-Ergebnisliste');
define('lang_sys_conf_form_field_quick_return', 'Schnellrücknahme');
define('lang_sys_conf_form_field_limit_overide', 'Ausleihlimit ignorieren können'); //?
define('lang_sys_conf_form_field_opac_xml', 'OPAC XML-Detail');
define('lang_sys_conf_form_field_xml_result', 'OPAC XML-Ergebnis');
define('lang_sys_conf_form_field_xml_file', 'Herunterladen von Dateien im OPAC zulassen');
define('lang_sys_conf_form_option_enable', 'Aktivieren');
define('lang_sys_conf_form_option_disable', 'Deaktivieren');
define('lang_sys_conf_form_option_allow', 'Zulassen');
define('lang_sys_conf_form_option_forbid', 'Verweigern');
define('lang_sys_conf_form_field_session', 'Automatisch abmelden nach (Sekunden)');
define('lang_sys_conf_form_field_promote_titles', 'Propagierte Titel auf der Startseite anzeigen'); //?

/* Module Configuration */
define('lang_sys_conf_module_alert_noempty', 'Name und Pfad des Modules müssen angegeben sein');
define('lang_sys_conf_module_alert_save_ok', 'Daten des neuen Moduls erfolgreich gespeichert');
define('lang_sys_conf_module_alert_save_fail', 'Speicherung der Moduldaten FEHLGESCHLAGEN. Bitte kontaktieren Sie den Systemadministrator');
define('lang_sys_conf_module_alert_update_ok', 'Moduldaten erfolgreich aktualisiert');
define('lang_sys_conf_module_alert_update_fail', 'Aktualisierung der Moduldaten FEHLGESCHLAGEN. Bitte kontaktieren Sie den Systemadministrator');
define('lang_sys_conf_module_alert_not_exist', 'Fehler! Moduldaten sind nicht vorhanden!');
define('lang_sys_conf_module_common_edit_info', 'Sie sind im Begriff die Angaben für folgendes Modul zu bearbeiten');
define('lang_sys_conf_module_common_alert_delete_success', 'Alle Daten erfolgreich gelöscht');
define('lang_sys_conf_module_common_alert_delete_fail', 'Einige oder alle Daten wurden NICHT erfolgreich gelöscht!\nBitte kontaktieren Sie den Systemadministrator');
define('lang_sys_conf_module_common_alert_delete_group_ok', 'Benutzergruppe erfolgreich gelöscht');
define('lang_sys_conf_module_common_alert_delete_group_fail', 'Löschung der Benutzergruppe fehlgeschlagen');
define('lang_sys_conf_module_field_name', 'Modulname');
define('lang_sys_conf_module_field_path', 'Modulpfad');
define('lang_sys_conf_module_field_description', 'Modulbeschreibung');

/* User Configuration */
define('lang_sys_conf_user_alert_noempty', 'Anmeldename und Name müssen angegeben sein');
define('lang_sys_conf_user_alert_forbid', 'Anmeldename oder Name nicht zulässig!');
define('lang_sys_conf_user_alert_nopassword', 'Es muss ein Passwort angegeben werden!');
define('lang_sys_conf_user_alert_nomatch', 'Passwort stimmt nicht mit Passwortbestätigung überein. Prüfen Sie, ob versehentlich die Shift-Lock-Taste aktiviert wurde!');
define('lang_sys_conf_user_alert_save_ok', 'Neue Benutzerdaten erfolgreich gespeichert');
define('lang_sys_conf_user_alert_save_fail', 'Speicherung der Benutzerdaten FEHLGESCHLAGEN. Bitte kontaktieren Sie den Systemadministrator');
define('lang_sys_conf_user_alert_update_ok', 'Benutzerdaten erfolgreich aktualisiert');
define('lang_sys_conf_user_alert_update_fail', 'Aktualisierung der Benutzerdaten FEHLGESCHLAGEN. Bitte kontaktieren Sie den Systemadministrator');
define('lang_sys_conf_user_alert_not_exist', 'Fehler! Benutzerdaten sind nicht vorhanden!');
define('lang_sys_conf_user_common_edit_info', 'Sie sind im Begriff die Angaben für folgendes Benutzerprofil zu bearbeiten');
define('lang_sys_conf_user_common_last_update', 'Letzte Aktualisierung ');
define('lang_sys_conf_user_common_info_1', 'Füllen Sie das Passwortfeld nicht aus, wenn Sie das Passwort nicht ändern wollen');
define('lang_sys_conf_user_common_alert_delete_success', 'Alle Daten erfolgreich gelöscht');
define('lang_sys_conf_user_common_alert_delete_fail', 'Einige oder alle Daten wurden NICHT erfolgreich gelöscht!\nBitte kontaktieren Sie den Systemadministrator');
define('lang_sys_conf_user_common_alert_delete_record_ok', 'Benutzer erfolgreich gelöscht');
define('lang_sys_conf_user_common_alert_delete_record_fail', 'Löschung des Benutzers fehlgeschlagen');
define('lang_sys_conf_user_field_login_name', 'Anmeldename');
define('lang_sys_conf_user_field_real', 'Name');
define('lang_sys_conf_user_field_group', 'Benutzergruppe(n)');
define('lang_sys_conf_user_field_password_1', 'Passwort');
define('lang_sys_conf_user_field_password_2', 'Passwort bestätigen');
define('lang_sys_conf_user_field_password_3', 'Neues Passwort');
define('lang_sys_conf_user_field_password_4', 'Neues Passwort bestätigen');
define('lang_sys_conf_user_field_last_login', 'Letzte Anmeldung');

/* Group Configuration */
define('lang_sys_conf_group_alert_noempty', 'Benutzergruppenname muss angegeben sein');
define('lang_sys_conf_group_alert_save_ok', 'Neue Benutzergruppendaten erfolgreich gespeichert');
define('lang_sys_conf_group_alert_save_fail', 'Speicherung der Benutzergruppendaten FEHLGESCHLAGEN. Bitte kontaktieren Sie den Systemadministrator');
define('lang_sys_conf_group_alert_update_ok', 'Benutzergruppendaten erfolgreich aktualisiert');
define('lang_sys_conf_group_alert_update_fail', 'Aktualisierung der Benutzergruppendaten FEHLGESCHLAGEN. Bitte kontaktieren Sie den Systemadministrator');
define('lang_sys_conf_group_alert_not_exist', 'Fehler! Group data sind nicht vorhanden!');
define('lang_sys_conf_group_common_edit_info', 'Sie sind im Begriff die Angaben für folgende Benutzergruppe zu bearbeiten');
define('lang_sys_conf_group_common_last_update', 'Letzte Aktualisierung ');
define('lang_sys_conf_group_common_alert_delete_success', 'Alle Daten erfolgreich gelöscht');
define('lang_sys_conf_group_common_alert_delete_fail', 'Einige oder alle Daten wurden NICHT erfolgreich gelöscht!\nBitte kontaktieren Sie den Systemadministrator');
define('lang_sys_conf_group_common_alert_delete_record_ok', 'Benutzergruppe erfolgreich gelöscht');
define('lang_sys_conf_group_common_alert_delete_record_fail', 'Löschung der Benutzergruppe fehlgeschlagen');
define('lang_sys_conf_group_field_name', 'Benutzergruppenname');
define('lang_sys_conf_group_field_privileges', 'Rechte');
define('lang_sys_conf_group_privileges_modul_name', 'Modulname');
define('lang_sys_conf_group_privileges_modul_read', 'Lesen');
define('lang_sys_conf_group_privileges_modul_write', 'Schreiben');

/* Holiday Configuration */
define('lang_sys_holiday_set_day', 'Wochenruhetage festlegen');
define('lang_sys_holiday_add_day', 'Neuer Ruhezeitraum (Ferien, Feiertage)');
define('lang_sys_holiday_list', 'Ruhezeiträume ansehen');
define('lang_sys_conf_holiday_alert_noempty', 'Beschreibung des Ruhezeitraums muss angegeben sein');
define('lang_sys_conf_holiday_alert_save_ok', 'Neuer Ruhezeitraum erfolgreich gespeichert');
define('lang_sys_conf_holiday_alert_save_fail', 'Speicherung  des Ruhezeitraums FEHLGESCHLAGEN. Bitte kontaktieren Sie den Systemadministrator');
define('lang_sys_conf_holiday_alert_update_ok', 'Ruhetag erfolgreich aktualisiert');
define('lang_sys_conf_holiday_alert_update_fail', 'Aktualisierung des Ruhetags FEHLGESCHLAGEN. Bitte kontaktieren Sie den Systemadministrator');
define('lang_sys_conf_holiday_alert_not_exist', 'Fehler! Ruhetag ist nicht vorhanden!');
define('lang_sys_conf_holiday_alert_set_ok', 'Wochenruhetage gespeichert');
define('lang_sys_conf_holiday_common_edit_info', 'Sie sind im Begriff die Angaben für folgenden Ruhezeitraum (Tag davon) zu bearbeiten');
define('lang_sys_conf_holiday_common_alert_delete_success', 'Alle Daten erfolgreich gelöscht');
define('lang_sys_conf_holiday_common_alert_delete_fail', 'Einige oder alle Daten wurden NICHT erfolgreich gelöscht!\nBitte kontaktieren Sie den Systemadministrator');
define('lang_sys_conf_holiday_common_alert_delete_record_ok', 'Ruhezeitraum erfolgreich gelöscht'); //-
define('lang_sys_conf_holiday_common_alert_delete_record_fail', 'Löschung des Ruhezeitraums fehlgeschlagen'); //-
define('lang_sys_conf_holiday_form_save', 'Einstellungen speichern');
define('lang_sys_conf_holiday_field_date_day', 'Beginn des Ruhezeitraums');
define('lang_sys_conf_holiday_field_date_day_end', 'Ende des Ruhezeitraums');
define('lang_sys_conf_holiday_field_description', 'Ruhezeitraum Beschreibung');
define('lang_sys_conf_holiday_field_day_name', 'Name des Tages');
define('lang_sys_conf_holiday_field_day_1', 'Montag');
define('lang_sys_conf_holiday_field_day_2', 'Dienstag');
define('lang_sys_conf_holiday_field_day_3', 'Mittwoch');
define('lang_sys_conf_holiday_field_day_4', 'Donnerstag');
define('lang_sys_conf_holiday_field_day_5', 'Freitag');
define('lang_sys_conf_holiday_field_day_6', 'Samstag');
define('lang_sys_conf_holiday_field_day_7', 'Sonntag');

/* Barcode Generator */
define('lang_sys_conf_barcode_alert_print_fail', 'Fehler beim Erstellen des Barcodes!');
define('lang_sys_conf_barcode_alert_print_ok', 'Barcodeerstellung abgeschlossen');
define('lang_sys_conf_barcode_button_print', 'Barcodes erstellen');
define('lang_sys_conf_barcode_field_size', 'Barcodegröße');
define('lang_sys_conf_barcode_field_option_1', 'Klein');
define('lang_sys_conf_barcode_field_option_2', 'Mittel');
define('lang_sys_conf_barcode_field_option_3', 'Groß');

/* Log System */
define('lang_sys_conf_log_field_time', 'Zeit');
define('lang_sys_conf_log_field_location', 'Stelle');
define('lang_sys_conf_log_field_message', 'Nachricht');

/* OPAC */
define('lang_opac_search_result', 'Suchergebnis');
define('lang_opac_info', 'Bibliothekskatalog Online - Nutzen Sie die verschiedenen Suchmöglichkeiten um schnell das Gesuchte zu finden'); //? OAPC - a word patrons fear :D
define('lang_opac_rec_detail', 'Details zum Titel'); //? (Record Details); Translation more user friendly?
define('lang_opac_page_info', 'Sie befinden sich auf Seite <strong>{page}</strong> von <strong>{total_pages}</strong> Seiten(n)');
define('lang_opac_search_result_info', '<strong>{biblio_list->num_rows}</strong> Ergebnisse gefunden für die Suchbegriffe');
define('lang_opac_back_prev', 'Zurück zur vorherigen Seite');

/* DEFAULT MODULE */
define('lang_mod_default_home_panel', 'Schnellzugriff');
define('lang_mod_default_home_user_profile', 'Mein Profil ändern');
define('lang_mod_default_home_user_profile_titletag', 'Aktuelles Benutzerprofil und -passwort ändern');

/* BIBLIOGRAPHIC MODULE */
# submenu
define('lang_mod_biblio', 'Titelaufnahmen');
define('lang_mod_biblio_list', 'Titelaufnahmen ansehen');
define('lang_mod_biblio_list_titletag', 'Vorhandene Titelaufnahmen anzeigen');
define('lang_mod_biblio_add', 'Neue Titelaufnahme');
define('lang_mod_biblio_add_titletag', 'Neue Titelaufnahme zum Katalog hinzufügen');
define('lang_mod_biblio_item', 'Exemplare');
define('lang_mod_biblio_item_list', 'Exemplare ansehen');
define('lang_mod_biblio_item_list_titletag', 'Übersicht der Bibliotheksexemplare');
define('lang_mod_biblio_item_checkout', 'Entliehene Exemplare');
define('lang_mod_biblio_item_checkout_titletag', 'Übersicht der derzeit entliehenen Exemplare');
define('lang_mod_biblio_tools', 'Werkzeuge');
define('lang_mod_biblio_tools_z3950', 'Z39.50 Service');
define('lang_mod_biblio_tools_z3950_titletag', 'Bibliographische Daten von einem Z39.50-Services beziehen');
define('lang_mod_biblio_tools_label_print', 'Etikette drucken (Aufnahmen)');
define('lang_mod_biblio_tools_label_print_titletag', 'Etikette mit Signatur für Titelaufnahmen drucken');
define('lang_mod_biblio_tools_label_print_select', 'Etikettendruck starten');
define('lang_mod_biblio_tools_label_print_clear', 'Druckerwarteschlange löschen');
define('lang_mod_biblio_tools_item_barcode', 'Barcodes drucken (Exemplare)');
define('lang_mod_biblio_tools_item_barcode_titletag', 'Exemplarbarcodes drucken');
define('lang_mod_biblio_tools_item_barcode_print_select', 'Barcodedruck starten');
define('lang_mod_biblio_tools_item_barcode_clear', 'Druckerwarteschlange löschen');
define('lang_mod_biblio_tools_export', 'Daten exportieren');
define('lang_mod_biblio_tools_export_titletag', 'Titelaufnahmen in Datei exportieren (CSV-Format)');
define('lang_mod_biblio_tools_import', 'Daten importieren');
define('lang_mod_biblio_tools_import_titletag', 'Titelaufnahmen aus Datei importieren (CSV-Format)');
# bibliography form fields
define('lang_mod_biblio_field_title', 'Titel');
define('lang_mod_biblio_field_edition', 'Ausgabe');
define('lang_mod_biblio_field_specific_detail', 'Anmerkung'); //? (Specific Detail Info)
define('lang_mod_biblio_field_items', 'Exemplardatensatz/-sätze');
define('lang_mod_biblio_field_no_item', 'Für diesen Titel ist noch kein Exemplar eingetragen');
define('lang_mod_biblio_link_item_add', 'Neues Exemplar hinzufügen');
define('lang_mod_biblio_field_authors', 'Autor(en)');
define('lang_mod_biblio_link_author_add', 'Autor(en) hinzufügen');
define('lang_mod_biblio_link_author_search', 'Klicken um weitere Titel von diesem Autor anzuzeigen');
define('lang_mod_biblio_field_gmd', 'Ressourcenart');
define('lang_mod_biblio_field_isbn', 'ISBN/ISSN');
define('lang_mod_biblio_field_class', 'Klassifikation'); //? Hmm
define('lang_mod_biblio_field_publisher', 'Verlag');
define('lang_mod_biblio_field_no_publisher', 'Kein Verlag angegeben bisher');
define('lang_mod_biblio_field_publish_year', 'Erscheinungsjahr');
define('lang_mod_biblio_field_publish_place', 'Erscheinungsort');
define('lang_mod_biblio_field_no_publish_place', 'Kein Erscheinungsort angegeben bisher');
define('lang_mod_biblio_field_collation', 'Umfang'); //? (Collation)
define('lang_mod_biblio_field_series', 'Reihentitel'); //? Series Title
define('lang_mod_biblio_field_call_number', 'Signatur');
define('lang_mod_biblio_field_topic', 'Schlagwörter');
define('lang_mod_biblio_link_topic_add', 'Schlagwörter hinzufügen');
define('lang_mod_biblio_link_topic_search', 'Klicken um weitere Titel mit diesem Schlagwort anzuzeigen');
define('lang_mod_biblio_field_lang', 'Sprache');
define('lang_mod_biblio_field_notes', 'Abstract/Inhalt');
define('lang_mod_biblio_field_image', 'Bild');
define('lang_mod_biblio_field_image_nothing', 'Kein Bild vorhanden');
define('lang_mod_biblio_field_attachment', 'Dateianhang');
define('lang_mod_biblio_field_attachment_nothing', 'Kein Dateianhang vorhanden');
define('lang_mod_biblio_field_availability', 'Verfügbarkeit');
define('lang_mod_biblio_field_hide_opac', 'Anzeige im OPAC');
define('lang_mod_biblio_field_promote', 'Auf der Startseite anzeigen'); //? promote...
# bibliography common
define('lang_mod_biblio_common_form_print_queue', 'Zur Druckerwarteschlange hinzufügen');
define('lang_mod_biblio_common_print_queue_confirm', 'Zur Druckerwarteschlange hinzufügen?');
define('lang_mod_biblio_common_print_cleared', 'Druckerwarteschlange gelöscht!');
define('lang_mod_biblio_common_print_no_data', 'Es sind keine Daten zum Drucken vorhanden!');
define('lang_mod_biblio_alert_print_no_add_queue', 'Ausgewählte Einträge NICHT zur Druckerwarteschlange hinzugefügt. Es können höchstens {max_print} auf einmal gedruckt werden');
define('lang_mod_biblio_alert_print_add_ok', 'Ausgewählte Einträge zur Druckerwarteschlange hinzugefügt');
define('lang_mod_biblio_alert_title_empty', 'Titel muss angegeben sein');
define('lang_mod_biblio_alert_failed_to_save', 'Speicherung der Titelaufnahme FEHLGESCHLAGEN. Bitte kontaktieren Sie den Systemadministrator');
define('lang_mod_biblio_alert_failed_to_update', 'Aktualisierung der Titelaufnahme FEHLGESCHLAGEN. Bitte kontaktieren Sie den Systemadministrator');
define('lang_mod_biblio_alert_new_added', 'Neue Titelaufnahme erfolgreich gespeichert');
define('lang_mod_biblio_alert_updated_ok', 'Titelaufnahme erfolgreich aktualisiert');
define('lang_mod_biblio_alert_image_uploaded', 'Bild erfolgreich hochgeladen');
define('lang_mod_biblio_alert_image_not_uploaded', 'Hochladen des Bildes FEHLGESCHLAGEN');
define('lang_mod_biblio_alert_attach_uploaded', 'Dateianhang erfolgreich hochgeladen');
define('lang_mod_biblio_alert_attach_not_uploaded', 'Hochladen des Dateianhangs FEHLGESCHLAGEN');
define('lang_mod_biblio_common_not_exists','FEHLER! Ausgewählte Daten sind nicht vorhanden');
define('lang_mod_biblio_common_edit_message', 'Sie sind im Begriff die Angaben für folgende Titelaufnahme zu bearbeiten');
define('lang_mod_biblio_common_last_update', 'Letzte Aktualisierung ');
define('lang_mod_biblio_alert_list_not_deleted', 'Folgende Daten können nicht gelöscht werden: ');
define('lang_mod_biblio_alert_data_selected_deleted', 'Alle Daten erfolgreich gelöscht');
define('lang_mod_biblio_alert_data_selected_not_deleted', 'Einige oder alle Daten wurden NICHT erfolgreich gelöscht!\nBitte kontaktieren Sie den Systemadministrator');
define('lang_mod_biblio_alert_data_have_item', 'Diese Titelaufnahme kann nicht gelöscht werden, da noch {biblio_item} Exemplare mit ihr verknüpft sind. Bitte löschen Sie diese Exemplare zunächst.');
define('lang_mod_biblio_alert_data_deleted', 'Titelaufnahme erfolgreich gelöscht');
define('lang_mod_biblio_alert_data_not_deleted', 'Löschung der Titelaufnahme fehlgeschlagen');
# item form fields
define('lang_mod_biblio_item_field_title', 'Titel');
define('lang_mod_biblio_item_field_itemcode', 'Barcode/Exemplar');
define('lang_mod_biblio_item_field_inventory', 'Bestandsnummer'); //? (Inventory Code)
define('lang_mod_biblio_item_field_location', 'Standort'); //?
define('lang_mod_biblio_item_field_site', 'Regalstandort');
define('lang_mod_biblio_item_field_ctype', 'Sammlung');
define('lang_mod_biblio_item_field_item_status', 'Exemplarstatus');
define('lang_mod_biblio_item_field_order_number', 'Bestellnummer'); //? (Order Number)
define('lang_mod_biblio_item_field_order_date', 'Bestelldatum');
define('lang_mod_biblio_item_field_received_date', 'Lieferungsdatum');
define('lang_mod_biblio_item_field_supplier', 'Zulieferer');
define('lang_mod_biblio_item_field_item_source', 'Quelle'); //? Herkunft...?
define('lang_mod_biblio_item_field_invoice', 'Rechnung');
define('lang_mod_biblio_item_field_invoice_date', 'Rechnungsdatum');
define('lang_mod_biblio_item_field_price', 'Preis');
#item
define('lang_mod_biblio_item_common_opac_status_1', 'Wir besitzen {copy} Exemplare dieses Titels und ALLE sind derzeit ausgeliehen');
define('lang_mod_biblio_item_common_opac_status_2', 'Wir besitzen {copy} Exemplare dieses Titels');
define('lang_mod_biblio_item_common_opac_status_3', 'ist verfügbar');
define('lang_mod_biblio_item_common_opac_status_4', 'derzeit ausgeliehen');
define('lang_mod_biblio_item_common_location_status_1', 'Exemplare in'); //? at - how does it continue?
define('lang_mod_biblio_item_alert_collection_title', 'Titel der Sammlung muss angegeben sein!');
define('lang_mod_biblio_item_alert_item_code', 'Barcode/Exemplar muss angegeben sein!');
define('lang_mod_biblio_item_alert_new_saved', 'Neues Exemplar erfolgreich gespeichert');
define('lang_mod_biblio_item_alert_updated','Exemplar erfolgreich aktualisiert');
define('lang_mod_biblio_item_alert_not_saved', 'Speicherung des Exemplars FEHLGESCHLAGEN. Bitte kontaktieren Sie den Systemadministrator');
define('lang_mod_biblio_item_alert_delete_fail_on_loan', 'Exemplars kann nicht gelöscht werden, da es noch ausgeliehen ist');
define('lang_mod_biblio_item_alert_delete_item_data_success', 'Alle Daten erfolgreich gelöscht');
define('lang_mod_biblio_item_alert_delete_item_data_failed', 'Einige oder alle Daten wurden NICHT erfolgreich gelöscht!\nBitte kontaktieren Sie den Systemadministrator');
define('lang_mod_biblio_item_common_edit_message', 'Sie sind im Begriff die Angaben für folgendes Exemplar zu bearbeiten');
define('lang_mod_biblio_item_common_last_update', 'Letzte Aktualisierung');
define('lang_mod_biblio_item_common_delete_success', 'Exemplar erfolgreich gelöscht');
define('lang_mod_biblio_item_common_delete_failed', 'Löschung des Exemplars fehlgeschlagen');
define('lang_mod_biblio_item_alert_remove_success', 'Exemplar erfolgreich entfernt!');
define('lang_mod_biblio_item_alert_remove_failed', 'Entfernung des Exemplars FEHLGESCHLAGEN!');
# file attached
define('lang_mod_biblio_file_delete_success', 'Datei {file_d[0]} gelöscht');
define('lang_mod_biblio_file_delete_fail', 'Löschung der Datei {file_d[0]} FEHLGESCHLAGEN');
# export
define('lang_mod_biblio_export_header', 'EXPORT-WERKZEUG');
define('lang_mod_biblio_export_header_text', 'Titelaufnahmen in Datei exportieren (CSV-Format)');
define('lang_mod_biblio_export_form_field_separator', 'Trennzeichen für Felder*');
define('lang_mod_biblio_export_form_field_enclosed', 'Feldinhalte einschließen zwischen*');
define('lang_mod_biblio_export_form_field_rec_separator', 'Datensatztrennzeichen');
define('lang_mod_biblio_export_form_field_rec_to_export', 'Zahl der zu exportierenden Datensätze (0 für alle Datensätze)');
define('lang_mod_biblio_export_form_field_rec_start', 'Beginnend von Datensatz');
define('lang_mod_biblio_export_form_button_start', 'Export starten');
define('lang_mod_biblio_export_alert_all_field', 'Erforderliche Felder müssen korrekt angegeben sein!');
define('lang_mod_biblio_export_alert_err_query', 'Fehler bei der Datenbankabfrage, Export FEHLGESCHLAGEN!');
define('lang_mod_biblio_export_alert_no_record', 'Es sind keine Titelaufnahmen in der Datenbank vorhanden, Export FEHLGESCHLAGEN!');
# import
define('lang_mod_biblio_import_header', 'IMPORT-WERKZEUG');
define('lang_mod_biblio_import_header_text', 'Titelaufnahmen aus Datei importieren (CSV-Format). Für Erläuterung zur Sortierung und dem Format der CVS-Felder ziehen Sie bitte die Dokumentation zu Rate oder besuchen Sie die <a href="http://senayan.diknas.go.id" target="_blank">Offizielle Webseite</a>');
define('lang_mod_biblio_import_form_field_file_input', 'Zu importierende Datei*');
define('lang_mod_biblio_import_file_input_require', 'Bitte wählen Sie die zu importierende Datei aus!');
define('lang_mod_biblio_import_form_field_separator', 'Trennzeichen für Felder*');
define('lang_mod_biblio_import_form_field_enclosed', 'Feldinhalte eingeschlossen zwischen*');
define('lang_mod_biblio_import_form_field_rec_to_export', 'Zahl der zu importierenden Datensätze (0 für alle Datensätze)');
define('lang_mod_biblio_import_form_field_rec_start', 'Beginnend von Datensatz');
define('lang_mod_biblio_import_form_button_start', 'Import starten');
define('lang_mod_biblio_import_alert_all_field', 'Erforderliche Felder müssen korrekt angegeben sein!');
define('lang_mod_biblio_import_alert_err_size', 'Hochladen fehlgeschlagen! Dateityp ist unzulässig oder ist größer als ');
define('lang_mod_biblio_alert_field_author_removed', 'Autor entfernt!');
define('lang_mod_biblio_alert_field_author_session_removed', 'Autor erfolgreich entfernt!');
# pop-ups
# author
define('lang_mod_biblio_author_update_ok', 'Autor erfolgreich aktualisiert!');
define('lang_mod_biblio_author_added_ok', 'Autor hinzugefügt!');
define('lang_mod_biblio_author_added_fail', 'Hinzufügen des Autors FEHLGESCHLAGEN. Bitte kontaktieren Sie den Systemadministrator');
define('lang_mod_biblio_author_form_name', 'Name des Autors');
define('lang_mod_biblio_author_form_search', 'Tippen Sie einen Namen ein um nach vorhandenen Autoren zu suchen oder einen neuen hinzufügen');
define('lang_mod_biblio_author_insert_to_biblio', 'In Titelaufnahme einfügen');
#topic
define('lang_mod_biblio_topic_update_ok', 'Schlagwort erfolgreich aktualisiert!');
define('lang_mod_biblio_topic_added_ok', 'Schlagwort hinzugefügt!');
define('lang_mod_biblio_topic_added_fail', 'Hinzufügen des Schlagwortes FEHLGESCHLAGEN. Bitte kontaktieren Sie den Systemadministrator');
define('lang_mod_biblio_topic_form_title', 'Schlagwörter hinzufügen');
define('lang_mod_biblio_topic_form_keyword', 'Stichwort');
define('lang_mod_biblio_topic_form_search', 'Tippen Sie einfach los um nach vorhandenen Schlagwörtern zu suchen oder ein neues hinzufügen');
define('lang_mod_biblio_topic_insert_to_biblio', 'In Titelaufnahme einfügen');

/* CIRCULATION MODULE */
# submenu
define('lang_mod_circ', 'Ausleihe');
define('lang_mod_circ_start', 'Neue Buchung');
define('lang_mod_circ_start_titletag', 'Neuen Buchungsvorgang ausführen (Entleihung, Rücknahme, Vormerkung, Gebühren)');
define('lang_mod_circ_quick_return', 'Schnellrücknahme');
define('lang_mod_circ_quick_return_titletag', 'Exemplare schnell zurückbuchen');
define('lang_mod_circ_quick_return_msg1', 'Tippen oder scannen Sie den Barcode eines Exemplars ein um es zurückzubuchen');
define('lang_mod_circ_loan_rules', 'Ausleihregeln');
define('lang_mod_circ_loan_rules_titletag', 'Ausleihregeln ansehen und ändern');
define('lang_mod_circ_loan_rules_add', 'Neue Ausleihregel');
define('lang_mod_circ_loan_rules_list', 'Ausleihregeln ansehen');
define('lang_mod_circ_transaction_history', 'Ausleihverlauf');
define('lang_mod_circ_transaction_history_titletag', 'Übersicht vergangener Ausleihvorgänge');
define('lang_mod_circ_overdues', 'Mahnungen');
define('lang_mod_circ_overdues_titletag', 'Zeige Mitlgieder mit Mahngebühren');
# common
define('lang_mod_circ_common_welcome', 'AUSLEIHE - Geben sie eine Mitgliedsnummer ein um einen Buchungsvorgang auszuführen');
define('lang_mod_circ_common_loan_not_saved', 'FEHLER! Ausleihinformationen können nicht in der Datenbank gespeichert werden');
define('lang_mod_circ_common_trans_finish', 'Buchungsvorgang für Mitglied {member_id} erfolgreich abgeschlossen');
define('lang_mod_circ_common_error_unregistered_member', ' ungültig (nicht in der Datenbank vorhanden) ');
define('lang_mod_circ_common_error_expired_membership', 'Mitgliedschaft ist abgelaufen ');
define('lang_mod_circ_common_error_pending_membership', 'Status der Mitgliedsschaft ist \'ruhend\', keine Ausleihvorgänge möglich.');
define('lang_mod_circ_common_return_confirmation', 'Wollen Sie das Exemplar zurückbuchen?');
define('lang_mod_circ_common_extend_confirmation', 'Wollen Sie die Leihfrist verlängern für');
define('lang_mod_circ_common_overdued_for_1', 'ÜBERFÄLLIG seit');
define('lang_mod_circ_common_overdued_for_2', 'Tag(en) mit Mahngebühren');
define('lang_mod_circ_common_loan_confirmation', 'Wollen Sie den derzeitigen Buchungsvorgang abschließen?');
define('lang_mod_circ_common_finished_loan_confirmation', 'Buchungsvorgang abgeschlossen');
define('lang_mod_circ_common_fines_inserted', 'Mahngebühren im System gespeichert');
define('lang_mod_circ_common_fines_alert_01', 'Gebührenbeschreibung und Gebührenforderung müssen angegeben sein');
define('lang_mod_circ_common_fines_alert_02', 'Das Guthaben kann nicht größer als die Gebührenforderung sein');
define('lang_mod_circ_common_alert_error_limit_reach', 'Ausleihlimit erreicht!');
define('lang_mod_circ_common_alert_extended_success', 'Leihfrist verlängert');
define('lang_mod_circ_common_overide_confirmation', 'Wollen Sie dies ausdrücklich ignorieren und weiter fortfahren?');
define('lang_mod_circ_alert_on_resereved', 'Warnung! Dieses Exemplar ist durch ein anderes Mitglied vorgemerkt');
define('lang_mod_circ_alert_item_not_registered', 'Dieses Exemplar ist im System nicht vorhanden');
define('lang_mod_circ_alert_item_not_available', 'Dieses Exemplar ist derzeitig nicht verfügbar');
define('lang_mod_circ_alert_member_expired', 'Ausleihe NICHT ZULÄSSIG! Mitgliedschaft ist ABGELAUFEN!');
define('lang_mod_circ_alert_member_pending', 'Ausleihe NICHT ZULÄSSIG! Mitgliedschaft hat Status RUHEND!');
define('lang_mod_circ_alert_not_for_loan', 'Ausleihe für dieses Exemplar nicht gestattet!');
define('lang_mod_circ_alert_item_remove_from_session', 'Exemplar {removeID} aus Ausleihliste entfernt');
define('lang_mod_circ_common_item_already_return', 'Dieses Exemplar wurde bereits zurückgebucht oder ist nicht in der Ausleihdatenbank geführt');
define('lang_mod_circ_common_return_overdue', 'ÜBERFÄLLIG seit {overdueDays} Tag(en) mit Mahngebühren von '); /* see common_overdued_for_1 & 2 */
define('lang_mod_circ_common_item_return_ok', ' erfolgreich zurückgebucht am ');
define('lang_mod_circ_reserve', 'Vormerkungen');
define('lang_mod_circ_reserve_alert_nod_data', 'KEINE DATEN zur Vormerkung ausgewählt!');
define('lang_mod_circ_reserve_alert_forbidden', 'Exemplar kann nicht vorgemerkt werden. Ausleihe nicht gestattet!');
define('lang_mod_circ_reserve_alert_success', 'Vormerkung hinzugefügt');
define('lang_mod_circ_reserve_alert_after_return', 'Exemplar {itemCode} ist durch Mitglied {member} vorgemerkt');
define('lang_mod_circ_reserve_alert_available', 'Ein Exemplar für diesen Titel ist verfügbar oder bereits von diesem Mitglied ausgeliehen!');
define('lang_mod_circ_reserve_alert_removed', 'Vormerkung entfernt');
define('lang_mod_circ_reserve_alert_reach_limit', 'Es können keine weiteren Vormerkungen hinzugefügt werden. Höchstzahl erreicht');
define('lang_mod_circ_fines_alert_removed', 'Gebührendaten entfernt');
# transaction form
define('lang_mod_circ_field_member_id', 'Mitgliedsnummer');
define('lang_mod_circ_field_member_name', 'Name des Mitglieds');
define('lang_mod_circ_field_member_email', 'E-Mail des Mitglieds');
define('lang_mod_circ_field_register_date', 'Registrierungsdatum');
define('lang_mod_circ_field_member_type', 'Mitgliedstyp');
define('lang_mod_circ_field_expiry_date', 'Ablaufdatum');
define('lang_mod_circ_button_loans', 'Ausleihen');
define('lang_mod_circ_button_current_loans', 'Derzeitige Entleihungen');
define('lang_mod_circ_button_reserve', 'Vormerkungen');
define('lang_mod_circ_button_fines', 'Gebühren');
define('lang_mod_circ_button_loan_history', 'Gebühren- und Ausleihverlauf');
define('lang_mod_circ_button_finish_transaction', 'Buchungsvorgang abschließen');
define('lang_mod_circ_tblheader_return', 'Zurückbuchen');
define('lang_mod_circ_tblheader_extend', 'Verlängern');
define('lang_mod_circ_tblheader_item_code', 'Barcode');
define('lang_mod_circ_tblheader_title', 'Titel');
define('lang_mod_circ_tblheader_loan_date', 'Ausleihdatum');
define('lang_mod_circ_tblheader_due_date', 'Rückgabetermin');
define('lang_mod_circ_tblheader_returned_date', 'Rückgabedatum');
define('lang_mod_circ_tblheader_remove', 'Entfernen');
define('lang_mod_circ_tblheader_reserve_date', 'Datum der Vormerkung');
define('lang_mod_circ_tblheader_add_new_fines', 'Neue Gebühr hinzufügen');
define('lang_mod_circ_tblheader_fines_list', 'Gebühren ansehen');
define('lang_mod_circ_tblheader_view_balanced_overdue', 'Beglichene Mahngebühren ansehen');
define('lang_mod_circ_loan_field_insert_barcode', 'Barcode des Exemplars angeben');
define('lang_mod_circ_loan_button_loan', 'Ausleihen');
define('lang_mod_circ_reserve_field_search_collection', 'Bestand durchsuchen');
define('lang_mod_circ_reserve_button_add_reserve', 'Vormerkung hinzufügen');
define('lang_mod_circ_return_titletext_return', 'Exemplar zurückbuchen');
define('lang_mod_circ_return_alttext_return', 'Zurückbuchen');
define('lang_mod_circ_return_no_return_history_data', 'Noch nicht zurückgegeben');
define('lang_mod_circ_extend_alttext_no_extend', 'Keine Verlängerung');
define('lang_mod_circ_extend_titletext_extend', 'Leihfrist für dieses Exemplar verlängern');
define('lang_mod_circ_extend_alttext_extend', 'Verlängern');
define('lang_mod_circ_extend_renewal_flag', 'Verlängert');
define('lang_mod_circ_extend_noextend_confirmation', 'Leihfrist des Exemplars kann NICHT verlängert werdenItem! Exemplar ist durch ein anderes Mitglied vorgemerkt');
# fines
define('lang_mod_circ_fines_alert_new_added', 'Neuer Gebühreneintrag erfolgreich gespeichert');
define('lang_mod_circ_fines_alert_fail_to_save', 'Speicherung des Gebühreneintrags FEHLGESCHLAGEN. Bitte kontaktieren Sie den Systemadministrator');
define('lang_mod_circ_fines_alert_required_data', 'Gebührenbeschreibung und Gebührenforderung müssen angegeben sein');
define('lang_mod_circ_fines_alert_balance_data', 'Das Guthaben kann nicht größer als die Gebührenforderung sein');
define('lang_mod_circ_fines_alert_updated', 'Gebühreneintrag erfolgreich aktualisiert');
define('lang_mod_circ_fines_alert_not_updated', 'Aktualisierung des Gebühreneintrags FEHLGESCHLAGEN. Bitte kontaktieren Sie den Systemadministrator');
define('lang_mod_circ_fines_alert_not_exists', 'Fehler! Gebühreneintrag ist nicht vorhanden!');
define('lang_mod_circ_fines_common_info', 'Sie sind im Begriff die Angaben für folgenden Gebühreneintrag zu bearbeiten: ');
# form
define('lang_mod_circ_fines_field_date', 'Gebührendatum');
define('lang_mod_circ_fines_field_description', 'Beschreibung/Name');
define('lang_mod_circ_fines_field_debit', 'Gebührenforderung');
define('lang_mod_circ_fines_field_credit', 'Guthaben');
# loan rules
define('lang_mod_circ_loan_rules_alert_add_ok', 'Neue Ausleihregel erfolgreich gespeichert');
define('lang_mod_circ_loan_rules_alert_add_fail', 'Speicherung der Ausleihregel FEHLGESCHLAGEN. Bitte kontaktieren Sie den Systemadministrator');
# form loan rules
define('lang_mod_circ_loan_rules_field_member_type', 'Mitgliedstyp');
define('lang_mod_circ_loan_rules_field_collection_type', 'Sammlungstyp');
define('lang_mod_circ_loan_rules_field_gmd', 'Ressourcenart');
define('lang_mod_circ_loan_rules_field_loan_limit', 'Ausleihlimit');
define('lang_mod_circ_loan_rules_field_loan_period', 'Ausleihdauer');
define('lang_mod_circ_loan_rules_field_reborrow_limit', 'Ausleiherneuerungen maximal');
define('lang_mod_circ_loan_rules_field_fines', 'Gebühren pro Tag');
# common loan rules
define('lang_mod_circ_loan_rules_alert_updated_ok', 'Ausleihregeln erfolgreich aktualisiert');
define('lang_mod_circ_loan_rules_alert_updated_fail', 'Aktualisierung der Ausleihregeln FEHLGESCHLAGEN. Bitte kontaktieren Sie den Systemadministrator');
define('lang_mod_circ_loan_rules_alert_not_exist', 'Fehler! Ausleihregel sind nicht vorhanden!');
define('lang_mod_circ_loan_rules_common_edit_info', 'Sie sind im Begriff die Angaben für folgende Ausleihregel zu bearbeiten: ');
define('lang_mod_circ_loan_rules_common_last_update', 'Letzte Aktualisierung ');
define('lang_mod_circ_loan_rules_alert_all_deleted', 'Alle Daten erfolgreich gelöscht');
define('lang_mod_circ_loan_rules_alert_not_all_deleted', 'Einige oder alle Daten wurden NICHT erfolgreich gelöscht!\nBitte kontaktieren Sie den Systemadministrator');
define('lang_mod_circ_loan_rules_alert_deleted', 'Ausleihregeln erfolgreich gelöscht');
define('lang_mod_circ_loan_rules_alert_not_deleted', 'Löschung der Ausleihregeln FEHLGESCHLAGEN');
# overdue loan
define('lang_mod_circ_loan_overdue_tblheader', 'Mitglied(er) mit Mahngebühren');
# quick return
define('lang_mod_circ_loan_quick_return_disable', 'Schnellrücknahme ist deaktiviert');
define('lang_mod_circ_loan_quick_return_form_item_id', 'Barcode/Exemplar');
define('lang_mod_circ_loan_quick_return_form_button', 'Zurückbuchen');
# reserve list
define('lang_mod_circ_loan_reserve_status', 'VERFÜGBAR');
define('lang_mod_circ_loan_reserve_confirm_delete', 'Wollen Sie die Vormerkung entfernen für');
define('lang_mod_circ_loan_reserve_expired', 'BEREITS ABGELAUFEN');

/* MEMBERSHIP MODULE */
# submenu
define('lang_mod_membership', 'Mitgliedschaften');
define('lang_mod_membership_view_member_list', 'Mitgliederliste');
define('lang_mod_membership_view_member_list_titletag', 'Liste der Bibliotheksmitglieder aufrufen');
define('lang_mod_membership_add_new_member', 'Neues Mitglied');
define('lang_mod_membership_add_new_member_titletag', 'Ein neues Bibliotheksmitglied hinzufügen');
define('lang_mod_membership_member_type', 'Mitgliedstypen');
define('lang_mod_membership_member_type_titletag', 'Mitgliedstyp ansehen und ändern');
define('lang_mod_membership_member_type_new_add', 'Neuer Mitgliedstyp');
define('lang_mod_membership_member_type_list', 'Mitgliedstypen ansehen');
define('lang_mod_membership_member_list', 'Mitgliederliste');
define('lang_mod_membership_view_expired_member', 'Abgelaufene Mitgliedschaften anzeigen');
define('lang_mod_membership_tools', 'Werkzeuge');
define('lang_mod_membership_import_data', 'Daten importieren');
define('lang_mod_membership_import_data_titletag', 'Mitgliederdaten aus Datei importieren (CSV-Format)');
define('lang_mod_membership_import_data_description', 'Mitgliederdaten aus Datei importieren (CSV-Format)');
define('lang_mod_membership_export_data', 'Daten exportieren');
define('lang_mod_membership_export_data_titletag', 'Mitgliederdaten in Datei exportieren (CSV-Format)');
define('lang_mod_membership_export_data_description', 'Mitgliederdaten in Datei exportieren (CSV-Format)');
define('lang_mod_membership_search', 'Mitgliedersuche');
define('lang_mod_membership_search_button', 'Suchen');
define('lang_mod_membership_card_generator_titletag', 'Mitgliederkarten drucken');
define('lang_mod_membership_card_generator', 'Mitgliederkarten drucken');
# common
define('lang_mod_membership_common_error_no_id_name', 'Mitgliedsnummer und Name müssen angegeben sein');
define('lang_mod_membership_common_member_data_saved', 'Neue Mitgliedsdaten erfolgreich gespeichert');
define('lang_mod_membership_common_image_upload_success', 'Bild erfolgreich hochgeladen');
define('lang_mod_membership_common_image_upload_error', 'Hochladen des Bildes FEHLGESCHLAGEN');
define('lang_mod_membership_common_error_fail_to_save_member_data', 'Speicherung/Aktualisierung der Mitgliedsdaten FEHLGESCHLAGEN. Bitte kontaktieren Sie den Systemadministrator');
define('lang_mod_membership_common_error_member_data_not_exist', 'FEHLER! Ausgewählte Daten sind nicht vorhanden');
define('lang_mod_membership_common_error_membership_expired', 'Mitgliedschaft bereits abgelaufen');
define('lang_mod_membership_common_member_data_updated', 'Mitgliedsdaten erfolgreich aktualisiert');
define('lang_mod_membership_button_save', 'Speichern');
define('lang_mod_membership_common_maximum', 'Maximum');
define('lang_mod_membership_common_edit_message', 'Sie sind im Begriff die Angaben für folgendes Mitglied zu bearbeiten');
define('lang_mod_membership_common_last_update', 'Letzte Aktualisierung');
define('lang_mod_membership_common_alert_no_delete_member_data', 'Folgende Mitgliederdaten können nicht geklöscht werden, da noch Entleihungen gebucht sind');
define('lang_mod_membership_common_alert_no_delete_member_data_1', 'Mitgliederdaten');
define('lang_mod_membership_common_alert_no_delete_member_data_2', 'können nicht geklöscht werden,');
define('lang_mod_membership_common_alert_no_delete_member_data_3', 'da noch Entleihungen gebucht sind');
define('lang_mod_membership_common_member_data_deleted_success', 'Mitgliederdaten erfolgreich gelöscht');
define('lang_mod_membership_common_member_data_deleted_failed', 'Löschung des Mitglieds fehlgeschlagen');
define('lang_mod_membership_common_expired_member_list', 'Liste abgelaufener Mitgliedschaften');
define('lang_mod_membership_common_found_text_1', 'Es wurde');
define('lang_mod_membership_common_found_text_2', 'Mitglied(er) gefunden mit dem Suchbegriff');
define('lang_mod_membership_common_alert_delete_member_data_success', 'Alle Daten erfolgreich gelöscht');
define('lang_mod_membership_common_alert_delete_member_data_failed', 'Einige oder alle Daten wurden NICHT erfolgreich gelöscht!\nBitte kontaktieren Sie den Systemadministrator');
# form
define('lang_mod_membership_field_extend_membership', 'Mitgliedschaft verlängern');
define('lang_mod_membership_field_extend', 'Verlängern');
define('lang_mod_membership_field_member_id', 'Mitgliedsnummer');
define('lang_mod_membership_field_name', 'Name des Mitglieds');
define('lang_mod_membership_field_birth_date', 'Geburtsdatum');
define('lang_mod_membership_field_institution', 'Institution');
define('lang_mod_membership_field_membership_type', 'Mitgliedstyp');
define('lang_mod_membership_field_gender', 'Geschlecht');
define('lang_mod_membership_field_gender_opt1', 'Männlich');
define('lang_mod_membership_field_gender_opt2', 'Weiblich');
define('lang_mod_membership_field_email', 'E-Mail');
define('lang_mod_membership_field_address', 'Adresse');
define('lang_mod_membership_field_postal_code', 'Postleitzahl');
define('lang_mod_membership_field_phone_number', 'Telefon');
define('lang_mod_membership_field_fax_number', 'Fax');
define('lang_mod_membership_field_personal_id', 'Personal ID Number'); //? Personalnummer; Personalausweisnummer?... lost in translation? :)
define('lang_mod_membership_field_notes', 'Bemerkungen');
define('lang_mod_membership_field_photo', 'Foto');
define('lang_mod_membership_field_member_since', 'Mitglied seit');
define('lang_mod_membership_field_register_date', 'Registrierungsdatum');
define('lang_mod_membership_field_expiry_date', 'Ablaufdatum');
define('lang_mod_membership_field_pending', 'Ruhende Mitgliedschaft');
# member type form
define('lang_mod_member_type_alert_name_noempty', 'Bezeichnung des Mitgliedstyps muss angegeben sein');
define('lang_mod_member_type_alert_data_not_exist', 'FEHLER! Mitgliedstypsdaten sind nicht vorhanden');
define('lang_mod_member_type_common_edit_message', 'Sie sind im Begriff die Angaben für folgenden Mitgliedstyp zu bearbeiten');
define('lang_mod_member_type_common_last_update', 'Letzte Aktualisierung');
define('lang_mod_member_type_common_member_type_saved', 'Neuer Mitgliedstyp erfolgreich gespeichert');
define('lang_mod_member_type_common_member_type_updated', 'Mitgliedstyp erfolgreich aktualisiert');
define('lang_mod_member_type_common_fail_to_save_member_type', 'Speicherung/Aktualisierung der Mitgliedstypdaten FEHLGESCHLAGEN. Bitte kontaktieren Sie den Systemadministrator');
define('lang_mod_member_type_field_name', 'Bezeichnung des Mitgliedstyps');
define('lang_mod_member_type_field_periode', 'Mitgliedschaftsdauer (in Tagen)');
define('lang_mod_circ_field_loan_limit', 'Ausleihlimit');
define('lang_mod_circ_field_loan_periode', 'Ausleihdauer (in Tagen)'); //? (Loan Periode)
define('lang_mod_circ_field_reserve', 'Vormerkungen');
define('lang_mod_circ_field_reserve_limit', 'Vormerkungen Limit');
define('lang_mod_circ_field_reborrow_limit', 'Ausleiherneuerungen maximal');
define('lang_mod_circ_field_fine_each_day', 'Gebühren pro Tag');
define('lang_mod_circ_field_grace_periode', 'Kulanzzeit bei Überfälligkeit');
# import membership
define('lang_mod_member_import_alert_file_noempty', 'Bitte wählen Sie eine Datei zum Import aus!');
define('lang_mod_member_import_alert_required_noempty', 'Erforderliche Felder müssen korrekt angegeben sein!');
define('lang_mod_member_import_alert_fail', 'Hochladen fehlgeschlagen! Dateityp ist unzulässig oder ist größer als');
define('lang_mod_member_import_info_record_uploaded',  'Datensätze erfolgreich in die Mitgliederdatenbank eingefügt, von Datensatz'); //? from record?
define('lang_mod_member_import_field_file', 'Zu importierende Datei');
define('lang_mod_member_import_field_field_separator', 'Trennzeichen für Felder');
define('lang_mod_member_import_field_field_enclosed', 'Feldinhalte eingeschlossen zwischen');
define('lang_mod_member_import_field_record_number', 'Zahl der zu importierenden Datensätze (0 für alle Datensätze)');
define('lang_mod_member_import_field_record_offset', 'Beginnend von Datensatz');
define('lang_mod_member_import_button_start', 'Import starten');
# export membership
define('lang_mod_member_export_alert_required_noempty', 'Erforderliche Felder müssen korrekt angegeben sein!');
define('lang_mod_member_export_alert_fail', 'Es befinden sich keine Datensätze in der Mitgliederdatenbank, Export FEHLGESCHLAGEN');
define('lang_mod_member_export_alert_query_fail', 'Fehler bei der Datenbankabfrage, Export FEHLGESCHLAGEN!');
define('lang_mod_member_export_field_field_separator', 'Trennzeichen für Felder');
define('lang_mod_member_export_field_field_enclosed', 'Feldinhalte eingeschlossen zwischen');
define('lang_mod_member_export_field_record_number', 'Zahl der zu exportierenden Datensätze (0 für alle Datensätze)');
define('lang_mod_member_export_field_record_offset', 'Beginnend von Datensatz');
define('lang_mod_member_export_field_record_separator', 'Datensatztrennzeichen');
define('lang_mod_member_export_button_start', 'Export starten');

/* MASTER FILE MODULE */
# submenu
define('lang_mod_masterfile_authority_files', 'Normdateien');
define('lang_mod_masterfile_lookup_files', 'Nachschlagedateien');
define('lang_mod_masterfile_gmd', 'Ressourcenart');
define('lang_mod_masterfile_gmd_titletag', 'Ressourcenart');
define('lang_mod_masterfile_gmd_new_add', 'Neue Ressourcenart');
define('lang_mod_masterfile_gmd_list', 'Ressourcenarten ansehen');
define('lang_mod_masterfile_publisher', 'Verlag');
define('lang_mod_masterfile_publisher_titletag', 'Verlag');
define('lang_mod_masterfile_publisher_new_add', 'Neuer Verlag');
define('lang_mod_masterfile_publisher_list', 'Verlage ansehen');
define('lang_mod_masterfile_supplier', 'Zulieferer');
define('lang_mod_masterfile_supplier_titletag', 'Zulieferer für Bibliotheksexemplare');
define('lang_mod_masterfile_supplier_new_add', 'Neuer Zulieferer');
define('lang_mod_masterfile_supplier_list', 'Zulieferer ansehen');
define('lang_mod_masterfile_author', 'Autor');
define('lang_mod_masterfile_author_titletag', 'Autoren');
define('lang_mod_masterfile_author_new_add', 'Neuer Autor');
define('lang_mod_masterfile_author_list', 'Autoren ansehen');
define('lang_mod_masterfile_topic', 'Schlagwort');
define('lang_mod_masterfile_topic_titletag', 'Schlagwort');
define('lang_mod_masterfile_topic_list', 'Schlagwörter ansehen');
define('lang_mod_masterfile_topic_type', 'Schlagwortkategorie');
define('lang_mod_masterfile_topic_new_add', 'Neues Schlagwort');
define('lang_mod_masterfile_location', 'Standort'); //? doch Zweigstelle? Der "echte" Standort wird dann über Shelf Location angegeben
define('lang_mod_masterfile_location_titletag', 'Standortangabe für Exemplare');
define('lang_mod_masterfile_location_new_add', 'Neuer Standort');
define('lang_mod_masterfile_location_list', 'Standorte ansehen');
define('lang_mod_masterfile_place', 'Erscheinungsort');
define('lang_mod_masterfile_place_titletag', 'Erscheinungsort');
define('lang_mod_masterfile_place_new_add', 'Neuer Erscheinungsort');
define('lang_mod_masterfile_place_list', 'Erscheinungsorte ansehen');
define('lang_mod_masterfile_itemstatus', 'Exemplarstatus');
define('lang_mod_masterfile_itemstatus_titletag', 'Exemplarstatus');
define('lang_mod_masterfile_itemstatus_new_add', 'Neuer Exemplarstatus');
define('lang_mod_masterfile_itemstatus_list', 'Exemplarstatus ansehen'); //! item_status.php wrong (lang_mod_masterfile_itemstatus)
define('lang_mod_masterfile_colltype', 'Sammlungstyp');
define('lang_mod_masterfile_colltype_titletag', 'Sammlungstyp (Thema, Genre)');
define('lang_mod_masterfile_colltype_new_add', 'Neuer Sammlungstyp');
define('lang_mod_masterfile_colltype_list', 'Sammlungstypen ansehen');
define('lang_mod_masterfile_lang', 'Sprache');
define('lang_mod_masterfile_lang_titletag', 'Sprache in der Werke verfasst sind');
define('lang_mod_masterfile_lang_new_add', 'Neue Sprache');
define('lang_mod_masterfile_lang_list', 'Sprachen ansehen');
define('lang_mod_masterfile_label', 'Kennzeichnung');
define('lang_mod_masterfile_label_titletag', 'Besondere Kennzeichnungen für Titel, wie z.B. \'Neuer Titel\'');
define('lang_mod_masterfile_label_new_add', 'Neue Kennzeichnung');
define('lang_mod_masterfile_label_list', 'Kennzeichnungen ansehen');
define('lang_mod_masterfile_frequency', 'Erscheinungshäufigkeit');
define('lang_mod_masterfile_frequency_titletag', 'Erscheinungshäufigkeit (Periodika)');
define('lang_mod_masterfile_frequency_new_add', 'Neue Erscheinungshäufigkeit');
define('lang_mod_masterfile_frequency_list', 'Erscheinungshäufigkeiten ansehen');
# author master file
# common
define('lang_mod_masterfile_author_alert_name_noempty', 'Name des Autors muss angegeben sein');
define('lang_mod_masterfile_author_alert_new_add_ok', 'Neuer Autor erfolgreich gespeichert');
define('lang_mod_masterfile_author_alert_add_fail', 'Speicherung der Autorendaten FEHLGESCHLAGEN. Bitte kontaktieren Sie den Systemadministrator');
define('lang_mod_masterfile_author_alert_update_ok', 'Autorendaten erfolgreich aktualisiert');
define('lang_mod_masterfile_author_alert_update_fail', 'Aktualisierung der Autorendaten FEHLGESCHLAGEN. Bitte kontaktieren Sie den Systemadministrator');
define('lang_mod_masterfile_author_alert_not_exists', 'FEHLER! Ausgewählte Daten sind nicht vorhanden');
define('lang_mod_masterfile_author_common_edit_info', 'Sie sind im Begriff die Angaben für folgenden Autor zu bearbeiten: ');
define('lang_mod_masterfile_author_common_last_update', 'Letzte Aktualisierung ');
define('lang_mod_masterfile_author_alert_all_delete_ok', 'Alle Daten erfolgreich gelöscht');
define('lang_mod_masterfile_author_alert_all_delete_fail', 'Einige oder alle Daten wurden NICHT erfolgreich gelöscht!\nBitte kontaktieren Sie den Systemadministrator');
define('lang_mod_masterfile_author_alert_delete_ok', 'Löschung des Autors fehlgeschlagen');
# form
define('lang_mod_masterfile_author_form_field_name', 'Name des Autors');
define('lang_mod_masterfile_author_form_field_authority', 'Normdatentyp');
# collection type master file
# common
define('lang_mod_masterfile_colltype_alert_name_noempty', 'Bezeichnung des Sammlungstyps muss angegeben sein');
define('lang_mod_masterfile_colltype_alert_new_add_ok', 'Neuer Sammlungstyp erfolgreich gespeichert');
define('lang_mod_masterfile_colltype_alert_add_fail', 'Speicherung des Sammlungstyps FEHLGESCHLAGEN. Bitte kontaktieren Sie den Systemadministrator');
define('lang_mod_masterfile_colltype_alert_update_ok', 'Sammlungstyp erfolgreich aktualisiert');
define('lang_mod_masterfile_colltype_alert_update_fail', 'Aktualisierung des Sammlungstypss FEHLGESCHLAGEN. Bitte kontaktieren Sie den Systemadministrator');
define('lang_mod_masterfile_colltype_alert_not_exists', 'FEHLER! Ausgewählte Daten sind nicht vorhanden');
define('lang_mod_masterfile_colltype_common_edit_info', 'Sie sind im Begriff die Angaben für folgend.. ... zu bearbeiten collection type data : ');
define('lang_mod_masterfile_colltype_common_last_update', 'Letzte Aktualisierung ');
define('lang_mod_masterfile_colltype_alert_not_delete', 'Folgende Daten können nicht gelöscht werden: \n');
define('lang_mod_masterfile_colltype_alert_all_delete_ok', 'Alle Daten erfolgreich gelöscht');
define('lang_mod_masterfile_colltype_alert_all_delete_fail', 'Einige oder alle Daten wurden NICHT erfolgreich gelöscht!\nBitte kontaktieren Sie den Systemadministrator');
define('lang_mod_masterfile_colltype_alert_has_item', 'Der Sammlungstyp ({item_name}) ist noch für {number_items} Exemplar(e) eingetragen');
define('lang_mod_masterfile_colltype_alert_inuse', 'Dieser Sammlungstyp kann nicht gelöscht werden, da er noch für {item_d} Exemplar(e) eingetragen ist. Bitte löschen Sie die Exemplare (bzw. diese Angabe dort) zunächst');
define('lang_mod_masterfile_colltype_alert_delete_fail', 'Löschung des Sammlungstyps fehlgeschlagen');
# form
define('lang_mod_masterfile_colltype_form_field_colltype', 'Sammlungstyp');
# language master file
# common
define('lang_mod_masterfile_lang_alert_name_noempty', 'Codekürzel und/oder Name der Sprache müssen angegeben sein');
define('lang_mod_masterfile_lang_alert_new_add_ok', 'Neue Sprache erfolgreich gespeichert');
define('lang_mod_masterfile_lang_alert_add_fail', 'Speicherung der Sprache FEHLGESCHLAGEN. Bitte kontaktieren Sie den Systemadministrator');
define('lang_mod_masterfile_lang_alert_update_ok', 'Sprachangaben erfolgreich aktualisiert');
define('lang_mod_masterfile_lang_alert_update_fail', 'Aktualisierung der Sprachangaben FEHLGESCHLAGEN. Bitte kontaktieren Sie den Systemadministrator');
define('lang_mod_masterfile_lang_alert_not_exists', 'FEHLER! Ausgewählte Daten sind nicht vorhanden');
define('lang_mod_masterfile_lang_common_edit_info', 'Sie sind im Begriff die Angaben für folgende Sprache zu bearbeiten: ');
define('lang_mod_masterfile_lang_common_last_update', 'Letzte Aktualisierung ');
define('lang_mod_masterfile_lang_alert_all_delete_ok', 'Alle Daten erfolgreich gelöscht');
define('lang_mod_masterfile_lang_alert_all_delete_fail', 'Einige oder alle Daten wurden NICHT erfolgreich gelöscht!\nBitte kontaktieren Sie den Systemadministrator');
define('lang_mod_masterfile_lang_alert_delete_ok', 'Löschung der Sprache fehlgeschlagen');
# form
define('lang_mod_masterfile_lang_form_field_lang_code', 'Sprache Codekürzel');
define('lang_mod_masterfile_lang_form_field_name', 'Sprache');
# GMD master file
# common
define('lang_mod_masterfile_gmd_alert_name_noempty', 'Codekürzel und Name der Ressourcenart müssen angegeben sein');
define('lang_mod_masterfile_gmd_alert_new_add_ok', 'Neue Ressourcenart erfolgreich gespeichert');
define('lang_mod_masterfile_gmd_alert_add_fail', 'Speicherung der Ressourcenart FEHLGESCHLAGEN. Bitte kontaktieren Sie den Systemadministrator');
define('lang_mod_masterfile_gmd_alert_update_ok', 'Ressourcenart erfolgreich aktualisiert');
define('lang_mod_masterfile_gmd_alert_update_fail', 'Aktualisierung der Ressourcenart FEHLGESCHLAGEN. Bitte kontaktieren Sie den Systemadministrator');
define('lang_mod_masterfile_gmd_alert_not_exists', 'FEHLER! Ausgewählte Daten sind nicht vorhanden');
define('lang_mod_masterfile_gmd_common_edit_info', 'Sie sind im Begriff die Angaben für folgende Ressourcenart zu bearbeiten');
define('lang_mod_masterfile_gmd_common_last_update', 'Letzte Aktualisierung ');
define('lang_mod_masterfile_gmd_alert_all_delete_ok', 'Alle Daten erfolgreich gelöscht');
define('lang_mod_masterfile_gmd_alert_all_delete_fail', 'Einige oder alle Daten wurden NICHT erfolgreich gelöscht!\nBitte kontaktieren Sie den Systemadministrator');
define('lang_mod_masterfile_gmd_alert_delete_ok', 'Ressourcenart erfolgreich gelöscht');
define('lang_mod_masterfile_gmd_alert_delete_fail', 'Löschung der Ressourcenart fehlgeschlagen');
# form
define('lang_mod_masterfile_gmd_form_field_gmd_code', 'Ressourcenart Codekürzel');
define('lang_mod_masterfile_gmd_form_field_gmd_name', 'Name der Ressourcenart');
define('lang_mod_masterfile_gmd_form_field_gmd_icon', 'Ressourcenart Icon');
# Item status master file
# common
define('lang_mod_masterfile_itemstatus_alert_name_noempty', 'Codekürzel und Bezeichnung des Exemplarstatus müssen angegeben sein');
define('lang_mod_masterfile_itemstatus_alert_new_add_ok', 'Neuer Exemplarstatus erfolgreich gespeichert');
define('lang_mod_masterfile_itemstatus_alert_add_fail', 'Speicherung des Exemplarstatus FEHLGESCHLAGEN. Bitte kontaktieren Sie den Systemadministrator');
define('lang_mod_masterfile_itemstatus_alert_update_ok', 'Exemplarstatus erfolgreich aktualisiert');
define('lang_mod_masterfile_itemstatus_alert_update_fail', 'Aktualisierung des Exemplarstatus FEHLGESCHLAGEN. Bitte kontaktieren Sie den Systemadministrator');
define('lang_mod_masterfile_itemstatus_alert_not_exists', 'FEHLER! Ausgewählte Daten sind nicht vorhanden');
define('lang_mod_masterfile_itemstatus_common_edit_info', 'Sie sind im Begriff die Angaben für folgenden Exemplarstatus zu bearbeiten');
define('lang_mod_masterfile_itemstatus_common_last_update', 'Letzte Aktualisierung');
define('lang_mod_masterfile_itemstatus_alert_all_delete_ok', 'Alle Daten erfolgreich gelöscht');
define('lang_mod_masterfile_itemstatus_alert_all_delete_fail', 'Einige oder alle Daten wurden NICHT erfolgreich gelöscht!\nBitte kontaktieren Sie den Systemadministrator');
define('lang_mod_masterfile_itemstatus_alert_delete_fail', 'Löschung des Exemplarstatus fehlgeschlagen');
# form
define('lang_mod_masterfile_itemstatus_form_field_code', 'Exemplarstatus Codekürzel');
define('lang_mod_masterfile_itemstatus_form_field_name', 'Bezeichnung des Exemplarstatus');
define('lang_mod_masterfile_itemstatus_form_field_rules', 'Regeln');
# location master file
# common
define('lang_mod_masterfile_location_alert_name_noempty', 'Codekürzel und Name des Standorts müssen angegeben sein');
define('lang_mod_masterfile_location_alert_new_add_ok', 'Neuer Standort erfolgreich gespeichert');
define('lang_mod_masterfile_location_alert_add_fail', 'Speicherung des Standorts FEHLGESCHLAGEN. Bitte kontaktieren Sie den Systemadministrator');
define('lang_mod_masterfile_location_alert_update_ok', 'Standortangaben erfolgreich aktualisiert');
define('lang_mod_masterfile_location_alert_update_fail', 'Aktualisierung des Standorts FEHLGESCHLAGEN. Bitte kontaktieren Sie den Systemadministrator');
define('lang_mod_masterfile_location_alert_not_exists', 'FEHLER! Ausgewählte Daten sind nicht vorhanden');
define('lang_mod_masterfile_location_common_edit_info', 'Sie sind im Begriff die Angaben für folgenden Standort zu bearbeiten: ');
define('lang_mod_masterfile_location_common_last_update', 'Letzte Aktualisierung ');
define('lang_mod_masterfile_location_alert_not_delete', 'Folgende Standortdaten können nicht gelöscht werden: \n');
define('lang_mod_masterfile_location_alert_all_delete_ok', 'Alle Daten erfolgreich gelöscht');
define('lang_mod_masterfile_location_alert_all_delete_fail', 'Einige oder alle Daten wurden NICHT erfolgreich gelöscht!\nBitte kontaktieren Sie den Systemadministrator');
define('lang_mod_masterfile_location_alert_has_item', 'Der Standort ({item_name}) ist noch für {number_items} Exemplar(e) eingetragen');
define('lang_mod_masterfile_location_alert_inuse', 'Dieser Standort kann nicht gelöscht werden, da er noch für {item_d} Exemplar(e) eingetragen ist. Bitte löschen Sie die Exemplare (bzw. diese Angabe dort) zunächst');
define('lang_mod_masterfile_location_alert_delete_fail', 'Löschung des Standorts fehlgeschlagen');
# form
define('lang_mod_masterfile_location_form_field_code', 'Standort Codekürzel');
define('lang_mod_masterfile_location_form_field_name', 'Name des Standorts');
# place of publication master file
# common
define('lang_mod_masterfile_place_alert_name_noempty', 'Name des Erscheinungsorts muss angegeben sein');
define('lang_mod_masterfile_place_alert_new_add_ok', 'Neuer Erscheinungsort erfolgreich gespeichert');
define('lang_mod_masterfile_place_alert_add_fail', 'Speicherung des Erscheinungsorts FEHLGESCHLAGEN. Bitte kontaktieren Sie den Systemadministrator');
define('lang_mod_masterfile_place_alert_update_ok', 'Erscheinungsort erfolgreich aktualisiert');
define('lang_mod_masterfile_place_alert_update_fail', 'Aktualisierung des Erscheinungsorts FEHLGESCHLAGEN. Bitte kontaktieren Sie den Systemadministrator');
define('lang_mod_masterfile_place_alert_not_exists', 'FEHLER! Ausgewählte Daten sind nicht vorhanden');
define('lang_mod_masterfile_place_common_edit_info', 'Sie sind im Begriff die Angaben für folgenden Erscheinungsort zu bearbeiten');
define('lang_mod_masterfile_place_common_last_update', 'Letzte Aktualisierung ');
define('lang_mod_masterfile_place_alert_not_delete', 'Folgende Erscheinungsorte können nicht gelöscht werden: \n');
define('lang_mod_masterfile_place_alert_all_delete_ok', 'Alle Daten erfolgreich gelöscht');
define('lang_mod_masterfile_place_alert_all_delete_fail', 'Einige oder alle Daten wurden NICHT erfolgreich gelöscht!\nBitte kontaktieren Sie den Systemadministrator');
define('lang_mod_masterfile_place_alert_delete_fail', 'Löschung des Erscheinungsorts fehlgeschlagen');
# form
define('lang_mod_masterfile_place_form_field_name', 'Erscheinungsort Name');
# publisher master file
# common
define('lang_mod_masterfile_publisher_alert_name_noempty', 'Name des Verlags muss angegeben sein');
define('lang_mod_masterfile_publisher_alert_new_add_ok', 'Neuer Verlag erfolgreich gespeichert');
define('lang_mod_masterfile_publisher_alert_add_fail', 'Speicherung des Verlags FEHLGESCHLAGEN. Bitte kontaktieren Sie den Systemadministrator');
define('lang_mod_masterfile_publisher_alert_update_ok', 'Verlag erfolgreich aktualisiert');
define('lang_mod_masterfile_publisher_alert_update_fail', 'Aktualisierung des Verlags FEHLGESCHLAGEN. Bitte kontaktieren Sie den Systemadministrator');
define('lang_mod_masterfile_publisher_alert_not_exists', 'FEHLER! Ausgewählte Daten sind nicht vorhanden');
define('lang_mod_masterfile_publisher_common_edit_info', 'Sie sind im Begriff die Angaben für folgendem Verlag zu bearbeiten');
define('lang_mod_masterfile_publisher_common_last_update', 'Letzte Aktualisierung ');
define('lang_mod_masterfile_publisher_alert_not_delete', 'Folgender Verlag können nicht gelöscht werden: \n');
define('lang_mod_masterfile_publisher_alert_all_delete_ok', 'Alle Daten erfolgreich gelöscht');
define('lang_mod_masterfile_publisher_alert_all_delete_fail', 'Einige oder alle Daten wurden NICHT erfolgreich gelöscht!\nBitte kontaktieren Sie den Systemadministrator');
define('lang_mod_masterfile_publisher_alert_delete_fail', 'Löschung des Verlags fehlgeschlagen');
# form
define('lang_mod_masterfile_publisher_form_field_name', 'Name des Verlags');
# supplier master file
# common
define('lang_mod_masterfile_supplier_alert_name_noempty', 'Name des Zulieferers muss angegeben sein');
define('lang_mod_masterfile_supplier_alert_new_add_ok', 'Neuer Zulieferer erfolgreich gespeichert');
define('lang_mod_masterfile_supplier_alert_add_fail', 'Speicherung des Zulieferers FEHLGESCHLAGEN. Bitte kontaktieren Sie den Systemadministrator');
define('lang_mod_masterfile_supplier_alert_update_ok', 'Zulieferer erfolgreich aktualisiert');
define('lang_mod_masterfile_supplier_alert_update_fail', 'Aktualisierung des Zulieferers FEHLGESCHLAGEN. Bitte kontaktieren Sie den Systemadministrator');
define('lang_mod_masterfile_supplier_alert_not_exists', 'FEHLER! Ausgewählte Daten sind nicht vorhanden');
define('lang_mod_masterfile_supplier_common_edit_info', 'Sie sind im Begriff die Angaben für folgenden Zulieferer zu bearbeiten');
define('lang_mod_masterfile_supplier_common_last_update', 'Letzte Aktualisierung ');
#define('lang_mod_masterfile_supplier_alert_not_delete', 'Folgende Zulieferer können nicht gelöscht werden: \n'); //? why is it outcommented?
define('lang_mod_masterfile_supplier_alert_all_delete_ok', 'Alle Daten erfolgreich gelöscht');
define('lang_mod_masterfile_supplier_alert_all_delete_fail', 'Einige oder alle Daten wurden NICHT erfolgreich gelöscht!\nBitte kontaktieren Sie den Systemadministrator');
define('lang_mod_masterfile_supplier_alert_delete_fail', 'Löschung des Zulieferers fehlgeschlagen');
# form
define('lang_mod_masterfile_supplier_form_field_name', 'Name des Zulieferers');
define('lang_mod_masterfile_supplier_form_field_address', 'Adresse');
define('lang_mod_masterfile_supplier_form_field_contact', 'Kontakt(person)');
define('lang_mod_masterfile_supplier_form_field_phone', 'Telefon');
define('lang_mod_masterfile_supplier_form_field_fax', 'Fax');
define('lang_mod_masterfile_supplier_form_field_account', 'Kontonummer');
# topic master file
# common
define('lang_mod_masterfile_topic_alert_name_noempty', 'Schlagwort muss angegeben sein');
define('lang_mod_masterfile_topic_alert_new_add_ok', 'Neues Schlagwort erfolgreich gespeichert');
define('lang_mod_masterfile_topic_alert_add_fail', 'Speicherung des Schlagworts FEHLGESCHLAGEN. Bitte kontaktieren Sie den Systemadministrator');
define('lang_mod_masterfile_topic_alert_update_ok', 'Schlagwort erfolgreich aktualisiert');
define('lang_mod_masterfile_topic_alert_update_fail', 'Aktualisierung des Schlagworts FEHLGESCHLAGEN. Bitte kontaktieren Sie den Systemadministrator');
define('lang_mod_masterfile_topic_alert_not_exists', 'FEHLER! Ausgewählte Daten sind nicht vorhanden');
define('lang_mod_masterfile_topic_common_edit_info', 'Sie sind im Begriff die Angaben für folgendes Schlagwort zu bearbeiten');
define('lang_mod_masterfile_topic_common_last_update', 'Letzte Aktualisierung ');
define('lang_mod_masterfile_topic_alert_all_delete_ok', 'Alle Daten erfolgreich gelöscht');
define('lang_mod_masterfile_topic_alert_all_delete_fail', 'Einige oder alle Daten wurden NICHT erfolgreich gelöscht!\nBitte kontaktieren Sie den Systemadministrator');
define('lang_mod_masterfile_topic_alert_delete_fail', 'Löschung des Schlagworts fehlgeschlagen');
# form
define('lang_mod_masterfile_topic_form_field_name', 'Schlagwort');
# label master file
# common
define('lang_mod_masterfile_label_alert_new_add_ok', 'Neue Kennzeichnung erfolgreich gespeichert');
define('lang_mod_masterfile_label_alert_add_fail', 'Speicherung der Kennzeichnung FEHLGESCHLAGEN. Bitte kontaktieren Sie den Systemadministrator');
define('lang_mod_masterfile_label_alert_update_ok', 'Kennzeichnung erfolgreich aktualisiert');
define('lang_mod_masterfile_label_alert_update_fail', 'Aktualisierung der Kennzeichnung FEHLGESCHLAGEN. Bitte kontaktieren Sie den Systemadministrator');
define('lang_mod_masterfile_label_alert_not_exists', 'FEHLER! Ausgewählte Daten sind nicht vorhanden');
define('lang_mod_masterfile_label_common_edit_info', 'Sie sind im Begriff die Angaben für folgende Kennzeichnung zu bearbeiten');
define('lang_mod_masterfile_label_common_last_update', 'Letzte Aktualisierung ');
define('lang_mod_masterfile_label_alert_all_delete_ok', 'Alle Daten erfolgreich gelöscht');
define('lang_mod_masterfile_label_alert_all_delete_fail', 'Einige oder alle Daten wurden NICHT erfolgreich gelöscht!\nBitte kontaktieren Sie den Systemadministrator');
define('lang_mod_masterfile_label_alert_delete_fail', 'Löschung der Kennzeichnung fehlgeschlagen');
# form
define('lang_mod_masterfile_label_form_field_label_name', 'Bezeichnung der Kennzeichnung');
define('lang_mod_masterfile_label_form_field_label_desc', 'Beschreibung der Kennzeichnung');
define('lang_mod_masterfile_label_form_field_label_image', 'Kennzeichnung Bild');
# frequency
define('lang_mod_masterfile_frequency_alert_new_add_ok', 'Neue Erscheinungshäufigkeit erfolgreich gespeichert');
define('lang_mod_masterfile_frequency_alert_add_fail', 'Speicherung der Erscheinungshäufigkeit FEHLGESCHLAGEN. Bitte kontaktieren Sie den Systemadministrator');
define('lang_mod_masterfile_frequency_alert_update_ok', 'Erscheinungshäufigkeit erfolgreich aktualisiert');
define('lang_mod_masterfile_frequency_alert_update_fail', 'Aktualisierung der Erscheinungshäufigkeit FEHLGESCHLAGEN. Bitte kontaktieren Sie den Systemadministrator');
define('lang_mod_masterfile_frequency_alert_not_exists', 'FEHLER! Ausgewählte Daten sind nicht vorhanden');
define('lang_mod_masterfile_frequency_common_edit_info', 'Sie sind im Begriff die Angaben für folgende Erscheinungshäufigkeit zu bearbeiten');
define('lang_mod_masterfile_frequency_common_last_update', 'Letzte Aktualisierung ');
define('lang_mod_masterfile_frequency_alert_all_delete_ok', 'Alle Daten erfolgreich gelöscht');
define('lang_mod_masterfile_frequency_alert_all_delete_fail', 'Einige oder alle Daten wurden NICHT erfolgreich gelöscht!\nBitte kontaktieren Sie den Systemadministrator');
define('lang_mod_masterfile_frequency_alert_delete_fail', 'Löschung der Erscheinungshäufigkeit fehlgeschlagen');
# form
define('lang_mod_masterfile_frequency_form_field_frequency_name', 'Erscheinungshäufigkeit');
define('lang_mod_masterfile_frequency_form_field_frequency_lang', 'Sprache');
define('lang_mod_masterfile_frequency_form_field_frequency_time_increment', 'Zeitintervall');
define('lang_mod_masterfile_frequency_form_field_frequency_unit', 'Zeiteinheit');

/* STOCK TAKE MODULE */
# common
define('lang_mod_stocktake_active_status', 'Derzeit aktiv');
define('lang_mod_stocktake_total', 'Exemplare absolut in Inventur'); //? (Total Item Stock Taked)
define('lang_mod_stocktake_lost_total', 'Exemplare absolut verloren');
define('lang_mod_stocktake_exists_total', 'Exemplare absolut vorhanden');
define('lang_mod_stocktake_loan_total', 'Exemplare absolut ausgeliehen');
define('lang_mod_stocktake_participants', 'Inventurmitarbeiter');
define('lang_mod_stocktake_total_checked', 'Exemplare absolut geprüft/gescannt'); //? (Total Checked/Scanned Items)
define('lang_mod_stocktake_finish_confirmation', 'Wollen Sie die aktuellen Inventur wirklich beenden? Einmal beendet können Sie diese Inventur nicht nicht wieder fortsetzen');
define('lang_mod_stocktake_purge_lost', 'Verlorene Exemplare löschen');
# submenu
define('lang_mod_stocktake', 'Inventur');
define('lang_mod_stocktake_status', 'Status');
define('lang_mod_stocktake_history', 'Bisherige Inventuren');
define('lang_mod_stocktake_history_titletag', 'Betrachten sie Berichte abgeschlossener Inventuren');
define('lang_mod_stocktake_current', 'Aktuelle Inventur');
define('lang_mod_stocktake_current_titletag', 'Aktuellen Inventurvorgang ansehen');
define('lang_mod_stocktake_report', 'Inventurbericht');
define('lang_mod_stocktake_report_titletag', 'Bericht des aktuellen Inventurnvorgangs ansehen');
define('lang_mod_stocktake_init', 'Inventur starten');
define('lang_mod_stocktake_init_titletag', 'Einen neuen Inventurvorgang starten');
define('lang_mod_stocktake_finish', 'Inventur beenden');
define('lang_mod_stocktake_finish_titletag', 'Den aktuellen Inventurnvorgang abschließen');
define('lang_mod_stocktake_lost', 'Verlorene Exemplare aktuell');
define('lang_mod_stocktake_lost_titletag', 'Verlorene Exemplare des aktuellen Inventurvorgangs ansehen');
define('lang_mod_stocktake_log', 'Inventurlog');
define('lang_mod_stocktake_log_titletag', 'Log des aktuellen Inventurvorgangs ansehen');
define('lang_mod_stocktake_resync', 'Abgleich');
define('lang_mod_stocktake_resync_titletag', 'Daten der Titelaufnahmen mit dem aktuellen Inventurvorgang abgleichen');
# initialization
define('lang_mod_stocktake_init_info', 'Ein Inventurvorgang läuft bereits!');
define('lang_mod_stocktake_init_alert_noempty', 'Name der Inventur muss angegeben sein!');
define('lang_mod_stocktake_init_alert_started', 'Inventurvorgang gestartet');
define('lang_mod_stocktake_init_alert_fail_start', 'Start des Inventurvorgangs FEHLGESCHLAGEN.\nKeine Exemplare für eine Inventur vorhanden!');
define('lang_mod_stocktake_init_button_start', 'Inventur starten');
define('lang_mod_stocktake_init_field_name', 'Bezeichnung der Inventur');
define('lang_mod_stocktake_init_field_GMD', 'Ressourcenart');
define('lang_mod_stocktake_init_field_colltype', 'Sammlungstyp');
define('lang_mod_stocktake_init_field_location', 'Standort');
define('lang_mod_stocktake_init_field_site', 'Regalstandort');
define('lang_mod_stocktake_init_field_classification', 'Klassifikation'); //? hmm
define('lang_mod_stocktake_init_field_class_text', 'Geben Sie die Klassen getrennt durch Kommata an. Verwenden Sie das * als Platzhalter (Wildcard)');
define('lang_mod_stocktake_init_field_option_all', 'ALLE');
define('lang_mod_stocktake_init_field_start_date', 'Beginn');
define('lang_mod_stocktake_init_field_end_date', 'Abschluss');
define('lang_mod_stocktake_init_field_report_file', 'Bericht');
define('lang_mod_stocktake_init_field_user', 'Gestartet von');
#report
define('lang_mod_stocktake_report_page_title', 'BERICHT DER AKTUELLEN INVENTUR');
define('lang_mod_stocktake_report_not_initialize', 'KEIN Inventurvorgang gestartet bisher!');
define('lang_mod_stocktake_report_no_process', 'KEIN Inventurvorgang derzeit am laufen!');
define('lang_mod_stocktake_alert_process_finish', 'Inventurvorgang abgeschlossen!');

/* REPORTING MODULE */
# submenu
define('lang_mod_report', 'Berichte');
define('lang_mod_report_stat', 'Inventursstatistik');
define('lang_mod_report_stat_titletag', 'Statistik zum Bibliotheksbestand ansehen');
define('lang_mod_report_loan', 'Ausleihbericht');
define('lang_mod_report_loan_titletag', 'Bericht zur Ausleihe ansehen');
define('lang_mod_report_member', 'Mitgliedschaftsbericht');
define('lang_mod_report_member_titletag', 'Bericht zu Bibliotheksmitgliedschaften ansehen');
# General Statistic
define('lang_mod_report_stat_page_head', 'Bestandsstatistik - Bericht');
define('lang_mod_report_stat_table_head', 'Zusammenfassung der Bestandsstatistik');
define('lang_mod_report_stat_field_title', 'Titel absolut');
define('lang_mod_report_stat_field_items', 'Exemplare absolut');
define('lang_mod_report_stat_field_onloan', 'Entliehene Exemplare absolut');
define('lang_mod_report_stat_field_available', 'Exemplare absolut in der Bibliothek'); //? Wo ist der Unterschied zu "Exemplare absolut" (Total  item/copies)
define('lang_mod_report_stat_field_by_gmd', 'Titel absolut nach Medium/Ressourcenart');
define('lang_mod_report_stat_field_by_colltype', 'Exemplare absolut nach Sammlungstyp');
define('lang_mod_report_stat_field_title_topten', 'Die 10 beliebtesten Titel');
# Loan Statistic
define('lang_mod_report_loan_page_head', 'Ausleihbericht');
define('lang_mod_report_loan_table_head', 'Zusammenfassung der Ausleihvorgänge');
define('lang_mod_report_loan_field_total', 'Entleihungen absolut');
define('lang_mod_report_loan_field_transaction', 'Ausleihvorgänge absolut');
define('lang_mod_report_loan_field_perday', 'Ausleihvorgänge im Durchschnitt (pro Tag)');
define('lang_mod_report_loan_field_peak', 'Ausleihvorgänge - Spitzenwert');
define('lang_mod_report_loan_field_member_with_loan', 'Mitglieder mit Entleihungen');
define('lang_mod_report_loan_field_member_no_loan', 'Mitglieder ohne Entleihungen bisher');
define('lang_mod_report_loan_field_overdue', 'Entleihungen absolut mit Mahngebühren');
define('lang_mod_report_loan_field_by_gmd', 'Entleihungen absolut nach Ressourcenart/Medium');
define('lang_mod_report_loan_field_by_colltype', 'Entleihungen absolut nach Sammlungstyp');
# Member Statistic
define('lang_mod_report_member_page_head', 'Mitgliedschaftsbericht');
define('lang_mod_report_member_table_head', 'Zusammenfassung zu Mitgliedschaften');
define('lang_mod_report_member_field_registered', 'Registrierte Mitglieder absolut');
define('lang_mod_report_member_field_active', 'Aktive Mitglieder absolut');
define('lang_mod_report_member_field_active_topten', 'Die 10 aktivsten Mitglieder');
define('lang_mod_report_member_field_by_type', 'Mitglieder absolut nach Mitgliedstyp');
define('lang_mod_report_member_field_expired', 'Abgelaufene Mitgliedschaften absolut');

/* SERIAL CONTROL MODULE */
# submenu
define('lang_mod_serial', 'Periodikaverwaltung');
define('lang_mod_serial_subscription', 'Abonnements');
define('lang_mod_serial_subscription_titletag', 'Abonnements verwalten');
define('lang_mod_serial_kardex', 'Kardex');
define('lang_mod_serial_kardex_titletag', 'Kardex verwalten');
# subcription menu
define('lang_mod_serial_subscription_add', 'Neues Abonnement hinzufügen');
define('lang_mod_serial_subscription_list', 'Abonnements ansehen');
# kardex menu
define('lang_mod_serial_kardex_add', 'Neuen Kardex hinzufügen');
define('lang_mod_serial_kardex_view', 'Kardex ansehen');
# fields
define('lang_mod_serial_field_date_start', 'Abonniert seit');
define('lang_mod_serial_field_exemplar', 'Insgesamt erwartete Exemplare');
define('lang_mod_serial_field_period', 'Periodenbezeichnung'); //? (Period Name); ~Rechnungszeitraum
define('lang_mod_serial_field_notes', 'Bemerkungen zum Abonnement');
define('lang_mod_serial_kardex_field_date_expected', 'Erwartet (Datum)');
define('lang_mod_serial_kardex_field_date_received', 'Erhalten (Datum)');
define('lang_mod_serial_kardex_field_seq_number', 'Fortlaufende Nummer');
define('lang_mod_serial_kardex_field_notes', 'Bemerkungen');
# messages
define('lang_mod_serial_alert_01', 'Fehler beim Einfügen des Abonnement. Ein Abonnementsdatum muss angegeben sein!');
define('lang_mod_serial_subscription_alert_delete_ok', 'Abonnement erfolgreich gelöscht');
define('lang_mod_serial_subscription_alert_delete_failed', 'Löschung des Abonnements FEHLGESCHLAGEN!');
define('lang_mod_serial_alert_02', 'Kardex aktualisiert!');
define('lang_mod_serial_alert_03', 'Karde gelöscht!');
define('lang_mod_serial_alert_new_added', 'Neues Abonnement erfolgreich gespeichert');
define('lang_mod_serial_alert_fail_to_save', 'Speicherung des Abonnement FEHLGESCHLAGEN. Bitte kontaktieren Sie den Systemadministrator');
define('lang_mod_serial_alert_updated', 'Abonnement erfolgreich aktualisiert');
define('lang_mod_serial_alert_not_updated', 'Aktualisierung des Abonnement FEHLGESCHLAGEN. Bitte kontaktieren Sie den Systemadministrator');
define('lang_mod_serial_alert_not_exists', 'Fehler! Das Abonnement ist nicht vorhanden!');
define('lang_mod_serial_common_info', 'Sie sind im Begriff die Angaben für folgendes Abonnement zu bearbeiten: ');


##### Added 2009-08 #####
# datagrid form
define('lang_sys_common_tblheader_delete', 'LÖSCHEN');
define('lang_sys_common_tblheader_edit', 'EDIT');
define('lang_sys_common_tblheader_add', 'Hinzufügen');
define('lang_sys_common_tblheader_hover_sort', 'Sortiere List nach Spalte');
define('lang_sys_common_tblheader_hover_sort_asc', 'aufsteigend');
define('lang_sys_common_tblheader_hover_sort_desc', 'absteigend');
define('lang_sys_common_tblheader_print_header_part1', 'Datensätze gefunden. Angezeigt wird Seite');
define('lang_sys_common_tblheader_print_header_part2', 'Datensätze pro Seite');
/* BIBLIOGRAPHIC MODULE */
# submenu
define('lang_mod_biblio_tools_common_print_msg1', 'Höchstens');
define('lang_mod_biblio_tools_common_print_msg2', 'Datensätze können auf einmal gedruckt werden. Derzeit sind');
define('lang_mod_biblio_tools_common_print_msg3', 'Einträge in der Druckerwarteschlange.');
define('lang_mod_biblio_tools_card_generator_print_select', 'Mitgliederkartendruck starten');
define('lang_mod_biblio_tools_card_generator_print_clear', 'Druckerwarteschlange löschen');
#item
define('lang_mod_biblio_item_common_status_description', 'Leihstatus');
define('lang_mod_biblio_item_common_status_onloan', 'Ausgeliehen');
define('lang_mod_biblio_item_common_status_returned', 'Zurückgegeben');
define('lang_mod_biblio_item_common_status_missing', 'Vermisst');
define('lang_mod_biblio_item_common_status_exists', 'Vorhanden');
# bibliography form fields
define('lang_mod_biblio_field_copies', 'Exemplare');
define('lang_mod_biblio_field_copies_none', 'Keine');
define('lang_mod_biblio_field_update', 'Letzte Aktualisierung');
define('lang_mod_biblio_field_opt_all', 'Alle Felder');
define('lang_mod_biblio_field_opt_title', 'Titel');
define('lang_mod_biblio_field_opt_subject', 'Schlagwörter');
define('lang_mod_biblio_field_opt_author', 'Autoren');
define('lang_mod_biblio_field_opt_isbn', 'ISBN/ISSN');
define('lang_mod_biblio_field_opt_publisher', 'Verlage');
define('lang_mod_biblio_field_opt_none', 'NICHT ZUTREFFEND');
define('lang_mod_biblio_field_frequency_explain', 'Geben Sie dies bei Periodika an');
define('lang_mod_biblio_link_attachment_add', 'Dateianhang hinzufügen');
define('lang_mod_biblio_field_opt_show', 'Anzeigen');
define('lang_mod_biblio_field_opt_hide', 'Verbergen');
define('lang_mod_biblio_field_opt_promotefalse', 'Nicht anzeigen'); //?
define('lang_mod_biblio_field_opt_promotetrue', 'Anzeigen'); //?
define('lang_mod_biblio_author_form_title', 'Autor hinzufügen');
# pop-ups - attachment
define('lang_mod_biblio_attach_alert_typesize', 'Hochladen FEHLGESCHLAGEN! Dateityp nicht erlaubt oder Datei zu groß!');
define('lang_mod_biblio_attach_alert_update_ok', 'Dateianhang wurde aktualisiert!');
define('lang_mod_biblio_attach_alert_update_fail', 'Aktualisierung des Dateianhangs FEHLGESCHLAGEN!');
define('lang_mod_biblio_attach_alert_added_ok', 'Dateianhang erfolgreich hochgeladen!');
define('lang_mod_biblio_attach_alert_added_fail', 'Speicherung des Dateianhangs FEHLGESCHLAGEN!');
define('lang_mod_biblio_attach_alert_removed', 'Dateianhang entfernt!');
define('lang_mod_biblio_attach_form_button_upload', 'Jetzt hochloaden');
define('lang_mod_biblio_attach_form_field_title', 'Titel');
define('lang_mod_biblio_attach_form_field_filedir', 'Speicherort'); //?
define('lang_mod_biblio_attach_form_field_browse', 'Anzuhängende Datei');
define('lang_mod_biblio_attach_form_field_url', 'URL');
define('lang_mod_biblio_attach_form_field_description', 'Beschreibung');
define('lang_mod_biblio_attach_form_field_access', 'Zugriff');
define('lang_mod_biblio_attach_form_opt_public', 'Öffentlich');
define('lang_mod_biblio_attach_form_opt_private', 'Privat');
# item form fields
define('lang_mod_biblio_item_field_opt_available', 'Verfügbar');
define('lang_mod_biblio_item_field_opt_buy', 'Einkauf');
define('lang_mod_biblio_item_field_opt_grant', 'Schenkung/Sonstiges');
define('lang_mod_biblio_item_field_opt_none', 'Keine Angabe');
# Simbio table
define('lang_simbio_nodata', 'Keine Daten');
# z3950
define('lang_mod_biblio_tools_z3950_connection', '* Bitte stellen Sie sicher, dass Sie mit dem Internet verbunden sind.');
# circulation
define('lang_mod_circ_tblheader_callno', 'Signatur');
/* MEMBERSHIP MODULE - # form */
define('lang_mod_membership_field_opt_autoset', 'Vorgabe verwenden');
define('lang_mod_membership_field_opt_yes', 'Ja');
define('lang_mod_membership_extend_button', 'Ausgewählte Mitglieder verlängern');
define('lang_mod_membership_extend_alert_confirm', 'Wollen Sie die Mitgliedschaft für die ausgewählten Mitglieder VERLÄNGERN?');
define('lang_mod_membership_extend_success', 'Mitglieder verlängert!');
/* COMMON */
define('lang_sys_common_query_msg1', 'Abfrage in');
define('lang_sys_common_query_msg2', 'Sekunde(n) bearbeitet');
define('lang_sys_common_day', 'Tag');
define('lang_sys_common_week', 'Woche');
define('lang_sys_common_all', 'Alle');
define('lang_sys_common_month_short_01', 'Jan');
define('lang_sys_common_month_short_02', 'Feb');
define('lang_sys_common_month_short_03', 'Mär');
define('lang_sys_common_month_short_04', 'Apr');
define('lang_sys_common_month_short_05', 'Mai');
define('lang_sys_common_month_short_06', 'Jun');
define('lang_sys_common_month_short_07', 'Jul');
define('lang_sys_common_month_short_08', 'Aug');
define('lang_sys_common_month_short_09', 'Sep');
define('lang_sys_common_month_short_10', 'Okt');
define('lang_sys_common_month_short_11', 'Nov');
define('lang_sys_common_month_short_12', 'Dez');
/* REPORTING MODULE (especially "Other Reports"; and reports in other modules) */
# common
define('lang_mod_reporting_form_generic_header', 'Berichtsfilter');
define('lang_mod_reporting_form_button_filter_apply', 'Filter anwenden');
define('lang_mod_reporting_form_button_filter_options_show', 'Weitere Filteroptionen');
define('lang_mod_reporting_form_button_filter_options_hide', 'Filteroptionen verbergen');
define('lang_mod_reporting_form_button_print', 'Aktuelle Seite drucken');
# submenu (other)
define('lang_mod_report_other', 'Weitere Berichte');
define('lang_mod_report_other_recapitulation', 'Zusammenfassungen');
define('lang_mod_report_other_recapitulation_titletag', 'Zusammenfassungen von Titeln und Sammlungen, gefiltert nach Klassifikation oder anderen Kriterien');
define('lang_mod_report_other_titles', 'Titelliste');
define('lang_mod_report_other_titles_titletag', 'Liste vorhandener Titelaufnahmen');
define('lang_mod_report_other_itemtitles', 'Exemplarliste');
define('lang_mod_report_other_itemtitles_titletag', 'Liste vorhandener Exemplare');
define('lang_mod_report_other_itemusage', 'Jahresstatistik Exemplare');
define('lang_mod_report_other_itemusage_titletag', 'Ausleihstatistik für Exemplare nach Monaten eines Jahres');
define('lang_mod_report_other_loansclass', 'Ausleihen nach Klassifikation');
define('lang_mod_report_other_loansclass_titletag', 'Ausleihstatistik nach Klassifikation');
define('lang_mod_report_other_memberlist', 'Mitgliederliste');
define('lang_mod_report_other_memberlist_titletag', 'Liste von Bibliotheksmitgliedern');
define('lang_mod_report_other_loanmember', 'Entleihungen/Mitglieder');
define('lang_mod_report_other_loanmember_titletag', 'Liste derzeit ausgeliehener Titel nach Mitgliedern');
define('lang_mod_report_other_staffactivity', 'Mitarbeiterbericht');
define('lang_mod_report_other_staffactivity_titletag', 'Tätigkeiten der Mitarbeiter als Bericht');
# Report - common
define('lang_mod_report_common_form_titisbn', 'Titel/ISBN');
define('lang_mod_report_common_form_recspage', 'Datensätze pro Seite');
define('lang_mod_report_common_form_recspage_help', 'Wählen Sie einen Wert zwischen 20 und 200');
define('lang_mod_report_common_form_select_help', 'Halten Sie Strg während des Klickens gedrückt um mehere Einträge zu wählen');
# Report - Recapitulation
define('lang_mod_report_recapitulation_form_recapby', 'Zusammenfassen nach');
define('lang_mod_report_recapitulation_print_header', 'Zusammenfassung von Titeln und Exemplaren nach');
# Report - Titles
define('lang_mod_report_recapitulation_form_author', 'Autor');
# Report - Loans by Classification
define('lang_mod_report_loansclass_form_opt_class0', '0er Klassifikationen');
define('lang_mod_report_loansclass_form_opt_class1', '1er Klassifikationen');
define('lang_mod_report_loansclass_form_opt_class2', '2er Klassifikationen');
define('lang_mod_report_loansclass_form_opt_class2x', '2Xer Klassifikationen (Islamisches)');
define('lang_mod_report_loansclass_form_opt_class3', '3er Klassifikationen');
define('lang_mod_report_loansclass_form_opt_class4', '4er Klassifikationen');
define('lang_mod_report_loansclass_form_opt_class5', '5er Klassifikationen');
define('lang_mod_report_loansclass_form_opt_class6', '6er Klassifikationen');
define('lang_mod_report_loansclass_form_opt_class7', '7er Klassifikationen');
define('lang_mod_report_loansclass_form_opt_class8', '8er Klassifikationen');
define('lang_mod_report_loansclass_form_opt_class9', '9er Klassifikationen');
define('lang_mod_report_loansclass_form_opt_classx', 'NON-Dezimal-Klassifikationen');
# Report - Member List
define('lang_mod_report_memberlist_form_regfrom', 'Registrierungsdatum ab');
define('lang_mod_report_memberlist_form_regto', 'Registrierungsdatum bis');
# Report - Loan List by Member
define('lang_mod_report_loanmember_form_loanfrom', 'Entleihungen ab');
define('lang_mod_report_loanmember_form_loanto', 'Entleihungen bis');
# Report - Overdued List
define('lang_mod_report_overdues_table_overdue', 'Überfälligkeit');
define('lang_mod_report_overdues_table_overdue_days', 'Tag(e)');
# Report - Staff Activity
define('lang_mod_report_staffactivity_form_activityfrom', 'Aktivitäten ab');
define('lang_mod_report_staffactivity_form_activityto', 'Aktivitäten bis');
define('lang_mod_report_staffactivity_tblheader_bibliography', 'Titel aufgenommen');
define('lang_mod_report_staffactivity_tblheader_items', 'Exemplare eingetragen');
define('lang_mod_report_staffactivity_tblheader_members', 'Mitglieder eingetragen');
define('lang_mod_report_staffactivity_tblheader_circulation', 'Ausleihen vorgenommen');
# Report - Reservation
define('lang_mod_report_reservation_form_reservefrom', 'Vormerkungen ab');
define('lang_mod_report_reservation_form_reserveto', 'Vormerkungen bis');
/* STOCK TAKE MODULE */
# submenu
define('lang_mod_stocktake_upload', 'Daten importieren');
define('lang_mod_stocktake_upload_titletag', 'Textdatei mit Barcodes hochladen');
# common
define('lang_mod_stocktake_tblheader_lost', 'Verlorene Exemplare');
define('lang_mod_stocktake_tblheader_exists', 'Vorhandene Exemplare');
define('lang_mod_stocktake_tblheader_loan', 'Entliehene Exemplare');
define('lang_mod_stocktake_tblfield_classes', 'er Klassifikation');
define('lang_mod_stocktake_participants_checked', 'Exemplare bisher inventurisiert');
define('lang_mod_stocktake_field_opt_yes', 'Ja');
define('lang_mod_stocktake_tblfield_none', 'Keine');
define('lang_mod_stocktake_resync_info', 'Der Abgleich umfasst nur Exemplare der laufenden Inventur. Titelaufnahmen oder Exemplardatensätze, die während der Inventur erstellt wurden, werden nicht aktualisiert.');
define('lang_mod_stocktake_resync_button', 'Jetzt abgleichen');
# Current
define('lang_mod_stocktake_current_welcome', 'INVENTUR - Geben oder scannen sie einen Barcode/Exemplar ein um es der Inventurliste hinzuzufügen');
define('lang_mod_stocktake_current_welcome_alt', 'Derzeit vermisste/verlorene Exemplare');
define('lang_mod_stocktake_current_form_list', 'Zeige Inventur durch');
define('lang_mod_stocktake_current_form_opt_user_cur', 'Aktuellen Benutzer (Sie)');
define('lang_mod_stocktake_current_form_opt_user_all', 'Alle Mitarbeiter');
define('lang_mod_stocktake_current_form_button_change', 'Status ändern');
# Upload
define('lang_mod_stocktake_upload_welcome', 'INVENTUR DATENIMPORT - Laden Sie eine Textdatei (.txt) mit einer Auflistung von Barcode/Exemplar zum inventurisieren hoch. Ein Barcode/Exemplar pro Zeile.');
define('lang_mod_stocktake_upload_form_file', ' Datei');
define('lang_mod_stocktake_upload_form_button_upload', ' Datei hochladen');
define('lang_mod_stocktake_upload_alert_success', 'Inventurdatei erfolgreich hochgeladen ');
define('lang_mod_stocktake_upload_alert_success_info', ' Barcodes eingelesen!');
/* SERIAL CONTROL MODULE */
# subcription menu 
define('lang_mod_serial_subscription_header', 'Vorhandene Periodika');
define('lang_mod_serial_subscription_close', 'SCHLIEßEN');
define('lang_mod_serial_subscription_kardex', 'Kardex ansehen/bearbeiten');
define('lang_mod_serial_subscription_kardex_msg', 'Details zum Kardex des Abonnements');
/* OPAC */
define('lang_opac_form_opt_gmd', 'Alle Ressourcenarten');
define('lang_opac_form_opt_collection', 'Alle Sammlungen');
define('lang_opac_form_opt_location', 'Alle Standorte');
define('lang_opac_rec_detail_attachment_none', 'Kein Anhang');
define('lang_opac_rec_detail_status_onloan', 'Derzeit ausgeliehen (bis zum ');
define('lang_opac_rec_detail_status_unavailable', 'Nicht verfügbar');
define('lang_opac_rec_detail_status_available', 'Verfügbar');


/* 
#############################
# GENERAL TRANSLATION NOTES #
#############################
Library German<>English Dictionary: http://www.bibliotheks-glossar.de/
GMD = General Materials Designator

  //?   = Fehlende Übersetzung/Sehr unschöne Übersetzung 
  //-   = Not used in code
  //!   = Remark
*/

/* 
###############################
# KONVENTIONEN VERSION: ALPHA #
###############################
add                               =>  hinzufügen (manchmal wäre "erstellen" 
                                      schöner; so bleibt's einheitlich)
Are You Sure Want to              =>  Wollen Sie ... (wirklich) ...
Authority Files                   =>  Normdateien
Authority Type                    =>  Normdatentyp
bibliographic                     =>  ~Titelaufnahmen (oder doch Bibliographie;
                                      gar Katalogisierung?)
cant be empty / can not be empty  =>  muss/müssen angegeben sein
Call Number                       =>  Signatur
cancel                            =>  abbrechen
circulation                       =>  Entleihe (trifft's nur bedingt, aber besser
                                      als Umlauf/Verbuchung etc. ... oder?); 
                                      Abgrenzung von loan (Ausleihe)
check                             =>  wählen
checkout (items)                  =>  entliehen exemplare
Code                              =>  Codekürzel
Collection                        =>  Sammlung/(Bestand)
Collection Type                   =>  Sammlungstyp
confirm                           =>  bestätigen
content                           =>  Inhaltsbereiche (eek)
copies = items                    =>  Exemplar
Credit                            =>  Guthaben
data                              =>  Daten (oder besser: Datensätze; was ganz anderes?)
database backup                   =>  Datenbanksicherung (!= Datenbanbackup)
Debit                             =>  Gebührenforderung
due date                          =>  Rückgabetermin
expired                           =>  abgelaufen (nicht "ausgelaufen")
Expiry Date                       =>  Ablaufdatum (oder doch "Gültig bis"?)
Export XXX Data To CSV format     =>  XXX in Datei exportieren (CSV-Format)
fines                             =>  Gebühren (!= overdue fines)
Forbidden                         =>  nicht gestattet
frequency                         =>  Erscheinungshäufigkeit 
gmd                               =>  Ressourcenart
group                             =>  Benutzergruppe
history                           =>  Verlauf
holiday                           =>  Ruhetag(e) (Erläuterung: "Holiday" sind 
                                      ausschließlich Tage, die bei den Leih-
                                      fristen rausgerechnet werden; sie werden
                                      nirgendwo auf der Seite angezeigt; es hat
                                      nichts mit Mitarbeiterurlaub o.ä. zu tun)
id                                =>  ggf. "...nummer"
image thumbnail                   =>  Vorschaubild
Import Data to XXX from CSV file  =>  XXX aus Datei importieren (CSV-Format)
initialize                        =>  starten
Inventory Code                    =>  Bestandsnummer (?)
item = copies                     =>  Exemplar
Item Code                         =>  Barcode/Exemplar
label                             =>  Kennzeichnung (NICHT Etikettenlabel, s. Labels)
Labels                            =>  Etikett (die druckbaren, nicht die Labels 
                                      á la "New Title", "Favorite"...)
library automatation (system)     =>  (im) Bibliotheksmanagementsystem
library members                   =>  Bibliotheksmitglieder (oder doch: Bibliotheksnutzer?)
list                              =>  Übersicht (manchmal Liste; manchmal weggestrichen)
loan                              =>  Ausleihe/ausgeliehen/Ausleih.../(Leihfrist)/(Entleihungen)
                                      (nicht Verleihe/verliehen; entliehen)
Loan Limit                        =>  Ausleihlimit
Location                          =>  Standort (Ort = mißverständlich; Filiale = unschön; 
                                      Zweigstelle = ob das allein gemeint ist? hmmm...)
login                             =>  anmelden/Anmeldung
Lookup Files                      =>  Nachschlagedateien
make sure                         =>  stellen Sie sicher
member ID                         =>  Mitgliedsnummer
Member Type                       =>  Mitgliedstyp (hmm...)
Member Type Name                  =>  Bezeichnung des Mitgliedstyps
Membership                        =>  Mitgliedschaft
module                            =>  Modul (?)
must be set = cant be empty       =>  muss/müssen angegeben sein
overdue                           =>  überfällig/Mahnung
(overdue) fines                   =>  Mahngebühren
Override(Overide)                 =>  ignorieren (oder außer Kraft setzen?)
pending                           =>  ruhend
PERMITTED                         =>  zulässig (Forbidden = nicht gestattet)
Place                             =>  Erscheinungsort
previous                          =>  Vorherig/letztes
privileges                        =>  Rechte
promote(ed)                       =>  propagiert (igitt!)
quick return                      =>  Schnellrücknahme
Real Name                         =>  Name (oder: Vor- und Nachname bzw. Nach- und Vorname?)
Reborrow                          =>  Ausleiherneuerung
repository                        =>  ?
Required                          =>  erforderlich (nicht benötigt)
reservation                       =>  Vormerkung
return                            =>  zurückbuchen
section                           =>  Bereich
stock take                        =>  Bestandsaufnahme (oder doch Bestandsrevision oder...?)
Subject                           =>  Schlagwort
Subject Type                      =>  Schlagwortkategorie
Subscription                      =>  Abonnement
supplier                          =>  zulieferer
System Users                      =>  Systembenutzer (oder: Systemanwender?)
template                          =>  Template (konvention)
transaction                       =>  Buchungsvorgang
uncheck                           =>  abwählen
update                            =>  aktualisieren
user/user name                    =>  Benutzer/Benutzername
view                              =>  einzusehen
writable                          =>  beschreibbar
you                               =>  Sie
You are going to edit xxx         =>  Sie sind im Begriff die Angaben für folgend.. ... zu bearbeiten
*/

/* 
#############################
# ÄNDERUNGEN Version: BETA  #
#############################
Neue Titelaufnahme hinzufügen           => Neue Titelaufnahme
Neuer Buchungsvorgang                   => Neue Buchung
Neues Mitglied hinzufügen               => Neues Mitglied
ENTLEIHE -                              => AUSLEIHE -
Titelaufnahmenübersicht                 => Titelaufnahmen ansehen
Lösche ausgewählte Daten                => Auswahl löschen
Exemplarübersicht                       => Exemplare ansehen
Drucke Etiketten (Aufnahmen/Signatur)   => Etikette drucken (Aufnahmen)
Aufnahmeetikett drucken                 => Etikette mit Signatur für Titelaufnahmen drucken
Etikette ausgewählter Aufnahmen drucken => Etikettendruck starten
Drucke Barcodes (Exemplare)             => Barcodes drucken (Exemplare)
Barcodes der Exemplare ausgewählter Aufnahmen drucken => Barcodedruck starten
Entleihungen [_button_loans]            => Ausleihen
Barcode des Exemplars einfügen          => Barcode des Exemplars angeben
Neue Gebühren hinzufügen                => Neue Gebühr hinzufügen
Gebührenverlauf                         => Gebühren- und Ausleihverlauf
Gebührenübersicht                       => Gebühren ansehen
Zeige beglichene Mahngebühren           => Beglichene Mahngebühren ansehen
Neue Ausleihregel hinzufügen            => Neue Ausleihregel
Übersicht Ausleihregeln                 => Ausleihregeln ansehen
Ausleiherneuerung Limit                 => Ausleiherneuerungen maximal
Mitgliedstyp [_membership_member_type]  => Mitgliedstypen
Mitgliedsdaten [diverse]                => Mitgliederdaten
Neuen Materialcode hinzufügen           => Neue Ressourcenart
Materialcodeübersicht                   => Ressourcenart ansehen
Materialcode Name                       => Name der Ressourcenart
Neuen Herausgeber hinzufügen            => Neuer Herausgeber
Herausgeberliste                        => Herausgeber ansehen
Herausgeber Name                        => Name des Herausgebers
Neuen Zulieferer hinzufügen             => Neuer Zulieferer
Zuliefererliste                         => Zulieferer ansehen
Zulieferer Name                         => Name des Zulieferers
Neuen Autor hinzufügen                  => Neuer Autor
Autorenübersicht                        => Autoren ansehen
Neues Schlagwort hinzufügen             => Neues Schlagwort
Schlagwörterübersicht                   => Schlagwörter ansehen
Neue Standortangabe hinzufügen          => Neuer Standort
Liste der Standortangaben               => Standorte ansehen
Standort Name                           => Name des Standorts
Neuen Erscheinungsort hinzufügen        => Neuer Erscheinungsort
Liste der Erscheinungsorte              => Erscheinungsorte ansehen
Angabemöglichkeiten zum Exemplarstatus  => Exemplarstatus
Neuen Exemplarstatus hinzufügen         => Neuer Exemplarstatus
Liste der Exemplarstatus                => Exemplarstatus ansehen
Exemplarstatus Bezeichnung              => Bezeichnung des Exemplarstatus
Neuen Sammlungstyp hinzufügen           => Neuer Sammlungstyp
Übersicht der Sammlungstypen            => Sammlungstypen ansehen
Neue Sprache hinzufügen                 => Neue Sprache
Liste der Sprachen                      => Sprachen ansehen
Neue Kennzeichnung hinzufügen           => Neue Kennzeichnung
Liste der Kennzeichnungen               => Kennzeichnungen ansehen
Kennzeichnung Name                      => Bezeichnung der Kennzeichnung
Kennzeichnung Beschreibung              => Beschreibung der Kennzeichnung
Neue Erscheinungshäufigkeit hinzufügen  => Neue Erscheinungshäufigkeit
Vorhandene Angaben zur Erscheinungshäufigkeit => Erscheinungshäufigkeiten ansehen
Frühere Bestandsaufnahmen               => Bisherige Bestandsaufnahmen
Bestandsaufnahme Name                   => Bezeichnung der Bestandsaufnahme
Beteiligte der Bestandsaufnahme         => Bestandsaufnahmemitarbeiter
Bestandsaufnahme abschließen            => Bestandsaufnahme beenden
Session Login Timeout                   => Automatisch abmelden nach (Sekunden)
OPAC XML Detail                         => OPAC XML-Detail
OPAC XML Ergebnis                       => OPAC XML-Ergebnis
Anzahl der Sammlungen, die in der Ergebnisliste des OPACs angezeigt werden => Zahl anzuzeigender Sammlungen in der OPAC-Ergebnisliste
Neue Seite hinzufügen                   => Neue Seite
Seitenliste                             => Seiten ansehen
Neue Module hinzufügen                  => Neues Modul
Übersicht der Module                    => Module ansehen
Neuen Benutzer hinzufügen               => Neuer Benutzer
Benutzerübersicht                       => Benutzer ansehen
Neue Benutzergruppe hinzufügen          => Neue Benutzergruppe
Benutzergruppenübersicht                => Benutzergruppen ansehen
Übersicht besonderer Ruhezeiträume      => Ruhezeiträume ansehen
Besonderern Ruhezeitraum (Ferien, Feiertage) hinzufügen => Neuer Ruhezeitraum (Ferien, Feiertage)
System Log                              => Systemlog
Abonnement                              => Abonnements
Sortierfolge                            => Umfang
Zeitschriftenverwaltung                 => Periodikaverwaltung
Erscheinungshäufigkeit (Zeitschriften)  => Erscheinungshäufigkeit (Periodika)
Neuen Mitgliedstyp hinzufügen           => Neuer Mitgliedstyp
Mitgliedstypenübersicht                 => Mitgliedstypen ansehen
Bestands... [aufnahmen]                 => Inventur...
Herausgeber [publisher]									=> Verlag
*/

/* BUGS-NOTES
Circulation > Start Transaction > Fines > Add New Fines
*/
?>
