<?php
/*
 * Arie Nugraha - 2009
 * Hendro Wicaksono - 2008
 * Wardiyono - 2008
 * Tobias Zeumer - 2009
ENGLISH language */

/* COMMON */

define('lang_sys_common_unauthorized', 'You are not authorized to view this section');
define('lang_sys_common_no_privilege', 'You dont have enough privileges to view this section');
define('lang_sys_common_timeout', 'Your Login Session has already timeout!');
define('lang_sys_common_welcome', 'Welcome To Library Automation System, you currently login as ');
define('lang_sys_common_overdue', 'There is currently <strong>{num_overdue}</strong> library members having overdue. Please check at <b>Circulation</b> module at <b>Overdues</b> section for more detail');
define('lang_sys_common_gd_not_loaded', '<strong>PHP GD</strong> extension is not installed. Please install it or application wont be able to create image thumbnail and barcode.');
define('lang_sys_common_gd_freetype_not_loaded', '<strong>Freetype</strong> support is not enabled in PHP GD extension. Rebuild PHP GD extension with Freetype support or application wont be able to create barcode.');
define('lang_sys_common_imagedir_unwritable', '<strong>Images</strong> directory and directories under it is not writable. Make sure it is writable by changing its permission or you wont be able to upload any images and create barcodes');
define('lang_sys_common_uploaddir_unwritable', '<strong>File upload</strong> directory is not writable. Make sure it is writable (and all directories under it) by changing its permission or you wont be able to upload any file, create report files and create database backups.');
define('lang_sys_common_repodir_unwritable', '<strong>Repository</strong> directory is not writable. Make sure it is writable (and all directories under it) by changing its permission or you wont be able to upload any bibliographic attachments.');
define('lang_sys_common_mysqldump_not_found', 'The PATH for <strong>mysqldump</strong> program is not right! Please check configuration file or you wont be able to do any database backups.');
define('lang_sys_common_tools', 'Tools');
define('lang_sys_common_confirm_delete_selected', 'Are You Sure Want to DELETE Selected Data?');
define('lang_sys_common_button_delete_selected', 'Delete Selected Data');
define('lang_sys_common_holiday_set_error', 'Maximum 6 day can be set as holiday!');
define('lang_sys_common_language_select', 'Select Language');
define('lang_sys_common_no_privilage', 'You don\'t have enough privileges to access this area!');
define('lang_sys_common_year', 'Year');
define('lang_sys_common_month', 'Month');
define('lang_sys_common_date', 'Date');
# template
define('lang_template_topmenu_1','Home');
define('lang_template_topmenu_2','Library Information');
define('lang_template_topmenu_3','Help on Search');
define('lang_template_topmenu_4','Librarian LOGIN');
define('lang_template_simple_search','Simple Search');
define('lang_template_adv_search','Advanced Search');
# login and logout
define('lang_sys_login_javastatus','Your browser does not support Javascript or Javascript is disabled. Application wont run without Javascript!');
define('lang_sys_login_alert', 'Please supply valid username and password');
define('lang_sys_login_alert_ok', 'Welcome to Library Automation, ');
define('lang_sys_login_alert_fail', 'Wrong Username or Password. ACCESS DENIED');
define('lang_sys_logout_alert', 'You Have Been Logged Out From Library Automation System');
# system module submenu
define('lang_sys_mod', 'System');
define('lang_sys_configuration', 'System Configuration');
define('lang_sys_configuration_titletag', 'Configure Global System Preferences');
define('lang_sys_configuration_description', 'Modify global application preferences');
define('lang_sys_modules', 'Modules');
define('lang_sys_modules_titletag', 'Configure Application Modules');
define('lang_sys_modules_new_add', 'Add New Modules');
define('lang_sys_modules_list', 'Modules List');
define('lang_sys_user', 'System Users');
define('lang_sys_user_titletag', 'Manage Application User or Library Staff');
define('lang_sys_user_new_add', 'Add New User');
define('lang_sys_user_list', 'User List');
define('lang_sys_group', 'User Group');
define('lang_sys_group_titletag', 'Manage Group of Application User');
define('lang_sys_group_new_add', 'Add New Group');
define('lang_sys_group_list', 'Group List');
define('lang_sys_holiday', 'Holiday Setting');
define('lang_sys_holiday_titletag', 'Holiday Setting');
define('lang_sys_barcodes', 'Barcode Generator');
define('lang_sys_barcodes_titletag', 'Barcode Generator');
define('lang_sys_barcodes_description', 'Type barcodes text to one or more text field below and click');
define('lang_sys_syslog', 'System Log');
define('lang_sys_syslog_titletag', 'View Application System Log');
define('lang_sys_backup', 'Database Backup');
define('lang_sys_backup_titletag', 'Backup Application Database');
define('lang_sys_backup_new_add', 'Start New Backup');
define('lang_sys_content', 'Content');
define('lang_sys_content_titletag', 'Content');
# form button
define('lang_sys_common_form_save', 'Save');
define('lang_sys_common_form_update', 'Update');
define('lang_sys_common_form_cancel', 'Cancel');
define('lang_sys_common_form_delete', 'Delete Record');
define('lang_sys_common_form_search', 'Search'); /* proposed */
define('lang_sys_common_form_search_field', 'Search'); /* proposed */
define('lang_sys_common_form_save_change', 'Save'); /* proposed */
define('lang_sys_common_form_report','Download Report');
# datagrid form
define('lang_sys_common_form_checkbox_all', 'Check All');
define('lang_sys_common_form_uncheckbox_all', 'Uncheck All');
# display search data
define('lang_sys_common_search_result_info', 'Found <strong>{result->num_rows}</strong> from your keywords');
define('lang_sys_common_paging_first', 'First Page');
define('lang_sys_common_paging_last', 'Last Page');
define('lang_sys_common_paging_prev', 'Previous');
define('lang_sys_common_paging_next', 'Next');
# application user form
define('lang_sys_user_field_login_username', 'Login Username');
define('lang_sys_user_field_realname', 'Real Name');
define('lang_sys_user_field_password_confirm', 'Confirm Password');
# content form
define('lang_sys_content_field_title', 'Content Title');
define('lang_sys_content_field_path', 'Path (Must be unique)');
define('lang_sys_content_field_desc', 'Content Description');
define('lang_sys_content_new_add', 'Add New Content');
define('lang_sys_content_list', 'Content List');
define('lang_sys_content_alert_noempty', 'Title or Path can\'t be empty!');
define('lang_sys_content_common_last_update', 'Last updated ');
define('lang_sys_content_common_edit_info', 'You are going to update Content data ');
define('lang_sys_content_alert_save_ok', 'Content data saved');
define('lang_sys_content_alert_save_fail', 'Content data FAILED to save!');
define('lang_sys_content_alert_update_ok', 'Content data updated');
define('lang_sys_content_alert_update_fail', 'Content data FAILED to update!');

