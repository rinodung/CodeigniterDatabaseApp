<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
*
*/


//shared items across the entire app
$lang['shared_click_to_expand'] = "Click to expand";
$lang['shared_html_editor_please'] = "Advanced editor (incl <b>file uploads</b>)";



//login screen
$lang['login_email_label'] = "Your email";
$lang['login_pw_label'] = "Your password";
$lang['login_remember_me'] = "Remember me";
$lang['login_button'] = "Log me in please";
$lang['login_forgot_your_password'] = "Forgot your password?";


//forgot password screen
$lang['forgotpassword_heading'] = "Please enter your Email so we can send you an email to reset your password.";
$lang['forgotpassword_email_label'] = "Your email";
$lang['forgotpassword_button'] = "Send reset email";


//reset password
$lang['resetpassword_label_new_password'] = "Type your new password";
$lang['resetpassword_label_new_password_confirm'] = "Confirm your password";
$lang['resetpassword_button'] = "Reset password";


//navigation
$lang['menu_databases'] = 'Databases';
$lang['menu_manage_databases'] = 'Manage Databases';
$lang['menu_users'] = 'Users';
$lang['menu_roles_permissions'] = 'Roles/Permissions';
$lang['menu_files'] = 'Files';
$lang['menu_hi'] = 'Hi';
$lang['menu_my_account'] = 'My Account';
$lang['menu_logout'] = 'Logout';


//dashboard
$lang['dashboard_heading'] = "Choose a database to work on:";
$lang['dashboard_number_of_tables'] = "Number of tables:";
$lang['dashboard_work_on_this_database'] = "Work on this database";

$lang['dashboard_nodbs1_heading'] = "Oh no! There aren't any databases to work with!";
$lang['dashboard_nodbs1_message'] = "Databased is not currently handling any databases. If this is a new installation, please proceed to the Database section and activate one or more existing MySQL databases or create one or more databases from scratch.";
$lang['dashboard_nodbs1_button'] = "Manage Databases";

$lang['dashboard_nodbs2_heading'] = "Oh no! There aren't any databases to work with!";
$lang['dashboard_nodbs2_message'] = "Databased is not currently handling any databases or you haven't been given access to any databases. Please contact of the administrators or contact";


//database admin
$lang['admindb_error_heading'] = "Ouch!";
$lang['admindb_success_heading'] = "Joy!";

$lang['admindb_tab_all_databases'] = "All Databases";
$lang['admindb_tab_all_create_database'] = "Create Database";
$lang['admindb_heading1'] = "All Databases";
$lang['admindb_heading2'] = "Create Database";

$lang['admindb_enabledisable1_heading'] = "Enable / disable";
$lang['admindb_enabledisable1_message'] = "To enable this database in <b>Databased</b>, please make sure the checkbox below is checked. Disabling the database means it won't be available in <b>Databased</b>, however all your data will remain intact and the database can be re-enabled at any moment.";
$lang['admindb_enable_label'] = "Enable database in <b>Databased</b>";
$lang['admindb_enabledisable2_heading'] = "Ouch!";
$lang['admindb_enabledisable2_message'] = "Unfortunately, this database can not be enabled in <b>Databased</b> right now. This is probably due not one or more tables missing a primary key or the primary key being set on a wrong column.";
$lang['admindb_deletedb_label'] = "Permanently delete database";

$lang['admindb_enabled_label'] = "Enabled";
$lang['admindb_disabled_label'] = "Disabled";
$lang['admindb_disabledand_label'] = "Disabled and can't be enabled";

$lang['admindb_newdb_name'] = "Name";
$lang['admindb_newdb_database_name'] = "Database name";
$lang['admindb_newdb_label'] = "Database name *";
$lang['admindb_newdb_enabled?'] = "Enable in <b>Databased</b>?";
$lang['admindb_newdb_button'] = "Create database";


//my account
$lang['myaccount_error_header'] = "Ouch!";
$lang['myaccount_success_header'] = "Joy!";
$lang['myaccount_tab_my_profile'] = "My Profile";
$lang['myaccount_tab_more'] = "More";

$lang['myaccount_heading1'] = "My Profile";

$lang['myaccount_email'] = "Email";
$lang['myaccount_email_label'] = "Email";
$lang['myaccount_password'] = "Password";
$lang['myaccount_password_label'] = "Password";
$lang['myaccount_button_userpass'] = "Update username / password";

$lang['myaccount_firstname'] = "First name";
$lang['myaccount_firstname_label'] = "First name";
$lang['myaccount_lastname'] = "Last name";
$lang['myaccount_lastname_label'] = "Last name";
$lang['myaccount_company'] = "Company";
$lang['myaccount_company_label'] = "Company";
$lang['myaccount_phone'] = "Phone";
$lang['myaccount_phone_label'] = "Phone number";
$lang['myaccount_userrole'] = "User role";
$lang['myaccount_button_updateprofile'] = "Update profile";

$lang['myaccount_moreactions_header'] = "More actions for this user";


//revisions: cell
$lang['revisionscell_field'] = "Field:";
$lang['revisionscell_date'] = "Date:";
$lang['revisionscell_revision'] = "Revision:";



//roles
$lang['roles_databased_roles'] = "<b>Databased</b> roles";
$lang['roles_empty_message'] = "Seem a bit empty up there? Click the button below to add a role.";
$lang['roles_create_button'] = "Create New Role";

$lang['roles_tab_database_permissions'] = "Database Permissions";
$lang['roles_tab_other'] = "Other";

$lang['roles_heading1'] = "Configure database and table permissions";

$lang['roles_admin_message_heading'] = "Please note";
$lang['roles_admin_message'] = "The <b>Administrator</b> role always has access to every database and table. This can not be changed. To limit users' access, please create separate roles for these users.";

$lang['roles_permission'] = "Permission";
$lang['roles_create_tables_within_this_database'] = "Create tables within this database";
$lang['roles_delete_tables_within_this_database'] = "Delete tables within this database";

$lang['roles_table'] = "Table";

$lang['roles_read_records_from_this_table'] = "Read records from this table";
$lang['roles_delete_records_from_this_table'] = "Delete records from this table";
$lang['roles_insert_records_into_this_table'] = "Insert records into this table";
$lang['roles_update_records_within_this_table'] = "Update records within this table";
$lang['roles_addeditremove_columns_within_this_table'] = "Add/edit/remove columns within this table";
$lang['roles_users_can_access_only_their_own_records'] = "Users can access only their own records";

