<?php
function combineImagePdf($files=[]) {
	$uploads = array();
	$target_path   = FCPATH . "uploads/imagetopdf/";
	foreach ($files as $file) {
		array_push($uploads, FCPATH . "tests/".$file);;
	}
	$filename="combine".rand().".pdf";
	$pdf = new Imagick($uploads);
	$pdf->setImageFormat('pdf');

	$pdf->writeImages($target_path.$filename, true); 
	$buffer = file_get_contents($target_path.$filename);
}

function two_dimensional_arr_search($permission_arr, $menu_id_str, $menu_id_val)
{
   foreach($permission_arr as $key => $per)
   {
      if ($per[$menu_id_str] === $menu_id_val)
        return $key;
   }
   return false;
}

function get_date_db_value($date_val_db_format) {

	return date("m/d/Y", strtotime($date_val_db_format));  
}

function get_db_date_range($input_db_date, $is_increment = true) {

	$db_dates[] = $input_db_date;
	$db_operator = $is_increment ? "+" : "-"; 

	for ($i = 1; $i < 7; $i++) {
		$db_dates[] .= date('m/d/Y', strtotime("$db_operator $i day", strtotime($input_db_date)));
	}

	print_r($db_dates);

	return $db_dates;
}

function get_db_decrement_date_range($input_db_date) {

	$db_dates[] = $input_db_date;

	for($i=1; $i<7; $i++) {
		$db_dates[] .= date('m/d/Y', strtotime("-$i day", strtotime($input_db_date)));
	}
	return $db_dates;	
}

function get_db_increment_date_range($input_db_date) {

	$db_dates[] = $input_db_date;

	for($i=1; $i<7; $i++) {
		$db_dates[] .= date('m/d/Y', strtotime("+$i day", strtotime($input_db_date)));
	}
	return $db_dates;
}

function get_login_user_types($current_user_type = "", $return_drop_down_html = false) {

	global $global_user_types;

	if (!empty($global_user_types)) {
		if ($return_drop_down_html) {
			$output = '';

			foreach ($global_user_types as $_each_type_key => $_each_type_text) {
				if (SHOW_DEMO && $_SERVER['REQUEST_URI'] != '/sadmin' && 'sadmin' == $_each_type_key) {
					continue;
				}

				$_each_select = '';
				$_each_base_url = ('sadmin' == $_each_type_key) ? base_url() : base_url($_each_type_key);

				if ($_each_type_key == $current_user_type) {
					$_each_select = ' selected';
					$_each_base_url = '';
				}

				$output .= '<option value="' . $_each_base_url . '"' . $_each_select . '>' . $_each_type_text . '</option>';

				unset($_each_select, $_each_base_url);
			}

			return $output;
		} else {
			if (empty($current_user_type)) {
				return $global_user_types;
			} else {
				return $global_user_types[$current_user_type];
			}
		}
	}

	return '';
}

/**
 * Shows the Rate types and returns its HTML.
 *
 * @param      string  $key          Key literal (if any)
 * @param      bool    $return_html  Whether to return HTML (true | false)
 * @param      string  $input_type   Input type ('dropdown' | 'checkbox')
 * @param      string  $input_name   Input name (without [], if any)
 * @param      string  $input_id     Input identifier (if any)
 * @param      string  $input_class  Input CSS class/es (if any)
 *
 * @return     string  Returns either the HTML or the Rate type value itself
 */
function show_rate_type($key = '', $return_html = true, $input_type = 'dropdown', $input_name = '', $input_id = '', $input_class = '') {

	global $global_rate_types;
	$output = '';

	if (!empty($global_rate_types)) {
		if ($return_html) {
			if ($input_type == 'dropdown') {
				if (!empty($input_name)) {
					$output .= '<select name="' . $input_name . '"
						id="' . $input_id . '"
						class="' . $input_class . '">';
				}

				foreach($global_rate_types as $rate_type_key => $_each_rate_type) {

					$_each_select = '';
					
					if (!empty($key) && $rate_type_key == $key) {
						$_each_select = ' selected';
					}

					$output .= '<option value="' . $rate_type_key . '"' . $_each_select . '>' . $_each_rate_type . '</option>';
				}

				if (!empty($input_name)) {
					$output .= '</select>';
				}

			} else if ($input_type == 'checkbox') {
				foreach($global_rate_types as $rate_type_key => $_each_rate_type) {

					$_each_select = '';
					
					if (!empty($key) && $rate_type_key == $key) {
						$_each_select = ' checked';
					}

					if (empty($input_name)) {
						$input_name = 'rate_type';
					}

					$output .= '<input type="checkbox" 
						name="' . $input_name . '[]"
						id="' . $input_id . '_' . $rate_type_key . '"
						class="' . $input_class . '"
						value="' . $rate_type_key . '"
						' . $_each_select . '> ' . $_each_rate_type . '<br>';
				}
			}

		} else {

			if (!empty($key) && array_key_exists($key, $global_rate_types)) {
				$output = $global_rate_types[$key];
			}
		}
	}

	return $output;
}