/* Global Configuration */
define('lang_sys_conf_alert_save', 'Settings saved. Refreshing page');
define('lang_sys_conf_form_button_save', 'Save Configuration');
define('lang_sys_conf_form_field_library', 'Library Name');
define('lang_sys_conf_form_field_library_subname', 'Library Subname');
define('lang_sys_conf_form_field_public_template', 'Public Template');
define('lang_sys_conf_form_field_admin_template', 'Admin Template');
define('lang_sys_conf_form_field_language', 'Default App. Language');
define('lang_sys_conf_form_field_opac_result', 'Number Of Collection To Show In OPAC Result List');
define('lang_sys_conf_form_field_quick_return', 'Quick Return');
define('lang_sys_conf_form_field_limit_overide', 'Loan Limit Override');
define('lang_sys_conf_form_field_opac_xml', 'OPAC XML Detail');
define('lang_sys_conf_form_field_xml_result', 'OPAC XML Result');
define('lang_sys_conf_form_field_xml_file', 'Allow OPAC File Download');
define('lang_sys_conf_form_option_enable', 'Enable');
define('lang_sys_conf_form_option_disable', 'Disable');
define('lang_sys_conf_form_option_allow', 'Allow');
define('lang_sys_conf_form_option_forbid', 'Forbid');
define('lang_sys_conf_form_field_session', 'Session Login Timeout');
define('lang_sys_conf_form_field_promote_titles', 'Show Promoted Titles at Homepage');
/* Module Configuration */
define('lang_sys_conf_module_alert_noempty', 'Module name and path cant be empty');
define('lang_sys_conf_module_alert_save_ok', 'New Module Data Successfully Save');
define('lang_sys_conf_module_alert_save_fail', 'Module Data FAILED to Save. Please Contact System Administrator');
define('lang_sys_conf_module_alert_update_ok', 'Module Data Successfully Updated');
define('lang_sys_conf_module_alert_update_fail', 'Module Data FAILED to Updated. Please Contact System Administrator');
define('lang_sys_conf_module_common_edit_info', 'You are going to edit data');
define('lang_sys_conf_module_common_alert_delete_success', 'All Data Successfully Deleted');
define('lang_sys_conf_module_common_alert_delete_fail', 'Some or All Data NOT deleted successfully!\nPlease contact system administrator');
define('lang_sys_conf_module_field_name', 'Module Name');
define('lang_sys_conf_module_field_path', 'Module Path');
define('lang_sys_conf_module_field_description', 'Module Description');
/* User Configuration */
define('lang_sys_conf_user_alert_noempty', 'User Name or Real Name cant be empty');
define('lang_sys_conf_user_alert_forbid', 'Login username or Real Name is probihited!');
define('lang_sys_conf_user_alert_nomatch', 'Password confirmation not match. See if your Caps Lock key is on!');
define('lang_sys_conf_user_alert_save_ok', 'New User Data Successfully Save');
define('lang_sys_conf_user_alert_save_fail', 'User Data FAILED to Save. Please Contact System Administrator');
define('lang_sys_conf_user_alert_update_ok', 'User Data Successfully Updated');
define('lang_sys_conf_user_alert_update_fail', 'User Data FAILED to Updated. Please Contact System Administrator');
define('lang_sys_conf_user_common_edit_info', 'You are going to edit user profile');
define('lang_sys_conf_user_common_last_update', 'Last Update ');
define('lang_sys_conf_user_common_info_1', 'Leave Password field blank if you dont want to change password');
define('lang_sys_conf_user_common_alert_delete_success', 'All Data Successfully Deleted');
define('lang_sys_conf_user_common_alert_delete_fail', 'Some or All Data NOT deleted successfully!\nPlease contact system administrator');
define('lang_sys_conf_user_field_login_name', 'Login Username');
define('lang_sys_conf_user_field_real', 'Real Name');
define('lang_sys_conf_user_field_group', 'Group(s)');
define('lang_sys_conf_user_field_password_3', 'New Password');
define('lang_sys_conf_user_field_password_4', 'Confirm New Password');
define('lang_sys_conf_user_field_last_login', 'Last Login');
/* Group Configuration */
define('lang_sys_conf_group_alert_noempty', 'Group name cant be empty');
define('lang_sys_conf_group_alert_save_ok', 'New Group Data Successfully Save');
define('lang_sys_conf_group_alert_save_fail', 'Group Data FAILED to Save. Please Contact System Administrator');
define('lang_sys_conf_group_alert_update_ok', 'Group Data Successfully Updated');
define('lang_sys_conf_group_alert_update_fail', 'Group Data FAILED to Updated. Please Contact System Administrator');
define('lang_sys_conf_group_common_edit_info', 'You are going to edit Group data');
define('lang_sys_conf_group_common_last_update', 'Last Update ');
define('lang_sys_conf_group_common_alert_delete_success', 'All Data Successfully Deleted');
define('lang_sys_conf_group_common_alert_delete_fail', 'Some or All Data NOT deleted successfully!\nPlease contact system administrator');
define('lang_sys_conf_group_field_name', 'Group Name');
define('lang_sys_conf_group_field_privileges', 'Privileges');
define('lang_sys_conf_group_privileges_modul_name', 'Module Name');
define('lang_sys_conf_group_privileges_modul_read', 'Read');
define('lang_sys_conf_group_privileges_modul_write', 'Write');
/* Holiday Configuration */
define('lang_sys_holiday_set_day', 'Set holiday');
define('lang_sys_holiday_add_day', 'Add Special holiday');
define('lang_sys_holiday_list', 'Special holiday');
define('lang_sys_conf_holiday_alert_save_ok', 'New Holiday Successfully Save');
define('lang_sys_conf_holiday_alert_save_fail', 'Holiday FAILED to Save. Please Contact System Administrator');
define('lang_sys_conf_holiday_alert_update_ok', 'Holiday Data Successfully updated');
define('lang_sys_conf_holiday_alert_update_fail', 'Holiday FAILED to update. Please Contact System Administrator');
define('lang_sys_conf_holiday_alert_set_ok', 'Holiday settings saved');
define('lang_sys_conf_holiday_common_edit_info', 'You are going to edit holiday data');
define('lang_sys_conf_holiday_common_alert_delete_success', 'All Data Successfully Deleted');
define('lang_sys_conf_holiday_common_alert_delete_fail', 'Some or All Data NOT deleted successfully!\nPlease contact system administrator');
define('lang_sys_conf_holiday_form_save', 'Save Settings');
define('lang_sys_conf_holiday_field_date_day', 'Holiday Date Start');
define('lang_sys_conf_holiday_field_date_day_end', 'Holiday Date End');
define('lang_sys_conf_holiday_field_description', 'Holiday Description');
define('lang_sys_conf_holiday_field_day_name', 'Dayname');
define('lang_sys_conf_holiday_field_day_1', 'Monday');
define('lang_sys_conf_holiday_field_day_2', 'Tuesday');
define('lang_sys_conf_holiday_field_day_3', 'Wednesday');
define('lang_sys_conf_holiday_field_day_4', 'Thuesday');
define('lang_sys_conf_holiday_field_day_5', 'Friday');
define('lang_sys_conf_holiday_field_day_6', 'Saturday');
define('lang_sys_conf_holiday_field_day_7', 'Sunday');
/* Barcode Generator */
define('lang_sys_conf_barcode_alert_print_fail', 'Error creating barcode!');
define('lang_sys_conf_barcode_alert_print_ok', 'Barcode generation finished');
define('lang_sys_conf_barcode_button_print', 'Generate Barcodes');
define('lang_sys_conf_barcode_field_size', 'Barcode Size');
define('lang_sys_conf_barcode_field_option_1', 'Small');
define('lang_sys_conf_barcode_field_option_2', 'Medium');
define('lang_sys_conf_barcode_field_option_3', 'Big');
/* Log System */
define('lang_sys_conf_log_field_time', 'Time');
define('lang_sys_conf_log_field_location', 'Location');
define('lang_sys_conf_log_field_message', 'Message');

/* OPAC */
define('lang_opac_info', 'Web Online Public Access Catalog - Use Search facility to find document quickly');
define('lang_opac_rec_detail', 'Record Detail');
define('lang_opac_page_info', 'You currently on page <strong>{page}</strong> of <strong>{total_pages}</strong> page(s)');
define('lang_opac_search_result_info', 'Found  <strong>{biblio_list->num_rows}</strong> from your keywords');
define('lang_opac_back_prev', 'Back To Previous');

/* DEFAULT MODULE */
define('lang_mod_default_home_panel', 'Panel');
define('lang_mod_default_home_user_profile', 'Change User Profiles');
define('lang_mod_default_home_user_profile_titletag', 'Change Current User Profiles and Password');

