<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
  | -------------------------------------------------------------------------
  | URI ROUTING
  | -------------------------------------------------------------------------
  | This file lets you re-map URI requests to specific controller functions.
  |
  | Typically there is a one-to-one relationship between a URL string
  | and its corresponding controller class/method. The segments in a
  | URL normally follow this pattern:
  |
  |	example.com/class/method/id/
  |
  | In some instances, however, you may want to remap this relationship
  | so that a different class/function is called than the one
  | corresponding to the URL.
  |
  | Please see the user guide for complete details:
  |
  |	http://codeigniter.com/user_guide/general/routing.html
  |
  | -------------------------------------------------------------------------
  | RESERVED ROUTES
  | -------------------------------------------------------------------------
  |
  | There area two reserved routes:
  |
  |	$route['default_controller'] = 'welcome';
  |
  | This route indicates which controller class should be loaded if the
  | URI contains no data. In the above example, the "welcome" class
  | would be loaded.
  |
  |	$route['404_override'] = 'errors/page_missing';
  |
  | This route will tell the Router what URI segments to use if those provided
  | in the URL cannot be matched to a valid route.
  |
 */

//$route['404_override'] = 'errors/page_errors/error_404';

/* ------------------------------Super Admin-------------------------------- */

if (defined ("SHOW_DEMO") && SHOW_DEMO) {

  $route['default_controller'] = 'admin/login';
  $route['index.php'] = 'admin/login';
  $route['sadmin'] = 'superadmin/login';

} else {

  $route['default_controller'] = 'superadmin/login';
  $route['index.php'] = 'superadmin/login';
}

$route['view-work-order/(:any)'] = 'show_work_order/index/$1';

$route['valid_login'] = 'superadmin/login/valid_login';
$route['superadmin_qr_code/(:any)'] = 'superadmin/login/qr_code/$1';
$route['update_profile'] = 'superadmin/profile/update_profile';
$route['dashboard'] = 'superadmin/login/dashboard';
$route['profile'] = 'superadmin/profile';
$route['about-us'] = 'superadmin/profile/about_us';
$route['contact-us'] = 'superadmin/profile/contact_us';
$route['logout'] = 'superadmin/login/logout';
$route['change-password'] = 'superadmin/login/change_password';
$route['sa_update_password'] = 'superadmin/login/update_password';
$route['user-recovery'] = 'superadmin/profile/user_recovery';
$route['access-log'] = 'superadmin/profile/access_log';
$route['ajax_change_uscis_status'] = 'superadmin/manage_employee/ajax_change_uscis_status';
$route['ajax_con_project_list'] = 'superadmin/manage_employee/get_con_project_list';
$route['ajax_emp_project_list'] = 'superadmin/manage_employee/get_emp_project_list';

$route['sadmin-load-cons-invoice'] = 'superadmin/login/load_cons_invoice';
$route['sadmin-load-emp-invoice'] = 'superadmin/login/load_emp_invoice';
$route['sadmin-load-1099-invoice'] = 'superadmin/login/load_1099_invoice';
$route['sadmin-load-timesheet'] = 'superadmin/login/load_periodic_timesheet';

$route['super-admin-user'] = 'superadmin/profile/superadmin_lists';
$route['add-super-admin-user'] = 'superadmin/profile/add_superadmin';
$route['insert_superadmin'] = 'superadmin/profile/insert_superadmin';
$route['edit-super-admin-user/(:any)'] = 'superadmin/profile/edit_super_admin_user/$1';
$route['update_superadmin'] = 'superadmin/profile/update_superadmin';
$route['delete-superadmin-user'] = 'superadmin/profile/delete_superadmin_user';

$route['insert_admin_menu'] = 'superadmin/login/insert_admin_menu';
$route['admin-menu-permission'] = 'superadmin/login/admin_permission';
$route['edit-admin-menu-permission/(:any)'] = 'superadmin/login/edit_admin_permission/$1';

$route['insert_superadmin_menu'] = 'superadmin/login/insert_superadmin_menu';
$route['menu-permission'] = 'superadmin/login/superadmin_permission';
$route['super-admin-menu-permission/(:any)'] = 'superadmin/login/edit_superadmin_permission/$1';

$route['forgot-password'] = 'superadmin/login/forgot_password';
$route['valid_forgot_password'] = 'superadmin/login/valid_forgot_password';
$route['otp-forgot-password'] = 'superadmin/login/otp_forgot_password';
$route['valid_otp'] = 'superadmin/login/valid_otp';
$route['sa_reset_password'] = 'superadmin/login/sa_reset_password';
$route['reset-password/(:any)'] = 'superadmin/login/reset_password/$1';

$route['add-admin-user'] = 'superadmin/manage_admin';
$route['insert-admin'] = 'superadmin/manage_admin/add_admin';
$route['admin-user'] = 'superadmin/manage_admin/admin_lists';
$route['change_block_status'] = 'superadmin/manage_admin/change_block_status';
$route['change_status'] = 'superadmin/manage_admin/change_status';
$route['update-admin'] = 'superadmin/manage_admin/update_admin';
$route['edit-admin-user/(:any)'] = 'superadmin/manage_admin/edit_admin/$1';
$route['delete-admin-user'] = 'superadmin/manage_admin/delete_admin_user';

$route['vendor-user'] = 'superadmin/manage_vendor/vendor_lists';$route['add-vendor-user'] = 'superadmin/manage_vendor';
$route['insert_vendor'] = 'superadmin/manage_vendor/add_vendor';
$route['ajax_state_list'] = 'superadmin/manage_vendor/get_state_list';
$route['ajax_city_list'] = 'superadmin/manage_vendor/get_city_list';
$route['change_vendor_block_status'] = 'superadmin/manage_vendor/change_block_status';
$route['change_vendor_status'] = 'superadmin/manage_vendor/change_status';
$route['update_vendor'] = 'superadmin/manage_vendor/update_vendor';
$route['edit-vendor-user/(:any)'] = 'superadmin/manage_vendor/edit_vendor/$1';
$route['delete_vendor_user'] = 'superadmin/manage_vendor/delete_vendor_user';
$route['sa-view-vendor-profile/(:any)'] = 'superadmin/manage_vendor/sa_view_vendor_profile/$1';

$route['add-vendor-user-sd'] = 'superadmin/manage_vendor/add_vendor_user_sd';
$route['insert_vendor_sd'] = 'superadmin/manage_vendor/add_vendor_sd';

$route['consultant-user'] = 'superadmin/manage_employee/employee_lists';
$route['add-consultant'] = 'superadmin/manage_employee';
$route['insert_employee'] = 'superadmin/manage_employee/add_employee';
$route['change_employee_block_status'] = 'superadmin/manage_employee/change_block_status';
$route['change_employee_status'] = 'superadmin/manage_employee/change_status';
$route['update_employee'] = 'superadmin/manage_employee/update_employee';
$route['edit-consultant/(:any)'] = 'superadmin/manage_employee/edit_employee/$1';
$route['delete-employee-user'] = 'superadmin/manage_employee/delete_employee_user';
$route['con-timesheet'] = 'superadmin/manage_employee/con_timesheet';
$route['emp-timesheet'] = 'superadmin/manage_employee/emp_timesheet';


$route['sadmin_get_approved_timesheet_data_all'] = 'superadmin/manage_employee/get_approved_timesheet_data_all';
$route['sadmin_get_pending_timesheet_data_all'] = 'superadmin/manage_employee/get_pending_timesheet_data_all';
$route['sadmin_get_not_approved_timesheet_data_all'] = 'superadmin/manage_employee/get_not_approved_timesheet_data_all';

$route['sadmin_get_consultant_approved_timesheet_data_all'] = 'superadmin/manage_employee/get_consultant_approved_timesheet_data_all';

$route['sadmin-historical-timesheet'] = 'superadmin/manage_employee/historical_timesheet';
$route['sadmin-load-historical-timesheet'] = 'superadmin/manage_employee/load_historical_timesheet';
$route['add-con-timesheet'] = 'superadmin/manage_employee/add_con_timesheet';
$route['add-emp-timesheet'] = 'superadmin/manage_employee/add_emp_timesheet';

