<?php

function get_user_type() {

	if ( $this->session->userdata('logged_in') ) {

		$user_type = 'superadmin';
		return $user_type;

	} else if ( $this->session->userdata('admin_logged_in') ) {

		$user_type = 'admin';
		return $user_type;

	} else if ( $this->session->userdata('vendor_logged_in') ) {

		$email = $sess_arr['email'];
        return $email;

	} else if ( $this->session->userdata('emp_logged_in') ) {

		$email = $sess_arr['email'];
        return $email;
	}
}

function get_user_email($user_type) {

	if($user_type == "superadmin") {

		$sess_arr = $this->session->userdata('logged_in');
        $email = $sess_arr['email'];
        return $email;

	} else if ($user_type == "admin") {

		$sess_arr = $this->session->userdata('admin_logged_in');
        $email = $sess_arr['email'];
        return $email;

	} else if ($user_type == "vendor") {

		$sess_arr = $this->session->userdata('vendor_logged_in');
        $email = $sess_arr['email'];
        return $email;

	} else if ($user_type == "employee") {

		$sess_arr = $this->session->userdata('emp_logged_in');
        $email = $sess_arr['email'];
        return $email;
	}
}