$lang['roles_button_save_permissions'] = "Save Permissions";

$lang['roles_heading2'] = "Configure other details for this role";

$lang['roles_role_name'] = "Role name";
$lang['roles_role_name_label'] = "Role name *";
$lang['roles_description'] = "Description";
$lang['roles_description_label'] = "Please provide a description here";
$lang['roles_allow_user_administration?'] = "Allow user administration?";
$lang['roles_set_as_default_role?'] = "Set as default role?";
$lang['roles_button_update_role'] = "Update Role";

$lang['roles_delete_message_heading'] = "Delete this user role";
$lang['roles_delete_message1'] = "Deleting this, or any other user role, means that users who are currently assigned this role, will no longer have ANY ACCESS to ANY DATA. You will need to manually assign another role to these users.";
$lang['roles_delete_message_confirm'] = "I understand, please delete this role";
$lang['roles_delete_message2'] = "You can not delete the current DEFAULT role.";
$lang['roles_delete_message3'] = "Before deleting any user role, you will need to assign one role as the DEFAULT role. This way we know what role to assign to users when their current role is being deleted.";

$lang['roles_popup_heading'] = "Create new role";
$lang['roles_popup_role_name'] = "Role name *";
$lang['roles_popup_description'] = "Description";
$lang['roles_popup_allow_user_administration'] = "Allow user administration?";
$lang['roles_popup_set_as_default'] = "Set as default role?";
$lang['roles_popup_heading2'] = "Configure database and table permissions";

$lang['roles_popup_button_savenewrole'] = "Save New Role";
$lang['roles_popup_button_cancel'] = "Cancel";


//data table view
$lang['table_error_heading'] = "Ouch!";
$lang['table_success_heading'] = "Joy!";

$lang['table_tab_table_data'] = "Table Data";
$lang['table_tab_table_columns'] = "Table Columns";
$lang['table_tab_table_notes'] = "Table Notes";
$lang['table_tab_more'] = "More";

$lang['table_button_newrecord'] = "Create New Record";
$lang['table_button_importdata'] = "Import Data";

$lang['table_search_placeholder'] = "Search table";
$lang['table_search_more_options'] = "More options";
$lang['table_search_using_advanced'] = "Using advanced search items";
$lang['table_search_reset_search'] = "Reset search";

$lang['table_search_advanced_heading'] = "Advanced search panel";
$lang['table_search_advanced_hide'] = "Hide";

$lang['table_search_search_item'] = "Search item";
$lang['table_search_toggle_visibility'] = "toggle visibility";
$lang['table_search_choose_column'] = "Choose column";

$lang['table_search_choose_operator'] = "Choose operator";
$lang['table_search_equals'] = "Equals";
$lang['table_search_does_not_equal'] = "Does not equal";
$lang['table_search_contains'] = "Contains";
$lang['table_search_does_not_contain'] = "Does not contain";
$lang['table_search_less_then'] = "Less then (&lt;)";
$lang['table_search_greater_then'] = "Greater then (&gt;)";
$lang['table_search_equals_or_less_then'] = "Equals or less then (&lt;=)";
$lang['table_search_equals_or_greater'] = "Equals or greater (&gt;=)";

$lang['table_search_remove_item'] = "Remove item";

$lang['table_search_apply_search_items'] = "Apply search items";
$lang['table_search_clear_search'] = "Clear search";
$lang['table_search_add_search_item'] = "Add search item";

$lang['table_column_actions'] = "actions";

$lang['table_error_noprimkey_heading'] = "Error: no primary key is set";
$lang['table_error_noprimkey_message'] = "It appears there no primary key set on this table. For Databased to function properly, you will need to define a primary key.";

$lang['table_error_notables_heading'] = "Error: no tables in database";
$lang['table_error_notables_message'] = "It appears there are not tables in this database. Click click the green button at the bottom of the page to start creating tables.";

$lang['table_columns_message_heading'] = "Important!";
$lang['table_columns_message'] = "Choose which columns you would like to include in your data view. Once finished, click the button below to reload the data view and apply the selected columns.";
$lang['table_columns_reload_view'] = "Reload data view";
$lang['table_columns_create_new_column'] = "Create new column";

$lang['table_columns_table_field_name'] = "Field name";
$lang['table_columns_table_column_type'] = "Column Type";
$lang['table_columns_table_index'] = "Index";
$lang['table_columns_table_actions'] = "Actions";
$lang['table_columns_table_type_number'] = "Number";
$lang['table_columns_table_type_decimal'] = "Decimal";
$lang['table_columns_table_type_small_text'] = "Small text";
$lang['table_columns_table_type_big_text'] = "Big text";
$lang['table_columns_table_type_file'] = "File";
$lang['table_columns_table_type_date'] = "Date";
$lang['table_columns_table_type_select'] = "Select";

$lang['table_columns_table_primary_key'] = "primary key";
$lang['table_columns_table_unique_index'] = "unique index";
$lang['table_columns_table_regular_index'] = "regular index";

$lang['table_columns_table_button_edit'] = "Edit";
$lang['table_columns_table_button_delete'] = "Delete";

$lang['table_notes_heading'] = "Create a new note:";
$lang['table_notes_newnote_placeholder'] = "There is where you start typing your new note :)";
$lang['table_notes_newnote_button'] = "Save note";

$lang['table_notes_button_edit'] = "Edit";
$lang['table_notes_button_delete'] = "Delete";
$lang['table_notes_button_savenote'] = "Save note";
$lang['table_notes_button_cancel'] = "Cancel";

$lang['table_more_delete_heading'] = "Delete this table";
$lang['table_more_delete_message'] = "To permanently delete this table, click the button below. Please note that this will result in all data, including meta data being permanently deleted. The only way to undo this later, is by restoring a backup of the database.";
$lang['table_more_delete_button'] = "Permanently delete table";

$lang['table_more_table_name'] = "Table name";
$lang['table_more_table_label'] = "Table name";
$lang['table_more_table_update_button'] = "Update table";

$lang['table_bottom_tables'] = "TABLES";

$lang['table_popup_cell_tab_cell_data'] = "Data";
$lang['table_popup_cell_tab_cell_revisions'] = "Revisions";
$lang['table_popup_cell_tab_column_notes'] = "(Field)Notes";