$route['view-superadmin-emp-timesheet/(:any)'] = 'superadmin/manage_employee/view_superadmin_emp_timesheet/$1';
$route['view-superadmin-con-timesheet/(:any)'] = 'superadmin/manage_employee/view_superadmin_con_timesheet/$1';
$route['view-superadmin-employee-timesheet/(:any)'] = 'superadmin/manage_employee/view_superadmin_employee_timesheet/$1';
$route['view_superadmin_consultant_timesheet/(:any)'] = 'superadmin/manage_employee/view_employees_timesheet/$1';
$route['view_superadmin_consultant_documents/(:any)'] = 'superadmin/manage_employee/view_consultant_documents/$1';
$route['view_superadmin_vendor_documents/(:any)'] = 'superadmin/manage_vendor/view_vendor_documents/$1';
$route['view_superadmin_project_timesheet/(:any)/(:any)'] = 'superadmin/manage_employee/view_project_timesheet/$1/$2';

$route['superadmin_consultant_invoice'] = 'superadmin/manage_employee/superadmin_employee_invoice';
/* Super Admin New Invoice */
$route['sadmin_consultant_invoice'] = 'superadmin/manage_employee/sadmin_consultant_invoice';
$route['sadmin_vendor_invoice'] = 'superadmin/manage_employee/sadmin_vendor_invoice';
$route['sadmin_employee_invoice'] = 'superadmin/manage_employee/sadmin_employee_invoice';
$route['edit-sadmin-employee-invoice/(:any)'] = 'superadmin/manage_employee/edit_sadmin_employee_invoice/$1';
$route['update_sadmin_employee_invoice'] = 'superadmin/manage_employee/update_sadmin_employee_invoice';



$route['superadmin_invoice_pdf/(:any)'] = 'superadmin/manage_employee/invoice_pdf/$1';
$route['sa_invoice_pdf/(:any)'] = 'superadmin/manage_employee/sa_invoice_pdf/$1';

$route['compose'] = 'superadmin/manage_communication';
$route['send_mail'] = 'superadmin/manage_communication/send_mail';
$route['get_recipient_emails'] = 'superadmin/manage_communication/get_recipient_emails';
$route['sent_items'] = 'superadmin/manage_communication/sent_items';
$route['sent_mail_details/(:any)'] = 'superadmin/manage_communication/sent_mail_details/$1';
$route['inbox'] = 'superadmin/manage_communication/inbox';
$route['inbox_mail_details/(:any)'] = 'superadmin/manage_communication/inbox_mail_details/$1';
$route['inbox_mail_reply/(:any)/(:any)'] = 'superadmin/manage_communication/inbox_mail_reply/$1/$2';
$route['send_reply'] = 'superadmin/manage_communication/send_reply';

$route['get_notification_count'] = 'superadmin/manage_communication/get_notification_count';
$route['get_mail_notification'] = 'superadmin/manage_communication/get_mail_notification';

$route['manage-documents'] = 'superadmin/manage_employee/consultant_documents';
$route['add_consultant_documentations'] = 'superadmin/manage_employee/add_consultant_documentations';
$route['insert_documentation_form'] = 'superadmin/manage_employee/insert_documentation_form';
$route['edit-consultant-documents/(:any)'] = 'superadmin/manage_employee/edit_consultant_documents/$1';
$route['update_consultant_documentation_form'] = 'superadmin/manage_employee/update_consultant_documentation_form';
$route['change_document_status'] = 'superadmin/manage_employee/change_document_status';
$route['load_timesheet_table'] = 'superadmin/profile/add_timesheet_tbl';
/*********************************************1099 Users Document Section******************************************/
$route['ten99-docs'] = 'superadmin/manage_ten99/ten99_documents';
$route['add-ten99-doc'] = 'superadmin/manage_ten99/add_ten99_documentations';
$route['insert_ten99_documentation_form'] = 'superadmin/manage_ten99/insert_ten99_documentation_form';
$route['edit-ten99-documents/(:any)'] = 'superadmin/manage_ten99/edit_ten99_documents/$1';
$route['update_ten99_documentation_form'] = 'superadmin/manage_ten99/update_ten99_documentation_form';
/*********************************************1099 Users Document Section******************************************/

$route['vendor-docs'] = 'superadmin/manage_employee/vendor_documents';
$route['add-vendor-doc'] = 'superadmin/manage_employee/add_vendor_documentations';
$route['insert_vendor_documentation_form'] = 'superadmin/manage_employee/insert_vendor_documentation_form';
$route['edit-vendor-documents/(:any)'] = 'superadmin/manage_employee/edit_vendor_documents/$1';
$route['update_vendor_documentation_form'] = 'superadmin/manage_employee/update_vendor_documentation_form';

$route['project_lists'] = 'superadmin/manage_employee/project_lists';
$route['delete-project'] = 'superadmin/manage_employee/delete_project';
$route['view_superadmin_consultant_details/(:any)'] = 'superadmin/manage_employee/view_consultant_details/$1';

$route['get_superadmin_others_notification_count'] = 'superadmin/manage_communication/get_others_notification_count';
$route['get_superadmin_others_notification_details'] = 'superadmin/manage_communication/get_superadmin_others_notification_details';
$route['notifications'] = 'superadmin/login/notifications';

$route['sa_view_vendor_document/(:any)/(:any)'] = 'superadmin/manage_vendor/view_vendor_document/$1/$2';
$route['sa_verify_vendor_documents/(:any)'] = 'superadmin/manage_vendor/verify_vendor_documents/$1';

$route['sa_verify_documents'] = 'superadmin/manage_vendor/verify_documents';

/*********************************************1099 Users List Section********************************************************/
$route['1099-user'] = 'superadmin/manage_ten99/superadmin_ten99users_list';
$route['add-superadmin-ten99-user'] = 'superadmin/manage_ten99/add_superadmin_ten99_user';
$route['insert_superadmin_ten99_user'] = 'superadmin/manage_ten99/insert_superadmin_ten99_user';
$route['edit-superadmin-ten99-user/(:any)'] = 'superadmin/manage_ten99/edit_superadmin_ten99_user/$1';
$route['update-superadmin-ten99-user'] = 'superadmin/manage_ten99/update_superadmin_ten99_user';
$route['assign-projects-to-superadmin-ten99user'] = 'superadmin/manage_ten99/assign_project_to_ten99user';
$route['add-superadmin-assign-ten99user-projects'] = 'superadmin/manage_ten99/add_assign_ten99user_projects';
$route['generate-superadmin-ten99user-login-details/(:any)'] = 'superadmin/manage_ten99/generate_ten99user_login_details/$1';
$route['insert_superadmin_ten99user_login_details'] = 'superadmin/manage_ten99/insert_ten99user_login_details';
$route['sa_upload_ten99user_docs'] = 'superadmin/manage_ten99/upload_sa_ten99user_doc';
$route['superadmin_ten99user_onboarding/(:any)'] = 'superadmin/manage_ten99/ten99user_onboarding/$1';
$route['delete-ten99-user'] = 'superadmin/manage_ten99/delete_ten99_user';


$route['view_superadmin_ten99user_documents/(:any)'] = 'superadmin/manage_ten99/view_ten99user_documents/$1';
$route['sa_approve_disapprove_ten99user_documents'] = 'superadmin/manage_ten99/approve_disapprove_ten99user_documents';
$route['upload_sa_ten99user_documents/(:any)'] = 'superadmin/manage_ten99/upload_sa_ten99user_documents/$1';


$route['view-superadmin-ten99user-timesheet/(:any)'] = 'superadmin/manage_ten99/view_superadmin_ten99user_timesheet/$1';
$route['ten99user-con-view-period-timesheet/(:any)'] = 'superadmin/manage_ten99/ten99user_con_view_period_timesheet/$1';
$route['ten99user-timesheet'] = 'superadmin/manage_ten99/ten99user_timesheet';
$route['add-ten99user-timesheet'] = 'superadmin/manage_ten99/add_ten99user_timesheet';
$route['insert_new_ten99user_timesheet'] = 'superadmin/manage_ten99/insert_new_ten99user_timesheet';
$route['ajax_ten99user_project_list'] = 'superadmin/manage_ten99/get_ten99user_project_list';
$route['ajax_get_ten99user_timesheet_list'] = 'superadmin/manage_ten99/ajax_ten99user_timesheet_list';
$route['sadmin-view-ten99user-period-timesheet/(:any)'] = 'superadmin/manage_ten99/sadmin_view_ten99user_period_timesheet/$1';
$route['sadmin_approve_disapprove_ten99user_timesheet_period'] = 'superadmin/manage_ten99/sadmin_approve_disapprove_ten99user_timesheet_period';