/* BIBLIOGRAPHIC MODULE */
# submenu
define('lang_mod_biblio', 'Bibliographic');
define('lang_mod_biblio_list', 'Bibliographic List');
define('lang_mod_biblio_list_titletag', 'Show Existing Bibliographic Data');
define('lang_mod_biblio_add', 'Add New Bibliography');
define('lang_mod_biblio_add_titletag', 'Add New Bibliographic Data/Catalog');
define('lang_mod_biblio_item', 'Items');
define('lang_mod_biblio_item_list', 'Item List');
define('lang_mod_biblio_item_list_titletag', 'Show List of Library Items');
define('lang_mod_biblio_item_checkout', 'Checkout Items');
define('lang_mod_biblio_item_checkout_titletag', 'Show List of Checkout Items');
define('lang_mod_biblio_tools_z3950', 'Z3950 Service');
define('lang_mod_biblio_tools_z3950_titletag', 'Grab Bibliographic Data from Z3950 Web Services');
define('lang_mod_biblio_tools_label_print', 'Labels Printing');
define('lang_mod_biblio_tools_label_print_titletag', 'Print Document Labels');
define('lang_mod_biblio_tools_label_print_select', 'Print Selected Data');
define('lang_mod_biblio_tools_label_print_clear', 'Clear Print Queue');
define('lang_mod_biblio_tools_item_barcode', 'Item Barcodes Printing');
define('lang_mod_biblio_tools_item_barcode_titletag', 'Print Item Barcodes');
define('lang_mod_biblio_tools_item_barcode_print_select', 'Print Selected Data');
define('lang_mod_biblio_tools_item_barcode_clear', 'Clear Print Queue');
define('lang_mod_biblio_tools_export', 'Export Data');
define('lang_mod_biblio_tools_export_titletag', 'Export Bibliographic Data To CSV format');
define('lang_mod_biblio_tools_import', 'Import Data');
define('lang_mod_biblio_tools_import_titletag', 'Import Data to Bibliographic Database from CSV file');
# bibliography form fields
define('lang_mod_biblio_field_title', 'Title');
define('lang_mod_biblio_field_edition', 'Edition');
define('lang_mod_biblio_field_specific_detail', 'Specific Detail Info');
define('lang_mod_biblio_field_no_item', 'There is no item/copy for this title yet');
define('lang_mod_biblio_link_item_add', 'Add New Items');
define('lang_mod_biblio_field_authors', 'Author(s)');
define('lang_mod_biblio_link_author_add', 'Add Author(s)');
define('lang_mod_biblio_link_author_search', 'Click to view others document with this author');
define('lang_mod_biblio_field_gmd', 'GMD');
define('lang_mod_biblio_field_isbn', 'ISBN/ISSN');
define('lang_mod_biblio_field_class', 'Classification');
define('lang_mod_biblio_field_publisher', 'Publisher');
define('lang_mod_biblio_field_publish_year', 'Publish Year');
define('lang_mod_biblio_field_publish_place', 'Publish Place');
define('lang_mod_biblio_field_collation', 'Collation');
define('lang_mod_biblio_field_series', 'Series Title');
define('lang_mod_biblio_field_call_number', 'Call Number');
define('lang_mod_biblio_field_topic', 'Subject(s)');
define('lang_mod_biblio_link_topic_add', 'Add Subject(s)');
define('lang_mod_biblio_link_topic_search', 'Click to view others document with this subject');
define('lang_mod_biblio_field_lang', 'Language');
define('lang_mod_biblio_field_notes', 'Abstract/Notes');
define('lang_mod_biblio_field_image', 'Image');
define('lang_mod_biblio_field_attachment', 'File Attachment');
define('lang_mod_biblio_field_availability', 'Availability');
define('lang_mod_biblio_field_hide_opac', 'Hide in OPAC');
define('lang_mod_biblio_field_promote', 'Promote To Homepage');
# bibliography common
define('lang_mod_biblio_common_form_print_queue', 'Add To Print Queue');
define('lang_mod_biblio_common_print_queue_confirm', 'Add to print queue?');
define('lang_mod_biblio_common_print_cleared', 'Print queue cleared!');
define('lang_mod_biblio_common_print_no_data', 'There is no data to print!');
define('lang_mod_biblio_alert_print_no_add_queue', 'Selected items NOT ADDED to print queue. Only {max_print} can be printed at once');
define('lang_mod_biblio_alert_print_add_ok', 'Selected items added to print queue');
define('lang_mod_biblio_alert_title_empty', 'Title can not be empty');
define('lang_mod_biblio_alert_failed_to_save', 'Bibliography Data FAILED to Save. Please Contact System Administrator');
define('lang_mod_biblio_alert_failed_to_update', 'Bibliography Data FAILED to Updated. Please Contact System Administrator');
define('lang_mod_biblio_alert_new_added', 'New Bibliography Data Successfully Save');
define('lang_mod_biblio_alert_updated_ok', 'Bibliography Data Successfully Updated');
define('lang_mod_biblio_alert_image_uploaded', 'Image Uploaded Successfully');
define('lang_mod_biblio_common_edit_message', 'You are going to edit biblio data');
define('lang_mod_biblio_common_last_update', 'Last Updated ');
define('lang_mod_biblio_alert_list_not_deleted', 'Below data can not be deleted : ');
define('lang_mod_biblio_alert_data_selected_deleted', 'All Data Successfully Deleted');
define('lang_mod_biblio_alert_data_selected_not_deleted', 'Some or All Data NOT deleted successfully!\nPlease contact system administrator');
# item form fields
define('lang_mod_biblio_item_field_title', 'Title');
define('lang_mod_biblio_item_field_itemcode', 'Item Code');
define('lang_mod_biblio_item_field_inventory', 'Inventory Code');
define('lang_mod_biblio_item_field_location', 'Location');
define('lang_mod_biblio_item_field_site', 'Shelf Location');
define('lang_mod_biblio_item_field_ctype', 'Collection Type');
define('lang_mod_biblio_item_field_item_status', 'Item Status');
define('lang_mod_biblio_item_field_order_number', 'Order Number');
define('lang_mod_biblio_item_field_order_date', 'Order Date');
define('lang_mod_biblio_item_field_received_date', 'Received Date');
define('lang_mod_biblio_item_field_supplier', 'Supplier');
define('lang_mod_biblio_item_field_item_source', 'Source');
define('lang_mod_biblio_item_field_invoice', 'Invoice');
define('lang_mod_biblio_item_field_invoice_date', 'Invoice Date');
define('lang_mod_biblio_item_field_price', 'Price');
#item
define('lang_mod_biblio_item_common_location_status_1', 'copies at');
define('lang_mod_biblio_item_alert_item_code', 'Item Code cant be empty!');
define('lang_mod_biblio_item_alert_new_saved', 'New Item Data Successfully Save');
define('lang_mod_biblio_item_alert_updated','Item Data Successfully Updated');
define('lang_mod_biblio_item_alert_not_saved', 'Item Data FAILED to Save. Please Contact System Administrator');
define('lang_mod_biblio_item_alert_delete_fail_on_loan', 'Item data can not be deleted because still on hold by members');
define('lang_mod_biblio_item_common_edit_message', 'You are going to edit Item data');
define('lang_mod_biblio_item_common_last_update', 'Last Updated');
define('lang_mod_biblio_item_alert_remove_success', 'Item succesfully removed!');
define('lang_mod_biblio_item_alert_remove_failed', 'Item FAILED to removed!');
# export
define('lang_mod_biblio_export_header', 'EXPORT TOOL');
define('lang_mod_biblio_export_header_text', 'Export bibliographics data to CSV file');
define('lang_mod_biblio_export_form_field_separator', 'Field Separator*');
define('lang_mod_biblio_export_form_field_enclosed', 'Field Enclosed With*');
define('lang_mod_biblio_export_form_field_rec_separator', 'Record Separator');
define('lang_mod_biblio_export_form_field_rec_to_export', 'Number of Records To Export (0 for all records)');
define('lang_mod_biblio_export_form_field_rec_start', 'Start From Record');
define('lang_mod_biblio_export_form_button_start', 'Export now');
define('lang_mod_biblio_export_alert_all_field', 'Required field must be filled correctly!');
define('lang_mod_biblio_export_alert_err_query', 'Error on query to database, Export FAILED!');
define('lang_mod_biblio_export_alert_no_record', 'There is no record in bibliographic database yet, Export FAILED!');
# import
define('lang_mod_biblio_import_header', 'IMPORT TOOL');
define('lang_mod_biblio_import_header_text', 'Import for bibliographics data from CSV file. For guide on CVS fields order and format please refer to documentation or visit <a href="http://senayan.diknas.go.id" target="_blank">Official Website</a>');
define('lang_mod_biblio_import_form_field_file_input', 'File To Import*');
define('lang_mod_biblio_import_file_input_require', 'Please select the file to import!');
define('lang_mod_biblio_import_form_field_separator', 'Field Separator*');
define('lang_mod_biblio_import_form_field_enclosed', 'Field Enclosed With*');
define('lang_mod_biblio_import_form_field_rec_to_export', 'Number of Records To Import (0 for all records)');
define('lang_mod_biblio_import_form_field_rec_start', 'Start From Record');
define('lang_mod_biblio_import_form_button_start', 'Import now');
define('lang_mod_biblio_import_alert_all_field', 'Required field must be filled correctly!');
define('lang_mod_biblio_import_alert_err_size', 'Upload failed! File type not allowed or the size is more than ');
define('lang_mod_biblio_alert_field_author_removed', 'Author removed!');
define('lang_mod_biblio_alert_field_author_session_removed', 'Author succesfully removed!');
# author
define('lang_mod_biblio_author_update_ok', 'Author succesfully updated!');
define('lang_mod_biblio_author_added_ok', 'Author added!');
define('lang_mod_biblio_author_added_fail', 'Author FAILED to Add. Please Contact System Administrator');
define('lang_mod_biblio_author_form_name', 'Author name');
define('lang_mod_biblio_author_form_search', 'Type to search or add new');
define('lang_mod_biblio_author_insert_to_biblio', 'Insert To Bibliography');
#topic
define('lang_mod_biblio_topic_added_ok', 'Subject added!');
define('lang_mod_biblio_topic_added_fail', 'Subject FAILED to Add. Please Contact System Administrator');
define('lang_mod_biblio_topic_form_title', 'Add Subject');
define('lang_mod_biblio_topic_form_keyword', 'Keyword');
define('lang_mod_biblio_topic_form_search', 'Type to search or add new');
define('lang_mod_biblio_topic_insert_to_biblio', 'Insert To Bibliography');

/* CIRCULATION MODULE */
# submenu
define('lang_mod_circ', 'Circulation');
define('lang_mod_circ_start', 'Start Transaction');
define('lang_mod_circ_start_titletag', 'Start Circulation Transaction Proccess');
define('lang_mod_circ_quick_return', 'Quick Return');
define('lang_mod_circ_quick_return_titletag', 'Quick Return Collection');
define('lang_mod_circ_quick_return_msg1', 'Insert an item ID to return collection with keyboard or barcode reader');
define('lang_mod_circ_loan_rules', 'Loan Rules');
define('lang_mod_circ_loan_rules_titletag', 'View and Modify Circulation Loan Rules');
define('lang_mod_circ_loan_rules_add', 'Add New Loan Rules');
define('lang_mod_circ_loan_rules_list', 'Loan Rules List');
define('lang_mod_circ_transaction_history', 'Loan History');
define('lang_mod_circ_transaction_history_titletag', 'Loan History');
define('lang_mod_circ_overdues', 'Overdued List');
define('lang_mod_circ_overdues_titletag', 'View Members Having Overdues');
# common
define('lang_mod_circ_common_welcome', 'CIRCULATION - Insert a member ID to start transaction with keyboard or barcode reader');
define('lang_mod_circ_common_loan_not_saved', 'ERROR! Loan data cant be saved to database');
define('lang_mod_circ_common_trans_finish', 'Transaction with member {member_id} is completed');
define('lang_mod_circ_common_error_unregistered_member', ' not valid (unregistered in database) ');
define('lang_mod_circ_common_error_expired_membership', 'Membership already expired');
define('lang_mod_circ_common_error_pending_membership', 'Membership currently in pending state, loan transaction is locked.');
define('lang_mod_circ_common_return_confirmation', 'Are you sure you want to return the item');
define('lang_mod_circ_common_extend_confirmation', 'Are you sure to extend loan for');
define('lang_mod_circ_common_overdued_for_1', 'OVERDUED for');
define('lang_mod_circ_common_overdued_for_2', 'days(s) with fines value');
define('lang_mod_circ_common_loan_confirmation', 'Are you sure want to finish current transaction?');
define('lang_mod_circ_common_finished_loan_confirmation', 'Transaction finished');
define('lang_mod_circ_common_fines_inserted', 'Overdue fines inserted to fines database');
define('lang_mod_circ_common_fines_alert_01', 'Fines Description and Debet value cant be empty');
define('lang_mod_circ_common_fines_alert_02', 'Value of Credit can not be higher that Debet Value');
define('lang_mod_circ_common_alert_error_limit_reach', 'Loan Limit Reached!');
define('lang_mod_circ_common_alert_extended_success', 'Loan Extended');
define('lang_mod_circ_common_overide_confirmation', 'Do You Want To Overide This?');
define('lang_mod_circ_alert_on_resereved', 'WARNING! This Item is being reserved by other member');
define('lang_mod_circ_alert_item_not_registered', 'This Item is not registered in database');
define('lang_mod_circ_alert_item_not_available', 'This Item is currently not available');
define('lang_mod_circ_alert_member_expired', 'Loan NOT PERMITTED! Membership already EXPIRED!');
define('lang_mod_circ_alert_member_pending', 'Loan NOT PERMITTED! Membership under PENDING State!');
define('lang_mod_circ_alert_not_for_loan', 'Loan Forbidden for this Item!');
define('lang_mod_circ_alert_item_remove_from_session', 'Item {removeID} removed from session');
define('lang_mod_circ_common_item_already_return', 'This is item already returned or not exists in loan database');
define('lang_mod_circ_common_return_overdue', 'OVERDUED for {overdueDays} days(s) with fines value of '); /* see common_overdued_for_1 & 2 */
define('lang_mod_circ_common_item_return_ok', ' successfully returned on ');
define('lang_mod_circ_reserve', 'Reservation');
define('lang_mod_circ_reserve_alert_nod_data', 'NO DATA Selected to reserve!');
define('lang_mod_circ_reserve_alert_forbidden', 'Cant reserve this Item. Loan Forbidden!');
define('lang_mod_circ_reserve_alert_success', 'Reservation added');
define('lang_mod_circ_reserve_alert_after_return', 'Item {itemCode} is being reserved by member {member}');
define('lang_mod_circ_reserve_alert_available', 'Item for this title is already available or already on hold by this member!');
define('lang_mod_circ_reserve_alert_removed', 'Reservation removed');
define('lang_mod_circ_reserve_alert_reach_limit', 'Can not add more reservation. Maximum limit reached');
define('lang_mod_circ_fines_alert_removed', 'Fines data removed');
# transaction form
define('lang_mod_circ_field_member_id', 'Member ID');
define('lang_mod_circ_field_member_name', 'Member Name');
define('lang_mod_circ_field_member_email', 'Member Email');
define('lang_mod_circ_field_register_date', 'Register Date');
define('lang_mod_circ_field_member_type', 'Member Type');
define('lang_mod_circ_field_expiry_date', 'Expiry Date');
define('lang_mod_circ_button_loans', 'Loans');
define('lang_mod_circ_button_current_loans', 'Current Loans');
define('lang_mod_circ_button_reserve', 'Reserve');
define('lang_mod_circ_button_fines', 'Fines');
define('lang_mod_circ_button_loan_history', 'Loan History');
define('lang_mod_circ_button_finish_transaction', 'Finish Transaction');
define('lang_mod_circ_tblheader_return', 'Return');
define('lang_mod_circ_tblheader_extend', 'Extend');
define('lang_mod_circ_tblheader_item_code', 'Item Code');
define('lang_mod_circ_tblheader_title', 'Title');
define('lang_mod_circ_tblheader_loan_date', 'Loan Date');
define('lang_mod_circ_tblheader_due_date', 'Due Date');
define('lang_mod_circ_tblheader_returned_date', 'Returned Date');
define('lang_mod_circ_tblheader_remove', 'Remove');
define('lang_mod_circ_tblheader_reserve_date', 'Reserve Date');
define('lang_mod_circ_tblheader_add_new_fines', 'Add New Fines');
define('lang_mod_circ_tblheader_fines_list', 'Fines List');
define('lang_mod_circ_tblheader_view_balanced_overdue', 'View Balanced Overdue');
define('lang_mod_circ_loan_field_insert_barcode', 'Insert Item Code/Barcode');
define('lang_mod_circ_loan_button_loan', 'Loan');
define('lang_mod_circ_reserve_field_search_collection', 'Search Collection');
define('lang_mod_circ_reserve_button_add_reserve', 'Add Reserve');
define('lang_mod_circ_return_titletext_return', 'Return this item');
define('lang_mod_circ_return_no_return_history_data', 'Not Return Yet');
define('lang_mod_circ_extend_alttext_no_extend', 'No Extend');
define('lang_mod_circ_extend_titletext_extend', 'Extend loan for this item');
define('lang_mod_circ_extend_renewal_flag', 'Extended');
define('lang_mod_circ_extend_noextend_confirmation', 'Item CANT BE Extended! This Item is being reserved by other member');
# fines
define('lang_mod_circ_fines_alert_new_added', 'New Fines Data Successfully Save');
define('lang_mod_circ_fines_alert_fail_to_save', 'Fines Data FAILED to Save. Please Contact System Administrator');
define('lang_mod_circ_fines_alert_updated', 'Fines Data Successfully Updated');
define('lang_mod_circ_fines_alert_not_updated', 'Fines Data FAILED to Updated. Please Contact System Administrator');
define('lang_mod_circ_fines_common_info', 'You are going to edit fines data : ');
# form
define('lang_mod_circ_fines_field_date', 'Fines Date');
define('lang_mod_circ_fines_field_description', 'Description/Name');
define('lang_mod_circ_fines_field_debit', 'Debit');
define('lang_mod_circ_fines_field_credit', 'Credit');
# loan rules
define('lang_mod_circ_loan_rules_alert_add_ok', 'New Loan Rules Successfully Save');
define('lang_mod_circ_loan_rules_alert_add_fail', 'Loan Rules FAILED to Save. Please Contact System Administrator');
# form loan rules
define('lang_mod_circ_loan_rules_field_member_type', 'Member Type');
define('lang_mod_circ_loan_rules_field_collection_type', 'Collection Type');
define('lang_mod_circ_loan_rules_field_gmd', 'GMD');
define('lang_mod_circ_loan_rules_field_loan_limit', 'Loan Limit');
define('lang_mod_circ_loan_rules_field_loan_period', 'Loan Period');
define('lang_mod_circ_loan_rules_field_reborrow_limit', 'Reborrow Limit');
define('lang_mod_circ_loan_rules_field_fines', 'Fines Each Day');
# common loan rules
define('lang_mod_circ_loan_rules_alert_updated_ok', 'Loan Rules Successfully Updated');
define('lang_mod_circ_loan_rules_alert_updated_fail', 'Loan Rules FAILED to Updated. Please Contact System Administrator');
define('lang_mod_circ_loan_rules_common_edit_info', 'You are going to edit loan rules : ');
define('lang_mod_circ_loan_rules_common_last_update', 'Last update ');
define('lang_mod_circ_loan_rules_alert_all_deleted', 'All Data Successfully Deleted');
define('lang_mod_circ_loan_rules_alert_not_all_deleted', 'Some or All Data NOT deleted successfully!\nPlease contact system administrator');
# quick return
define('lang_mod_circ_loan_quick_return_disable', 'Quick Return is disabled');
define('lang_mod_circ_loan_quick_return_form_item_id', 'Item ID');
define('lang_mod_circ_loan_quick_return_form_button', 'Return');
# reserve list
define('lang_mod_circ_loan_reserve_status', 'AVAILABLE');
define('lang_mod_circ_loan_reserve_confirm_delete', 'Are you sure to remove reservation for');
define('lang_mod_circ_loan_reserve_expired', 'ALREADY EXPIRED');