$lang['table_popup_cell_message_connected'] = "This column is connected to the table: <b>%s</b>, displaying values from column: <b>%s</b>.";
$lang['table_popup_cell_message_index'] = "This column set as the following index type: <b class='text-danger'>%s</b>. Be careful with updating this column!";
$lang['table_popup_cell_message_autoincrement'] = "This column is set to \"<b>auto_increment</b>\" and therefor can not be updated.";

$lang['table_popup_cell_revisions_date'] = "Date";
$lang['table_popup_cell_revisions_revision'] = "Revision";
$lang['table_popup_cell_revisions_restore_button'] = "Restore";

$lang['table_popup_cell_notes_heading'] = "Create a new note:";
$lang['table_popup_cell_notes_newnote_placeholder'] = "There is where you start typing your new note :)";
$lang['table_popup_cell_notes_on'] = "on";
$lang['table_popup_cell_notes_by'] = "by";
$lang['table_popup_cell_notes_button_edit'] = "Edit";
$lang['table_popup_cell_notes_button_delete'] = "Delete";
$lang['table_popup_cell_notes_button_savenote'] = "Save note";
$lang['table_popup_cell_notes_button_cancel'] = "Cancel";

$lang['table_popup_cell_button_add_new_note'] = "Add New Note";
$lang['table_popup_cell_button_update_data'] = "Update Data";
$lang['table_popup_cell_button_close_window'] = "Close Window";

$lang['table_popup_column_edit_column'] = "Edit column:";
$lang['table_popup_column_tab_column_details'] = "Column Details";
$lang['table_popup_column_tab_retrictions'] = "Restrictions";
$lang['table_popup_column_tab_notes'] = "Notes";

$lang['table_popup_column_column_name'] = "Column name:";
$lang['table_popup_column_column_name_label'] = "Column name *";
$lang['table_popup_column_column_type'] = "Column type:";
$lang['table_popup_column_column_type_choose'] = "Choose a column type";
$lang['table_popup_column_column_type_number'] = "Number (0, 1, 2, 3, etc.)";
$lang['table_popup_column_column_type_decimal'] = "Decimals (0.34, 5.784, etc)";
$lang['table_popup_column_column_type_small_text'] = "Small text (255 characters or less)";
$lang['table_popup_column_column_type_large_text'] = "Large text (more then 255 characters)";
$lang['table_popup_column_column_type_date'] = "Date (YYYY-MM-DD)";
$lang['table_popup_column_column_type_select'] = "Select (choose from given options)";
$lang['table_popup_column_column_type_blob'] = "Binary objects (files or images)";
$lang['table_popup_column_options'] = "Options:";
$lang['table_popup_column_options_label'] = "Please enter one option per row";
$lang['table_popup_column_column_default_value'] = "Default value:";
$lang['table_popup_column_column_default_value_label'] = "Default value";
$lang['table_popup_column_column_index'] = "Index:";
$lang['table_popup_column_column_index_label'] = "Index?";
$lang['table_popup_column_column_index_no_index'] = "No index please";
$lang['table_popup_column_column_index_primary_key'] = "Primary key";
$lang['table_popup_column_column_index_unique'] = "Unique";
$lang['table_popup_column_column_index_index'] = "Index (regular non-unique index)";
$lang['table_popup_column_column_position'] = "Column position:";
$lang['table_popup_column_column_position_insert'] = "Insert into table...";
$lang['table_popup_column_column_position_at_front'] = "At the front";
$lang['table_popup_column_column_position_at_end'] = "At the end";
$lang['table_popup_column_column_position_after'] = "After";

$lang['table_popup_column_connection_warning_heading'] = "Warning";
$lang['table_popup_column_connection_warning1'] = "By connecting this field to another table, <b>Databased</b> might need to modify this column where it finds invalid values.";
$lang['table_popup_column_connection_warning2'] = "By connecting this column to another table, this column can only hold values from the selected table > column (Databased will automatically generate the drop down select for these values).";

$lang['table_popup_column_connect_to'] = "Connect to:";
$lang['table_popup_column_connect_to_none'] = "No connection...";

$lang['table_popup_column_retrictions_message_heading'] = "Column restrictions";
$lang['table_popup_column_retrictions_message'] = "There are a variety of restrictions you set on each column. To learn more about the available restrictions, please click the button below:";
$lang['table_popup_column_retrictions_message_button'] = "Available restrictions";
$lang['table_popup_column_retrictions_restriction'] = "Restriction";
$lang['table_popup_column_retrictions_restriction_select'] = "Select a restriction";
$lang['table_popup_column_retrictions_restriction_required'] = "Required";
$lang['table_popup_column_retrictions_restriction_min_length'] = "min_length";
$lang['table_popup_column_retrictions_restriction_max_length'] = "max_length";
$lang['table_popup_column_retrictions_restriction_exact_length'] = "exact_length";
$lang['table_popup_column_retrictions_restriction_greater_than'] = "greater_than";
$lang['table_popup_column_retrictions_restriction_less_than'] = "less_than";
$lang['table_popup_column_retrictions_restriction_alpha'] = "alpha";
$lang['table_popup_column_retrictions_restriction_alpha_numeric'] = "alpha_numeric";
$lang['table_popup_column_retrictions_restriction_alpha_dash'] = "alpha_dash";
$lang['table_popup_column_retrictions_restriction_numeric'] = "numeric";
$lang['table_popup_column_retrictions_restriction_integer'] = "integer";
$lang['table_popup_column_retrictions_restriction_is_natural'] = "is_natural";
$lang['table_popup_column_retrictions_restriction_is_natural_no_zero'] = "is_natural_no_zero";
$lang['table_popup_column_retrictions_restriction_valid_email'] = "valid_email";
$lang['table_popup_column_retrictions_restriction_valid_emails'] = "valid_emails";
$lang['table_popup_column_retrictions_restriction_valid_ip'] = "valid_ip";

$lang['table_popup_column_retrictions_value'] = "Value:";
$lang['table_popup_column_retrictions_button_remove'] = "Remove Restriction";

$lang['table_popup_column_retrictions_add_restriction'] = "Add another restriction";

$lang['table_popup_column_notes_headingnew'] = "Create a new note:";

$lang['table_popup_column_notes_button_addnewnote'] = "Add New Note";
$lang['table_popup_column_notes_button_updatecolumn'] = "Update Column";
$lang['table_popup_column_notes_button_closewindow'] = "Close Window";