/**
 * Shows the classifications of each Employee
 * Maps with the field 'temp_classification'
 *
 * @param      string  $key          Key literal (if any)
 * @param      bool    $return_html  Whether to return HTML (true | false)
 * @param      string  $input_type   Input type ('dropdown' | 'checkbox')
 * @param      string  $input_name   Input name (without [], if any)
 * @param      string  $input_id     Input identifier (if any)
 * @param      string  $input_class  Input CSS class/es (if any)
 *
 * @return     string  HTML option values or the value itself
 */
function show_classifications($key = '', $return_html = true, $input_type = 'dropdown', $input_name = '', $input_id = '', $input_class = '') {
	
	global $classifications_employee;

	$output = '';

	if (!empty($classifications_employee)) {
		if ($return_html) {
			foreach($classifications_employee as $_each_classification_key => $_each_class_value) {
			
				$_each_select = '';

				if (!empty($key) && $_each_classification_key == $key) {
					$_each_select = ' selected';
				}

				$output .= '<option value="' . $_each_classification_key . '"' . $_each_select . '>' . $_each_class_value . '</option>';
			}
		} else {

			if (!empty($key) && array_key_exists($key, $classifications_employee)) {

				$output = $classifications_employee[$key];
			}
		}

	}

	return $output;
}

function show_categories($key = '', $return_html = true) {

	global $categories_employee;
	$output = '';

	if (!empty($categories_employee)) {
		
		if ($return_html) {

			foreach($categories_employee as $_each_category_key => $_each_category) {

				$_each_select = '';
				
				if (!empty($key) && $_each_category_key == $key) {
					$_each_select = ' selected';
				}

				$output .= '<option value="' . $_each_category_key . '"' . $_each_select . '>' . $_each_category . '</option>';
			}
			
		} else {

			if (!empty($key) && array_key_exists($key, $categories_employee)) {

				$output = $categories_employee[$key];
			}
		}
	}

	return $output;
}

/**
 * Set the user privileges of the current logged-in user
 */
function set_user_privileges($menu_data) {

    if (!empty($menu_data)) {
    	global $global_user_privileges;

        $user_privileges_temp = $global_user_privileges;

        // Loop through the menu options available for this user
        foreach ($menu_data as $_each_menu_details) {

            // Loop through the temporary privilege array
            foreach ($user_privileges_temp as $_each_privilege_name => $_each_privilege_value) {
                /**
                 * Check if the user privilege option is present in the available menu options
                 */
                if (stripos($_each_menu_details['menu_name'], $_each_privilege_name) !== false) {
                    /**
                     * Only if the current user privilege is available in the available menu option,
                     * mark it as true in the global privilege option
                     */
                    $global_user_privileges[$_each_privilege_name] = true;
                    // $user_privileges_final[$_each_privilege_name] = true;

                    /**
                     * Since we got the privilege and it's no more required to traverse,
                     * remove this option from the temporary privilege array
                     */
                    unset($user_privileges_temp[$_each_privilege_name]);

                    /**
                     * Looping through the temporary privilege array is no more required
                     */
                    break;
                }
            }
        }
	}
}

/**
 * Check if the menu is showable
 */
function menu_is_showable($menu_name) {
	// To store the result
	$result = false;

	// Required to check if a privilege name matches with the given menu name
	$match_found = false;

	if (!empty($menu_name)) {
		global $global_user_privileges;

		foreach ($global_user_privileges as $_each_privilege_name => $_each_privilege_value) {
			if (stripos($menu_name, $_each_privilege_name) !== false) {
				$result = $_each_privilege_value;
				$match_found = true;
				break;
			}
		}

		/**
		 * If no match is found between the given menu name and all the available privileges,
		 * then this menu is assumed to be neutral and should be allowed to show.
		 */
		if (!$match_found) {
			$result = true;
		}
	}

	return $result;
}

function get_month_name($month){

	if ($month == "1"){

		echo "January";
	} else if ($month == "2") {
		echo "February";
	} else if ($month == "3") {
		echo "March";
	} else if ($month == "4") {
		echo "April";
	} else if ($month == "5") {
		echo "May";
	} else if ($month == "6") {
		echo "June"; 
	} else if ($month == "7") {
		echo "July"; 
	} else if ($month == "8") {
		echo "August";
	} else if ($month == "9") {
		echo "September";
	} else if ($month == "10") {
		echo "October";
	} else if ($month == "11") {
		echo "November";
	} else if ($month == "12") {
		echo "December";
	}
}