/* MEMBERSHIP MODULE */
# submenu
define('lang_mod_membership', 'Membership');
define('lang_mod_membership_view_member_list', 'View Member List');
define('lang_mod_membership_view_member_list_titletag', 'View Library Member List');
define('lang_mod_membership_add_new_member', 'Add New Member');
define('lang_mod_membership_add_new_member_titletag', 'Add New Library Member Data');
define('lang_mod_membership_member_type', 'Member Type');
define('lang_mod_membership_member_type_titletag', 'View and modify member type');
define('lang_mod_membership_member_type_new_add', 'Add New Member Type');
define('lang_mod_membership_member_type_list', 'Member Type List');
define('lang_mod_membership_member_list', 'Member List');
define('lang_mod_membership_view_expired_member', 'View Expired Member');
define('lang_mod_membership_import_data', 'Import Data');
define('lang_mod_membership_import_data_titletag', 'Import Members Data From CSV File');
define('lang_mod_membership_import_data_description', 'Import for members data from CSV file');
define('lang_mod_membership_export_data', 'Export Data');
define('lang_mod_membership_export_data_titletag', 'Export Members Data To CSV File');
define('lang_mod_membership_export_data_description', 'Export member(s) data to CSV file');
define('lang_mod_membership_search', 'Member Search');
define('lang_mod_membership_search_button', 'Search');
define('lang_mod_membership_card_generator_titletag', 'Print Member Card');
define('lang_mod_membership_card_generator', 'Member Card Printing');
# common
define('lang_mod_membership_common_error_no_id_name', 'Member ID and Name cant be empty');
define('lang_mod_membership_common_member_data_saved', 'New Member Data Successfully Save');
define('lang_mod_membership_common_image_upload_success', 'Image Uploaded Successfully');
define('lang_mod_membership_common_image_upload_error', 'Image FAILED to upload');
define('lang_mod_membership_common_error_fail_to_save_member_data', 'Member Data FAILED to Save/Update. Please Contact System Administrator');
define('lang_mod_membership_common_error_membership_expired', 'Membership Already Expired');
define('lang_mod_membership_common_member_data_updated', 'Member Data Successfully Updated');
define('lang_mod_membership_button_save', 'Save');
define('lang_mod_membership_common_maximum', 'Maximum');
define('lang_mod_membership_common_edit_message', 'You are going to edit member data');
define('lang_mod_membership_common_last_update', 'Last Updated');
define('lang_mod_membership_common_alert_no_delete_member_data', 'Below member data cant be deleted because still have unreturned item(s)');
define('lang_mod_membership_common_expired_member_list', 'Expired Member List');
define('lang_mod_membership_common_found_text_1', 'Found');
define('lang_mod_membership_common_found_text_2', 'from your search with keyword');
define('lang_mod_membership_common_alert_delete_member_data_success', 'All Data Successfully Deleted');
define('lang_mod_membership_common_alert_delete_member_data_failed', 'Some or All Data NOT deleted successfully!\nPlease contact system administrator');
# form
define('lang_mod_membership_field_extend_membership', 'Extend Membership');
define('lang_mod_membership_field_extend', 'Extend');
define('lang_mod_membership_field_member_id', 'Member ID');
define('lang_mod_membership_field_name', 'Member Name');
define('lang_mod_membership_field_birth_date', 'Birth Date');
define('lang_mod_membership_field_institution', 'Institution');
define('lang_mod_membership_field_membership_type', 'Membership Type');
define('lang_mod_membership_field_gender', 'Gender');
define('lang_mod_membership_field_gender_opt1', 'Male');
define('lang_mod_membership_field_gender_opt2', 'Female');
define('lang_mod_membership_field_email', 'E-mail');
define('lang_mod_membership_field_address', 'Address');
define('lang_mod_membership_field_postal_code', 'Postal Code');
define('lang_mod_membership_field_phone_number', 'Phone Number');
define('lang_mod_membership_field_fax_number', 'Fax Number');
define('lang_mod_membership_field_personal_id', 'Personal ID Number');
define('lang_mod_membership_field_notes', 'Notes');
define('lang_mod_membership_field_photo', 'Photo');
define('lang_mod_membership_field_member_since', 'Member Since');
define('lang_mod_membership_field_register_date', 'Register Date');
define('lang_mod_membership_field_expiry_date', 'Expiry Date');
define('lang_mod_membership_field_pending', 'Pending Membership');
# member type form
define('lang_mod_member_type_alert_name_noempty', 'Member Type Name cant be empty');
define('lang_mod_member_type_common_edit_message', 'You are going to edit member data');
define('lang_mod_member_type_common_last_update', 'Last Updated');
define('lang_mod_member_type_common_member_type_saved', 'New Member Type Successfully Save');
define('lang_mod_member_type_common_member_type_updated', 'Member Type Successfully Updated');
define('lang_mod_member_type_common_fail_to_save_member_type', 'Member Type Data FAILED to Save/Update. Please Contact System Administrator');
define('lang_mod_member_type_field_name', 'Member Type Name');
define('lang_mod_member_type_field_periode', 'Membership Periode (In Days)');
define('lang_mod_circ_field_loan_limit', 'Loan Limit');
define('lang_mod_circ_field_loan_periode', 'Loan Periode (In Days)');
define('lang_mod_circ_field_reserve', 'Reserve');
define('lang_mod_circ_field_reserve_limit', 'Reserve Limit');
define('lang_mod_circ_field_reborrow_limit', 'Reborrow Limit');
define('lang_mod_circ_field_fine_each_day', 'Fine Each Day');
define('lang_mod_circ_field_grace_periode', 'Overdue Grace Periode');
# import membership
define('lang_mod_member_import_alert_file_noempty', 'Please select the file to import!');
define('lang_mod_member_import_alert_required_noempty', 'Required field must be filled correctly!');
define('lang_mod_member_import_alert_fail', 'Upload failed! File type not allowed or the size is more than');
define('lang_mod_member_import_info_record_uploaded',  'records inserted successfully to members database, from record');
define('lang_mod_member_import_field_file', 'File To Import');
define('lang_mod_member_import_field_field_separator', 'Field Separator');
define('lang_mod_member_import_field_field_enclosed', 'Field Enclosed With');
define('lang_mod_member_import_field_record_number', 'Number of Records To Import (0 for all records)');
define('lang_mod_member_import_field_record_offset', 'Start From Record');
define('lang_mod_member_import_button_start', 'Import Now');
# export membership
define('lang_mod_member_export_alert_required_noempty', 'Required field must be filled correctly!');
define('lang_mod_member_export_alert_fail', 'There is no record in membership database yet, Export FAILED!');
define('lang_mod_member_export_alert_query_fail', 'Error on query to database, Export FAILED!');
define('lang_mod_member_export_field_field_separator', 'Field Separator');
define('lang_mod_member_export_field_field_enclosed', 'Field Enclosed With');
define('lang_mod_member_export_field_record_number', 'Number of Records To Export (0 for all records)');
define('lang_mod_member_export_field_record_offset', 'Start From Record');
define('lang_mod_member_export_field_record_separator', 'Record Separator');
define('lang_mod_member_export_button_start', 'Export Now');