$route['add_sadmin_ten99user_work_order/(:any)'] = 'superadmin/manage_ten99/add_admin_ten99user_work_order/$1';
$route['sadmin_ajax_work_note'] = 'superadmin/manage_employee/get_work_note';
$route['insert_sadmin_ten99user_work_order'] = 'superadmin/manage_ten99/insert_sadmin_ten99user_work_order';
$route['edit-sadmin-ten99user-work-order/(:any)'] = 'superadmin/manage_ten99/edit_sadmin_ten99user_work_order/$1';
$route['update_sadmin_ten99user_work_order'] = 'superadmin/manage_ten99/update_sadmin_ten99user_work_order';
$route['view_sadmin_ten99user_work_order_pdf/(:any)'] = 'superadmin/manage_ten99/view_sadmin_ten99user_work_order_pdf/$1';



$route['add_sadmin_ten99user_work_order/(:any)'] = 'superadmin/manage_ten99/add_admin_ten99user_work_order/$1';
$route['sadmin_ajax_work_note'] = 'superadmin/manage_employee/get_work_note';
$route['insert_sadmin_ten99user_work_order'] = 'superadmin/manage_ten99/insert_sadmin_ten99user_work_order';
/*********************************************1099 Users List Section********************************************************/


$route['superadmin-employee-list'] = 'superadmin/manage_employee/superadmin_employee_list';
$route['add-superadmin-employee-user'] = 'superadmin/manage_employee/add_superadmin_employee_user';
$route['insert_superadmin_employee_user'] = 'superadmin/manage_employee/insert_superadmin_employee_user';
$route['edit-superadmin-employee-user/(:any)'] = 'superadmin/manage_employee/edit_superadmin_employee_user/$1';
$route['update-superadmin-employee-user'] = 'superadmin/manage_employee/update_superadmin_employee_user';
$route['assign-projects-to-superadmin-employee'] = 'superadmin/manage_employee/assign_project_to_employee';
$route['assign-projects-to-superadmin-consultant'] = 'superadmin/manage_employee/assign_project_to_consultant';
$route['add-superadmin-assign-projects'] = 'superadmin/manage_employee/add_assign_projects';
$route['add-superadmin-assign-projects-consultant'] = 'superadmin/manage_employee/add_assign_projects_consultant';
$route['generate-superadmin-employee-login-details/(:any)'] = 'superadmin/manage_employee/generate_employee_login_details/$1';
$route['generate-superadmin-consultant-login-details/(:any)'] = 'superadmin/manage_employee/generate_consultant_login_details/$1';
$route['insert_superadmin_employee_login_details'] = 'superadmin/manage_employee/insert_employee_login_details';
$route['insert_superadmin_consultant_login_details'] = 'superadmin/manage_employee/insert_consultant_login_details';
$route['add-superadmin-employee-work_order/(:any)'] = 'superadmin/manage_employee/add_employee_work_order/$1';
$route['insert_superadmin_employee_work_order'] = 'superadmin/manage_employee/insert_employee_work_order';
$route['view_superadmin_employees_work_order_pdf/(:any)'] = 'superadmin/manage_employee/view_employees_work_order_pdf/$1';

$route['sa_approve_disapprove_documents'] = 'superadmin/manage_employee/approve_disapprove_documents';
$route['sa_approve_disapprove_vendor_documents'] = 'superadmin/manage_vendor/approve_disapprove_vendor_documents';
$route['sa_approve_disapprove_ucsic_docs'] = 'superadmin/manage_employee/approve_disapprove_ucsic_docs';
$route['superadmin_employee_onboarding/(:any)'] = 'superadmin/manage_employee/consultant_onboarding/$1';
$route['upload_superadmin_employee_documents/(:any)'] = 'superadmin/manage_employee/upload_consultant_documents/$1';
$route['upload_sa_consultant_documents/(:any)'] = 'superadmin/manage_employee/upload_sa_consultant_documents/$1';
$route['sa_upload_consultant_document'] = 'superadmin/manage_employee/upload_document';
$route['sa_upload_consultant_docs'] = 'superadmin/manage_employee/upload_sa_doc';
$route['superadmin-show-files/(:any)/(:any)'] = 'superadmin/profile/show_files/$1/$2';
$route['sa-generate-invoice/(:any)'] = 'superadmin/manage_employee/generate_sa_employee_payment/$1';
$route['sa_ajax_monthly_timesheet'] = 'superadmin/manage_employee/ajax_monthly_timesheet';
$route['sa_ajax_weekly_timesheet'] = 'superadmin/manage_employee/ajax_weekly_timesheet';
$route['sa_generate_payment'] = 'superadmin/manage_employee/sa_generate_payment';
$route['recover_user_account'] = 'superadmin/profile/recover_user_account';
$route['per_delete_user_account'] = 'superadmin/profile/per_delete_user_account';
$route['delete-emp-invoice'] = 'superadmin/manage_employee/delete_employee_invoice';
$route['delete-consultant-invoice'] = 'superadmin/manage_employee/delete_consultant_invoice';
$route['delete-vendor-invoice'] = 'superadmin/manage_employee/delete_vendor_invoice';
$route['uploads-sadmin-vendor-documents/(:any)/(:any)'] = 'superadmin/manage_vendor/uploads_sadmin_vendor_documents/$1/$2';



/****For Vendor Files***/
$route['uploads-sadmin-approved-vendor-documents/(:any)/(:any)'] = 'superadmin/manage_vendor/uploads_sadmin_approved_vendor_documents/$1/$2';
$route['sadmin_upload_signed_vendor_document'] = 'superadmin/manage_vendor/upload_signed_vendor_document';
/****For Vendor Files***/

$route['sadmin_upload_vendor_document'] = 'superadmin/manage_vendor/upload_document';
$route['view_sadmin_employees_work_order_pdf/(:any)'] = 'superadmin/manage_employee/view_sadmin_employees_work_order_pdf/$1';
$route['edit-sadmin-employee-work-order/(:any)'] = 'superadmin/manage_employee/edit_sadmin_employee_work_order/$1';
$route['update_sadmin_employee_work_order'] = 'superadmin/manage_employee/update_sadmin_employee_work_order';
$route['consultants-internal-files'] = 'superadmin/manage_employee/consultants_internal_files';
$route['all_internal_files/(:any)'] = 'superadmin/manage_employee/all_internal_files/$1';
$route['add-consultant-internal-files'] = 'superadmin/manage_employee/add_consultant_internal_files';
$route['insert_consultant_internal_files'] = 'superadmin/manage_employee/insert_consultant_internal_files';
$route['edit-consultant-internal-files/(:any)'] = 'superadmin/manage_employee/edit_consultant_internal_files/$1';
$route['upload-consultant-signed-internal-files/(:any)'] = 'superadmin/manage_employee/upload_consultant_signed_internal_files/$1';
$route['update_consultant_internal_files'] = 'superadmin/manage_employee/update_consultant_internal_files';
$route['update_consultant_signed_internal_files'] = 'superadmin/manage_employee/update_consultant_signed_internal_files';
$route['send_internal_files_mail'] = 'superadmin/manage_employee/send_internal_files_mail';

$route['view-period-timesheet/(:any)'] = 'superadmin/login/view_period_timesheet/$1';
$route['con-view-period-timesheet/(:any)'] = 'superadmin/manage_employee/con_view_period_timesheet/$1';
$route['search-sa-con-timesheet'] = 'superadmin/manage_employee/search_sa_con_timesheet';
$route['sadmin-view-period-timesheet/(:any)'] = 'superadmin/manage_employee/sadmin_view_period_timesheet/$1';
$route['sadmin_approve_disapprove_timesheet_period'] = 'superadmin/manage_employee/sadmin_approve_disapprove_timesheet_period';

$route['add-role-rights'] = 'superadmin/manage_role/add_role_rights';
$route['insert-role-rights'] = 'superadmin/manage_role/insert_role_rights';
$route['ajax_menu_list'] = 'superadmin/manage_role/get_menu_list';

$route['add_sadmin_employee_work_order/(:any)'] = 'superadmin/manage_employee/add_admin_employee_work_order/$1';
$route['sadmin_ajax_work_note'] = 'superadmin/manage_employee/get_work_note';
$route['insert_sadmin_employee_work_order'] = 'superadmin/manage_employee/insert_sadmin_employee_work_order';
$route['send-migration-email'] = 'superadmin/manage_employee/load_send_migration_email_page';