function show_vendor_tier($key = '', $return_html = true) {

	global $vendor_tier;
	$output = '';

	if (!empty($vendor_tier)) {
		
		if ($return_html) {

			foreach($vendor_tier as $_each_tier_key => $_each_tier) {

				$_each_select = '';
				
				if (!empty($key) && $_each_tier_key == $key) {
					$_each_select = ' selected';
				}

				$output .= '<option value="' . $_each_tier_key . '"' . $_each_select . '>' . $_each_tier . '</option>';
			}
			
		} else {

			if (!empty($key) && array_key_exists($key, $vendor_tier)) {

				$output = $vendor_tier[$key];
			}
		}
	}

	return $output;
}

/**
 * For requisition dropdown option and view status
 *
 * @param      string  $key          The key
 * @param      bool    $return_html  The return html
 *
 * @return     string  ( description_of_the_return_value )
 */
function show_requisition_status($key = '', $return_html = true) {

	global $requisition_status;
	$output = '';

	if (!empty($requisition_status)) {
		
		if ($return_html) {

			foreach($requisition_status as $_each_requisition_status_key => $_each_requisition_status) {

				$_each_select = '';
				
				if (!empty($key) && $_each_requisition_status_key == $key) {
					$_each_select = ' selected';
				}

				$output .= '<option value="' . $_each_requisition_status_key . '"' . $_each_select . '>' . $_each_requisition_status . '</option>';
			}
			
		} else {

			if (!empty($key) && array_key_exists($key, $requisition_status)) {

				$output = $requisition_status[$key];
			}
		}
	}

	return $output;
}

/**
 * Sends an email for each Work Order action.
 * For more details on the WO workflow, check the Jira issue POROS-58.
 *
 * @param      int     $wo_stage         The WO stage number
 * @param      string  $init_user_type   The initializing user type
 * @param      array   $content_details  The content details [
 * 											'init_user_full_name', (mandatory)
 * 											'con_full_name', (mandatory)
 * 											'con_code', (mandatory)
 * 											'access_link_part', (optional)
 * 										 ]
 * @param      array   $to               To email ID/s
 * @param      array   $cc               CC email ID/s
 * @param      array   $bcc              BCC email ID/s
 * @param      bool    $is_edit          Indicates if Edit
 *
 * @return     string  Status or Error message/s
 */