/* MASTER FILE MODULE */
# submenu
define('lang_mod_masterfile_authority_files', 'Authority Files');
define('lang_mod_masterfile_lookup_files', 'Lookup Files');
define('lang_mod_masterfile_gmd', 'GMD');
define('lang_mod_masterfile_gmd_titletag', 'General Material Designation');
define('lang_mod_masterfile_gmd_new_add', 'Add new GMD');
define('lang_mod_masterfile_gmd_list', 'GMD List');
define('lang_mod_masterfile_publisher', 'Publisher');
define('lang_mod_masterfile_publisher_titletag', 'Document Publisher');
define('lang_mod_masterfile_publisher_new_add', 'Add new Publisher');
define('lang_mod_masterfile_publisher_list', 'Publisher List');
define('lang_mod_masterfile_supplier', 'Supplier');
define('lang_mod_masterfile_supplier_titletag', 'Item Supplier');
define('lang_mod_masterfile_supplier_new_add', 'Add new Supplier');
define('lang_mod_masterfile_supplier_list', 'Supplier List');
define('lang_mod_masterfile_author', 'Author');
define('lang_mod_masterfile_author_titletag', 'Document Authors');
define('lang_mod_masterfile_author_new_add', 'Add new Author');
define('lang_mod_masterfile_author_list', 'Author List ');
define('lang_mod_masterfile_topic', 'Subject');
define('lang_mod_masterfile_topic_titletag', 'Subject');
define('lang_mod_masterfile_topic_list', 'Subject List');
define('lang_mod_masterfile_topic_type', 'Subject Type');
define('lang_mod_masterfile_topic_new_add', 'Add new Subject');
define('lang_mod_masterfile_location', 'Location');
define('lang_mod_masterfile_location_titletag', 'Item Location');
define('lang_mod_masterfile_location_new_add', 'Add new Location');
define('lang_mod_masterfile_location_list', 'Location List');
define('lang_mod_masterfile_place', 'Place');
define('lang_mod_masterfile_place_titletag', 'Place Name');
define('lang_mod_masterfile_place_new_add', 'Add new Place');
define('lang_mod_masterfile_place_list', 'Place List');
define('lang_mod_masterfile_itemstatus', 'Item Status');
define('lang_mod_masterfile_itemstatus_titletag', 'Item Status');
define('lang_mod_masterfile_itemstatus_new_add', 'Add new Item Status');
define('lang_mod_masterfile_colltype', 'Collection Type');
define('lang_mod_masterfile_colltype_titletag', 'Collection Type');
define('lang_mod_masterfile_colltype_new_add', 'Add new Collection Type');
define('lang_mod_masterfile_colltype_list', 'Collection Type List');
define('lang_mod_masterfile_lang', 'Doc. Language');
define('lang_mod_masterfile_lang_titletag', 'Document Content Language');
define('lang_mod_masterfile_lang_new_add', 'Add new Language');
define('lang_mod_masterfile_lang_list', 'Language List');
define('lang_mod_masterfile_label', 'Label');
define('lang_mod_masterfile_label_titletag', 'Label');
define('lang_mod_masterfile_label_new_add', 'Add new Label');
define('lang_mod_masterfile_label_list', 'Label List');
define('lang_mod_masterfile_frequency', 'Frequency');
define('lang_mod_masterfile_frequency_titletag', 'Frequency');
define('lang_mod_masterfile_frequency_new_add', 'Add New Frequency');
define('lang_mod_masterfile_frequency_list', 'Frequency Available');
# author master file
# common
define('lang_mod_masterfile_author_alert_name_noempty', 'Author name cant be empty');
define('lang_mod_masterfile_author_alert_new_add_ok', 'New Author Data Successfully Save');
define('lang_mod_masterfile_author_alert_add_fail', 'Author Data FAILED to Save. Please Contact System Administrator');
define('lang_mod_masterfile_author_alert_update_ok', 'Author Data Successfully Updated');
define('lang_mod_masterfile_author_alert_update_fail', 'Author Data FAILED to Updated. Please Contact System Administrator');
define('lang_mod_masterfile_author_common_edit_info', 'You are going to edit author data : ');
define('lang_mod_masterfile_author_common_last_update', 'Last update ');
define('lang_mod_masterfile_author_alert_all_delete_ok', 'All Data Successfully Deleted');
define('lang_mod_masterfile_author_alert_all_delete_fail', 'Some or All Data NOT deleted successfully!\nPlease contact system administrator');
# form
define('lang_mod_masterfile_author_form_field_name', 'Author Name');
define('lang_mod_masterfile_author_form_field_authority', 'Authority Type');
# collection type master file
# common
define('lang_mod_masterfile_colltype_alert_name_noempty', 'Collection type name cant be empty');
define('lang_mod_masterfile_colltype_alert_new_add_ok', 'New Colllection Type Data Successfully Save');
define('lang_mod_masterfile_colltype_alert_add_fail', 'Author Data FAILED to Save. Please Contact System Administrator');
define('lang_mod_masterfile_colltype_alert_update_ok', 'Colllection Type Data Successfully Updated');
define('lang_mod_masterfile_colltype_alert_update_fail', 'Colllection Type Data FAILED to Updated. Please Contact System Administrator');
define('lang_mod_masterfile_colltype_alert_not_exists', 'ERROR! Selected data doesnt exists');
define('lang_mod_masterfile_colltype_common_edit_info', 'You are going to edit collection type data : ');
define('lang_mod_masterfile_colltype_common_last_update', 'Last update ');
define('lang_mod_masterfile_colltype_alert_not_delete', 'Below data cant be deleted : \n');
define('lang_mod_masterfile_colltype_alert_all_delete_ok', 'All Data Successfully Deleted');
define('lang_mod_masterfile_colltype_alert_all_delete_fail', 'Some or All Data NOT deleted successfully!\nPlease contact system administrator');
# form
define('lang_mod_masterfile_colltype_form_field_colltype', 'Collection Type');
# language master file
# common
define('lang_mod_masterfile_lang_alert_name_noempty', 'Language ID or Name cant be empty');
define('lang_mod_masterfile_lang_alert_new_add_ok', 'New Language Data Successfully Save');
define('lang_mod_masterfile_lang_alert_add_fail', 'Language Data FAILED to Save. Please Contact System Administrator');
define('lang_mod_masterfile_lang_alert_update_ok', 'Language Data Successfully Updated');
define('lang_mod_masterfile_lang_alert_update_fail', 'Language Data FAILED to Updated. Please Contact System Administrator');
define('lang_mod_masterfile_lang_common_edit_info', 'You are going to edit language data : ');
define('lang_mod_masterfile_lang_common_last_update', 'Last update ');
define('lang_mod_masterfile_lang_alert_all_delete_ok', 'All Data Successfully Deleted');
define('lang_mod_masterfile_lang_alert_all_delete_fail', 'Some or All Data NOT deleted successfully!\nPlease contact system administrator');
# form
define('lang_mod_masterfile_lang_form_field_lang_code', 'Language Code');
define('lang_mod_masterfile_lang_form_field_name', 'Language');
# GMD master file
# common
define('lang_mod_masterfile_gmd_alert_name_noempty', 'GMD Code And Name cant be empty');
define('lang_mod_masterfile_gmd_alert_new_add_ok', 'New GMD Data Successfully Save');
define('lang_mod_masterfile_gmd_alert_add_fail', 'GMD Data FAILED to Save. Please Contact System Administrator');
define('lang_mod_masterfile_gmd_alert_update_ok', 'GMD Data Successfully Updated');
define('lang_mod_masterfile_gmd_alert_update_fail', 'GMD Data FAILED to Updated. Please Contact System Administrator');
define('lang_mod_masterfile_gmd_common_edit_info', 'You are going to edit gmd data');
define('lang_mod_masterfile_gmd_common_last_update', 'Last update ');
define('lang_mod_masterfile_gmd_alert_all_delete_ok', 'All Data Successfully Deleted');
define('lang_mod_masterfile_gmd_alert_all_delete_fail', 'Some or All Data NOT deleted successfully!\nPlease contact system administrator');
# form
define('lang_mod_masterfile_gmd_form_field_gmd_code', 'GMD Code');
define('lang_mod_masterfile_gmd_form_field_gmd_name', 'GMD Name');
# Item status master file
# common
define('lang_mod_masterfile_itemstatus_alert_name_noempty', 'Item Status ID and Name cant be empty');
define('lang_mod_masterfile_itemstatus_alert_new_add_ok', 'New Item Status Data Successfully Save');
define('lang_mod_masterfile_itemstatus_alert_add_fail', 'Item Status Data FAILED to Save. Please Contact System Administrator');
define('lang_mod_masterfile_itemstatus_alert_update_ok', 'Item Status Data Successfully Updated');
define('lang_mod_masterfile_itemstatus_alert_update_fail', 'Item Status Data FAILED to Updated. Please Contact System Administrator');
define('lang_mod_masterfile_itemstatus_common_edit_info', 'You are going to edit Item Status data');
define('lang_mod_masterfile_itemstatus_common_last_update', 'Last update ');
define('lang_mod_masterfile_itemstatus_alert_all_delete_ok', 'All Data Successfully Deleted');
define('lang_mod_masterfile_itemstatus_alert_all_delete_fail', 'Some or All Data NOT deleted successfully!\nPlease contact system administrator');
# form
define('lang_mod_masterfile_itemstatus_form_field_code', 'Item Status Code');
define('lang_mod_masterfile_itemstatus_form_field_name', 'Item Status Name');
define('lang_mod_masterfile_itemstatus_form_field_rules', 'Rules');
# location master file
# common
define('lang_mod_masterfile_location_alert_name_noempty', 'Location ID and Name cant be empty');
define('lang_mod_masterfile_location_alert_new_add_ok', 'New Location Data Successfully Save');
define('lang_mod_masterfile_location_alert_add_fail', 'Location Data FAILED to Save. Please Contact System Administrator');
define('lang_mod_masterfile_location_alert_update_ok', 'Location Data Successfully Updated');
define('lang_mod_masterfile_location_alert_update_fail', 'Location Data FAILED to Updated. Please Contact System Administrator');
define('lang_mod_masterfile_location_common_edit_info', 'You are going to edit location data : ');
define('lang_mod_masterfile_location_common_last_update', 'Last update ');
define('lang_mod_masterfile_location_alert_not_delete', 'Below data cant be deleted : \n');
define('lang_mod_masterfile_location_alert_all_delete_ok', 'All Data Successfully Deleted');
define('lang_mod_masterfile_location_alert_all_delete_fail', 'Some or All Data NOT deleted successfully!\nPlease contact system administrator');
define('lang_mod_masterfile_location_alert_has_item', 'Location ({item_name}) still used by {number_items} item(s)');
# form
define('lang_mod_masterfile_location_form_field_code', 'Location Code');
define('lang_mod_masterfile_location_form_field_name', 'Location Name');
# place of publication master file
# common
define('lang_mod_masterfile_place_alert_name_noempty', 'Place Name cant be empty');
define('lang_mod_masterfile_place_alert_new_add_ok', 'New Place Data Successfully Save');
define('lang_mod_masterfile_place_alert_add_fail', 'Place Data FAILED to Save. Please Contact System Administrator');
define('lang_mod_masterfile_place_alert_update_ok', 'Place Data Successfully Updated');
define('lang_mod_masterfile_place_alert_update_fail', 'Place Data FAILED to Updated. Please Contact System Administrator');
define('lang_mod_masterfile_place_common_edit_info', 'You are going to edit place data');
define('lang_mod_masterfile_place_common_last_update', 'Last update ');
define('lang_mod_masterfile_place_alert_all_delete_ok', 'All Data Successfully Deleted');
define('lang_mod_masterfile_place_alert_all_delete_fail', 'Some or All Data NOT deleted successfully!\nPlease contact system administrator');
# form
define('lang_mod_masterfile_place_form_field_name', 'Place Name');
# publisher master file
# common
define('lang_mod_masterfile_publisher_alert_name_noempty', 'Publisher Name cant be empty');
define('lang_mod_masterfile_publisher_alert_new_add_ok', 'New Publisher Data Successfully Save');
define('lang_mod_masterfile_publisher_alert_add_fail', 'Publisher Data FAILED to Save. Please Contact System Administrator');
define('lang_mod_masterfile_publisher_alert_update_ok', 'Publisher Data Successfully Updated');
define('lang_mod_masterfile_publisher_alert_update_fail', 'PUBLISHER Data FAILED to Updated. Please Contact System Administrator');
define('lang_mod_masterfile_publisher_common_edit_info', 'You are going to edit publisher data');
define('lang_mod_masterfile_publisher_common_last_update', 'Last update ');
define('lang_mod_masterfile_publisher_alert_all_delete_ok', 'All Data Successfully Deleted');
define('lang_mod_masterfile_publisher_alert_all_delete_fail', 'Some or All Data NOT deleted successfully!\nPlease contact system administrator');
# form
define('lang_mod_masterfile_publisher_form_field_name', 'Publisher Name');
# supplier master file
# common
define('lang_mod_masterfile_supplier_alert_name_noempty', 'Supplier Name cant be empty');
define('lang_mod_masterfile_supplier_alert_new_add_ok', 'New Supplier Data Successfully Save');
define('lang_mod_masterfile_supplier_alert_add_fail', 'Supplier Data FAILED to Save. Please Contact System Administrator');
define('lang_mod_masterfile_supplier_alert_update_ok', 'Supplier Data Successfully Updated');
define('lang_mod_masterfile_supplier_alert_update_fail', 'Supplier Data FAILED to Updated. Please Contact System Administrator');
define('lang_mod_masterfile_supplier_common_edit_info', 'You are going to edit Supplier data');
define('lang_mod_masterfile_supplier_common_last_update', 'Last update ');
#define('lang_mod_masterfile_supplier_alert_not_delete', 'Below data cant be deleted : \n');
define('lang_mod_masterfile_supplier_alert_all_delete_ok', 'All Data Successfully Deleted');
define('lang_mod_masterfile_supplier_alert_all_delete_fail', 'Some or All Data NOT deleted successfully!\nPlease contact system administrator');
# form
define('lang_mod_masterfile_supplier_form_field_name', 'Supplier Name');
define('lang_mod_masterfile_supplier_form_field_address', 'Address');
define('lang_mod_masterfile_supplier_form_field_contact', 'Contact');
define('lang_mod_masterfile_supplier_form_field_phone', 'Phone Number');
define('lang_mod_masterfile_supplier_form_field_fax', 'Fax Number');
define('lang_mod_masterfile_supplier_form_field_account', 'Account Number');
# topic master file
# common
define('lang_mod_masterfile_topic_alert_name_noempty', 'Subject cant be empty');
define('lang_mod_masterfile_topic_alert_new_add_ok', 'New Subject Data Successfully Save');
define('lang_mod_masterfile_topic_alert_add_fail', 'Subject Data FAILED to Save. Please Contact System Administrator');
define('lang_mod_masterfile_topic_alert_update_ok', 'Subject Data Successfully Updated');
define('lang_mod_masterfile_topic_alert_update_fail', 'Subject Data FAILED to Updated. Please Contact System Administrator');
define('lang_mod_masterfile_topic_common_edit_info', 'You are going to edit Subject data');
define('lang_mod_masterfile_topic_common_last_update', 'Last update ');
define('lang_mod_masterfile_topic_alert_all_delete_ok', 'All Data Successfully Deleted');
define('lang_mod_masterfile_topic_alert_all_delete_fail', 'Some or All Data NOT deleted successfully!\nPlease contact system administrator');
# form
define('lang_mod_masterfile_topic_form_field_name', 'Subject');
# label master file
# common
define('lang_mod_masterfile_label_alert_new_add_ok', 'New Label Data Successfully Save');
define('lang_mod_masterfile_label_alert_add_fail', 'Label Data FAILED to Save. Please Contact System Administrator');
define('lang_mod_masterfile_label_alert_update_ok', 'Label Data Successfully Updated');
define('lang_mod_masterfile_label_alert_update_fail', 'Label Data FAILED to Updated. Please Contact System Administrator');
define('lang_mod_masterfile_label_common_edit_info', 'You are going to edit Label data');
define('lang_mod_masterfile_label_common_last_update', 'Last update ');
define('lang_mod_masterfile_label_alert_all_delete_ok', 'All Data Successfully Deleted');
define('lang_mod_masterfile_label_alert_all_delete_fail', 'Some or All Data NOT deleted successfully!\nPlease contact system administrator');
# form
define('lang_mod_masterfile_label_form_field_label_name', 'Label Name');
define('lang_mod_masterfile_label_form_field_label_desc', 'Label Description');
# frequency
define('lang_mod_masterfile_frequency_alert_new_add_ok', 'New Frequency Data Successfully Save');
define('lang_mod_masterfile_frequency_alert_add_fail', 'Frequency Data FAILED to Save. Please Contact System Administrator');
define('lang_mod_masterfile_frequency_alert_update_ok', 'Frequency Data Successfully Updated');
define('lang_mod_masterfile_frequency_alert_update_fail', 'Frequency Data FAILED to Updated. Please Contact System Administrator');
define('lang_mod_masterfile_frequency_common_edit_info', 'You are going to edit Frequency data');
define('lang_mod_masterfile_frequency_common_last_update', 'Last update ');
define('lang_mod_masterfile_frequency_alert_all_delete_ok', 'All Data Successfully Deleted');
define('lang_mod_masterfile_frequency_alert_all_delete_fail', 'Some or All Data NOT deleted successfully!\nPlease contact system administrator');
# form
define('lang_mod_masterfile_frequency_form_field_frequency_name', 'Frequency');
define('lang_mod_masterfile_frequency_form_field_frequency_time_increment', 'Time Increment');
define('lang_mod_masterfile_frequency_form_field_frequency_unit', 'Time Unit');