$route['sso-settings'] = 'superadmin/profile/sso_settings';
$route['add-document-template'] = 'superadmin/manage_employee/add_document_template';
$route['insert-document-template'] = 'superadmin/manage_employee/insert_document_template';
$route['document-template-list'] = 'superadmin/manage_employee/document_template_list';
$route['edit-document-template/(:any)'] = 'superadmin/manage_employee/edit_document_template/$1';
$route['update-document-template'] = 'superadmin/manage_employee/update_document_template';
$route['add-doc-in-specific-doc-template/(:any)'] = 'superadmin/manage_employee/add_doc_in_specific_doc_template/$1';
$route['upload-doc-in-specific-doc-template'] = 'superadmin/manage_employee/upload_doc_in_specific_doc_template';
$route['doc-list-for-doc-template/(:any)'] = 'superadmin/manage_employee/show_doc_list_for_specific_doc_template/$1';
$route['mockup-add-template-page'] = 'superadmin/manage_employee/mockup_add_template_page';


$route['superadmin-employee-shift-status'] = 'superadmin/manage_employee/all_employee_current_status';
$route['superadmin-addEdit-employee-shifthours'] = 'superadmin/manage_employee/add_employee_shift_test';
$route['insert_shift_break_form_data'] = 'superadmin/manage_employee/insert_shift_break_form_data';
$route['get_employee_clock_data'] = 'superadmin/manage_employee/get_employee_clock_data';
$route['add_admin_employee_shift'] = 'superadmin/manage_employee/add_admin_employee_shift';


$route['superadmin-view-employees-shifthours'] = 'superadmin/manage_employee/all_employee_shift_details';
$route['get_all_employee_shift_details'] = 'superadmin/manage_employee/get_all_employee_shift_details';



$route['superadmin-view-employee-shifthours-detail'] = 'superadmin/manage_employee/get_employee_datewise_shift_summary';
$route['superadmin_get_employee_shift_summary_data_all'] = 'superadmin/manage_employee/get_employee_shift_summary_data_all';
$route['superadmin_change_employee_datewise_shift_summary_status'] = 'superadmin/manage_employee/change_employee_datewise_shift_summary_status';
$route['superadmin_change_employee_datewise_shift_summary_status_disapprove'] = 'superadmin/manage_employee/change_employee_datewise_shift_summary_status_disapprove';



$route['superadmin-employee_shift_list'] = 'superadmin/manage_employee/employee_shift_list';
$route['superadmin-add-new-shift'] = 'superadmin/manage_employee/add_employee_shift_data';
$route['superadmin-add-emp-master-shift-data'] = 'superadmin/manage_employee/add_employee_master_shift_data';
$route['superadmin-delete_current_shift/(:any)'] = 'superadmin/manage_employee/delete_current_shift/$1';
$route['superadmin-edit_current_shift/(:any)'] = 'superadmin/manage_employee/edit_employee_master_shift/$1';
$route['superadmin-edit-emp-master-shift-data'] = 'superadmin/manage_employee/update_employee_master_shift_data';
$route['superadmin-assign_shift_to_employees/(:any)'] = 'superadmin/manage_employee/assign_shift_to_employees/$1';

$route['superadmin-assign_shift_to_employee'] = 'superadmin/manage_employee/assign_shift_to_employee';
$route['superadmin-assign_shift_to_group'] = 'superadmin/manage_employee/assign_shift_to_group';
$route['superadmin-remove_employee_from_shift'] = 'superadmin/manage_employee/remove_employee_from_shift';
$route['superadmin-remove_group_from_shift'] = 'superadmin/manage_employee/remove_group_from_shift';

$route['superadmin-employee_group_list'] = 'superadmin/manage_employee/employee_group_list';
$route['superadmin-create_new_group'] = 'superadmin/manage_employee/create_new_group';
$route['superadmin-assign_group_to_employees/(:any)'] = 'superadmin/manage_employee/assign_group_to_employees/$1';
$route['superadmin-update_group_name'] = 'superadmin/manage_employee/update_group_name';
$route['superadmin-add-remove-employee-from-group/(:any)'] = 'superadmin/manage_employee/add_remove_employee_from_group/$1';
$route['superadmin-save_members_not_members'] = 'superadmin/manage_employee/save_members_not_members';
/* ------------------------------Super Admin-------------------------------- */

/* ------------------------------Admin-------------------------------- */

$route['admin'] = 'admin/login';
$route['admin_valid_login'] = 'admin/login/valid_login';
$route['qr_code/(:any)'] = 'admin/login/qr_code/$1';

$route['admin_okta_login'] = 'admin/login/admin_okta_login'; //okta hosted log in

$route['admin-logout'] = 'admin/login/logout';
$route['change_password'] = 'admin/login/change_password';
$route['update_password'] = 'admin/login/update_password';
$route['admin_dashboard'] = 'admin/login/dashboard';
$route['admin_profile'] = 'admin/profile';
$route['update_documents'] = 'admin/profile/update_documents';
$route['update_vendor_documents'] = 'admin/profile/update_vendor_documents';
$route['admin-view-vendor-profile/(:any)'] = 'admin/manage_vendor/admin_view_vendor_profile/$1';

$route['admin-con-timesheet'] = 'admin/manage_employee/con_timesheet';
$route['admin-emp-timesheet'] = 'admin/manage_employee/emp_timesheet';
$route['admin-historical-timesheet'] = 'admin/manage_employee/admin_historical_timesheet';
$route['admin-load-historical-timesheet'] = 'admin/manage_employee/admin_load_historical_timesheet';
$route['admin-ten99user-timesheet'] = 'admin/manage_ten99user/ten99user_timesheet';
$route['admin-view-period-manage-timesheet/(:any)'] = 'admin/manage_employee/admin_view_period_manage_timesheet/$1';











$route['get_approved_timesheet_data_all'] = 'admin/manage_employee/get_approved_timesheet_data_all';
$route['get_pending_timesheet_data_all'] = 'admin/manage_employee/get_pending_timesheet_data_all';
$route['get_not_approved_timesheet_data_all'] = 'admin/manage_employee/get_not_approved_timesheet_data_all';











$route['manage_expense_request'] = 'admin/manage_employee/manage_expense_request';
// $route['view_employee_all_expense/(:any)'] = 'admin/manage_employee/view_employee_all_expense/$1';

$route['view_employee_all_expense'] = 'admin/manage_employee/view_employee_all_expense';

// $route['view_expense_form/(:any)'] = 'admin/manage_employee/view_expense_form/$1';

$route['view_expense_form/(:any)/(:any)'] = 'admin/manage_employee/view_expense_form/$1/$2';

$route['update_admin_expense_approval_request'] = 'admin/manage_employee/update_admin_expense_approval_request';

$route['get_expense_pdf'] = 'admin/manage_employee/get_expense_pdf';


$route['manage_payroll'] = 'admin/manage_employee/manage_payroll';
$route['get_payroll_data'] = 'admin/manage_employee/get_payroll_data';
$route['store_payroll_table_data'] = 'admin/manage_employee/store_payroll_table_data';
$route['truncate_payroll_table_data'] = 'admin/manage_employee/truncate_payroll_table_data';



$route['manage_purchase_order'] = 'admin/manage_employee/manage_purchase_order';
$route['insert_purchase_order'] = 'admin/manage_employee/insert_purchase_order';
$route['add_purchase_order_form'] = 'admin/manage_employee/add_purchase_order_form';
$route['show_purchase_order_pdf'] =  'admin/manage_employee/show_purchase_order_pdf';















$route['add-admin-con-timesheet'] = 'admin/manage_employee/add_con_timesheet';
$route['add-admin-emp-timesheet'] = 'admin/manage_employee/add_emp_timesheet';

$route['ajax_admin_con_project_list'] = 'admin/manage_employee/get_con_project_list';
$route['ajax_admin_emp_project_list'] = 'admin/manage_employee/get_emp_project_list';

$route['ajax_get_admin_con_timesheet_list'] = 'admin/manage_employee/ajax_con_timesheet_list';
$route['ajax_get_admin_emp_timesheet_list'] = 'admin/manage_employee/ajax_emp_timesheet_list';
$route['insert_new_admin_con_timesheet'] = 'admin/manage_employee/insert_new_con_timesheet';
$route['insert_new_admin_emp_timesheet'] = 'admin/manage_employee/insert_new_emp_timesheet';

$route['admin-change-password'] = 'admin/login/admin_change_password';
$route['admin_update_password'] = 'admin/login/admin_update_password';