function send_emails_work_order(int $wo_stage, string $init_user_type, array $content_details, array $to, array $cc = [], array $bcc = [], bool $is_edit = false) {

    $is_error = false;
    if  (empty($wo_stage))  {
		$is_error = true;
        return "Please specify the current stage after the current Work Order action.";
    }
    if  (empty($init_user_type))  {
		$is_error = true;
        return "Please specify the initiating user type.";
    }
	if (empty($to)) {
		$is_error = true;
		return "Please specify the email ID/s of the intended recipients.";
	}

	if (empty($content_details)) {
		$is_error = true;
		return "Please specify all the content details as per the WO email feature requirement.";
	} else {
		if (!array_key_exists('init_user_full_name', $content_details)) {
			$is_error = true;
			return "Please specify the initiating user's full name.";
		} else if (!array_key_exists('con_full_name', $content_details)) {
			$is_error = true;
			return "Please specify the consultant's full name.";
		} else if (!array_key_exists('con_code', $content_details)) {
			$is_error = true;
			return "Please specify the consultant's code.";
		}
	}

	if (empty($is_error)) {
        $from 	 = REPLY_EMAIL;
        $subject = '';
		$body	 = '';

        switch ($wo_stage) {
        	case 1: // Initiation of the WO is in progress
        	default:
        		return "Please check the stage value again.";
        		break;

            case 2: // Initiation/Edit is complete; sent for Approval
            	$subject = $is_edit ? 'Work Order Updated successfully' : 'Work Order Added successfully';

            	if ($init_user_type == 'sadmin') {

            		$body = $content_details['init_user_full_name'] . ' (the actual super admin who initiated the Work Order) added Work Order for ' . $content_details['con_full_name'] . ' [ ' . $content_details['con_code'] . ' ].';
                } else if ($init_user_type == 'admin') {

                	$body = $content_details['init_user_full_name'] . ' (the actual admin who initiated the Work Order) added Work Order for ' . $content_details['con_full_name'] . ' [ ' . $content_details['con_code'] . ' ].';
                }

            	if ($is_edit) {

            		$body = $content_details['init_user_full_name'] . ' updated Work Order for ' . $content_details['con_full_name'] . ' [ ' . $content_details['con_code'] . ' ].';
            	}

            	if (array_key_exists('access_link_part', $content_details) && !empty($content_details['access_link_part'])) {
	            	if ($init_user_type == 'admin' || ($init_user_type == 'sadmin' && !$is_edit)) {

		            	$body .= '<br/><br/>' .
		            		'Click on the link below to approve the Work Order:-<br/>' .
    			        	base_url() . $content_details['access_link_part'];
    			    }
    			}

            	break;

            case 3: // Approval is complete; sent for Vendor sign
            	$subject = 'Work Order Approved by Super Admin';

				if ($init_user_type == 'sadmin') {

            		$body = $content_details['init_user_full_name'] . ' approved Work Order for ' . $content_details['con_full_name'] . ' [ ' . $content_details['con_code'] . ' ].';

            		if (array_key_exists('access_link_part', $content_details) && !empty($content_details['access_link_part'])) {

	            		$body .= '<br/><br/>' .
	            			'Click on the link below to sign the Work Order:-<br/>' .
    	        			base_url() . $content_details['access_link_part'];
	        		}
                }

				break;

            case 4: // Vendor sign is complete; sent for ASP sign
            	$subject = 'Work Order Signed successfully by the Vendor';

				if ($init_user_type == 'vendor') {

					$body = $content_details['init_user_full_name'] . ' (Vendor) has successfully signed the Work Order for ' . $content_details['con_full_name'] . ' [ ' . $content_details['con_code'] . ' ].';

					if (array_key_exists('access_link_part', $content_details) && !empty($content_details['access_link_part'])) {

						$body .= '<br/><br/>' .
							'Click on the link below to sign the Work Order:-<br/>' .
        	    			base_url() . $content_details['access_link_part'];
    	    		}
				}

				break;

            case 5: // ASP sign is complete
            	$subject = 'ASP Signed Work Order successfully';

				if ($init_user_type == 'asp') {

					$body = $content_details['init_user_full_name'] . ' (ASP) has successfully signed the Work Order for ' . $content_details['con_full_name'] . ' [ ' . $content_details['con_code'] . ' ].';

					if (array_key_exists('access_link_part', $content_details) && !empty($content_details['access_link_part'])) {

						$body .= '<br/><br/>' .
							'Click on the link below to view the signed Work Order PDF:-<br/>' .
        	    			base_url() . $content_details['access_link_part'];
    	    		}
				}

				break;
        }

		$ci = &get_instance();
		$ci->load->library('email');
		$ci->email->set_mailtype('html');
		$ci->email->from($from);
        $ci->email->to($to);
		$ci->email->subject($subject);

        if (!empty($cc)) {
			$ci->email->cc($cc);   
        }

        if (!empty($bcc)) {
			$ci->email->bcc($bcc);   
        }


		$data['msg'] = $body;
		$ci->email->message($ci->load->view('admin/email_template/form_submitted_template', $data, true));

		if ($ci->email->send()) {
			return "Email has been sent successfully.";
		}
		else {
			return "Something went wrong with the email. Please try again.";
		}
	}
}

/**
 * Returns the URL of the current page
 * @return string URL of the current page
 */
function current_page_url() {
	return base_url() . substr($_SERVER['REQUEST_URI'], 1);
}

/**
 * Sets the current page URL into session if it is not already stored with the key name referer_url
 */
function set_referer_url() {
	$ci = &get_instance();
	if (empty($ci->session->userdata('referer_url'))) { 
		$ci->session->set_userdata('referer_url', current_page_url());
	}
}

/**
 * Redirects to the referer URL if it is stored in session, else redirects to the default page (dashboard) after login 
 * @param string $default_page
 */
function go_to_correct_logged_in_url(string $default_page = '') {
	$ci = &get_instance();
	if (empty($ci->session->userdata('referer_url'))) {
		redirect(base_url() . $default_page);
	} else {
		$temp_referer_url = $ci->session->userdata('referer_url');
		$ci->session->unset_userdata('referer_url');

		redirect($temp_referer_url);
	}
}

/**
 * Get the proper names of each user type
 *
 * @param      string  $data   User Type keys
 *
 * @return     string  Proper names of each user type
 */
function get_user_types(string $data) {
	$str_user_types = "";

	if (stripos($data, ',') !== false) {
		$arr_user_types = explode(",", $data);
	} else {
		$arr_user_types = [
			$data
		];
	}

	if (count($arr_user_types)) {
		// This is defined in the config/constants.php page
		global $global_candidate_types;

		foreach ($arr_user_types as $_each_user_type) {
			$str_user_types .= empty($str_user_types) ? '' : ', ';

			$str_user_types .= $global_candidate_types[$_each_user_type];
		}
	}

	return $str_user_types;
}