/* STOCK TAKE MODULE */
# common
define('lang_mod_stocktake_active_status', 'Currently Active');
define('lang_mod_stocktake_total', 'Total Item Stock Taked');
define('lang_mod_stocktake_lost_total', 'Total Item Lost');
define('lang_mod_stocktake_exists_total', 'Total Item Exists');
define('lang_mod_stocktake_loan_total', 'Total Item On Loan');
define('lang_mod_stocktake_participants', 'Stock Take Participants');
define('lang_mod_stocktake_total_checked', 'Total Checked/Scanned Items');
define('lang_mod_stocktake_finish_confirmation', 'Are you sure to end current stock take proccess? Once it finished there is no way you can rollback this stock take');
define('lang_mod_stocktake_purge_lost', 'Purge Lost Item');
# submenu
define('lang_mod_stocktake', 'Stock Take');
define('lang_mod_stocktake_status', 'Status');
define('lang_mod_stocktake_history', 'Stock Take History');
define('lang_mod_stocktake_history_titletag', 'View Stock Take History');
define('lang_mod_stocktake_current', 'Current Stock Take');
define('lang_mod_stocktake_current_titletag', 'View Current Stock Take Process');
define('lang_mod_stocktake_report', 'Stock Take Report');
define('lang_mod_stocktake_report_titletag', 'View Current Stock Take Report');
define('lang_mod_stocktake_init', 'Initialize');
define('lang_mod_stocktake_init_titletag', 'Initialize New Stock Take Proccess');
define('lang_mod_stocktake_finish', 'Finish Stock Take');
define('lang_mod_stocktake_finish_titletag', 'Finish Current Stock Take Proccess');
define('lang_mod_stocktake_lost', 'Current Lost Item');
define('lang_mod_stocktake_lost_titletag', 'View Lost Item in Current Stock Take Proccess');
define('lang_mod_stocktake_log', 'Stock Take Log');
define('lang_mod_stocktake_log_titletag', 'View Log of Current Stock Take Proccess');
define('lang_mod_stocktake_resync', 'Resynchronize');
define('lang_mod_stocktake_resync_titletag', 'Resynchronize bibliographic data with current stock take');
# initialization
define('lang_mod_stocktake_init_info', 'There is already stock taking proccess running!');
define('lang_mod_stocktake_init_alert_noempty', 'Stock Take Name must be filled!');
define('lang_mod_stocktake_init_alert_started', 'Stock Taking Initialized');
define('lang_mod_stocktake_init_alert_fail_start', 'Stock Taking FAILED to Initialized.\nNo item to stock take!');
define('lang_mod_stocktake_init_button_start', 'Initialize Stock Take');
define('lang_mod_stocktake_init_field_name', 'Stock Take Name');
define('lang_mod_stocktake_init_field_GMD', 'GMD');
define('lang_mod_stocktake_init_field_colltype', 'Collection Type');
define('lang_mod_stocktake_init_field_location', 'Location');
define('lang_mod_stocktake_init_field_site', 'Shelf Location');
define('lang_mod_stocktake_init_field_classification', 'Classification');
define('lang_mod_stocktake_init_field_class_text', 'Separate each class comma sign. Use * for wildcard');
define('lang_mod_stocktake_init_field_option_all', 'ALL');
define('lang_mod_stocktake_init_field_start_date', 'Start Date');
define('lang_mod_stocktake_init_field_end_date', 'End Date');
define('lang_mod_stocktake_init_field_report_file', 'Report');
define('lang_mod_stocktake_init_field_user', 'Initializer');
#report
define('lang_mod_stocktake_report_page_title', 'CURRENT STOCK TAKE REPORT');
define('lang_mod_stocktake_report_not_initialize', 'NO stock taking proccess initialized yet!');
define('lang_mod_stocktake_report_no_process', 'NO stock taking proccess running!');
define('lang_mod_stocktake_alert_process_finish', 'Stock Take Proccess Finished!');