$route['admin-forgot-password'] = 'admin/login/forgot_password';
$route['valid_admin_forgot_password'] = 'admin/login/valid_forgot_password';
$route['admin-otp-forgot-password'] = 'admin/login/otp_forgot_password';
$route['admin_valid_otp'] = 'admin/login/valid_otp';
$route['admin_reset_password'] = 'admin/login/admin_reset_password';
$route['admin-reset-password/(:any)'] = 'admin/login/reset_password/$1';
$route['ajax_change_uscis_status_admin'] = 'admin/manage_employee/ajax_change_uscis_status';

$route['admin_vendor_lists'] = 'admin/manage_vendor/vendor_lists';

$route['update_vendor_bg_status/(:any)/(:any)'] = 'admin/manage_vendor/update_bg_status/$1/$2';
$route['bg_check_report_file'] = 'admin/report_file';
$route['submit-vendor-consultant-form'] = 'admin/manage_vendor/submit_consultant_form';

$route['add_admin_vendor'] = 'admin/manage_vendor';
$route['edit_admin_vendor/(:any)'] = 'admin/manage_vendor/edit_vendor/$1';
$route['change_admin_vendor_block_status'] = 'admin/manage_vendor/change_block_status';
$route['change_admin_vendor_status'] = 'admin/manage_vendor/change_status';
$route['insert_admin_vendor'] = 'admin/manage_vendor/add_vendor';
$route['update_admin_vendor'] = 'admin/manage_vendor/update_vendor';
$route['delete-vendor-user'] = 'admin/manage_vendor/delete_vendor_user';

$route['add-admin-vendor-user-sd'] = 'admin/manage_vendor/add_admin_vendor_user_sd';
$route['insert_admin_vendor_sd'] = 'admin/manage_vendor/add_admin_vendor_sd';

$route['admin_consultant_lists'] = 'admin/manage_employee/employee_lists';
$route['update_employee_bg_status/(:any)/(:any)'] = 'admin/manage_employee/update_bg_status/$1/$2';
$route['bg_check_report_file'] = 'admin/report_file';
$route['submit-admin-consultant-form'] = 'admin/manage_employee/submit_consultant_form';
$route['add_admin_employee'] = 'admin/manage_employee';
$route['insert_admin_employee'] = 'admin/manage_employee/add_employee';
$route['change_admin_employee_block_status'] = 'admin/manage_employee/change_block_status';
$route['change_admin_employee_status'] = 'admin/manage_employee/change_status';
$route['edit_admin_employee/(:any)'] = 'admin/manage_employee/edit_employee/$1';
$route['update_admin_employee'] = 'admin/manage_employee/update_employee';
$route['insert_payment_comment'] = 'admin/manage_employee/insert_payment_comment';

$route['admin_project_lists'] = 'admin/manage_employee/admin_project_lists';
$route['add_admin_projects'] = 'admin/manage_employee/add_admin_projects';
$route['insert_admin_projects'] = 'admin/manage_employee/insert_projects';
$route['update_admin_projects'] = 'admin/manage_employee/update_admin_projects';
$route['edit_admin_projects/(:any)'] = 'admin/manage_employee/edit_admin_projects/$1';

$route['update_admin_profile'] = 'admin/profile/update_profile';
$route['view_admin_vendor_documents/(:any)'] = 'admin/manage_vendor/view_admin_vendor_documents/$1';
$route['verify_documents'] = 'admin/manage_vendor/verify_documents';
$route['verify_vendor_documents/(:any)'] = 'admin/manage_vendor/verify_vendor_documents/$1';

$route['view_admin_employees_timesheet/(:any)'] = 'admin/manage_employee/view_employees_timesheet/$1';
$route['view_admin_project_timesheet/(:any)/(:any)'] = 'admin/manage_employee/view_project_timesheet/$1/$2';

$route['edit_admin_employee_work_order/(:any)'] = 'admin/manage_employee/edit_admin_employee_work_order/$1';
$route['update_admin_employee_work_order'] = 'admin/manage_employee/update_admin_employee_work_order';

$route['approve_invoice'] = 'admin/manage_employee/approve_invoice';
$route['delete-admin-consultant-invoice'] = 'admin/manage_employee/delete_consultant_invoice';
$route['delete-admin-vendor-invoice'] = 'admin/manage_employee/delete_vendor_invoice';

$route['view_admin_employees_work_order/(:any)'] = 'admin/manage_employee/view_admin_employees_work_order/$1';
$route['view_admin_employees_work_order_pdf/(:any)'] = 'admin/manage_employee/view_admin_employees_work_order_pdf/$1';
$route['invoice_pdf/(:any)'] = 'admin/manage_employee/invoice_pdf/$1';
//$route['admin_invoice_pdf/(:any)'] = 'admin/manage_employee/admin_invoice_pdf/$1';
$route['admin_invoice_pdf/(:any)'] = 'invoice/admin_invoice_pdf/$1';

$route['admin_compose'] = 'admin/manage_communication';
$route['admin_send_mail'] = 'admin/manage_communication/send_mail';
$route['get_admin_recipient_emails'] = 'admin/manage_communication/get_recipient_emails';
$route['admin_sent_items'] = 'admin/manage_communication/sent_items';
$route['admin_sent_mail_details/(:any)'] = 'admin/manage_communication/sent_mail_details/$1';
$route['admin_inbox'] = 'admin/manage_communication/inbox';
$route['admin_inbox_mail_details/(:any)'] = 'admin/manage_communication/inbox_mail_details/$1';
$route['admin_inbox_mail_reply/(:any)/(:any)'] = 'admin/manage_communication/admin_inbox_mail_reply/$1/$2';
$route['admin_send_reply'] = 'admin/manage_communication/admin_send_reply';

$route['get_admin_notification_count'] = 'admin/manage_communication/get_notification_count';
$route['get_admin_mail_notification'] = 'admin/manage_communication/get_mail_notification';
$route['get_admin_others_notification_count'] = 'admin/manage_communication/get_others_notification_count';
$route['get_admin_others_notification_details'] = 'admin/manage_communication/get_admin_others_notification_details';




$route['approve_shift_notification'] = 'admin/manage_communication/approve_shift_notification';
$route['disapprove_shift_notification'] = 'admin/manage_communication/disapprove_shift_notification';







$route['view_vendor_document/(:any)/(:any)'] = 'admin/manage_vendor/view_vendor_document/$1/$2';
/**Vendor Documents**/
$route['admin_view_vendor_submitted_document/(:any)/(:any)'] = 'admin/manage_vendor/view_vendor_submiited_document/$1/$2';
/**Vendor Documents**/
$route['add_admin_employee_work_order/(:any)'] = 'admin/manage_employee/add_admin_employee_work_order/$1';
$route['insert_admin_employee_work_order'] = 'admin/manage_employee/insert_admin_employee_work_order';


$route['admin_approve_disapprove_consultant'] = 'admin/manage_employee/admin_approve_disapprove_consultant';
$route['admin_approve_disapprove_ucsic_docs'] = 'admin/manage_employee/approve_disapprove_ucsic_docs';

$route['approve_disapprove_timesheet_period'] = 'admin/manage_employee/admin_approve_disapprove_timesheet_period';
$route['admin_approve_disapprove_timesheet'] = 'admin/manage_employee/approve_disapprove_timesheet';
$route['view_consultant_details/(:any)'] = 'admin/manage_employee/view_consultant_details/$1';
$route['view_admin_consultant_documents/(:any)'] = 'admin/manage_employee/view_consultant_documents/$1';
$route['admin_notifications/(:any)'] = 'admin/login/admin_notifications/$1';

$route['admin_notifications_new'] = 'admin/login/admin_notifications_new';

$route['insert_admin_payment_comment'] = 'admin/manage_employee/insert_payment_comment';
$route['admin_payment_comments/(:any)'] = 'admin/manage_employee/admin_payment_comments/$1';
$route['check-payment-due-date'] = 'admin/manage_invoice/check_payment_due_date';

$route['see_all_notifications'] = 'admin/login/see_all_notifications';


/* ------------------------------ 1099 User Admin Section -------------------------------- */