$lang['table_popup_import_heading'] = "Import Data";
$lang['table_popup_import_message1'] = "Use the form below to import a CSV file from your computer. Importing CSV files can be tricky, please make sure that:";
$lang['table_popup_import_message2'] = "<li>The number of fields per row in your CSV files matches with the number of columns in the Databased table.</li>
<li>The values in the primary key fields in your CSV file are unique. If Databased detects primary key values which already exist in your Databased table, the import will fail.</li>";
$lang['table_popup_import_select_file'] = "Select file";
$lang['table_popup_import_change'] = "Change";
$lang['table_popup_import_remove'] = "Remove";
$lang['table_popup_import_advanced_options'] = "Advanced options";
$lang['table_popup_import_columns_separated_by'] = "Columns separated by (default is ','):";
$lang['table_popup_import_columns_enclosed_by'] = "Columns enclosed by (single character, default is '\"'):";

$lang['table_popup_import_button_importdata'] = "Import Data";
$lang['table_popup_import_button_closewindow'] = "Close Window";


$lang['table_popup_newcolumn_heading'] = "Add Column";
$lang['table_popup_newcolumn_tab_column_details'] = "Column details";
$lang['table_popup_newcolumn_tab_column_restrictions'] = "Restrictions";

$lang['table_popup_newcolumn_button_addcolumn'] = "Add column";
$lang['table_popup_newcolumn_button_closewindow'] = "Close Window";

$lang['table_popup_newrecord_heading'] = "New Record";
$lang['table_popup_newrecord_button_createrecord'] = "Create Record";
$lang['table_popup_newrecord_button_cancel'] = "Cancel";


$lang['table_popup_newtable_heading'] = "Create Table";
$lang['table_popup_newtable_tab_buildtable'] = "Build Table";
$lang['table_popup_newtable_tab_importdata'] = "Import Data";
$lang['table_popup_newtable_table_name'] = "Table name:";
$lang['table_popup_newtable_table_name_label'] = "Table name *";
$lang['table_popup_newtable_table_columns'] = "Columns:";
$lang['table_popup_newtable_table_column'] = "Column";
$lang['table_popup_newtable_table_column_name_label'] = "Column name *";

$lang['table_popup_newtable_column_remove'] = "remove";
$lang['table_popup_newtable_column_column'] = "Column";
$lang['table_popup_newtable_column_primary_message'] = "The first column of your new table will automatically be setup as the primary key of the new table. We suggest you also set this column to \"auto-increment\".";
$lang['table_popup_newtable_column_autoincrement?'] = "Set column to \"auto-increment\"?";

$lang['table_popup_newtable_column_add_column'] = "Add Another Column";
$lang['table_popup_newtable_permissions'] = "Permissions:";
$lang['table_popup_newtable_keep_private'] = "Keep this table private (only you + admins will have access)";
$lang['table_popup_newtable_share_with_group'] = "Share with my group (%s)";
$lang['table_popup_newtable_share_with_all'] = "Share with everyone";

$lang['table_popup_newtable_import_message'] = "Use the form below to import a CSV file from your computer. <b>Databased</b> will turn this file into a table after uploading it.";
$lang['table_popup_newtable_import_table_name_label'] = "Table name *";
$lang['table_popup_newtable_import_first_row'] = "First row contains column names";

$lang['table_popup_newtable_button_addtable'] = "Add Table";
$lang['table_popup_newtable_button_import'] = "Import file and create table";
$lang['table_popup_newtable_button_closewindow'] = "Close Window";

$lang['table_popup_record_tab_recorddata'] = "Record Data";
$lang['table_popup_record_tab_recordrevisions'] = "Record Revisions";
$lang['table_popup_record_tab_recordnotes'] = "Record Notes";

$lang['table_popup_record_revisions_fields'] = "field(s)";
$lang['table_popup_record_revisions_field'] = "Field";
$lang['table_popup_record_revisions_value'] = "Value";
$lang['table_popup_record_revisions_button_restore'] = "Restore selected fields";

$lang['table_popup_record_button_addnote'] = "Add New Note";
$lang['table_popup_record_button_update'] = "Update Record";
$lang['table_popup_record_button_closewindow'] = "Close Window";


//USERS
$lang['users_databased_users'] = "<b>Databased</b> users";
$lang['users_empty_message'] = "Seem a bit empty up there? Click the button below to add a new user.";
$lang['users_button_newuser'] = "Create New User";

$lang['users_error_heading'] = "Ouch!";
$lang['users_success_heading'] = "Joy!";

$lang['users_tab_userprofile'] = "User Profile";
$lang['users_tab_more'] = "More";

$lang['users_user_profile_heading'] = "User Profile";
$lang['users_user_profile_email'] = "Email";
$lang['users_user_profile_email_label'] = "Email *";
$lang['users_user_profile_password'] = "Password";
$lang['users_user_profile_password_label'] = "Password *";
$lang['users_user_profile_button_update'] = "Update username / password";

$lang['users_user_profile_firstname'] = "First name";
$lang['users_user_profile_firstname_label'] = "First name";
$lang['users_user_profile_lastname'] = "Last name";
$lang['users_user_profile_lastname_label'] = "Last name";
$lang['users_user_profile_company'] = "Company";
$lang['users_user_profile_company_label'] = "Company";
$lang['users_user_profile_phone'] = "Phone";
$lang['users_user_profile_phone_label'] = "Phone number";
$lang['users_user_profile_user_role'] = "User role";
$lang['users_user_profile_user_role_choose'] = "Choose a user role";
$lang['users_user_profile_button_update'] = "Update Profile";

$lang['users_user_more_actions_heading'] = "More actions for this user";
$lang['users_user_more_actions_delete_heading'] = "Delete this user (%s %s)";
$lang['users_user_more_actions_delete_message'] = "Deleting this, or any other user, will result in this user no longer being able to access any data and that all his or her associated data (like notes created by this user) will be permanently deleted.";
$lang['users_user_more_actions_button_delete'] = "I understand, please delete this user";

$lang['users_user_popup_heading'] = "Create new user";
$lang['users_user_popup_first_name_label'] = "First name *";
$lang['users_user_popup_last_name_label'] = "Last name *";
$lang['users_user_popup_email_label'] = "Email *";
$lang['users_user_popup_password_label'] = "Password *";
$lang['users_user_popup_company_label'] = "Company";
$lang['users_user_popup_phone_label'] = "Phone";
$lang['users_user_popup_choose_role'] = "Choose a user role *";

$lang['users_user_popup_button_createuser'] = "Create User";
$lang['users_user_popup_button_cancel'] = "Cancel";