/* REPORTING MODULE */
# submenu
define('lang_mod_report', 'Reporting');
define('lang_mod_report_stat', 'Collection Statistic');
define('lang_mod_report_stat_titletag', 'View Library Collection Statistic');
define('lang_mod_report_loan', 'Loan Report');
define('lang_mod_report_loan_titletag', 'View Library Loan Report');
define('lang_mod_report_member', 'Membership Report');
define('lang_mod_report_member_titletag', 'View Membership Report');
# General Statistic
define('lang_mod_report_stat_page_head', 'Collection Statistic Report');
define('lang_mod_report_stat_table_head', 'Collection Statistic Summary');
define('lang_mod_report_stat_field_title', 'Total Titles');
define('lang_mod_report_stat_field_items', 'Total Items/Copies');
define('lang_mod_report_stat_field_onloan', 'Total Checkout Items');
define('lang_mod_report_stat_field_available', 'Total Items In Library');
define('lang_mod_report_stat_field_by_gmd', 'Total Titles By Medium/GMD');
define('lang_mod_report_stat_field_by_colltype', 'Total Items By Collection Type');
define('lang_mod_report_stat_field_title_topten', '10 Most Popular Titles');
# Loan Statistic
define('lang_mod_report_loan_page_head', 'Loan Report');
define('lang_mod_report_loan_table_head', 'Loan Data Summary');
define('lang_mod_report_loan_field_total', 'Total Loan');
define('lang_mod_report_loan_field_transaction', 'Total Loan Transactions');
define('lang_mod_report_loan_field_perday', 'Transaction Average (Per Day)');
define('lang_mod_report_loan_field_peak', 'Total Peak Transaction');
define('lang_mod_report_loan_field_member_with_loan', 'Members Already Had Loans');
define('lang_mod_report_loan_field_member_no_loan', 'Members Never Have Loans Yet');
define('lang_mod_report_loan_field_overdue', 'Total Overdued Loans');
define('lang_mod_report_loan_field_by_gmd', 'Total Loan By GMD/Medium');
define('lang_mod_report_loan_field_by_colltype', 'Total Loan By Collection Type');
# Member Statistic
define('lang_mod_report_member_page_head', 'Membership Report');
define('lang_mod_report_member_table_head', 'Membership Data Summary');
define('lang_mod_report_member_field_registered', 'Total Registered Members');
define('lang_mod_report_member_field_active', 'Total Active Member');
define('lang_mod_report_member_field_active_topten', '10 most active members');
define('lang_mod_report_member_field_by_type', 'Total Member By Membership Type');
define('lang_mod_report_member_field_expired', 'Total Expired Member');

/* SERIAL CONTROL MODULE */
# submenu
define('lang_mod_serial', 'Serial Control');
define('lang_mod_serial_subscription', 'Subscription');
define('lang_mod_serial_subscription_titletag', 'Manage Subscription');
# subcription menu
define('lang_mod_serial_subscription_add', 'Add New Subscription');
define('lang_mod_serial_subscription_list', 'View Subscriptions');
# kardex menu
# fields
define('lang_mod_serial_field_date_start', 'Subscription Start');
define('lang_mod_serial_field_exemplar', 'Total Exemplar Expected');
define('lang_mod_serial_field_period', 'Period Name');
define('lang_mod_serial_field_notes', 'Subscription Notes');
define('lang_mod_serial_kardex_field_date_expected', 'Date Expected');
define('lang_mod_serial_kardex_field_date_received', 'Date Received');
define('lang_mod_serial_kardex_field_seq_number', 'Seq. Number');
define('lang_mod_serial_kardex_field_notes', 'Catatan');
# messages
define('lang_mod_serial_alert_01', 'Error inserting subscription data, Subscription Date must be filled!');
define('lang_mod_serial_subscription_alert_delete_ok', 'Subscription data successfully deleted');
define('lang_mod_serial_subscription_alert_delete_failed', 'Subscription data FAILED to deleted!');
define('lang_mod_serial_alert_02', 'Kardex data updated!');
define('lang_mod_serial_alert_03', 'Kardex data deleted!');
define('lang_mod_serial_alert_new_added', 'New Subscription Data Successfully Save');
define('lang_mod_serial_alert_fail_to_save', 'Subscription Data FAILED to Save. Please Contact System Administrator');
define('lang_mod_serial_alert_updated', 'Subscription Data Successfully Updated');
define('lang_mod_serial_alert_not_updated', 'Subscription Data FAILED to Updated. Please Contact System Administrator');
define('lang_mod_serial_common_info', 'You are going to edit Subscription data : ');