$route['admin_1099users_lists'] = 'admin/manage_ten99user/admin_ten99user_list';
$route['view_admin_ten99user_documents/(:any)'] = 'admin/manage_ten99user/view_ten99user_documents/$1';
$route['admin_approve_disapprove_ten99user_documents'] = 'admin/manage_ten99user/approve_disapprove_ten99user_documents';
$route['view_admin_ten99user_timesheet/(:any)'] = 'admin/manage_ten99user/view_ten99user_timesheet/$1';
$route['admin-view-ten99user-period-timesheet/(:any)'] = 'admin/manage_ten99user/admin_view_ten99user_period_timesheet/$1';
$route['approve_disapprove_ten99user_timesheet_period'] = 'admin/manage_ten99user/admin_approve_disapprove_ten99user_timesheet_period';
$route['add-admin-ten99-user'] = 'admin/manage_ten99user/add_admin_ten99_user';
$route['insert_admin_ten99_user'] = 'admin/manage_ten99user/insert_admin_ten99_user';
$route['assign-projects-to-ten99user'] = 'admin/manage_ten99user/assign_project_to_ten99user';
$route['add-admin-assign-ten99user-projects'] = 'admin/manage_ten99user/add_assign_ten99user_projects';

$route['view_admin_ten99user_work_order_pdf/(:any)'] = 'admin/manage_ten99user/view_admin_ten99user_work_order_pdf/$1';
$route['edit_admin_ten99user_work_order/(:any)'] = 'admin/manage_ten99user/edit_admin_ten99user_work_order/$1';
$route['update_admin_ten99user_work_order'] = 'admin/manage_ten99user/update_admin_ten99user_work_order';
$route['add_admin_ten99user_work_order/(:any)'] = 'admin/manage_ten99user/add_admin_ten99user_work_order/$1';
$route['insert_admin_ten99user_work_order'] = 'admin/manage_ten99user/insert_admin_ten99user_work_order';

$route['generate-ten99user-login-details/(:any)'] = 'admin/manage_ten99user/generate_ten99user_login_details/$1';
$route['insert_ten99user_login_details'] = 'admin/manage_ten99user/insert_ten99user_login_details';
$route['admin_ten99user_onboarding/(:any)'] = 'admin/manage_ten99user/ten99user_onboarding/$1';
$route['edit-admin-ten99-user/(:any)'] = 'admin/manage_ten99user/edit_admin_ten99_user/$1';
$route['update-admin-ten99-user'] = 'admin/manage_ten99user/update_admin_ten99_user';
$route['add-admin-ten99user-timesheet'] = 'admin/manage_ten99user/add_ten99user_timesheet';
$route['insert_new_admin_ten99user_timesheet'] = 'admin/manage_ten99user/insert_new_ten99user_timesheet';
/* ------------------------------ 1099 User Admin Section ------------------------------- */


$route['admin-employee-list'] = 'admin/manage_employee/admin_employee_list';





$route['all-admin-employee-list'] = 'admin/manage_employee/all_admin_employee_list';
$route['admin-direct-report-list'] = 'admin/manage_employee/admin_direct_report_list';






$route['add-admin-employee-user'] = 'admin/manage_employee/add_admin_employee_user';
$route['insert_admin_employee_user'] = 'admin/manage_employee/insert_admin_employee_user';
$route['edit-admin-employee-user/(:any)'] = 'admin/manage_employee/edit_admin_employee_user/$1';

$route['add-new-shift'] = 'admin/manage_employee/add_employee_shift_data';
$route['add-emp-master-shift-data'] = 'admin/manage_employee/add_employee_master_shift_data';
$route['addEdit-employee-shifthours'] = 'admin/manage_employee/add_employee_shift_test';
$route['view-employees-shifthours'] = 'admin/manage_employee/all_employee_shift_details';
$route['get_all_employee_shift_details'] = 'admin/manage_employee/get_all_employee_shift_details';


$route['view-employee-shifthours-detail'] = 'admin/manage_employee/get_employee_datewise_shift_summary';
$route['get_employee_shift_summary_data_all'] = 'admin/manage_employee/get_employee_shift_summary_data_all';
$route['change_employee_datewise_shift_summary_status'] = 'admin/manage_employee/change_employee_datewise_shift_summary_status';
$route['change_employee_datewise_shift_summary_status_disapprove'] = 'admin/manage_employee/change_employee_datewise_shift_summary_status_disapprove';
$route['approve-deny-email-page/(:any)/(:any)'] = 'admin/manage_employee/approve_deny_email_page/$1/$2';

$route['insert_shift_break_form_data'] = 'admin/manage_employee/insert_shift_break_form_data';
$route['get_employee_clock_data'] = 'admin/manage_employee/get_employee_clock_data';
$route['add_admin_employee_shift'] = 'admin/manage_employee/add_admin_employee_shift';
$route['employee-shift-status'] = 'admin/manage_employee/all_employee_current_status';
$route['employee_shift_list'] = 'admin/manage_employee/employee_shift_list';
$route['assign_shift_to_employees/(:any)'] = 'admin/manage_employee/assign_shift_to_employees/$1';
$route['submit-all-employee-shift'] = 'admin/manage_employee/submit_all_employee_shift';

$route['employee_group_list'] = 'admin/manage_employee/employee_group_list';

$route['create_new_group'] = 'admin/manage_employee/create_new_group';







$route['activate_group/(:any)'] = 'admin/manage_employee/activate_group/$1';
$route['deactivate_group/(:any)'] = 'admin/manage_employee/deactivate_group/$1';









$route['delete_current_shift/(:any)'] = 'admin/manage_employee/delete_current_shift/$1';
$route['edit_current_shift/(:any)'] = 'admin/manage_employee/edit_current_shift/$1';






$route['update_group_name'] = 'admin/manage_employee/update_group_name';




$route['assign_group_to_employees/(:any)'] = 'admin/manage_employee/assign_group_to_employees/$1';
$route['add-remove-employee-from-group/(:any)'] = 'admin/manage_employee/add_remove_employee_from_group/$1';
$route['save_members_not_members'] = 'admin/manage_employee/save_members_not_members';
$route['blank-test-page'] = 'admin/manage_employee/blank_test_page';

$route['assign_shift_to_employee'] = 'admin/manage_employee/assign_shift_to_employee';
$route['assign_shift_to_group'] = 'admin/manage_employee/assign_shift_to_group';
$route['remove_employee_from_shift'] = 'admin/manage_employee/remove_employee_from_shift';




$route['all-shift-list'] = 'admin/manage_employee/all_shift_list';
$route['delete-employee-master-shift'] = 'admin/manage_employee/delete_employee_master_shift';
$route['edit_current_shift/(:any)'] = 'admin/manage_employee/edit_employee_master_shift/$1';
$route['edit-emp-master-shift-data'] = 'admin/manage_employee/update_employee_master_shift_data';






$route['update-admin-employee-user'] = 'admin/manage_employee/update_admin_employee_user';
$route['assign-projects-to-employee'] = 'admin/manage_employee/assign_project_to_employee';
$route['assign-projects-to-admin-consultant'] = 'admin/manage_employee/assign_projects_to_admin_consultant';
$route['add-admin-assign-projects'] = 'admin/manage_employee/add_assign_projects';
$route['add-admin-assign-projects-consultant'] = 'admin/manage_employee/add_assign_projects_consultant';
$route['generate-employee-login-details/(:any)'] = 'admin/manage_employee/generate_employee_login_details/$1';
$route['generate-admin-consultant-login-details/(:any)'] = 'admin/manage_employee/generate_admin_consultant_login_details/$1';
$route['insert_employee_login_details'] = 'admin/manage_employee/insert_employee_login_details';
$route['insert_admin_consultant_login_details'] = 'admin/manage_employee/insert_admin_consultant_login_details';
$route['add_employee_work_order/(:any)'] = 'admin/manage_employee/add_employee_work_order/$1';
$route['insert_employee_work_order'] = 'admin/manage_employee/insert_employee_work_order';
$route['view_employees_work_order_pdf/(:any)'] = 'admin/manage_employee/view_employees_work_order_pdf/$1';

$route['admin_approve_disapprove_documents'] = 'admin/manage_employee/approve_disapprove_documents';
$route['admin_approve_disapprove_vendor_documents'] = 'admin/manage_vendor/approve_disapprove_vendor_documents';

$route['admin_employee_onboarding/(:any)'] = 'admin/manage_employee/consultant_onboarding/$1';
$route['migrate'] = 'admin/migrate/consultant_onboarding';
$route['upload_admin_employee_documents/(:any)'] = 'admin/manage_employee/upload_consultant_documents/$1';
$route['admin_upload_consultant_document'] = 'admin/manage_employee/upload_document';