$lang['files_message_no_files'] = "There are currently no files/images uploaded in <b>Databased</b>. To upload files or images, open up a cell or record and activate the advanced editor; this will allow you to upload files and images. <b>Make sure the folder /uploads has write permissions (to be save, set it to 777)</b>";
$lang['files_error_heading'] = "Oh no!";
$lang['files_success_heading'] = "Success!";
$lang['files_nr_of_files'] = "Number of files:";

$lang['files_table_heading_name'] = "Name";
$lang['files_table_heading_date'] = "Date";
$lang['files_table_heading_size'] = "Size";
$lang['files_table_heading_actions'] = "Actions";
$lang['files_table_bytes'] = "bytes";
$lang['files_button_delete'] = "Delete Selected";



//MESSAGES IN CONTROLLERS

//account.php
$lang['account_update_login_no_permission'] = "<h1>You don't have permission to do this.</h1>";
$lang['account_update_login_success_message'] = "The email address / password were updated successfully! Yeah!";

$lang['account_update_no_permission'] = "<h1>You don't have permission to do this.</h1>";
$lang['account_update_success_message'] = "The profile details were successfully updated. Yeah!";


//admin.php
$lang['admin_enabledb_error1_heading'] = "Ouch!";
$lang['admin_enabledb_error1'] = "Some database connection details are missing. Please reload the page and try again.";
$lang['admin_enabledb_error2_heading'] = "Ouch!";
$lang['admin_enabledb_error2'] = "You need to be an admin to do this.";
$lang['admin_enabledb_error3_heading'] = "Ouch!";
$lang['admin_enabledb_error3'] = "The database you're trying to enable seems to have some issues; most likely not all tables have a primary key set.";
$lang['admin_enabledb_success_heading'] = "Hiyaa!";
$lang['admin_enabledb_success'] = "The selected database is now part of <b>Databased</b>. Please keep in mind that non-administrator users won't have access to this table unless it's given to them.";

$lang['admin_disabledb_error1_heading'] = "Ouch!";
$lang['admin_disabledb_error1'] = "Some database connection details are missing. Please reload the page and try again.";
$lang['admin_disabledb_error2_heading'] = "Ouch!";
$lang['admin_disabledb_error2'] = "You need to be an admin to do this.";
$lang['admin_disabledb_success_heading'] = "Hiyaa!";
$lang['admin_disabledb_success'] = "The selected database has been removed from <b>Databased</b>. All data has been maintained and the database can be moved back at any moment.";

$lang['admin_newdb_error1'] = "<h1>You're not allowed to do this</h1>";
$lang['admin_newdb_error2_heading'] = "Ouch!";
$lang['admin_newdb_error2'] = "The name for your new database has to be unqiue.";
$lang['admin_newdb_success'] = "The new database was successfully created. Congrats!";

$lang['admin_deletedb_error1'] = "<h1>You're not allowed to do this</h1>";
$lang['admin_deletedb_error2_heading'] = "Ouch!";
$lang['admin_deletedb_error2'] = "Some important data seems to be missing. Awkward! Please go back to the previous page, reload and try again.";
$lang['admin_deletedb_success'] = "The new database was successfully deleted. Congrats!";

$lang['admin_delete_file_error1_heading'] = "Ouch!";
$lang['admin_delete_file_error1'] = "You didn't specify a file to delete";
$lang['admin_delete_file_success'] = "The file is successfully deleted.";
$lang['admin_delete_file_error2'] = "Something went wrong and the file cound't be deleted :(";

$lang['admin_delete_files_error1'] = "Something went wrong and the files cound't be deleted :(";
$lang['admin_delete_files_success'] = "The files were successfully deleted.";
$lang['admin_delete_files_error1'] = "Please choose one or more files to delete.";


//columnnotes.php
$lang['columnnotes_getcolumnnotes_error1_heading'] = "Ouch!";
$lang['columnnotes_getcolumnnotes_error1'] = "Some database connection details are missing. Please reload the page and try again.";
$lang['columnnotes_getcolumnnotes_error2_heading'] = "Ouch!";
$lang['columnnotes_getcolumnnotes_error2'] = "You don't have permission to do this.";

$lang['columnnotes_newnote_error1_heading'] = "Ouch!";
$lang['columnnotes_newnote_error1'] = "Some database connection details are missing. Please reload the page and try again.";
$lang['columnnotes_newnote_error2_heading'] = "Ouch!";
$lang['columnnotes_newnote_error2'] = "You don't have permission to do this.";
$lang['columnnotes_newnote_error3_heading'] = "Ouch!";
$lang['columnnotes_newnote_error3'] = "Something went wrong when trying to save your data, please see the details below:<br>";
$lang['columnnotes_newnote_success_heading'] = "Woohoo!";
$lang['columnnotes_newnote_success'] = "The new column note has been added!";

$lang['columnnotes_deletenote_error1_heading'] = "Ouch!";
$lang['columnnotes_deletenote_error1'] = "Some database connection details are missing. Please reload the page and try again.";
$lang['columnnotes_deletenote_error2_heading'] = "Ouch!";
$lang['columnnotes_deletenote_error2'] = "You don't have permission to do this.";
$lang['columnnotes_deletenote_error3'] = "Sorry; you're not the owner of this note, so you can't delete it.";
$lang['columnnotes_deletenote_success_heading'] = "Woohoo!";
$lang['columnnotes_deletenote_success'] = "The column note has been deleted!";
$lang['columnnotes_deletenote_error4'] = "Somehow, the note ID is missing. We need this. Please try again.";

$lang['columnnotes_updatenote_error1_heading'] = "Ouch!";
$lang['columnnotes_updatenote_error1'] = "Some database connection details are missing. Please reload the page and try again.";
$lang['columnnotes_updatenote_error2_heading'] = "Ouch!";
$lang['columnnotes_updatenote_error2'] = "You don't have permission to do this.";
$lang['columnnotes_updatenote_error3'] = "Sorry; you're not the owner of this note, so you can't edit it.";
$lang['columnnotes_updatenote_error4_heading'] = "Ouch!";
$lang['columnnotes_updatenote_error4'] = "Something went wrong when trying to save your data, please see the details below:<br>";
$lang['columnnotes_updatenote_success_heading'] = "Woohoo!";
$lang['columnnotes_updatenote_success'] = "The column note has been updated!";


//columns.php
$lang['colums_getdetails_error1_heading'] = "Ouch!";
$lang['colums_getdetails_error1'] = "You don't have permission to do this.";
$lang['colums_getdetails_error2_heading'] = "Ouch!";
$lang['colums_getdetails_error2'] = "Some database connection details are missing. Please reload the page and try again.";