##### Added 2009-08 #####
# datagrid form
define('lang_sys_common_tblheader_delete', 'DELETE');
define('lang_sys_common_tblheader_edit', 'EDIT');
define('lang_sys_common_tblheader_add', 'Add');
define('lang_sys_common_tblheader_hover_sort', 'Order list by');
define('lang_sys_common_tblheader_hover_sort_asc', 'ascendingly');
define('lang_sys_common_tblheader_hover_sort_desc', 'descendingly');
define('lang_sys_common_tblheader_print_header_part1', 'record(s) found. Currently displaying page');
define('lang_sys_common_tblheader_print_header_part2', 'record each page');
/* BIBLIOGRAPHIC MODULE */
# submenu
define('lang_mod_biblio_tools_common_print_msg1', 'Maximum');
define('lang_mod_biblio_tools_common_print_msg2', 'records can be printed at once. Currently there is');
define('lang_mod_biblio_tools_common_print_msg3', 'in queue waiting to be printed.');
define('lang_mod_biblio_tools_card_generator_print_select', 'Print Selected Data');
define('lang_mod_biblio_tools_card_generator_print_clear', 'Clear Print Queue');
#item
define('lang_mod_biblio_item_common_status_description', 'Loan Status');
define('lang_mod_biblio_item_common_status_onloan', 'On Loan');
define('lang_mod_biblio_item_common_status_returned', 'Returned');
define('lang_mod_biblio_item_common_status_missing', 'Missing');
define('lang_mod_biblio_item_common_status_exists', 'Exists');
# bibliography form fields
define('lang_mod_biblio_field_copies', 'Copies');
define('lang_mod_biblio_field_copies_none', 'None');
define('lang_mod_biblio_field_update', 'Last Update');
define('lang_mod_biblio_field_opt_all', 'All Fields');
define('lang_mod_biblio_field_opt_title', 'Title/Series Title');
define('lang_mod_biblio_field_opt_subject', 'Topics');
define('lang_mod_biblio_field_opt_author', 'Authors');
define('lang_mod_biblio_field_opt_isbn', 'ISBN/ISSN');
define('lang_mod_biblio_field_opt_publisher', 'Publisher');
define('lang_mod_biblio_field_opt_none', 'NONE');
define('lang_mod_biblio_field_frequency_explain', 'Use this for Serial publication');
define('lang_mod_biblio_link_attachment_add', 'Add Attachment');
define('lang_mod_biblio_field_opt_show', 'Show');
define('lang_mod_biblio_field_opt_hide', 'Hide');
define('lang_mod_biblio_field_opt_promotefalse', 'Don\'t Promote');
define('lang_mod_biblio_field_opt_promotetrue', 'Promote');
define('lang_mod_biblio_author_form_title', 'Add Author');
# pop-ups - attachment
define('lang_mod_biblio_attach_alert_typesize', 'Upload FAILED! Forbidden file type or file size too big!');
define('lang_mod_biblio_attach_alert_update_ok', 'File Attachment data updated!');
define('lang_mod_biblio_attach_alert_update_fail', 'File Attachment data FAILED to update!');
define('lang_mod_biblio_attach_alert_added_ok', 'File Attachment uploaded succesfully!');
define('lang_mod_biblio_attach_alert_added_fail', 'File Attachment data FAILED to save!');
define('lang_mod_biblio_attach_alert_removed', 'Attachment removed!');
define('lang_mod_biblio_attach_form_button_upload', 'Upload Now');
define('lang_mod_biblio_attach_form_field_title', 'Title');
define('lang_mod_biblio_attach_form_field_filedir', 'Repo. Directory');
define('lang_mod_biblio_attach_form_field_browse', 'File To Attach');
define('lang_mod_biblio_attach_form_field_url', 'URL');
define('lang_mod_biblio_attach_form_field_description', 'Description');
define('lang_mod_biblio_attach_form_field_access', 'Access');
define('lang_mod_biblio_attach_form_opt_public', 'Public');
define('lang_mod_biblio_attach_form_opt_private', 'Private');
# item form fields
define('lang_mod_biblio_item_field_opt_available', 'Available');
define('lang_mod_biblio_item_field_opt_buy', 'Buy');
define('lang_mod_biblio_item_field_opt_grant', 'Prize/Grant');
define('lang_mod_biblio_item_field_opt_none', 'None');
# Simbio table
define('lang_simbio_nodata', 'No Data');
# z3950
define('lang_mod_biblio_tools_z3950_connection', '* Please make sure you have working Internet connection.');
# circulation
define('lang_mod_circ_tblheader_callno', 'Call Number');
/* MEMBERSHIP MODULE */
define('lang_mod_membership_field_opt_autoset', 'Auto Set');
define('lang_mod_membership_field_opt_yes', 'Yes');
define('lang_mod_membership_extend_button', 'Extend Selected Member(s)');
define('lang_mod_membership_extend_alert_confirm', 'Are you sure to EXTEND membership for selected members?');
define('lang_mod_membership_extend_success', 'members extended!');
/* COMMON */
define('lang_sys_common_query_msg1', 'Query took');
define('lang_sys_common_query_msg2', 'second(s) to complete');
define('lang_sys_common_day', 'Day');
define('lang_sys_common_week', 'Week');
define('lang_sys_common_all', 'All');
define('lang_sys_common_month_short_01', 'Jan');
define('lang_sys_common_month_short_02', 'Feb');
define('lang_sys_common_month_short_03', 'Mar');
define('lang_sys_common_month_short_04', 'Apr');
define('lang_sys_common_month_short_05', 'May');
define('lang_sys_common_month_short_06', 'Jun');
define('lang_sys_common_month_short_07', 'Jul');
define('lang_sys_common_month_short_08', 'Aug');
define('lang_sys_common_month_short_09', 'Sep');
define('lang_sys_common_month_short_10', 'Oct');
define('lang_sys_common_month_short_11', 'Nov');
define('lang_sys_common_month_short_12', 'Dec');
/* REPORTING MODULE (especially "Other Reports"; and reports in other modules) */
# common
define('lang_mod_reporting_form_generic_header', 'Report Filter');
define('lang_mod_reporting_form_button_filter_apply', 'Apply Filter');
define('lang_mod_reporting_form_button_filter_options_show', 'Show More Filter Options');
define('lang_mod_reporting_form_button_filter_options_hide', 'Hide Filter Options');
define('lang_mod_reporting_form_button_print', 'Print Current Page');
# submenu (other)
define('lang_mod_report_other', 'Other Reports');
define('lang_mod_report_other_recapitulation', 'Custom Recapitulations');
define('lang_mod_report_other_recapitulation_titletag', 'Title and Collection recapitulation based on classification and others');
define('lang_mod_report_other_titles', 'Title List');
define('lang_mod_report_other_titles_titletag', 'List of bibliographic titles');
define('lang_mod_report_other_itemtitles', 'Items Title List');
define('lang_mod_report_other_itemtitles_titletag', 'List of collection/items');
define('lang_mod_report_other_itemusage', 'Items Usage Statistics');
define('lang_mod_report_other_itemusage_titletag', 'List of Collection/items usage statistic');
define('lang_mod_report_other_loansclass', 'Loans by Classification');
define('lang_mod_report_other_loansclass_titletag', 'Loan statistic by classification');
define('lang_mod_report_other_memberlist', 'Member List');
define('lang_mod_report_other_memberlist_titletag', 'List of library member/patron');
define('lang_mod_report_other_loanmember', 'Loan List by Member');
define('lang_mod_report_other_loanmember_titletag', 'List of loan by each member');
define('lang_mod_report_other_staffactivity', 'Staff Activity');
define('lang_mod_report_other_staffactivity_titletag', 'Staff activity log recapitulation');
# Report - common
define('lang_mod_report_common_form_titisbn', 'Title/ISBN');
define('lang_mod_report_common_form_recspage', 'Record each page');
define('lang_mod_report_common_form_recspage_help', 'Set between 20 and 200');
define('lang_mod_report_common_form_select_help', 'Press Ctrl and click to select multiple entries');
# Report - Recapitulation
define('lang_mod_report_recapitulation_form_recapby', 'Recap By');
define('lang_mod_report_recapitulation_print_header', 'Title and Collection Recap by');
# Report - Titles
define('lang_mod_report_recapitulation_form_author', 'Author');
# Report - Loans by Classification
define('lang_mod_report_loansclass_form_opt_class0', '0 Classes');
define('lang_mod_report_loansclass_form_opt_class1', '1 Classes');
define('lang_mod_report_loansclass_form_opt_class2', '2 Classes');
define('lang_mod_report_loansclass_form_opt_class2x', '2X Classes (Islamic Related)');
define('lang_mod_report_loansclass_form_opt_class3', '3 Classes');
define('lang_mod_report_loansclass_form_opt_class4', '4 Classes');
define('lang_mod_report_loansclass_form_opt_class5', '5 Classes');
define('lang_mod_report_loansclass_form_opt_class6', '6 Classes');
define('lang_mod_report_loansclass_form_opt_class7', '7 Classes');
define('lang_mod_report_loansclass_form_opt_class8', '8 Classes');
define('lang_mod_report_loansclass_form_opt_class9', '9 Classes');
define('lang_mod_report_loansclass_form_opt_classx', 'NON Decimal Classes');
# Report - Member List
define('lang_mod_report_memberlist_form_regfrom', 'Register Date From');
define('lang_mod_report_memberlist_form_regto', 'Register Date Until');
# Report - Loan List by Member (and lang_mod_circ_transaction_history)
define('lang_mod_report_loanmember_form_loanfrom', 'Loan Date From');
define('lang_mod_report_loanmember_form_loanto', 'Loan Date Until');
# Report - Overdued List
define('lang_mod_report_overdues_table_overdue', 'Overdue');
define('lang_mod_report_overdues_table_overdue_days', 'day(s)');
# Report - Staff Activity
define('lang_mod_report_staffactivity_form_activityfrom', 'Activity Date From');
define('lang_mod_report_staffactivity_form_activityto', 'Activity Date Until');
define('lang_mod_report_staffactivity_tblheader_bibliography', 'Bibliography Data Entry');
define('lang_mod_report_staffactivity_tblheader_items', 'Item Data Entry');
define('lang_mod_report_staffactivity_tblheader_members', 'Member Data Entry');
define('lang_mod_report_staffactivity_tblheader_circulation', 'Circulation');
# Report - Reservation
define('lang_mod_report_reservation_form_reservefrom', 'Reserve Date From');
define('lang_mod_report_reservation_form_reserveto', 'Reserve Date Until');
/* STOCK TAKE MODULE */
# submenu
define('lang_mod_stocktake_upload', 'Upload List');
define('lang_mod_stocktake_upload_titletag', 'Upload List in text file');
# common
define('lang_mod_stocktake_tblheader_lost', 'Lost Items');
define('lang_mod_stocktake_tblheader_exists', 'Exists Items');
define('lang_mod_stocktake_tblheader_loan', 'On Loan Items');
define('lang_mod_stocktake_tblfield_classes', ' classes');
define('lang_mod_stocktake_participants_checked', 'items already checked');
define('lang_mod_stocktake_field_opt_yes', 'Yes');
define('lang_mod_stocktake_tblfield_none', 'None');
define('lang_mod_stocktake_resync_info', 'Re-synchronize will only update current stock take\'s item data. It wont update
    any new bibliographic or item data that were inserted in the middle of stock take proccess');
define('lang_mod_stocktake_resync_button', 'Resynchronize Now');
# Current
define('lang_mod_stocktake_current_welcome', 'STOCK TAKE PROCCESS - Insert Item Code/Barcode with keyboard or barcode scanner');
define('lang_mod_stocktake_current_welcome_alt', 'Current Missing/Lost Items');
define('lang_mod_stocktake_current_form_list', 'List');
define('lang_mod_stocktake_current_form_opt_user_cur', 'Current User Only');
define('lang_mod_stocktake_current_form_opt_user_all', 'All User');
define('lang_mod_stocktake_current_form_button_change', 'Change Status');
# Upload
define('lang_mod_stocktake_upload_welcome', 'STOCK TAKE UPLOAD - Upload a plain text file (.txt) containing list of Item Code to stock take. Each Item Code separated by line.');
define('lang_mod_stocktake_upload_form_file', ' File');
define('lang_mod_stocktake_upload_form_button_upload', ' Upload File');
define('lang_mod_stocktake_upload_alert_success', 'Succesfully upload stock take file ');
define('lang_mod_stocktake_upload_alert_success_info', ' item codes scanned!');
/* SERIAL CONTROL MODULE */
# subcription menu
define('lang_mod_serial_subscription_header', 'Serial Title');
define('lang_mod_serial_subscription_close', 'CLOSE');
define('lang_mod_serial_subscription_kardex', 'View/Edit Kardex Detail');
define('lang_mod_serial_subscription_kardex_msg', 'Kardex Detail for subscription');
/* OPAC */
define('lang_opac_form_opt_gmd', 'All GMD/Media');
define('lang_opac_form_opt_collection', 'All Collections');
define('lang_opac_form_opt_location', 'All Locations');
define('lang_opac_rec_detail_attachment_none', 'No Attachment');
define('lang_opac_rec_detail_status_onloan', 'Currently On Loan (Due on ');
define('lang_opac_rec_detail_status_unavailable', 'Unavailable');
define('lang_opac_rec_detail_status_available', 'Available');
?>