$route['admin-show-files/(:any)/(:any)'] = 'admin/profile/show_files/$1/$2';
$route['uploads-admin-vendor-documents/(:any)/(:any)'] = 'admin/manage_vendor/uploads_admin_vendor_documents/$1/$2';
$route['admin_upload_vendor_document'] = 'admin/manage_vendor/upload_document';

$route['admin-generate-invoice/(:any)'] = 'admin/manage_employee/generate_admin_employee_payment/$1';
$route['admin_ajax_monthly_timesheet'] = 'admin/manage_employee/ajax_monthly_timesheet';
$route['admin_ajax_weekly_timesheet'] = 'admin/manage_employee/ajax_weekly_timesheet';
$route['admin_generate_payment'] = 'admin/manage_employee/admin_generate_payment';

$route['ajax_admin_state_list'] = 'admin/manage_vendor/get_state_list';
$route['ajax_admin_city_list'] = 'admin/manage_vendor/get_city_list';
$route['ajax_work_note'] = 'admin/manage_employee/get_work_note';
$route['admin-view-period-timesheet/(:any)'] = 'admin/login/admin_view_period_timesheet/$1';
$route['admin-view-period-timesheet-view/(:any)'] = 'admin/login/admin_view_period_timesheet_view/$1';

$route['ajax_get_con_timesheet_list'] = 'superadmin/manage_employee/ajax_con_timesheet_list';
$route['ajax_get_emp_timesheet_list'] = 'superadmin/manage_employee/ajax_emp_timesheet_list';
$route['insert_new_con_timesheet'] = 'superadmin/manage_employee/insert_new_con_timesheet';
$route['insert_new_emp_timesheet'] = 'superadmin/manage_employee/insert_new_emp_timesheet';

/* Admin new invoice */

$route['admin_consultant_invoice'] = 'admin/manage_employee/admin_employee_invoice';

$route['admin_consultant_invoice_summary'] = 'admin/manage_employee/admin_consultant_invoice_summary';
$route['admin_vendor_invoice_summary'] = 'admin/manage_employee/admin_vendor_invoice_summary';
$route['admin_employee_invoice_summary'] = 'admin/manage_employee/admin_employee_invoice_summary';
$route['edit-admin-employee-invoice-summary/(:any)'] = 'admin/manage_employee/edit_admin_employee_invoice_summary/$1';
$route['update_admin_employee_invoice_summary'] = 'admin/manage_employee/update_admin_employee_invoice_summary';
$route['admin-timesheet'] = 'admin/login/load_admin_timesheet_page';
$route['admin-consultant-invoice-summery'] = 'admin/login/load_admin_cons_invoice_summery_page';
$route['admin-employee-invoice-summery'] = 'admin/login/load_admin_emp_invoice_summery_page';
$route['admin-ten99-invoice-summery'] = 'admin/login/load_admin_ten99_invoice_summery_page';
$route['admin-emp-invoice-payment'] = 'admin/manage_employee/insert_invoice_payment_details';
$route['admin-company-policy'] = 'admin/manage_employee/show_admin_company_policy';
$route['add-admin-company-policy'] = 'admin/manage_employee/load_add_company_policy_doc_page';
$route['admin-requisition'] = 'admin/manage_employee/show_requisition';
$route['add-admin-requisition'] = 'admin/manage_employee/add_requisition';
$route['insert-admin-requisition'] = 'admin/manage_employee/insert_requisition';
$route['admin-view-requisition/(:any)'] = 'admin/manage_employee/view_specific_requisition/$1';
$route['add-admin-requisition-to-vendor'] = 'admin/manage_employee/add_requisition_to_vendor';
$route['admin-requisition-vendor-list'] = 'admin/manage_employee/requisition_vendor_list';
$route['admin-requisition-candidate-list/(:any)'] = 'admin/manage_employee/requisition_candidate_list/$1';
$route['admin-requisition-view-candidate/(:any)'] = 'admin/manage_employee/requisition_view_candidate/$1';
$route['admin-add-requisition-candidate'] = 'admin/manage_employee/requisition_add_candidate';
$route['admin-add-requisition-candidate/(:any)'] = 'admin/manage_employee/requisition_add_candidate/$1';
$route['admin-insert-requisition-candidate'] = 'admin/manage_employee/requisition_insert_candidate';
$route['admin-add-paid-stuff'] = 'admin/manage_employee/add_paid_stuff';
$route['insert-admin-add-paid-stuff'] = 'admin/manage_employee/insert_paid_stuff_document';
$route['admin-add-w2'] = 'admin/manage_employee/add_w2';
$route['insert-admin-add-w2'] = 'admin/manage_employee/insert_w2_document';
$route['view-admin-emp-paid-stuff-and-w2/(:any)'] = 'admin/manage_employee/view_emp_paid_stuff_and_w2/$1';
$route['admin-manage-documents'] = 'admin/manage_employee/admin_manage_documents';
$route['admin-add-cons-emp-documents'] = 'admin/manage_employee/admin_add_cons_document';
$route['insert-admin-documentation-form'] = 'admin/manage_employee/insert_admin_documentation_form';
$route['admin-edit-cons-emp-document/(:any)'] = 'admin/manage_employee/admin_edit_cons_emp_document_page/$1';
$route['admin-update-cons-emp-document'] = 'admin/manage_employee/admin_update_cons_emp_document';
$route['admin-upload-historical-approved-work-order/(:any)'] = 'admin/manage_employee/upload_historical_approved_work_order/$1';
$route['admin-insert-historical-approved-work-order'] = 'admin/manage_employee/insert_historical_approved_work_order';
$route['admin-historical-approved-work-order-list/(:any)'] = 'admin/manage_employee/historical_approved_work_order_list/$1';

/* ------------------------------Admin-------------------------------- */

/* ------------------------------Vendor-------------------------------- */
$route['vendor'] = 'vendor/login';
$route['registration'] = 'vendor/login/registration';
$route['vendor-logout'] = 'vendor/login/logout';
$route['verify_registration/(:any)'] = 'vendor/login/verify_registration/$1';
$route['vendor_valid_registration'] = 'vendor/login/vendor_valid_registration';
$route['vendor_reg_verification'] = 'vendor/login/vendor_reg_verification';
$route['vendor_verify'] = 'vendor/login/vendor_verify';
$route['vendor_registration_verification'] = 'vendor/login/vendor_registration_verification';
$route['vendor_valid_login'] = 'vendor/login/valid_login';

$route['vendor_qr_code/(:any)'] = 'vendor/login/qr_code/$1';

$route['vendor_okta_login'] = 'vendor/login/vendor_okta_login'; //okta hosted log in

$route['vendor_change_password'] = 'vendor/login/change_password';
$route['vendor_update_password'] = 'vendor/login/update_password';
$route['vendor-change-old-password'] = 'vendor/login/vendor_change_old_password';
$route['vendor_update_old_password'] = 'vendor/login/vendor_update_old_password';
$route['vendor_dashboard'] = 'vendor/login/dashboard';

$route['vendor-update-details'] = 'vendor/login/vendor_update_details';

$route['vendor-forgot-password'] = 'vendor/login/forgot_password';
$route['valid_vendor_forgot_password'] = 'vendor/login/valid_forgot_password';
$route['vendor-otp-forgot-password'] = 'vendor/login/otp_forgot_password';
$route['vendor_valid_otp'] = 'vendor/login/valid_otp';
$route['vendor_reset_password'] = 'vendor/login/vendor_reset_password';
$route['vendor-reset-password/(:any)'] = 'vendor/login/reset_password/$1';

$route['vendor_profile'] = 'vendor/profile';
$route['update_vendor_profile'] = 'vendor/profile/update_profile';
$route['ajax_vendor_state_list'] = 'vendor/profile/get_state_list';
$route['ajax_vendor_city_list'] = 'vendor/profile/get_city_list';

$route['vendor_consultant_lists'] = 'vendor/manage_employee/employee_lists';
$route['add_vendor_consultant'] = 'vendor/manage_employee';
$route['insert_vendor_employee'] = 'vendor/manage_employee/add_employee';
$route['edit_vendor_consultant/(:any)'] = 'vendor/manage_employee/edit_employee/$1';
$route['update_vendor_employee'] = 'vendor/manage_employee/update_employee';
$route['change_vendor_employee_block_status'] = 'vendor/manage_employee/change_block_status';
$route['change_vendor_employee_status'] = 'vendor/manage_employee/change_status';