$lang['colums_update_error1_heading'] = "Ouch!";
$lang['colums_update_error1'] = "Some database connection details are missing. Please reload the page and try again.";
$lang['colums_update_error2_heading'] = "Ouch!";
$lang['colums_update_error2'] = "You don't have permission to do this.";
$lang['colums_update_error3_heading'] = "Ouch!";
$lang['colums_update_error3'] = "Something went wrong when trying to save your data, please see the details below:<br>";
$lang['colums_update_error4_heading'] = "Ouch!";
$lang['colums_update_error4'] = "Please make sure you choose a unique column name. Thanks!";
$lang['colums_update_success_heading'] = "Hiyaa!";
$lang['colums_update_success'] = "The column details have been updated.";

$lang['colums_column_check_message'] = 'The %s field can not be the word "column"';

$lang['colums_delete_error1_heading'] = "Ouch!";
$lang['colums_delete_error1'] = "Some database connection details are missing. Please reload the page and try again.";
$lang['colums_delete_error2_heading'] = "Ouch!";
$lang['colums_delete_error2'] = "You don't have permission to do this.";

$lang['colums_addcolumn_error1_heading'] = "Ouch!";
$lang['colums_addcolumn_error1'] = "Some database connection details are missing. Please reload the page and try again.";
$lang['colums_addcolumn_error2_heading'] = "Ouch!";
$lang['colums_addcolumn_error2'] = "You don't have permission to do this.";
$lang['colums_addcolumn_error3_heading'] = "Ouch!";
$lang['colums_addcolumn_error3'] = "Something went wrong when trying to save your data, please see the details below:<br>";
$lang['colums_addcolumn_error4_heading'] = "Ouch!";
$lang['colums_addcolumn_error4'] = "Please make sure you choose a unique column name. Thanks!";
$lang['colums_addcolumn_success_heading'] = "Hiyaa!";
$lang['colums_addcolumn_success'] = 'The column has been created. To see your column in the data view, you will need to click the button below to reload the page:<br><a class="btn btn-info btn-embossed" href="%s">reload page</a>';


//db.php
$lang['db_index_error1_heading'] = "Ouch!";
$lang['db_index_error1'] = "It appears you're trying to load a non-existing database. Please contact your administrator at <a href='mailto:%s'>%s</a> if the problem persists.";
$lang['db_index_error2_heading'] = "Ouch!";
$lang['db_index_error2'] = "It appears you're trying to load a non-existing table. Please contact your administrator at <a href='mailto:%s'>%s</a> if the problem persists.";

$lang['db_savefield_error1_heading'] = "Ouch!";
$lang['db_savefield_error1'] = "Some database connection details are missing. Please reload the page and try again.";
$lang['db_savefield_error2_heading'] = "Ouch!";
$lang['db_savefield_error2'] = "You don't have permission to do this.";
$lang['db_savefield_error3_heading'] = "Ouch!";
$lang['db_savefield_error3'] = "Something went wrong when trying to save your data, please see the details below:<br>";
$lang['db_savefield_error4_heading'] = "Ouch!";
$lang['db_savefield_error4'] = "You have entered a duplicate value as primary key value. Please eneter a unique value for all primary key columns";

$lang['db_getrecord_error1_heading'] = "Ouch!";
$lang['db_getrecord_error1'] = "Some database connection details are missing. Please reload the page and try again.";
$lang['db_getrecord_error2_heading'] = "Ouch!";
$lang['db_getrecord_error2'] = "You don't have permission to do this.";

$lang['db_updaterecord_error1_heading'] = "Ouch!";
$lang['db_updaterecord_error1'] = "Some database connection details are missing. Please reload the page and try again.";
$lang['db_updaterecord_error2_heading'] = "Ouch!";
$lang['db_updaterecord_error2'] = "You don't have permission to do this.";
$lang['db_updaterecord_error3_heading'] = "Ouch!";
$lang['db_updaterecord_error3'] = "Something went wrong when trying to save your data, please see the details below:<br>";
$lang['db_updaterecord_error4_heading'] = "Ouch!";
$lang['db_updaterecord_error4'] = "You have entered a duplicate value as primary key value. Please eneter a unique value for all primary key columns";
$lang['db_updaterecord_success_heading'] = "Hooray!";
$lang['db_updaterecord_success'] = "Congrats! Your record was saved successfully!";

$lang['db_newrecord_error1_heading'] = "Ouch!";
$lang['db_newrecord_error1'] = "Some database connection details are missing. Please reload the page and try again.";
$lang['db_newrecord_error2_heading'] = "Ouch!";
$lang['db_newrecord_error2'] = "You don't have permission to do this.";
$lang['db_newrecord_error3_heading'] = "Ouch!";
$lang['db_newrecord_error3'] = "Something went wrong when trying to save your data, please see the details below:<br>";
$lang['db_newrecord_success_heading'] = "Hooray!";
$lang['db_newrecord_success'] = "Congrats! Your record was inserted successfully!";

$lang['db_deleterecord_error1_heading'] = "Ouch!";
$lang['db_deleterecord_error1'] = "Some database connection details are missing. Please reload the page and try again.";
$lang['db_deleterecord_error2_heading'] = "Ouch!";
$lang['db_deleterecord_error2'] = "You don't have permission to do this.";
$lang['db_deleterecord_success'] = "The record has been permanently deleted.";

$lang['db_newtable_error1_heading'] = "Ouch!";
$lang['db_newtable_error1'] = "Some database connection details are missing. Please reload the page and try again.";
$lang['db_newtable_error2_heading'] = "Ouch!";
$lang['db_newtable_error2'] = "You don't have permission to do this.";
$lang['db_newtable_error3_heading'] = "Ouch!";
$lang['db_newtable_error3'] = "Something went wrong when trying to save your data, please see the details below:<br>";
$lang['db_newtable_error4_heading'] = "Ouch!";
$lang['db_newtable_error4'] = "The table name <b>%s</b> is already taken. Please use a unqiue name.";
$lang['db_newtable_error5_heading'] = "Ouch!";
$lang['db_newtable_error5'] = "All column names <b>must be unqiue</b>. Please double check your column names";
$lang['db_newtable_success_heading'] = "Hooray!";
$lang['db_newtable_success'] = "Congrats! Your new table was created successfully! Click the button below to reload the page<br><a href='%s' class='btn btn-info btn-embossed'>reload page</a>";

$lang['db_deletetable_error1_heading'] = "Ouch!";
$lang['db_deletetable_error1'] = "Some database connection details are missing. Please reload the page and try again.";
$lang['db_deletetable_error2_heading'] = "Ouch!";
$lang['db_deletetable_error2'] = "You don't have permission to do this.";
$lang['db_deletetable_error3_heading'] = "Ouch!";
$lang['db_deletetable_error3_part1'] = "You can not delete this table right now, as it has column referenced by other tables. Please see below which tables and columns are referencing this table:";
$lang['db_deletetable_error3_part2'] = "You will need to remove these references before you can delete this table.<br><a href='%s' class='btn btn-info btn-block'><span class='fui-arrow-left'></span> Return to %s</a>";
$lang['db_deletetable_success'] = "The table has been permanently deleted.";

$lang['db_column_check_message'] = 'The %s field can not be the word "column"';

$lang['db_getcell_error1_heading'] = "Ouch!";
$lang['db_getcell_error1'] = "You don't have permission to do this.";

$lang['db_updatetable_error1_heading'] = "Ouch!";
$lang['db_updatetable_error1'] = "Some database connection details are missing. Please reload the page and try again.";
$lang['db_updatetable_error2_heading'] = "Ouch!";
$lang['db_updatetable_error2'] = "You don't have permission to do this.";
$lang['db_updatetable_error3'] = "Something went wrong with the data you entered, please see below:<br>";
$lang['db_updatetable_error4'] = "The table name %s is already taken, please choose a different table name.";
$lang['db_updatetable_success'] = "The table was successfully updated.";

$lang['db_uploadcsv_error1_heading'] = "Ouch!";
$lang['db_uploadcsv_error1'] = "Some database connection details are missing. Please reload the page and try again.";
$lang['db_uploadcsv_error2_heading'] = "Ouch!";
$lang['db_uploadcsv_error2'] = "Something went wrong when trying to save your data, please see the details below:<br>";
$lang['db_uploadcsv_error3_heading'] = "Ouch!";
$lang['db_uploadcsv_error3'] = "The table name must be unqiue; it appears the table name %s is already taken.";
$lang['db_uploadcsv_error4_heading'] = "Ouch!";
$lang['db_uploadcsv_error4'] = "Something went wrong with the file you were trying to upload: <br>";
$lang['db_uploadcsv_error5_heading'] = "Ouch!";
$lang['db_uploadcsv_error5'] = "It appears the value you've choses for the <b>Columns separated by</b> field does not match the delimiter detected by <b>Databased</b>. To prevent errors, we can't create the table. We suggest to leave the <b>Columns separated by</b> field empty and try again.";
$lang['db_uploadcsv_success_heading'] = "Hooray!";
$lang['db_uploadcsv_success'] = "Congrats! Your new table was created successfully! Click the button below to reload the page<br><a href='%s' class='btn btn-info btn-embossed'>reload page</a>";

$lang['db_importcsv_error1_heading'] = "Ouch!";
$lang['db_importcsv_error1'] = "Some database connection details are missing. Please reload the page and try again.";
$lang['db_importcsv_error2_heading'] = "Ouch!";
$lang['db_importcsv_error2'] = "Something went wrong with the file you were trying to upload: <br>";
$lang['db_importcsv_error3_heading'] = "Ouch!";
$lang['db_importcsv_error3'] = "It appears the value you've choses for the <b>Columns separated by</b> field does not match the delimiter detected by <b>Databased</b>. To prevent errors, we can't create the table. We suggest to leave the <b>Columns separated by</b> field empty and try again.";
$lang['db_importcsv_success_heading'] = "Hooray!";
$lang['db_importcsv_success'] = "Congrats! Your data was imported successfully! Click the button below to reload the page<br><a href='%s' class='btn btn-info btn-embossed'>reload page</a>";
$lang['db_importcsv_error4_heading'] = "Ouch!";
$lang['db_importcsv_error4'] = "We can not import your data right now. This is most likely due to your CSV file being wrongly formatted (the number of fields might not match the numnber of columns in your table) or it could be that the primary key field contains values already present in your Databased table. Please review your CSV file and try again.";


//recordnotes.php
$lang['recordnotes_getrecordnotes_error1_heading'] = "Ouch!";
$lang['recordnotes_getrecordnotes_error1'] = "Some database connection details are missing. Please reload the page and try again.";
$lang['recordnotes_getrecordnotes_error2_heading'] = "Ouch!";
$lang['recordnotes_getrecordnotes_error2'] = "You don't have permission to do this.";

$lang['recordnotes_newnote_error1_heading'] = "Ouch!";
$lang['recordnotes_newnote_error1'] = "Some database connection details are missing. Please reload the page and try again.";
$lang['recordnotes_newnote_error2_heading'] = "Ouch!";
$lang['recordnotes_newnote_error2'] = "You don't have permission to do this.";
$lang['recordnotes_newnote_error3_heading'] = "Ouch!";
$lang['recordnotes_newnote_error3'] = "Something went wrong when trying to save your data, please see the details below:<br>";
$lang['recordnotes_newnote_success_heading'] = "Hooray!";
$lang['recordnotes_newnote_success'] = "Your new note has been created.";

$lang['recordnotes_updatenote_error1_heading'] = "Ouch!";
$lang['recordnotes_updatenote_error1'] = "Some database connection details are missing. Please reload the page and try again.";
$lang['recordnotes_updatenote_error2_heading'] = "Ouch!";
$lang['recordnotes_updatenote_error2'] = "Sorry, you're not the owner of this note, so you can not edit it.";
$lang['recordnotes_updatenote_error3_heading'] = "Ouch!";
$lang['recordnotes_updatenote_error3'] = "Something went wrong when trying to save your data, please see the details below:<br>";
$lang['recordnotes_updatenote_success_heading'] = "Woohoo!";
$lang['recordnotes_updatenote_success'] = "The record note has been updated!";

$lang['recordnotes_deletenote_error1_heading'] = "Ouch!";
$lang['recordnotes_deletenote_error1'] = "Some database connection details are missing. Please reload the page and try again.";
$lang['recordnotes_deletenote_error2_heading'] = "Ouch!";
$lang['recordnotes_deletenote_error2'] = "You don't have permission to do this.";
$lang['recordnotes_deletenote_error3_heading'] = "Ouch!";
$lang['recordnotes_deletenote_error3'] = "Sorry, this is not your note, so you can not delete it.";
$lang['recordnotes_deletenote_success_heading'] = "Woohoo!";
$lang['recordnotes_deletenote_success'] = "The record note has been deleted!";