$route['vendor_documentation'] = 'vendor/profile/documents_lists';
$route['upload_vendor_documents'] = 'vendor/profile/upload_vendor_documents';
$route['upload_verification_documents'] = 'vendor/profile/upload_verification_documents';
$route['upload_documents'] = 'vendor/profile/upload_documents';

$route['vendor_consultant_timesheet'] = 'vendor/manage_employee/employee_timesheet';
$route['view_consultant_timesheet/(:any)'] = 'vendor/manage_employee/view_employees_timesheet/$1';
$route['add_vendor_employee_work_order/(:any)'] = 'vendor/manage_employee/add_vendor_employee_work_order/$1';
$route['insert_vendor_employee_work_order'] = 'vendor/manage_employee/insert_vendor_employee_work_order';
$route['edit_vendor_consultant_work_order/(:any)'] = 'vendor/manage_employee/edit_vendor_employee_work_order/$1';
$route['update_vendor_employee_work_order'] = 'vendor/manage_employee/update_vendor_employee_work_order';

$route['add_projects'] = 'vendor/manage_employee/add_projects';
$route['assign_project_to_consultant'] = 'vendor/manage_employee/assign_project_to_employee';
$route['add_assign_projects'] = 'vendor/manage_employee/add_assign_projects';

$route['projects_lists'] = 'vendor/manage_employee/project_lists';
$route['add-projects'] = 'superadmin/manage_employee/add_projects';
$route['insert_superadmin_projects'] = 'superadmin/manage_employee/insert_projects';
$route['update_superadmin_projects'] = 'superadmin/manage_employee/update_superadmin_projects';
$route['edit-superamdin-projects/(:any)'] = 'superadmin/manage_employee/edit_superadmin_projects/$1';

$route['ajax_vendor_list'] = 'superadmin/manage_employee/get_vendor_list';

$route['open_requirements'] = 'vendor/manage_employee/open_requirements';
$route['view_consultant/(:any)'] = 'vendor/manage_employee/view_employee/$1';
$route['insert_projects'] = 'vendor/manage_employee/insert_projects';
$route['update_projects'] = 'vendor/manage_employee/update_projects';
$route['edit_projects/(:any)'] = 'vendor/manage_employee/edit_projects/$1';
$route['tasks_lists/(:any)'] = 'vendor/manage_employee/tasks_lists/$1';
$route['add_tasks'] = 'vendor/manage_employee/add_tasks';
$route['insert_tasks'] = 'vendor/manage_employee/insert_tasks';
$route['edit_tasks/(:any)'] = 'vendor/manage_employee/edit_tasks/$1';
$route['update_tasks'] = 'vendor/manage_employee/update_tasks';
$route['view_vendor_project_timesheet/(:any)/(:any)'] = 'vendor/manage_employee/view_project_timesheet/$1/$2';
$route['ajax_vendor_timesheet_list'] = 'vendor/manage_employee/get_timesheet_list';
$route['change_timesheet_approve_status'] = 'vendor/manage_employee/change_timesheet_approve_status';
$route['approve_disapprove_timesheet'] = 'vendor/manage_employee/approve_disapprove_timesheet';

$route['all_documents_lists'] = 'vendor/profile/all_documents_lists';
$route['invoice'] = 'vendor/profile/invoice';
$route['invoice_submit'] = 'vendor/profile/invoice_submit';

$route['submit_documents/(:any)/(:any)'] = 'vendor/profile/submit_documents/$1/$2';

$route['add_ach_form'] = 'vendor/profile/add_ach_form';
$route['add_subcontractor_form'] = 'vendor/profile/add_subcontractor_form';
$route['add_insurance_form'] = 'vendor/profile/add_insurance_form';
$route['add_nda_form'] = 'vendor/profile/add_nda_form';

$route['view_consultant_work_order/(:any)'] = 'vendor/manage_employee/view_employees_work_order/$1';
$route['generate_invoice/(:any)/(:any)'] = 'vendor/manage_employee/generate_invoice/$1/$2';
$route['view_consultant_work_order_pdf/(:any)'] = 'vendor/manage_employee/view_employees_work_order_pdf/$1';

$route['generate_vendor_consultant_invoice/(:any)'] = 'vendor/manage_employee/generate_vendor_employee_payment/$1';
$route['generate_vendor_payment'] = 'vendor/manage_employee/generate_vendor_payment';
$route['vendor_consultant_invoice'] = 'vendor/manage_employee/vendor_employee_payment';
$route['search_vendor_payment'] = 'vendor/manage_employee/search_vendor_payment';
$route['search_by_emp_code'] = 'vendor/manage_employee/search_by_emp_code';
$route['ajax_monthly_timesheet'] = 'vendor/manage_employee/ajax_monthly_timesheet';
$route['ajax_weekly_timesheet'] = 'vendor/manage_employee/ajax_weekly_timesheet';
$route['ajax_daily_timesheet'] = 'vendor/manage_employee/ajax_daily_timesheet';

//$route['vendor_consultant_invoice'] = 'vendor/manage_employee/vendor_employee_invoice';
$route['vendor_invoice_pdf/(:any)'] = 'vendor/manage_employee/vendor_invoice_pdf/$1';

$route['vendor_compose'] = 'vendor/manage_communication';
$route['vendor_send_mail'] = 'vendor/manage_communication/send_mail';
$route['get_vendor_recipient_emails'] = 'vendor/manage_communication/get_recipient_emails';
$route['vendor_sent_items'] = 'vendor/manage_communication/sent_items';
$route['vendor_sent_mail_details/(:any)'] = 'vendor/manage_communication/sent_mail_details/$1';
$route['vendor_inbox'] = 'vendor/manage_communication/inbox';
$route['vendor_inbox_mail_details/(:any)'] = 'vendor/manage_communication/inbox_mail_details/$1';
$route['vendor_inbox_mail_reply/(:any)/(:any)'] = 'vendor/manage_communication/vendor_inbox_mail_reply/$1/$2';
$route['vendor_send_reply'] = 'vendor/manage_communication/vendor_send_reply';

$route['get_vendor_notification_count'] = 'vendor/manage_communication/get_notification_count';
$route['get_vendor_mail_notification'] = 'vendor/manage_communication/get_mail_notification';

$route['generate_consultant_login_details/(:any)'] = 'vendor/manage_employee/generate_consultant_login_details/$1';
$route['generate_login_details'] = 'vendor/manage_employee/generate_login_details';

$route['consultant_onboarding/(:any)'] = 'vendor/manage_employee/consultant_onboarding/$1';
$route['upload_vendor_consultant_documents/(:any)'] = 'vendor/manage_employee/upload_consultant_documents/$1';
$route['upload_consultant_document'] = 'vendor/manage_employee/upload_document';
$route['upload_vendor_document'] = 'vendor/profile/upload_file';

$route['upload_vendor_files/(:any)/(:any)'] = 'vendor/profile/upload_vendor_files/$1/$2';
$route['vendor-show-files/(:any)/(:any)'] = 'vendor/profile/show_files/$1/$2';

$route['vendor_notifications'] = 'vendor/login/vendor_notifications';
$route['insert_vendor_payment_comment'] = 'vendor/manage_employee/insert_payment_comment';
$route['vendor_payment_comments/(:any)'] = 'vendor/manage_employee/vendor_payment_comments/$1';

$route['get_vendor_others_notification_count'] = 'vendor/manage_communication/get_others_notification_count';
$route['get_vendor_others_notification_details'] = 'vendor/manage_communication/get_vendor_others_notification_details';

$route['vcon-view-period-timesheet/(:any)'] = 'vendor/manage_employee/con_view_period_timesheet/$1';
$route['generate_con_invoice_by_vendor'] = 'vendor/manage_employee/generate_con_invoice_by_vendor';
/* ------------------------------Vendor-------------------------------- */


/* ---------------------------Communication--------------------------- */

$route['sa_communication'] = 'superadmin/manage_communication';
$route['sa_compose'] = 'superadmin/manage_communication/sa_compose';

$route['submit_employee_documents/(:any)/(:any)'] = 'employee/profile/submit_documents/$1/$2';
$route['add_direct_deposit_form'] = 'employee/profile/add_direct_deposit_form';
$route['add_code_job_form'] = 'employee/profile/add_code_job_form';
$route['test_id_analyzer'] = 'employee/profile/test_id_analyzer';

/* ---------------------------Communication--------------------------- */


$route['404_override'] = '';


/* End of file routes.php */
/* Location: ./application/config/routes.php */