//revisions.php
$lang['revisions_index_error1_heading'] = "Ouch!";
$lang['revisions_index_error1'] = "Some database connection details are missing. Please reload the page and try again.";
$lang['revisions_index_error2_heading'] = "Ouch!";
$lang['revisions_index_error2'] = "You don't have permission to do this.";

$lang['revisions_loadrecordrevisions_error1_heading'] = "Ouch!";
$lang['revisions_loadrecordrevisions_error1'] = "You don't have permission to do this.";

$lang['revisions_removerevision_error1_heading'] = "Ouch!";
$lang['revisions_removerevision_error1'] = "Some database connection details are missing. Please reload the page and try again.";
$lang['revisions_removerevision_error2_heading'] = "Ouch!";
$lang['revisions_removerevision_error2'] = "You don't have permission to do this.";
$lang['revisions_removerevision_success_heading'] = "Hooray!";
$lang['revisions_removerevision_success'] = "The revision was removed successfully.";

$lang['revisions_restorerevision_error1_heading'] = "Ouch!";
$lang['revisions_restorerevision_error1'] = "You don't have permission to do this.";
$lang['revisions_restorerevision_success_heading'] = "Ouch!";
$lang['revisions_restorerevision_success'] = "The revision was removed successfully.";

$lang['revisions_viewcell_error1_heading'] = "Ouch!";
$lang['revisions_viewcell_error1'] = "You don't have permission to do this.";
$lang['revisions_viewcell_error2'] = "<h1>Revision ID is missing</h1>";

$lang['revisions_viewrecord_error1_heading'] = "Ouch!";
$lang['revisions_viewrecord_error1'] = "Some database connection details are missing. Please reload the page and try again.";
$lang['revisions_viewrecord_error2_heading'] = "Ouch!";
$lang['revisions_viewrecord_error2'] = "You don't have permission to do this.";

$lang['revisions_restorerecordrevision_error1_heading'] = "Ouch!";
$lang['revisions_restorerecordrevision_error1'] = "Some database connection details are missing. Please reload the page and try again.";
$lang['revisions_restorerecordrevision_success_heading'] = "Ouch!";
$lang['revisions_restorerecordrevision_success'] = "Your record was restored to its previous revision.";
$lang['revisions_restorerecordrevision_error2_heading'] = "Ouch!";
$lang['revisions_restorerecordrevision_error2'] = "Something is wrong with the data we received. Please reload the page and try again.";

$lang['revisions_deleterecordrevision_error1_heading'] = "Ouch!";
$lang['revisions_deleterecordrevision_error1'] = "Some database connection details are missing. Please reload the page and try again.";
$lang['revisions_deleterecordrevision_error2_heading'] = "Ouch!";
$lang['revisions_deleterecordrevision_error2'] = "You don't have permission to do this.";
$lang['revisions_deleterecordrevision_success_heading'] = "Hooray!";
$lang['revisions_deleterecordrevision_success'] = "The record revision was sucessfully deleted from the system; %s revisions were removed from the system.";
$lang['revisions_deleterecordrevision_error3_heading'] = "Ouch!";
$lang['revisions_deleterecordrevision_error3'] = "Some data we need seems to be missing. Please reload the page and try again.";


//roles.php
$lang['roles_create_error'] = "Something went wrong with the data you entered, please see below:<br>";
$lang['roles_create_success'] = "The new user role was created successfully! Yeah!";

$lang['roles_update_success'] = "The user role was updated successfully! Yeah!";
$lang['roles_update_error'] = "It appears some important data is missing and we couldn't update the role. Please try again. If you keep gettig this error message, please contact support.";

$lang['roles_delete_error'] = "Please choose a DEFAULT role before deleting one.";
$lang['roles_delete_success'] = "The user role was deleted successfully! Yeah!";


//tablenotes.php
$lang['tablenotes_newnote_error1_heading'] = "Ouch!";
$lang['tablenotes_newnote_error1'] = "Some database connection details are missing. Please reload the page and try again.";
$lang['tablenotes_newnote_error2_heading'] = "Ouch!";
$lang['tablenotes_newnote_error2'] = "You don't have permission to do this.";
$lang['tablenotes_newnote_error3_heading'] = "Ouch!";
$lang['tablenotes_newnote_error3'] = "Something went wrong when trying to save your data, please see the details below:<br>";
$lang['tablenotes_newnote_success_heading'] = "Woohoo!";
$lang['tablenotes_newnote_success'] = "The new table note has been added!";

$lang['tablenotes_deletenote_error1_heading'] = "Ouch!";
$lang['tablenotes_deletenote_error1'] = "Some database connection details are missing. Please reload the page and try again.";
$lang['tablenotes_deletenote_error2_heading'] = "Ouch!";
$lang['tablenotes_deletenote_error2'] = "You don't have permission to do this.";
$lang['tablenotes_deletenote_error3'] = "Sorry; you're not the owner of this note, so you can't delete it.";
$lang['tablenotes_deletenote_success_heading'] = "Woohoo!";
$lang['tablenotes_deletenote_success'] = "The table note has been deleted!";

$lang['tablenotes_updatenote_error1_heading'] = "Ouch!";
$lang['tablenotes_updatenote_error1'] = "Some database connection details are missing. Please reload the page and try again.";
$lang['tablenotes_updatenote_error2_heading'] = "Ouch!";
$lang['tablenotes_updatenote_error2'] = "You don't have permission to do this.";
$lang['tablenotes_updatenote_error3'] = "Sorry; you're not the owner of this note, so you can't delete it.";
$lang['tablenotes_updatenote_error4_heading'] = "Ouch!";
$lang['tablenotes_updatenote_error4'] = "Something went wrong when trying to save your data, please see the details below:<br>";
$lang['tablenotes_updatenote_success_heading'] = "Woohoo!";
$lang['tablenotes_updatenote_success'] = "The table note has been successfully updated!";


//users.php
$lang['users_create_error1'] = "Something went wrong when trying to save your data, please see the details below:<br>";
$lang['users_create_success'] = "The user was created successfully! Yeah!";

$lang['users_updatelogin_success'] = "The email address / password were updated successfully! Yeah!";

$lang['users_update_success'] = "The profile details were successfully updated. Yeah!";

$lang['users_delete_success'] = "The selected user and all it's associated data were permanently deleted.";