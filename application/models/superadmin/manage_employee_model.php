<?php

Class Manage_Employee_Model extends CI_Model {

    public function add_employee_user($data) {
        $this->db->insert('vms_employee_master', $data);
        $last_id = $this->db->insert_id();
        return $last_id;
    }

    public function get_all_employees_list() {
        if (INDIA || DEMO) {
            if (DEMO) {
                $query_str_timezone = "SET time_zone = '-6:00'";
            }
            if (INDIA) {
                $query_str_timezone = "SET SESSION time_zone = '+5:30'";
            }
            $query_timezone = $this->db->query($query_str_timezone);

            $query_str = "SELECT
            e.employee_id,
            e.first_name,
            e.last_name,
            e.employee_email,
            MAX(ct.clock_in) AS clock_in_time,
            MAX(ct.clock_out) AS clock_out_time,
            MAX(bt.break_start_time) AS break_start_time,
            MAX(bt.break_end_time) AS break_end_time,
            CASE
            WHEN (MAX(ct.clock_out) > MAX(ct.clock_in)) OR (MAX(ct.clock_out) = MAX(ct.clock_in)) OR ct.clock_in IS NULL THEN 'Inactive'
            WHEN (MAX(ct.clock_in) < MAX(bt.break_start_time))
            AND (MAX(bt.break_end_time) < MAX(bt.break_start_time)) THEN 'Break'
            WHEN (
                MAX(ct.clock_in) IS NOT NULL
                AND sm.daily_shift_end_time < CURTIME()
            )
            or (
                    MAX(ct.clock_in) IS NOT NULL
                    AND sm.daily_shift_start_time > CURTIME()
            ) THEN 'Over-time'
            WHEN MAX(ct.clock_in) IS NOT NULL THEN 'Active'
            END AS empStatus
        FROM  
            vms_employee_master e
            INNER JOIN vms_employee_shift_master sm ON e.shift_id = sm.id
            LEFT JOIN vms_employee_clock_time ct ON e.employee_id = ct.employee_id
            LEFT JOIN vms_employee_break_time bt ON e.employee_id = bt.employee_id
        WHERE
            (
                (sm.daily_shift_start_time < CURTIME()  
            AND sm.daily_shift_end_time > CURTIME())
            OR (ct.clock_in IS NOT NULL AND ct.clock_out IS NULL)
            
            )
        GROUP BY
            e.employee_id
        ORDER BY
            clock_in_time DESC;";

            $query = $this->db->query($query_str);
            $data = $query->result();
            return $data;
        }
    
    }



    public function get_all_employees_shift()
    {
        if (INDIA) {
            $this->db->select('employee_id, first_name, last_name');
            $this->db->from('vms_employee_master');
            $query = $this->db->get();
            $data = $query->result_array();
            return $data;
        }
    }

    public function insert_shift_break_form_data($employee_id, $clock_time_id, $break_type, $start_date, $start_time, $end_date, $end_time, $is_paid, $comment, $created_by, $created_time) {
        
        if (INDIA) {
            $start_time = date('Y-m-d H:i:s', strtotime("$start_date $start_time"));
            $end_time = date('Y-m-d H:i:s', strtotime("$end_date $end_time"));

            if($is_paid == 'yes') {
                $is_paid=1;
            }
            else {
                $is_paid=0;
            }

            $query_str = "INSERT INTO `porosiq`.`vms_employee_break_time` (`employee_id`,`clock_time_id`,`break_type`,`break_start_time`,`break_end_time`,`is_paid`, `comment`, `created_by`,`created_time`) VALUES ($employee_id, $clock_time_id, '$break_type','$start_time','$end_time',$is_paid,'$comment', $created_by, '$created_time')";

            $this->db->query($query_str);
        }
    }

    public function get_employee_shift_id($employee_id)
    {
        if (INDIA) {
            $this->db->select('shift_id');
            $this->db->from('vms_employee_master');
            $this->db->where('employee_id', $employee_id);
            $query = $this->db->get();
            $data = $query->result_array();
            return $data;
        }
    }

    public function get_employee_clock_data_main($employee_id, $date) {
        if (INDIA) {
            $date = date('Y-m-d H:i:s', strtotime($date));

            $query_str = "SELECT *,vec.id as clock_id FROM porosiq.vms_employee_clock_time vec WHERE vec.employee_id=$employee_id AND DATE(vec.clock_in)='$date'";

            $query = $this->db->query($query_str);
            $data = $query->result();
            return $data;
        }
    }
    
    public function get_employee_clock_data($employee_id, $date)
    {   
        if (INDIA) {
            $date = date('Y-m-d H:i:s', strtotime($date));

            $query_str = "SELECT *,veb.id as break_id,vec.id as clock_id FROM porosiq.vms_employee_clock_time vec LEFT JOIN porosiq.vms_employee_break_time veb ON vec.id = veb.clock_time_id WHERE vec.employee_id=$employee_id AND DATE(vec.clock_in)='$date'";

            $query = $this->db->query($query_str);
            $data = $query->result();
            return $data;
        }
    }

    public function update_clock_admin_data($clock_in_date, $clock_in_time, $clock_out_date, $clock_out_time, $comment, $clock_id) {
        if (INDIA) {
            if (!empty($clock_in_date) && !empty($clock_in_time)) {
                $clock_in_date = date('Y-m-d H:i:s', strtotime("$clock_in_date $clock_in_time"));
            } 
            else {
                $clock_in_date = '';
            }
            if (!empty($clock_out_date) && !empty($clock_out_time)) {
                $clock_out_date = date('Y-m-d H:i:s', strtotime("$clock_out_date $clock_out_time"));
            }
            else {
                $clock_out_date = '';
            }

            $query_str = "UPDATE `porosiq`.`vms_employee_clock_time` SET `clock_in` = '$clock_in_date',`clock_out` = '$clock_out_date', `comment` = '$comment', `modified_by` = ".$this->session->userdata('clock_break_data_admin_id').", `modified_time` = '".date('Y-m-d H:i:s')."' WHERE `id` = $clock_id";

            $this->db->query($query_str);
        }
    }

    public function update_training_break_admin($training_break_start_date, $training_break_start_time, $training_break_end_date, $training_break_end_time, $comment,$training_break_id) {
        
        if (INDIA) {
            if (!empty($training_break_start_date)) {
                $training_break_start_date = date('Y-m-d H:i:s', strtotime("$training_break_start_date $training_break_start_time"));
            } 
            else {
                $training_break_start_date = '';
            }
            if (!empty($training_break_end_date)) {
                $training_break_end_date = date('Y-m-d H:i:s', strtotime("$training_break_end_date $training_break_end_time"));
            }
            else {
                $training_break_end_date = '';
            }

            $query_str = "UPDATE `porosiq`.`vms_employee_break_time` SET `break_start_time` = '$training_break_start_date',`break_end_time` = '$training_break_end_date', `comment` = '$comment', `modified_by` = ".$this->session->userdata('clock_break_data_admin_id').", `modified_time` = '".date('Y-m-d H:i:s')."' WHERE `id` = $training_break_id";

            $this->db->query($query_str);
        }
    }

    public function update_personal_break_admin($personal_break_start_date, $personal_break_start_time, $personal_break_end_date, $personal_break_end_time, $comment, $personal_break_id) {
        
        if (INDIA) {
            if (!empty($personal_break_start_date)) {
                $personal_break_start_date = date('Y-m-d H:i:s', strtotime("$personal_break_start_date $personal_break_start_time"));
            } 
            else {
                $personal_break_start_date = '';
            }
            if (!empty($personal_break_end_date)) {
                $personal_break_end_date = date('Y-m-d H:i:s', strtotime("$personal_break_end_date $personal_break_end_time"));
            }
            else {
                $personal_break_end_date = '';
            }

            $query_str = "UPDATE `porosiq`.`vms_employee_break_time` SET `break_start_time` = '$personal_break_start_date',`break_end_time` = '$personal_break_end_date',`comment` = '$comment',`modified_by` = ".$this->session->userdata('clock_break_data_admin_id').", `modified_time` = '".date('Y-m-d H:i:s')."' WHERE `id` = $personal_break_id";

            $this->db->query($query_str);
        }
    }

    public function update_meeting_break_admin($meeting_break_start_date, $meeting_break_start_time,$meeting_break_end_date, $meeting_break_end_time, $comment, $meeting_break_id) {
        
        if(INDIA) {
            if (!empty($meeting_break_start_date)) {
                $meeting_break_start_date = date('Y-m-d H:i:s', strtotime("$meeting_break_start_date $meeting_break_start_time"));
            } 
            else {
                $meeting_break_start_date = '';
            }
            if (!empty($meeting_break_end_date)) {
                $meeting_break_end_date = date('Y-m-d H:i:s', strtotime("$meeting_break_end_date $meeting_break_end_time"));
            }
            else {
                $meeting_break_end_date = '';
            }

            $query_str = "UPDATE `porosiq`.`vms_employee_break_time` SET `break_start_time` = '$meeting_break_start_date',`break_end_time` = '$meeting_break_end_date',`comment` = '$comment', `modified_by` = ".$this->session->userdata('clock_break_data_admin_id').", `modified_time` = '".date('Y-m-d H:i:s')."' WHERE `id` = $meeting_break_id";

            $this->db->query($query_str);
        }
    }



    public function update_lunch_break_admin($lunch_break_start_date, $lunch_break_start_time,$lunch_break_end_date, $lunch_break_end_time, $comment, $lunch_break_id) {
        
        if  (INDIA) {
            if (!empty($lunch_break_start_date)) {
                $lunch_break_start_date = date('Y-m-d H:i:s', strtotime("$lunch_break_start_date $lunch_break_start_time"));
            } 
            else {
                $lunch_break_start_date = '';
            }
            if (!empty($lunch_break_end_date)) {
                $lunch_break_end_date = date('Y-m-d H:i:s', strtotime("$lunch_break_end_date $lunch_break_end_time"));
            }
            else {
                $lunch_break_end_date = '';
            }

            $query_str = "UPDATE `porosiq`.`vms_employee_break_time` SET `break_start_time` = '$lunch_break_start_date',`break_end_time` = '$lunch_break_end_date',`comment` = '$comment', `modified_by` = ".$this->session->userdata('clock_break_data_admin_id').", `modified_time` = '".date('Y-m-d H:i:s')."' WHERE `id` = $lunch_break_id";

            $this->db->query($query_str);
        }
    }

    public function insert_clock_data_admin($data) {
        if (INDIA) {
            $this->db->insert('vms_employee_clock_time', $data);
            $insert_id = $this->db->insert_id();
            return  $insert_id;
        }
    }




    




    public function get_current_employees_shift_total_hours($from, $to, $employee_id) {
        if (INDIA) {
            $query_str = "SELECT CONCAT(
                HOUR(
                sec_to_time(SUM(time_to_sec(timediff(clock_out, clock_in))))
                ),
                ' hours ',
                MINUTE(
                sec_to_time(SUM(time_to_sec(timediff(clock_out, clock_in))))
                ),
                ' minutes ',
                SECOND(
                sec_to_time(SUM(time_to_sec(timediff(clock_out, clock_in))))
                ),
                ' seconds'
            ) AS total_hours FROM porosiq.vms_employee_clock_time WHERE clock_in >= '".$from."' AND clock_in <= '".$to."' AND employee_id = ".$employee_id;

            $query = $this->db->query($query_str);
            $data = $query->result();
            return $data;
        }
    }

    public function get_current_employees_shift_total_paid_breaks($from, $to, $employee_id) {
        if (INDIA) {
            $query_str = "SELECT COUNT(*) AS total_paid_break FROM porosiq.vms_employee_break_time WHERE break_start_time >= '".$from."' AND break_start_time <= '".$to."' AND employee_id = ".$employee_id." AND is_paid=1";

            $query = $this->db->query($query_str);
            $data = $query->result();
            return $data;
        }
    }
    
    public function get_current_employees_shift_total_unpaid_breaks($from, $to, $employee_id) {
        if (INDIA) {
            $query_str = "SELECT COUNT(*) AS total_unpaid_break FROM porosiq.vms_employee_break_time WHERE break_start_time >= '".$from."' AND break_start_time <= '".$to."' AND employee_id = ".$employee_id." AND is_paid=0";

            $query = $this->db->query($query_str);
            $data = $query->result();
            return $data;
        }
    }









    public function get_employee_shift_summary_data_all($from, $to, $employee_id, $is_employee_id_empty) {
        
        if (INDIA) {
            $query_str = '';
            if ($is_employee_id_empty) {
        
                $employee_id = implode(',',$employee_id); 
        
                $query_str = "SELECT
                ct.id as clock_time_id,
                first_name,
                last_name,
                date(clock_in) AS date,
                time(clock_in) as clock_in,
                time(clock_out) as clock_out,
                CONCAT(
                    HOUR(
                    SEC_TO_TIME(time_to_sec(timediff(clock_out, clock_in)))
                    ),
                    ' hours ',
                    MINUTE(
                    SEC_TO_TIME(time_to_sec(timediff(clock_out, clock_in)))
                    ),
                    ' minutes ',
                    SECOND(
                    SEC_TO_TIME(time_to_sec(timediff(clock_out, clock_in)))
                    ),
                    ' seconds'
                ) AS total_hours,
                CONCAT(
                    HOUR(
                    SEC_TO_TIME(time_to_sec(timediff(clock_out, clock_in)))
                    ),
                    ':',
                    MINUTE(
                    SEC_TO_TIME(time_to_sec(timediff(clock_out, clock_in)))
                    ),
                    ':',
                    SECOND(
                    SEC_TO_TIME(time_to_sec(timediff(clock_out, clock_in)))
                    )
                ) AS total_hour_str,
                Personal,
                Meeting,
                Training,
                Lunch,
                Total,
                total_break_hours_str,
                ct.is_approved_by_superadmin
            FROM
                vms_employee_master e
                INNER JOIN vms_employee_clock_time ct ON e.employee_id = ct.employee_id
                LEFT JOIN (
                SELECT
                    clock_time_id,
                    CONCAT(
                        HOUR(
                        SEC_TO_TIME(
                            SUM(
                            CASE
                                WHEN break_type = 'personal' AND break_end_time != '0000-00-00 00:00:00' then time_to_sec(timediff(break_end_time, break_start_time))
                                ELSE 0
                            END
                            )
                        )
                        ),
                        ' hours ',
                        MINUTE(
                        SEC_TO_TIME(
                            SUM(
                            CASE
                                WHEN break_type = 'personal' AND break_end_time != '0000-00-00 00:00:00' then time_to_sec(timediff(break_end_time, break_start_time))
                                ELSE 0
                            END
                            )
                        )
                        ),
                        ' minutes ',
                        SECOND(
                        SEC_TO_TIME(
                            SUM(
                            CASE
                                WHEN break_type = 'personal' AND break_end_time != '0000-00-00 00:00:00' then time_to_sec(timediff(break_end_time, break_start_time))
                                ELSE 0
                            END
                            )
                        )
                        ),
                        ' seconds'
                    ) as 'Personal',
                    CONCAT(
                        HOUR(
                        SEC_TO_TIME(
                            SUM(
                            CASE
                                WHEN break_type = 'training' AND break_end_time != '0000-00-00 00:00:00' then time_to_sec(timediff(break_end_time, break_start_time))
                                ELSE 0
                            END
                            )
                        )
                        ),
                        ' hours ',
                        MINUTE(
                        SEC_TO_TIME(
                            SUM(
                            CASE
                                WHEN break_type = 'training' AND break_end_time != '0000-00-00 00:00:00' then time_to_sec(timediff(break_end_time, break_start_time))
                                ELSE 0
                            END
                            )
                        )
                        ),
                        ' minutes ',
                        SECOND(
                        SEC_TO_TIME(
                            SUM(
                            CASE
                                WHEN break_type = 'training' AND break_end_time != '0000-00-00 00:00:00' then time_to_sec(timediff(break_end_time, break_start_time))
                                ELSE 0
                            END
                            )
                        )
                        ),
                        ' seconds'
                    ) as 'Training',
                    CONCAT(
                        HOUR(
                        SEC_TO_TIME(
                            SUM(
                            CASE
                                WHEN break_type = 'meeting' AND break_end_time != '0000-00-00 00:00:00' then time_to_sec(timediff(break_end_time, break_start_time))
                                ELSE 0
                            END
                            )
                        )
                        ),
                        ' hours ',
                        MINUTE(
                        SEC_TO_TIME(
                            SUM(
                            CASE
                                WHEN break_type = 'meeting' AND break_end_time != '0000-00-00 00:00:00' then time_to_sec(timediff(break_end_time, break_start_time))
                                ELSE 0
                            END
                            )
                        )
                        ),
                        ' minutes ',
                        SECOND(
                        SEC_TO_TIME(
                            SUM(
                            CASE
                                WHEN break_type = 'meeting' AND break_end_time != '0000-00-00 00:00:00' then time_to_sec(timediff(break_end_time, break_start_time))
                                ELSE 0
                            END
                            )
                        )
                        ),
                        ' seconds'
                    ) as 'Meeting',
                    CONCAT(
                        HOUR(
                        SEC_TO_TIME(
                            SUM(
                            CASE
                                WHEN break_type = 'lunch' AND break_end_time != '0000-00-00 00:00:00' then time_to_sec(timediff(break_end_time, break_start_time))
                                ELSE 0
                            END
                            )
                        )
                        ),
                        ' hours ',
                        MINUTE(
                        SEC_TO_TIME(
                            SUM(
                            CASE
                                WHEN break_type = 'lunch' AND break_end_time != '0000-00-00 00:00:00' then time_to_sec(timediff(break_end_time, break_start_time))
                                ELSE 0
                            END
                            )
                        )
                        ),
                        ' minutes ',
                        SECOND(
                        SEC_TO_TIME(
                            SUM(
                            CASE
                                WHEN break_type = 'lunch' AND break_end_time != '0000-00-00 00:00:00' then time_to_sec(timediff(break_end_time, break_start_time))
                                ELSE 0
                            END
                            )
                        )
                        ),
                        ' seconds'
                    ) as 'Lunch',
                    CONCAT(
                        HOUR(
                        SEC_TO_TIME(
                            SUM(
                            CASE
                                WHEN break_end_time != '0000-00-00 00:00:00' then time_to_sec(timediff(break_end_time, break_start_time))
                                ELSE 0
                            END
                            )
                        )
                        ),
                        ' hours ',
                        MINUTE(
                        SEC_TO_TIME(
                            SUM(
                            CASE
                                WHEN break_end_time != '0000-00-00 00:00:00' then time_to_sec(timediff(break_end_time, break_start_time))
                                ELSE 0
                            END
                            )
                        )
                        ),
                        ' minutes ',
                        SECOND(
                        SEC_TO_TIME(
                            SUM(
                            CASE
                                WHEN break_end_time != '0000-00-00 00:00:00' then time_to_sec(timediff(break_end_time, break_start_time))
                                ELSE 0
                            END
                            )
                        )
                        ),
                        ' seconds'
                    ) as 'Total',
                    CONCAT(
                        HOUR(
                        SEC_TO_TIME(
                            SUM(
                            CASE
                                WHEN break_end_time != '0000-00-00 00:00:00' then time_to_sec(timediff(break_end_time, break_start_time))
                                ELSE 0
                            END
                            )
                        )
                        ),
                        ':',
                        MINUTE(
                        SEC_TO_TIME(
                            SUM(
                            CASE
                                WHEN break_end_time != '0000-00-00 00:00:00' then time_to_sec(timediff(break_end_time, break_start_time))
                                ELSE 0
                            END
                            )
                        )
                        ),
                        ':',
                        SECOND(
                        SEC_TO_TIME(
                            SUM(
                            CASE
                                WHEN break_end_time != '0000-00-00 00:00:00' then time_to_sec(timediff(break_end_time, break_start_time))
                                ELSE 0
                            END
                            )
                        )
                        )
                    ) as 'total_break_hours_str'
                FROM
                    vms_employee_break_time bt
                GROUP BY
                    clock_time_id
                ) bt_test ON (ct.id = bt_test.clock_time_id) WHERE e.employee_id IN (".$employee_id.") AND ct.clock_in >='".$from."' AND ct.clock_in <= '".$to."' order by e.first_name, e.last_name";
            }
            else {
                $query_str = "SELECT
                ct.id as clock_time_id,
                first_name,
                last_name,
                date(clock_in) AS date,
                time(clock_in) as clock_in,
                time(clock_out) as clock_out,
                CONCAT(
                    HOUR(
                    SEC_TO_TIME(time_to_sec(timediff(clock_out, clock_in)))
                    ),
                    ' hours ',
                    MINUTE(
                    SEC_TO_TIME(time_to_sec(timediff(clock_out, clock_in)))
                    ),
                    ' minutes ',
                    SECOND(
                    SEC_TO_TIME(time_to_sec(timediff(clock_out, clock_in)))
                    ),
                    ' seconds'
                ) AS total_hours,
                CONCAT(
                    HOUR(
                    SEC_TO_TIME(time_to_sec(timediff(clock_out, clock_in)))
                    ),
                    ':',
                    MINUTE(
                    SEC_TO_TIME(time_to_sec(timediff(clock_out, clock_in)))
                    ),
                    ':',
                    SECOND(
                    SEC_TO_TIME(time_to_sec(timediff(clock_out, clock_in)))
                    )
                ) AS total_hour_str,
                Personal,
                Meeting,
                Training,
                Lunch,
                Total,
                total_break_hours_str,
                ct.is_approved_by_superadmin
            FROM
                vms_employee_master e
                INNER JOIN vms_employee_clock_time ct ON e.employee_id = ct.employee_id
                LEFT JOIN (
                SELECT
                    clock_time_id,
                    CONCAT(
                        HOUR(
                        SEC_TO_TIME(
                            SUM(
                            CASE
                                WHEN break_type = 'personal' AND break_end_time != '0000-00-00 00:00:00' then time_to_sec(timediff(break_end_time, break_start_time))
                                ELSE 0
                            END
                            )
                        )
                        ),
                        ' hours ',
                        MINUTE(
                        SEC_TO_TIME(
                            SUM(
                            CASE
                                WHEN break_type = 'personal' AND break_end_time != '0000-00-00 00:00:00' then time_to_sec(timediff(break_end_time, break_start_time))
                                ELSE 0
                            END
                            )
                        )
                        ),
                        ' minutes ',
                        SECOND(
                        SEC_TO_TIME(
                            SUM(
                            CASE
                                WHEN break_type = 'personal' AND break_end_time != '0000-00-00 00:00:00' then time_to_sec(timediff(break_end_time, break_start_time))
                                ELSE 0
                            END
                            )
                        )
                        ),
                        ' seconds'
                    ) as 'Personal',
                    CONCAT(
                        HOUR(
                        SEC_TO_TIME(
                            SUM(
                            CASE
                                WHEN break_type = 'training' AND break_end_time != '0000-00-00 00:00:00' then time_to_sec(timediff(break_end_time, break_start_time))
                                ELSE 0
                            END
                            )
                        )
                        ),
                        ' hours ',
                        MINUTE(
                        SEC_TO_TIME(
                            SUM(
                            CASE
                                WHEN break_type = 'training' AND break_end_time != '0000-00-00 00:00:00' then time_to_sec(timediff(break_end_time, break_start_time))
                                ELSE 0
                            END
                            )
                        )
                        ),
                        ' minutes ',
                        SECOND(
                        SEC_TO_TIME(
                            SUM(
                            CASE
                                WHEN break_type = 'training' AND break_end_time != '0000-00-00 00:00:00' then time_to_sec(timediff(break_end_time, break_start_time))
                                ELSE 0
                            END
                            )
                        )
                        ),
                        ' seconds'
                    ) as 'Training',
                    CONCAT(
                        HOUR(
                        SEC_TO_TIME(
                            SUM(
                            CASE
                                WHEN break_type = 'meeting' AND break_end_time != '0000-00-00 00:00:00' then time_to_sec(timediff(break_end_time, break_start_time))
                                ELSE 0
                            END
                            )
                        )
                        ),
                        ' hours ',
                        MINUTE(
                        SEC_TO_TIME(
                            SUM(
                            CASE
                                WHEN break_type = 'meeting' AND break_end_time != '0000-00-00 00:00:00' then time_to_sec(timediff(break_end_time, break_start_time))
                                ELSE 0
                            END
                            )
                        )
                        ),
                        ' minutes ',
                        SECOND(
                        SEC_TO_TIME(
                            SUM(
                            CASE
                                WHEN break_type = 'meeting' AND break_end_time != '0000-00-00 00:00:00' then time_to_sec(timediff(break_end_time, break_start_time))
                                ELSE 0
                            END
                            )
                        )
                        ),
                        ' seconds'
                    ) as 'Meeting',
                    CONCAT(
                        HOUR(
                        SEC_TO_TIME(
                            SUM(
                            CASE
                                WHEN break_type = 'lunch' AND break_end_time != '0000-00-00 00:00:00' then time_to_sec(timediff(break_end_time, break_start_time))
                                ELSE 0
                            END
                            )
                        )
                        ),
                        ' hours ',
                        MINUTE(
                        SEC_TO_TIME(
                            SUM(
                            CASE
                                WHEN break_type = 'lunch' AND break_end_time != '0000-00-00 00:00:00' then time_to_sec(timediff(break_end_time, break_start_time))
                                ELSE 0
                            END
                            )
                        )
                        ),
                        ' minutes ',
                        SECOND(
                        SEC_TO_TIME(
                            SUM(
                            CASE
                                WHEN break_type = 'lunch' AND break_end_time != '0000-00-00 00:00:00' then time_to_sec(timediff(break_end_time, break_start_time))
                                ELSE 0
                            END
                            )
                        )
                        ),
                        ' seconds'
                    ) as 'Lunch',
                    CONCAT(
                        HOUR(
                        SEC_TO_TIME(
                            SUM(
                            CASE
                                WHEN break_end_time != '0000-00-00 00:00:00' then time_to_sec(timediff(break_end_time, break_start_time))
                                ELSE 0
                            END
                            )
                        )
                        ),
                        ' hours ',
                        MINUTE(
                        SEC_TO_TIME(
                            SUM(
                            CASE
                                WHEN break_end_time != '0000-00-00 00:00:00' then time_to_sec(timediff(break_end_time, break_start_time))
                                ELSE 0
                            END
                            )
                        )
                        ),
                        ' minutes ',
                        SECOND(
                        SEC_TO_TIME(
                            SUM(
                            CASE
                                WHEN break_end_time != '0000-00-00 00:00:00' then time_to_sec(timediff(break_end_time, break_start_time))
                                ELSE 0
                            END
                            )
                        )
                        ),
                        ' seconds'
                    ) as 'Total',
                    CONCAT(
                        HOUR(
                        SEC_TO_TIME(
                            SUM(
                            CASE
                                WHEN break_end_time != '0000-00-00 00:00:00' then time_to_sec(timediff(break_end_time, break_start_time))
                                ELSE 0
                            END
                            )
                        )
                        ),
                        ':',
                        MINUTE(
                        SEC_TO_TIME(
                            SUM(
                            CASE
                                WHEN break_end_time != '0000-00-00 00:00:00' then time_to_sec(timediff(break_end_time, break_start_time))
                                ELSE 0
                            END
                            )
                        )
                        ),
                        ':',
                        SECOND(
                        SEC_TO_TIME(
                            SUM(
                            CASE
                                WHEN break_end_time != '0000-00-00 00:00:00' then time_to_sec(timediff(break_end_time, break_start_time))
                                ELSE 0
                            END
                            )
                        )
                        )
                    ) as 'total_break_hours_str'
                FROM
                    vms_employee_break_time bt
                GROUP BY
                    clock_time_id
                ) bt_test ON (ct.id = bt_test.clock_time_id) WHERE e.employee_id=".$employee_id." AND ct.clock_in >='".$from."' AND ct.clock_in <= '".$to."'";
            }
                $query = $this->db->query($query_str);
                // print_r($this->db->last_query());
                $data = $query->result();
                return $data;
        }
    }




    public function activate_group($group_id) {
        if (INDIA) {
            $this->db->trans_start();

            $data = [
                'is_active' => 1,
            ];

            $this->db->where('group_id', $group_id);
            $this->db->update('porosiq.group', $data);

            $query_str = "SELECT employee_id FROM porosiq.vms_employee_master WHERE group_id=$group_id";

            $query = $this->db->query($query_str);
            $data_emp = $query->result();
            // print_r($data_emp);
            $emp = [];
            foreach ($data_emp as $emp_obj) {
                $emp[] = $emp_obj->employee_id;
            }

            $data1 = [
                'is_delete' => '0',
            ];

            $this->db->where_in('employee_id', $emp);
            $this->db->update('porosiq.vms_employee_login_details', $data1);

            $this->db->trans_complete();

            // print_r($this->db->last_query());
            // exit;

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                return 0;
            } else {
                $this->db->trans_commit();
                return 1;
            }
        }
    }

    public function deactivate_group($group_id) {
        if (INDIA) {
            $this->db->trans_start();

            $data = [
                'is_active' => 0,
            ];

            $this->db->where('group_id', $group_id);
            $this->db->update('porosiq.group', $data);

            $query_str = "SELECT employee_id FROM porosiq.vms_employee_master WHERE group_id=$group_id";

            $query = $this->db->query($query_str);
            $data_emp = $query->result();
            // print_r($data_emp);
            $emp = [];
            foreach ($data_emp as $emp_obj) {
                $emp[] = $emp_obj->employee_id;
            }
            // print_r($emp);

            $data1 = [
                'is_delete' => '1',
            ];

            $this->db->where_in('employee_id', $emp);
            $this->db->update('porosiq.vms_employee_login_details', $data1);

            $this->db->trans_complete();

            // print_r($this->db->last_query());
            // exit;

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                return 0;
            } else {
                $this->db->trans_commit();
                return 1;
            }
        }
    }




    public function change_employee_datewise_shift_summary_status_disapprove($clock_time_id, $admin_id) {
        if (INDIA) {
            $data = [
                'is_approved_by_superadmin' => 0,
                'superadmin_approver' => $admin_id,
            ];

            $this->db->where('id', $clock_time_id);
            $this->db->update('vms_employee_clock_time', $data);

            if ($this->db->affected_rows() > 0) {
                return 1;
            } else {
                return 0;
            }
        }
    }

    public function change_employee_datewise_shift_summary_status($clock_time_id, $admin_id) {
        if (INDIA) {
            $data = [
                'is_approved_by_superadmin' => 1,
                'superadmin_approver' => $admin_id,
            ];

            $this->db->where('id', $clock_time_id);
            $this->db->update('vms_employee_clock_time', $data);

            if ($this->db->affected_rows() > 0) {
                return 1;
            } else {
                return 0;
            }
        }
    }

    











    public function get_employee_shift_list() {
        if (INDIA) {
            $query_str = "SELECT
            id,
            employee_shift_type,
            daily_shift_start_time,
            daily_shift_end_time,
            paid_break_hours,
            unpaid_break_hours,
            days
        FROM  
            vms_employee_shift_master";

            $query = $this->db->query($query_str);
            $data = $query->result();
            return $data;
        }
    }

    public function get_all_shift_names() {
        if (INDIA) {
            $query_str = "SELECT employee_shift_type FROM porosiq.vms_employee_shift_master";
            $query = $this->db->query($query_str);
            $data = $query->result_array();
            return $data;
        }
    }

    public function add_employee_master_shift_data($data)
    {   
        if (INDIA) {
            $this->db->insert('vms_employee_shift_master', $data);
            $last_id = $this->db->insert_id();
            return $last_id;
        }
    }

    public function get_employee_assigned_to_shift($shift_id) {
        if (INDIA) {
            $query_str = "SELECT
            count(employee_id) as count
        FROM  
        vms_employee_master WHERE shift_id=".$shift_id;

            $query = $this->db->query($query_str);
            $data = $query->result();
            return $data;
        }
    }

    public function get_group_assigned_to_shift($shift_id) {
        if (INDIA) {
            $query_str = "SELECT
            count(group_id) as count
        FROM  
        porosiq.group WHERE shift_id=".$shift_id;

            $query = $this->db->query($query_str);
            $data = $query->result();
            return $data;
        }
    }

    public function delete_master_shift($shift_id) {
        
        if (INDIA) {
            $this->db->where('id', $shift_id);
            $this->db->delete('porosiq.vms_employee_shift_master');

            if ($this->db->affected_rows() > 0) {
                return 1;
            } else {
                return 0;
            }
        }
    }

    public function get_master_shift_data($shift_id) {
        if (INDIA) {
            $query_str = "SELECT 
            employee_shift_type,
            days,
            daily_shift_start_time,
            daily_shift_end_time,
            paid_break_hours,
            unpaid_break_hours,
            comment
        FROM
            vms_employee_shift_master WHERE id=".$shift_id.";";

            $query = $this->db->query($query_str);
            $data = $query->result();
            return $data;
        }
    }

    public function update_employee_master_shift_data($data, $shift_id)
    {
        if (INDIA) {
            $this->db->where('id', $shift_id);
            $this->db->update('vms_employee_shift_master', $data);
            return true;
        }
    }

    public function get_all_employees($shift_id) {
        if (INDIA) {
            $query_str = "SELECT first_name,last_name,employee_email,employee_id FROM porosiq.vms_employee_master WHERE shift_id IS NULL OR shift_id <> ".$shift_id;

            $query = $this->db->query($query_str);
            $data = $query->result();
            return $data;
        }
    }

    public function get_all_groups($shift_id) {
        if (INDIA) {
            $query_str = "SELECT group_id,group_name,group_description FROM porosiq.group WHERE shift_id IS NULL OR shift_id <> ".$shift_id;

            $query = $this->db->query($query_str);
            $data = $query->result();
            return $data;
        }
    }

    public function get_all_employee_shift_list($shift_id) {
        if (INDIA) {
            $query_str = "SELECT
            employee_id,
            employee_email,
            first_name,
            last_name,
            employee_designation
        FROM  
        vms_employee_master WHERE shift_id=".$shift_id;

            $query = $this->db->query($query_str);
            $data = $query->result();
            return $data;
        }
    }

    public function get_group_list_of_shift($shift_id) {
        if (INDIA) {
            $query_str = "SELECT
            group_id,
            group_name,
            group_description
        FROM  
        porosiq.group WHERE shift_id=".$shift_id;

            $query = $this->db->query($query_str);
            // print_r($this->db->last_query());
            $data = $query->result();
            return $data;
        }
    }

    public function get_shift_id_of_current_employee($employee_id) {
        if (INDIA) {
            $query_str = "SELECT shift_id FROM porosiq.vms_employee_master WHERE employee_id = ".$employee_id;

            $query = $this->db->query($query_str);
            $data = $query->result();
            return $data;
        }
    }

    public function assign_shift_to_employee($employee_id, $shift_id) {
        if (INDIA) {
            $data = array('shift_id' => $shift_id);
            $this->db->where('employee_id', $employee_id);
            $this->db->update('vms_employee_master', $data);
        }
    }

    public function get_shift_id_of_current_group($group_id) {
        if (INDIA) {
            $query_str = "SELECT shift_id FROM porosiq.group WHERE group_id = ".$group_id;

            $query = $this->db->query($query_str);
            $data = $query->result();
            return $data;
        }
    }

    public function assign_shift_to_group($group_id, $shift_id) {
        if (INDIA) {
            $data = array('shift_id' => $shift_id);
            $this->db->where('group_id', $group_id);
            $this->db->update('group', $data);
        }
    }
    


    
    public function get_employee_group_list() {
        if (INDIA) {
            $query_str = "SELECT COUNT(e.group_id) as employee, g.group_id, g.group_name, g.group_description, g.is_active FROM porosiq.group g LEFT JOIN porosiq.vms_employee_master e ON g.group_id = e.group_id GROUP BY g.group_id";

            $query = $this->db->query($query_str);
            $data = $query->result();
            return $data;
        }
    }

    public function insert_new_group($data) {
        if (INDIA) {
            $this->db->insert('group', $data);
            $insert_id = $this->db->insert_id();
            return  $insert_id;
        }
    }

    public function get_current_group_employees($group_id) {
        if (INDIA) {
            $query_str = "SELECT vem.first_name,vem.last_name,vem.employee_email,veld.status FROM porosiq.vms_employee_master vem INNER JOIN porosiq.vms_employee_login_details veld ON vem.employee_id = veld.employee_id WHERE group_id=$group_id";

            $query = $this->db->query($query_str);
            $data = $query->result();
            return $data;
        }
    }

    public function get_current_group_name($group_id) {
        if (INDIA) {
            $query_str = "SELECT group_name FROM porosiq.group WHERE group_id=$group_id";

            $query = $this->db->query($query_str);
            $data = $query->result();
            return $data;
        }
    }

    public function update_group_name($update_arr, $group_id) {
        if (INDIA) {
            $this->db->where('group_id', $group_id);
            $this->db->update('group', $update_arr);
        }
    }

    public function get_members($group_id) {
        if (INDIA) {
            $query_str = "SELECT first_name,last_name,employee_email,employee_id FROM porosiq.vms_employee_master WHERE group_id = $group_id";

            $query = $this->db->query($query_str);
            $data = $query->result();
            return $data;
        }
    }

    public function get_not_members($group_id) {
        if (INDIA) {
            $query_str = "SELECT first_name,last_name,employee_email,employee_id FROM porosiq.vms_employee_master WHERE group_id <> $group_id OR group_id IS NULL";

            $query = $this->db->query($query_str);
            $data = $query->result();
            return $data;
        }
    }

    public function add_members_to_group($group_id, $add_ids) {
        if (INDIA) {
            $data = array('group_id' => $group_id);
            $this->db->where_in('employee_id', $add_ids);
            $this->db->update('vms_employee_master', $data);
        }
    }

    public function remove_members_from_group($remove_ids) {
        if (INDIA) {
            $data = array('group_id' => null);
            $this->db->where_in('employee_id', $remove_ids);
            $this->db->update('vms_employee_master', $data);
        }
    }









    public function generateTimesheetInvoice($data) {
        $this->db->insert('vms_admin_payment_master', $data);

        $last_id = $this->db->insert_id();
        return $last_id;
    }

    public function generateConTimesheetInvoice($data) {
        $this->db->insert('vms_payment_master', $data);
//        echo $this->db->last_query();
//        die;
        $last_id = $this->db->insert_id();
        return $last_id;
    }

    public function add_consultants_internal_files($data) {
        $this->db->insert('vms_consultant_internal_files', $data);
        $last_id = $this->db->insert_id();
        return $last_id;
    }

    public function add_consultants_documents($data) {
        $this->db->insert('vms_consultant_documents', $data);
        $last_id = $this->db->insert_id();
        return $last_id;
    }

    public function update_employee_user($data, $id) {
        $this->db->where('employee_id', $id);
        $this->db->update('vms_employee_master', $data);
//        echo $this->db->last_query();
//        die;

        if ($this->db->affected_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    public function updateInternalFileStatus($data, $id) {
        $this->db->where('id', $id);
        $this->db->update('vms_consultant_internal_files', $data);
//        echo $this->db->last_query();
//        die;

        if ($this->db->affected_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    public function update_employee_login_user($data, $id) {
        $this->db->where('employee_id', $id);
        $this->db->update('vms_employee_login_details', $data);
//        echo $this->db->last_query();
//        die;

        if ($this->db->affected_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    public function update_docs($data, $id) {
        $this->db->where('id', $id);
        $this->db->update('vms_vendor_documents', $data);
//        echo $this->db->last_query();
//        die;

        if ($this->db->affected_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    public function update_consultants_internal_files($data, $id) {
        $this->db->where('id', $id);
        $this->db->update('vms_consultant_internal_files', $data);
//        echo $this->db->last_query();
//        die;

        if ($this->db->affected_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    public function update_consultant_docs($data, $id) {
        $this->db->where('id', $id);
        $this->db->update('vms_consultant_documents', $data);
//        echo $this->db->last_query();
//        die;

        if ($this->db->affected_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    public function change_block_status($data, $id) {
        $this->db->where('employee_id', $id);
        $this->db->update('vms_employee_login_details', $data);
//        echo $this->db->last_query();
//        die;

        if ($this->db->affected_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    public function checkStatus($id) {

        $condition = "employee_id = '" . $id . "'";
        $this->db->select('status');
        $this->db->from('vms_employee_login_details');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function checkBlockStatus($id) {

        $condition = "employee_id = '" . $id . "'";
        $this->db->select('block_status');
        $this->db->from('vms_employee_login_details');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function change_status($data, $id) {
        $this->db->where('employee_id', $id);
        $this->db->update('vms_employee_login_details', $data);
//        echo $this->db->last_query();
//        die;

        if ($this->db->affected_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    public function getDetails($email) {

        $condition = "employee_email = '" . $email . "'";
        $this->db->select('*');
        $this->db->from('vms_employee_master');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getDocumentsLists() {

        $condition = "status = '1'";
        $this->db->select('*');
        $this->db->from('vms_consultant_documents');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getDocumentsListsbyEmpType($employee_type) {

        $condition = "status = '1' and FIND_IN_SET('" . $employee_type . "',required_for) > 0";
        $this->db->select('*');
        $this->db->from('vms_consultant_documents');
        $this->db->where($condition);
        $query = $this->db->get();
//        echo $this->db->last_query();
//        die;
        $data = $query->result_array();
        return $data;
    }

    public function checkDuplicate($email, $id = 0) {

        $mails_arr = array();
        $this->db->select('distinct(sa_email)');
        $this->db->from('vms_superadmin_master');
        $this->db->like('sa_email', $email);
        $superadmin_query = $this->db->get();

        $this->db->select('distinct(admin_email)');
        $this->db->from('vms_admin_master');
        $this->db->like('admin_email', $email);
        $admin_query = $this->db->get();

        $this->db->select('distinct(vendor_email)');
        $this->db->from('vms_vendor_master');
        $this->db->like('vendor_email', $email);
        $vendor_query = $this->db->get();

        $this->db->select('distinct(employee_email)');
        $this->db->from('vms_employee_master');
        $this->db->like('employee_email', $email);
        if (LATAM) {
            if (!empty($id)) {
                $this->db->where("employee_id != '" . $id . "'");
            }
        }
        $employee_query = $this->db->get();

        $superadmin_email = array();
        $admin_email = array();
        $vendor_email = array();
        $employee_email = array();

        if ($superadmin_query->num_rows() > 0) {

            foreach ($superadmin_query->result() as $superadmin_row) {
                $superadmin_email[] = $superadmin_row->sa_email;
            }
        }

        if ($admin_query->num_rows() > 0) {
            foreach ($admin_query->result() as $admin_row) {
                $admin_email[] = $admin_row->admin_email;
            }
        }

        if ($vendor_query->num_rows() > 0) {

            foreach ($vendor_query->result() as $vendor_row) {
                $vendor_email[] = $vendor_row->vendor_email;
            }
        }

        if ($employee_query->num_rows() > 0) {

            foreach ($employee_query->result() as $employee_row) {
                $employee_email[] = $employee_row->employee_email;
            }
        }


        if (!empty($superadmin_email) || !empty($admin_email) || !empty($vendor_email) || !empty($employee_email)) {
            $mails_arr = array_unique(array_merge($superadmin_email, $admin_email, $vendor_email, $employee_email));
        }

        if (in_array($email, $mails_arr)) {
            return 1;
        } else {
            return 0;
        }
    }
    
    /**
     * Gets the list of all the active Consultants
     * along with all the necessary details from other tables.
     *
     * @return     array  The employee lists
     */
    public function getEmployeeListsIntegrated($debug = false) {
        if (INDIA || US) {
            $_time_start = time();

            // Set up the Main Query
            $query_str = "SELECT em.*,
                                vm.`vendor_company_name`,
                                ewo.`employee_id` AS `wo_employee_id`,
                                hawo.`file` AS `wo_file`,
                                eld.`consultant_email`, eld.`status` AS `login_status`,
                                eld.`block_status` AS `login_block_status`,
                                am.`name_prefix` AS `admin_name_prefix`,
                                am.`first_name` AS `admin_first_name`, am.`last_name` AS `admin_last_name`
                        FROM `vms_employee_master` AS em
                        INNER JOIN `vms_admin_master` AS am ON em.`admin_id` = am.`admin_id`
                        LEFT JOIN `vms_vendor_master` AS vm ON em.`vendor_id` = vm.`vendor_id`
                        LEFT JOIN `vms_employee_login_details` AS eld ON em.`employee_id` = eld.`employee_id`
                        LEFT JOIN `vms_employee_work_order` AS ewo ON em.`employee_id` = ewo.`employee_id`
                        LEFT JOIN (
                            -- This query finds the list of all latest WOs for each Consultant
                            SELECT `file`, `id`, `employee_id`
                            FROM `vms_historical_approved_work_order`
                            WHERE `id` IN (
                            -- This query finds the list of all max WO IDs for each Consultant
                            SELECT MAX(`id`) AS `hwo_max_id`
                            FROM `vms_historical_approved_work_order`
                            GROUP BY `employee_id`
                            )
                        ) AS hawo ON em.`employee_id` = hawo.`employee_id`
                        WHERE em.`employee_type` = 'C' AND em.`is_delete` = '0'
                        ORDER BY em.`first_name` ASC, em.`last_name` ASC";

            $query = $this->db->query($query_str);
            $data = $query->result_array();

            if ($debug) {
                echo "<pre>" . print_r($data, 1) . "</pre>--==";
            }

            if (count($data)) {
                // Sets up all the custom data as per the corresponding View page requirements
                foreach ($data as $_each_k => $_each_record) {
                    $_each_id_encoded = base64_encode($_each_record['employee_id']);
                    $data[$_each_k]['emp_id_encoded'] = $_each_id_encoded;

                    $data[$_each_k]['admin_full_name'] = ucwords($_each_record['admin_name_prefix'] . " " . $_each_record['admin_first_name'] . " " . $_each_record['admin_last_name']);

                    $data[$_each_k]['full_name'] = $_each_record['name_prefix'] . " " . $_each_record['first_name'] . " " . $_each_record['last_name'];

                    $data[$_each_k]['url_edit'] = base_url('edit-consultant/' . $_each_id_encoded);

                    $data[$_each_k]['mod_joining_date'] = date("m-d-Y", strtotime($_each_record['date_of_joining']));

                    $data[$_each_k]['category'] = show_categories($_each_record['temp_category'], false);

                    $data[$_each_k]['url_ts_view_detail'] = base_url('view-superadmin-con-timesheet/' . $_each_id_encoded);
                    $data[$_each_k]['url_ts_view_quick'] = base_url('con-timesheet?customid=' . $_each_record['employee_id']);

                    $data[$_each_k]['url_wo_add'] = base_url('add_sadmin_employee_work_order/' . $_each_id_encoded);
                    $data[$_each_k]['url_wo_edit'] = base_url('edit-sadmin-employee-work-order/' . $_each_id_encoded);
                    $data[$_each_k]['url_wo_view'] = base_url('uploads/historical_work_order/' . $_each_record['wo_file']);

                    $data[$_each_k]['url_docs_list'] = base_url('view_superadmin_consultant_documents/' . $_each_id_encoded);

                    $data[$_each_k]['url_generate_login_detail'] = base_url('generate-superadmin-consultant-login-details/' . $_each_id_encoded);

                    $data[$_each_k]['phone_num_text'] = '';
                    if (!empty($_each_record['phone_no'])) {
                        $data[$_each_k]['phone_num_text'] = $_each_record['phone_no'];
                    }

                    $data[$_each_k]['fax_num_text'] = '';
                    if (!empty($_each_record['fax_no'])) {
                        $data[$_each_k]['fax_num_text'] = $_each_record['fax_no'];
                    }

                    if (empty($_each_record['temp_classification'])) {
                        if ($_each_record['employee_category'] == '1') {
                            $_each_classification = "W2";
                        } else if ($_each_record['employee_category'] == '2') {
                            $_each_classification = "Subcontractor";
                        }
                    } else {
                        $_each_classification = show_classifications($_each_record['temp_classification'], false);
                    }
                    $data[$_each_k]['classification'] = $_each_classification;

                    $_each_resume_file_path = '#';
                    if (!empty($_each_record['resume_file'])) {
                        $_each_resume_file_path = base_url() . 'uploads/' . $_each_record['resume_file'];
                    }
                    $data[$_each_k]['resume_file_path'] = $_each_resume_file_path;

                    unset($_each_id_encoded, $_each_classification, $_each_resume_file_path);
                }
            }

            if ($debug) {
                $time_duration = time() - $_time_start;
                echo "<br/>Duration of this DB transaction = " . $time_duration . " seconds.<br/>";
                echo "<pre>" . print_r($data, 1) . "</pre>";
            }

            return $data;
        }
    }

    public function getEmployeeLists($str_select_fields = '*') {

        $condition = "employee_type = 'C' AND is_delete = '0'";
		//$condition = "is_delete = '0'";
        $this->db->select($str_select_fields);
        $this->db->from('vms_employee_master');
        $this->db->where($condition);
        $this->db->order_by("employee_id", "desc");

        $query = $this->db->get();
        $data = $query->result_array();

        return $data;
    }
	
    public function getAllEmployeeLists($str_select_fields = '*') {

        $condition = "is_delete = '0'";
        $this->db->select($str_select_fields);
        $this->db->from('vms_employee_master');
        $this->db->where($condition);
        $this->db->order_by("employee_id", "desc");

        $query = $this->db->get();
        $data = $query->result_array();

        return $data;
    }

    public function getEmployeeListsbyType($str_select_fields = '*') {

        $condition = "employee_type = 'E' and is_delete = '0'";
        $this->db->select($str_select_fields);
        $this->db->from('vms_employee_master');
        $this->db->where($condition);
        $this->db->order_by("employee_id", "desc");

        $query = $this->db->get();
        $data = $query->result_array();

        return $data;
    }

    public function getEmployeeData($id) {

        $condition = "employee_id = '" . $id . "'";
        $this->db->select('*');
        $this->db->from('vms_employee_master');
        $this->db->where($condition);

        $query = $this->db->get();
        $data = $query->result_array();

        return $data;
    }

    public function getConsultantData($id) {

        $condition = "employee_id = '" . $id . "' and is_delete = '0'";
        $this->db->select('*');
        $this->db->from('vms_employee_master');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getAdminData($id) {

        $condition = "admin_id = '" . $id . "'";
        $this->db->select('*');
        $this->db->from('vms_admin_master');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function update_work_order($data, $id) {
        $this->db->where('employee_id', $id);
        $this->db->update('vms_employee_work_order', $data);
//        echo $this->db->last_query();
//        die;

        if ($this->db->affected_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    public function getVendorData($id) {

        $condition = "vendor_id = '" . $id . "'";
        $this->db->select('*');
        $this->db->from('vms_vendor_master');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getSuperAdminData($id) {

        $condition = "sa_id = '" . $id . "' and lower(sa_name) not like 'aurica%'";
        $this->db->select('*');
        $this->db->from('vms_superadmin_master');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getFormData($id) {

        $condition = "id = '" . $id . "'";
        $this->db->select('*');
        $this->db->from('vms_consultant_documents');
        $this->db->where($condition);
        $query = $this->db->get();
        //echo $this->db->last_query();

        $data = $query->result_array();
        return $data;
    }

	public function getVendorFormData($id) {

        $condition = "id = '" . $id . "'";
        $this->db->select('*');
        $this->db->from('vms_vendor_documents');
        $this->db->where($condition);
        $query = $this->db->get();
        //echo $this->db->last_query();

        $data = $query->result_array();
        return $data;
    }

    public function getAdminName($id) {

        $condition = "admin_id = '" . $id . "'";
        $this->db->select('*');
        $this->db->from('vms_admin_master');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getVendorName($id) {

        $condition = "vendor_id = '" . $id . "'";
        $this->db->select('*');
        $this->db->from('vms_vendor_master');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getVendorsName($id) {

        $condition = "vendor_id IN (" . $id . ")";
        $this->db->select('*');
        $this->db->from('vms_vendor_master');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getVendorID($id) {

        $condition = "employee_id = '" . $id . "'";
        $this->db->select('vendor_id');
        $this->db->from('vms_employee_master');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->row();
        return $data;
    }

    public function getVendorDetails($id) {

        $condition = "vendor_id = '" . $id . "'";
        $this->db->select('*');
        $this->db->from('vms_vendor_master');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->row();
        return $data;
    }

    public function getEmployeeProjects($employee_id) {

        $condition = "employee_id = '" . $employee_id . "'";
        $this->db->select('*');
        $this->db->from('vms_assign_projects_to_employee');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getEmployeeProjectDetails($employee_id) {

        $condition = "employee_id = '" . $employee_id . "'";
        $this->db->select('*');
        $this->db->from('vms_project_timesheet_master');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getProjectData($id) {

        $condition = "id = '" . $id . "'";
        $this->db->select('*');
        $this->db->from('vms_project_master');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function update_projects($data, $id) {
        $this->db->where('id', $id);
        $this->db->update('vms_project_master', $data);
//        echo $this->db->last_query();
//        die;

        if ($this->db->affected_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    public function getTimesheetData($project_id, $employee_id) {

        $condition = "project_id = '" . $project_id . "' and employee_id = '" . $employee_id . "'";
        $this->db->select('*');
        $this->db->from('vms_project_timesheet_master');
        $this->db->order_by("entry_date", "asc");
        $this->db->where($condition);
//        echo $this->db->last_query();
//        die;
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getInvoiceCodeByID($timesheet_id, $vendor_id) {

        $condition = "timesheet_period_id = " . $timesheet_id . " and vendor_id = " . $vendor_id . "";
        $this->db->select('*');
        $this->db->from('vms_admin_payment_master');
        $this->db->where($condition);
//        echo $this->db->last_query();
//        die;
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }
    public function getInvoiceDetailbyInvoiceCode($invoice_code)
    {

        $condition = "invoice_code ='" . $invoice_code ."'" ;
        $this->db->select('*');
        $this->db->from('vms_admin_payment_master');
        $this->db->where($condition);
        $this->db->order_by("invoice_code", "desc");
        $query = $this->db->get();
       // echo $this->db->last_query();
        // die;
        $data = $query->result_array();
        return $data;
    }

    public function update_sadmin_employee_invoice($data, $id) {
        $this->db->where('invoice_code', $id);
        $this->db->update('vms_admin_payment_master', $data);
        
       //echo $this->db->last_query();
     //  die;
        if ($this->db->affected_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    public function getInvoiceDetails() {

//        $condition = "status = '1'";
        $this->db->select('*');
        $this->db->from('vms_payment_master');
//        $this->db->where($condition);
        $this->db->order_by("employee_id", "desc");
        $query = $this->db->get();
//        echo $this->db->last_query();
//        die;
        $data = $query->result_array();
        return $data;
    }

    public function getInvoiceDetailsbyConsultants($emp_str) {

        $condition = "employee_id not in (" . $emp_str . ")";
        $this->db->select('*');
        $this->db->from('vms_payment_master');
        $this->db->where($condition);
        $this->db->order_by("employee_id", "desc");
        $query = $this->db->get();
//        echo $this->db->last_query();
//        die;
        $data = $query->result_array();
        return $data;
    }

    public function getAdminInvoiceDetailsbyConsultants($emp_str) {

        $condition = "employee_id not in (" . $emp_str . ") and status = '1' and vendor_id <> 0";
        $this->db->select('*');
        $this->db->from('vms_admin_payment_master');
        $this->db->where($condition);
        $this->db->order_by("employee_id", "desc");
        if (INDIA || US) {
            $this->db->limit(250);
        }
        $query = $this->db->get();
//        echo $this->db->last_query();
//        die;
        $data = $query->result_array();
        return $data;
    }

    public function getAdminNotApprvInvoiceDetailsbyConsultants($emp_str) {

        $condition = "employee_id not in (" . $emp_str . ") and status = '2' and vendor_id <> 0";
        $this->db->select('*');
        $this->db->from('vms_admin_payment_master');
        $this->db->where($condition);
        $this->db->order_by("employee_id", "desc");
        $query = $this->db->get();
//        echo $this->db->last_query();
//        die;
        $data = $query->result_array();
        return $data;
    }

    public function deleteInvoicePermanently($invoice_id) {

        $this->db->where('id', $invoice_id);
        $this->db->delete('vms_admin_payment_master');

        if ($this->db->affected_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    public function deleteVendorInvoicePermanently($invoice_id) {

        $this->db->where('id', $invoice_id);
        $this->db->delete('vms_payment_master');

        if ($this->db->affected_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    public function deleteEmployeeInvoicePermanently($invoice_id) {

        $this->db->where('id', $invoice_id);
        $this->db->delete('vms_admin_payment_master');

        if ($this->db->affected_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    public function getInvoiceDetailsbyEmployee($emp_str) {

        $condition = "employee_id in (" . $emp_str . ")";
        $this->db->select('*');
        $this->db->from('vms_admin_payment_master');
        $this->db->where($condition);
        if (LATAM) {
            $this->db->order_by("employee_id", "desc");
        }
        else {
            $this->db->order_by("id", "desc");
            $this->db->limit(250); 
        }
        $query = $this->db->get();
       // echo $this->db->last_query();
       // die;
        $data = $query->result_array();
        return $data;
    }

    public function checkInvoiceStatus($invoice_id) {

        $condition = "id = '" . $invoice_id . "'";
        $this->db->select('*');
        $this->db->from('vms_payment_master');
        $this->db->where($condition);
        $query = $this->db->get();
//        echo $this->db->last_query();
//        die;
        $data = $query->result_array();
        return $data;
    }

    public function checkAdminInvoiceStatus($invoice_id) {

        $condition = "id = '" . $invoice_id . "'";
        $this->db->select('*');
        $this->db->from('vms_admin_payment_master');
        $this->db->where($condition);
        $query = $this->db->get();
//        echo $this->db->last_query();
//        die;
        $data = $query->result_array();
        return $data;
    }

    public function getVendorDtls($id) {

        $condition = "vendor_id = '" . $id . "'";
        $this->db->select('*');
        $this->db->from('vms_vendor_master');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getDocsDetails($id) {

        $condition = "id = '" . $id . "'";
        $this->db->select('*');
        $this->db->from('vms_consultant_documents');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getWorkingDays($payment_type, $start_date, $end_date, $employee_id) {
        $condition = "1 = 1 AND approved_by_admin = '1' ";

        if ($payment_type == '1' || $payment_type == '3') {
            if ($start_date != "") {
                $condition .= " AND project_date >= '" . $start_date . "'";
            }
            if ($end_date != "") {
                $condition .= " AND project_date <= '" . $end_date . "'";
            }
        }

        $condition .= " AND employee_id = '" . $employee_id . "'";

        $this->db->select('project_date,tot_time,over_time');
        $this->db->from('vms_project_timesheet_master');
        $this->db->where($condition, NULL, FALSE);

        $query = $this->db->get();
//        echo $this->db->last_query();
//        die;
        $data = $query->result_array();
        return $data;
    }

    public function getWorkingDaysMonthly($payment_type, $month, $year, $employee_id) {
        $condition = "1 = 1";

        if ($payment_type == '2') {
            if ($month != "" && $year != "") {
                $condition .= " AND YEAR(project_date) = '" . $year . "' and MONTH(project_date) = '" . $month . "' AND approved_by_admin = '1'";
            }
        }

        $condition .= " AND employee_id = '" . $employee_id . "'";

        $this->db->select('project_date,tot_time,over_time');
        $this->db->from('vms_project_timesheet_master');
        $this->db->where($condition, NULL, FALSE);

        $query = $this->db->get();
//        echo $this->db->last_query();
//        die;
        $data = $query->result_array();
        return $data;
    }

    public function deleteDocuments($id) {
        $this->db->where('id', $id);
        $this->db->delete('vms_consultant_documents');
        if ($this->db->affected_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    public function getUploadedDocs($doc_id, $employee_id) {

        $condition = "form_no = '" . $doc_id . "' and consultant_id = '" . $employee_id . "'";
        $this->db->select('*');
        $this->db->from('vms_consultant_files');
        $this->db->where($condition);
        $query = $this->db->get();
//        echo $this->db->last_query();
        $data = $query->result_array();
        return $data;
    }

    public function check_docs_status($employee_id, $doc_id) {

        $condition = "form_no = '" . $doc_id . "' and consultant_id = '" . $employee_id . "'";
        $this->db->select('*');
        $this->db->from('vms_consultant_files');
        $this->db->where($condition);
        $query = $this->db->get();
//        echo $this->db->last_query();
        $data = $query->result_array();
        return $data;
    }

    public function change_docs_status($data, $employee_id, $doc_id) {
        $condition = "form_no = '" . $doc_id . "' and consultant_id = '" . $employee_id . "'";
        $this->db->where($condition);
        $this->db->update('vms_consultant_files', $data);
//        echo $this->db->last_query();
//        die;

        if ($this->db->affected_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    public function change_ucsis_docs_status($data, $employee_id) {
        $condition = "consultant_id = '" . $employee_id . "'";
        $this->db->where($condition);
        $this->db->update('vms_consultant_files', $data);
//        echo $this->db->last_query();
//        die;

        if ($this->db->affected_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    public function change_ucsis_status($data, $uscis_id) {
        $condition = "id = '" . $uscis_id . "'";
        $this->db->where($condition);
        $this->db->update('vms_emp_id_uscis_verifications_doc', $data);
//        echo $this->db->last_query();
//        die;

        if ($this->db->affected_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    public function get_ucsis_sadmin_approve_status($employee_id) {
        $condition = "consultant_id = '" . $employee_id . "'";
        $this->db->select('*');
        $this->db->from('vms_consultant_files');
        $this->db->where($condition);
//        echo $this->db->last_query();
//        die;
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getLoginDetails($employee_id) {

        $condition = "employee_id = '" . $employee_id . "'";
        $this->db->select('*');
        $this->db->from('vms_employee_login_details');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getGenerateStatus($employee_id) {

        $condition = "employee_id = '" . $employee_id . "'";
        $this->db->select('count(*) as cnt');
        $this->db->from('vms_employee_login_details');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getProjectLists() {
        if (DEMO) {
            $query_str = "SELECT
                        vp.id, 
                        vp.vendor_id,
                        vp.project_name,
                        vp.project_code,
                        vp.project_type,
                        vp.project_details,
                        vp.start_date,
                        vp.end_date,
                        vp.client_name,
                        vv.vendor_company_name,
                        va.first_name,
                        va.last_name,
                        va.admin_company_name,
                        cnt
                    FROM
                        vms_project_master AS vp
                            LEFT JOIN
                        vms_vendor_master AS vv ON vp.vendor_id = vv.vendor_id
                            LEFT JOIN
                        vms_admin_master AS va ON va.admin_id = vp.admin_id
                            LEFT JOIN (
                                SELECT count(*) as cnt, project_id FROM demossql.vms_assign_projects_to_employee GROUP BY project_id
                            ) AS cnt ON vp.id = cnt.project_id
                    WHERE
                        vp.is_deleted = '1'
                    ORDER BY vp.entry_date DESC";
            $query = $this->db->query($query_str);
            $data = $query->result_array();
            
            if (count($data)) {
                foreach ($data as $_each_k => $_each_record) {
                    $data[$_each_k]['view_assigned_consultant'] = base_url('view_superadmin_consultant_details/' . base64_encode($_each_record['id']));
                    $data[$_each_k]['action'] = base_url('edit-superamdin-projects/' . base64_encode($_each_record['id']));
                }
            }   
        }
        else {
            $condition = "is_deleted = '1'";
            $this->db->select('*');
            $this->db->from('vms_project_master');
            $this->db->where($condition);
            $this->db->order_by("entry_date", "desc");
            $query = $this->db->get();
            $data = $query->result_array();
            // return $data;
        }

        // print_r($data);
        return $data;
    }

    public function getCountEmployeesByProjects($project_id) {
        
        if (LATAM) {
            $condition = "project_id = '" . $project_id . "' and is_assigned='0'";
        }
        else {
            $condition = "project_id = '" . $project_id . "'";
        }
        // $condition = "project_id = '" . $project_id . "'";
        $this->db->select('count(*) as cnt');
        $this->db->from('vms_assign_projects_to_employee');
        $this->db->where($condition);
        $query = $this->db->get();
        // $this->db->last_query();
        $data = $query->result_array();
        return $data;
    }

    public function getAssignedEmpoyees($project_id) {
        
        if (LATAM) {
            $condition = "project_id = '" . $project_id . "' and is_assigned='0'";
        }
        else {
            $condition = "project_id = '" . $project_id . "'";
        }
        // $condition = "project_id = '" . $project_id . "'";
        $this->db->select('*');
        $this->db->from('vms_assign_projects_to_employee');
        $this->db->where($condition);
        $this->db->order_by("employee_id", "desc");
        $query = $this->db->get();
//        echo $this->db->last_query();
//        die;
        $data = $query->result_array();
        return $data;
    }

    public function getAssignProjectDtls($employee_id, $vendor_id) {

        $condition = "employee_id = '" . $employee_id . "' and vendor_id = '" . $vendor_id . "'";
        $this->db->select('*');
        $this->db->from('vms_assign_projects_to_employee');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getAssignProjectDtlsbyEmp($employee_id) {

        $condition = "employee_id = '" . $employee_id . "'";
        $this->db->select('*');
        $this->db->from('vms_assign_projects_to_employee');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getWorkDetails($employee_id) {

        $condition = "employee_id = '" . $employee_id . "'";
        $this->db->select('*');
        $this->db->from('vms_employee_work_order');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function checkCount($vendor_id) {

        $condition = "vendor_id = '" . $vendor_id . "'";
        $this->db->select('count(*) as cnt');
        $this->db->from('vms_employee_master');
        $this->db->where($condition);
        $query = $this->db->get();
//        echo $this->db->last_query();
//        die;
        $data = $query->result_array();
        return $data;
    }

    public function getVendorLists() {

        $condition = "is_delete = '0'";
        $this->db->select('*');
        $this->db->from('vms_vendor_master');
        $this->db->where($condition);
        $this->db->order_by("vendor_id", "desc");
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function selectVendorList($admin_id) {

        $condition = "admin_id = '" . $admin_id . "' and status = '1' and block_status = '1' and is_delete = '0'";
        $this->db->select('*');
        $this->db->from('vms_vendor_master');
        $this->db->where($condition);
        $this->db->order_by("vendor_id", "desc");
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getProjectType() {

//        $condition = "admin_id = '" . $admin_id . "'";
        $this->db->select('*');
        $this->db->from('vms_project_type_master');
//        $this->db->where($condition);
//        $this->db->order_by("entry_date", "desc");
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getLastID() {

        $this->db->select('id');
        $this->db->from('vms_project_master');
        $this->db->order_by("id", "desc");
        $this->db->limit(1);
        $query = $this->db->get();
//        echo $this->db->last_query();
        $data = $query->result_array();
        return $data;
    }

    public function add_projects($data) {
        $this->db->insert('vms_project_master', $data);
        $last_id = $this->db->insert_id();
        return $last_id;
    }

    public function getAdminDetails($id) {

        $condition = "admin_id = '" . $id . "'";
        $this->db->select('*');
        $this->db->from('vms_admin_master');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getSuperAdminDetails($id) {

        $condition = "sa_id = '" . $id . "' and lower(sa_name) not like 'aurica%'";
        $this->db->select('*');
        $this->db->from('vms_superadmin_master');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function checkWorkOrderStatus($employee_id) {

        $condition = "employee_id = '" . $employee_id . "'";
        $this->db->select('*');
        $this->db->from('vms_employee_work_order');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getAdminLists() {

        $condition = "status = '1' and block_status = '1' and is_delete = '0'";
        $this->db->select('*');
        $this->db->from('vms_admin_master');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getClientLists() {

        $condition = "status = '1'";
        $this->db->select('*');
        $this->db->from('vms_client_master');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function checkAdminCount($admin_id) {

        $condition = "admin_id = '" . $admin_id . "' and vendor_id = '0'";
        $this->db->select('count(*) as cnt');
        $this->db->from('vms_employee_master');
        $this->db->where($condition);
        $query = $this->db->get();
//        echo $this->db->last_query();
//        die;
        $data = $query->result_array();
        return $data;
    }

    public function generate_login_details($data) {
        $this->db->insert('vms_employee_login_details', $data);
        $last_id = $this->db->insert_id();
        return $last_id;
    }

    public function update_login_details($data, $id) {
        $this->db->where('employee_id', $id);
        $this->db->update('vms_employee_master', $data);
//        echo $this->db->last_query();
//        die;

        if ($this->db->affected_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    public function add_work_order($data) {
        $this->db->insert('vms_employee_work_order', $data);
        $last_id = $this->db->insert_id();
        return $last_id;
    }

    public function getWorkOrder($employee_id) {

        $condition = "employee_id = '" . $employee_id . "'";
        $this->db->select('*');
        $this->db->from('vms_employee_work_order');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function add_assign_projects($data) {
        $this->db->insert('vms_assign_projects_to_employee', $data);
        $last_id = $this->db->insert_id();
        return $last_id;
    }

    public function check_prev_assign($project_name, $employee_name) {

        $condition = "project_id = '" . $project_name . "' and employee_id = '" . $employee_name . "'";
        $this->db->select('count(*) as cnt');
        $this->db->from('vms_assign_projects_to_employee');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function checkGenerateStatus($employee_id) {

        $condition = "employee_id = '" . $employee_id . "'";
        $this->db->select('count(*) as cnt');
        $this->db->from('vms_employee_login_details');
        $this->db->where($condition);
        $query = $this->db->get();
//        echo $this->db->last_query();
        $data = $query->result_array();
        return $data;
    }

    public function getFiles($consultant_id) {

        $condition = "consultant_id = '" . $consultant_id . "'";
        $this->db->select('*');
        $this->db->from('vms_consultant_files');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function checkPrevUploadedDetails($doc_id, $employee_id) {

        $condition = "form_no = '" . $doc_id . "' and consultant_id = '" . $employee_id . "'";
        $this->db->select('*');
        $this->db->from('vms_consultant_files');
        $this->db->where($condition);
        $query = $this->db->get();
//        echo $this->db->last_query();
        $data = $query->result_array();
        return $data;
    }

    public function checkPrevUploaded($doc_id, $employee_id) {

        $condition = "form_no = '" . $doc_id . "' and consultant_id = '" . $employee_id . "'";
        $this->db->select('count(*) as cnt');
        $this->db->from('vms_consultant_files');
        $this->db->where($condition);
        $query = $this->db->get();
//        echo $this->db->last_query();
        $data = $query->result_array();
        return $data;
    }

    public function getPrevUploaded($doc_id, $employee_id) {

        $condition = "form_no = '" . $doc_id . "' and consultant_id = '" . $employee_id . "'";
        $this->db->select('*');
        $this->db->from('vms_consultant_files');
        $this->db->where($condition);
        $query = $this->db->get();
//        echo $this->db->last_query();
        $data = $query->result_array();
        return $data;
    }

    public function add_employee_documents($data) {
        $this->db->insert('vms_consultant_files', $data);
        $last_id = $this->db->insert_id();
        return $last_id;
    }

    public function checkTimesheet($project_id) {

        $condition = "project_id = '" . $project_id . "'";
        $this->db->select('count(*) as cnt');
        $this->db->from('vms_project_timesheet_master');
        $this->db->where($condition);
        $query = $this->db->get();
        //echo $this->db->last_query();
        $data = $query->result_array();
        return $data;
    }
    public function checkTimesheetPeriod($project_id) {
        
        if (INDIA || US) {
            $condition = "project_id = '" . $project_id . "'";
        }
        $this->db->select('count(*) as cnt');
        $this->db->from('vms_project_timesheet_period');
        if (INDIA || US) {
            $this->db->where($condition);
        }
        $query = $this->db->get();
        //echo $this->db->last_query();
        $data = $query->result_array();
        return $data;
    }

    public function getMonthlyTimesheet($month, $year, $employee_id) {
        $times = array();
        $otimes = array();
        $times_arr = array();
        $condition = "employee_id = '" . $employee_id . "' and YEAR(project_date) = '" . $year . "' and MONTH(project_date) = '" . $month . "' and approved_by_admin = '1'";
        $this->db->select('*');
        $this->db->from('vms_project_timesheet_master');
        $this->db->where($condition);
        $query = $this->db->get();
//        echo $this->db->last_query();
        $data = $query->result_array();

        foreach ($data as $tval) {
            $times[] = $tval['tot_time'];
            $otimes[] = $tval['over_time'];
        }
        $hours = "";
        $minutes = "";
        foreach ($times as $time) {
            $t_arr = explode(' ', $time);
            $minutes += $t_arr[0] * 60;
        }

        $hours = floor($minutes / 60);

        $ohours = "";
        $ominutes = "";
        foreach ($otimes as $otime) {
            $o_arr = explode(' ', $otime);
            $ominutes += $o_arr[0] * 60;
        }

        $ohours = floor($ominutes / 60);

        $times_arr['st'] = $hours;
        $times_arr['ot'] = $ohours;
        $times_arr['monthly_work_duration'] = count($data);
//        echo "<pre>";
//        print_r($times_arr);
//        die;
        return $times_arr;
    }

    public function getWeeklyTimesheet($start_date, $end_date, $employee_id) {
        $times = array();
        $otimes = array();
        $times_arr = array();
        $condition = "employee_id = '" . $employee_id . "' and (project_date between '" . $start_date . "' and '" . $end_date . "' ) and approved_by_admin = '1'";
        $this->db->select('*');
        $this->db->from('vms_project_timesheet_master');
        $this->db->where($condition);
        $query = $this->db->get();
//        echo $this->db->last_query();
//        die;
        $data = $query->result_array();

        foreach ($data as $tval) {
            $times[] = $tval['tot_time'];
            $otimes[] = $tval['over_time'];
        }
        $hours = "";
        $minutes = "";
        foreach ($times as $time) {
            $t_arr = explode(' ', $time);
            $minutes += $t_arr[0] * 60;
        }

        $hours = floor($minutes / 60);

        $ohours = "";
        $ominutes = "";
        foreach ($otimes as $otime) {
            $o_arr = explode(' ', $otime);
            $ominutes += $o_arr[0] * 60;
        }

        $ohours = floor($ominutes / 60);

        $times_arr['st'] = $hours;
        $times_arr['ot'] = $ohours;
        $times_arr['weekly_work_duration'] = count($data);
//        echo "<pre>";
//        print_r($times_arr);
//        die;
        return $times_arr;
    }

    public function generate_payment($data) {
        $this->db->insert('vms_payment_master', $data);
        $last_id = $this->db->insert_id();
        return $last_id;
    }

    public function getPrevGeneratedCode() {

        $this->db->select('invoice_code');
        $this->db->from('vms_admin_payment_master');
        $this->db->limit(1);
        $this->db->order_by("id", "desc");
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getCheckMonth($month, $year, $employee_id) {

        $condition = "employee_id = '" . $employee_id . "' and month = '" . $month . "' and year = '" . $year . "'";
        $this->db->select('count(*) as cnt');
        $this->db->from('vms_payment_master');
        $this->db->where($condition);
        $query = $this->db->get();
//        echo $this->db->last_query();
//        die;
        $data = $query->result_array();
        return $data;
    }

    public function getPrevInvoice($timesheet_period_id, $employee_id, $vendor_id, $start_date, $end_date) {

        $condition = "timesheet_period_id = '" . $timesheet_period_id . "'";
//        $condition = "timesheet_period_id = '" . $timesheet_period_id . "' and employee_id = '" . $employee_id . "' and vendor_id = '" . $vendor_id . "' and start_date = '" . $start_date . "' and end_date = '" . $end_date . "'";
        $this->db->select('count(*) as cnt');
        $this->db->from('vms_admin_payment_master');
        $this->db->where($condition);
        $query = $this->db->get();
//        echo $this->db->last_query();
//        die;
        $data = $query->result_array();
        return $data;
    }

    public function getCheckDate($start_date, $end_date, $employee_id) {

        $condition = "employee_id = '" . $employee_id . "' and start_date = '" . $start_date . "' and end_date = '" . $end_date . "'";
        $this->db->select('count(*) as cnt');
        $this->db->from('vms_payment_master');
        $this->db->where($condition);
        $query = $this->db->get();
//       echo $this->db->last_query();
//        die;
        $data = $query->result_array();
        return $data;
    }

    public function getEmpIDs() {

        $condition = "employee_type = 'E'";
        $this->db->select('*');
        $this->db->from('vms_employee_master');
        $this->db->where($condition);
        $query = $this->db->get();
//       echo $this->db->last_query();
//        die;
        $data = $query->result_array();
        return $data;
    }

    public function checkEmployee($id) {
        
        if (LATAM) {
            $condition = "employee_id = '" . $id . "' and status = '1'";
        }
        else {
            $condition = "employee_id = '" . $id . "'";
        }
        $this->db->select('*');
        $this->db->from('vms_assign_projects_to_employee');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function deleteEmployeeUser($data, $id) {
        $this->db->where('employee_id', $id);
        $this->db->update('vms_employee_master', $data);
        $emp_tbl = $this->db->affected_rows();

        $this->db->where('employee_id', $id);
        $this->db->update('vms_employee_login_details', $data);
        $emp_login_tbl = $this->db->affected_rows();
//echo $this->db->last_query();
//die;
        if ($emp_tbl > 0 || $emp_login_tbl > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    public function checkProject($id) {

        $condition = "project_id = '" . $id . "'";
        $this->db->select('*');
        $this->db->from('vms_assign_projects_to_employee');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function deleteProject($data, $id) {
        $this->db->where('id', $id);
        $this->db->update('vms_project_master', $data);
//echo $this->db->last_query();
//die;
        if ($this->db->affected_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    function deletePreviousDocs($form_name, $employee_id) {
        $condition = "form_name = '" . trim($form_name) . "' and consultant_id = '" . $employee_id . "'";
        $this->db->where($condition);
        $this->db->delete('vms_consultant_files');
        return 1;
    }

    function deletePreviousDocsbyID($doc_id, $employee_id) {
        $condition = "form_no = '" . $doc_id . "' and consultant_id = '" . $employee_id . "'";
        $this->db->where($condition);
        $this->db->delete('vms_consultant_files');
        return 1;
    }

    public function checkApproveStatus($doc_id, $employee_id) {

        $condition = "form_no = '" . $doc_id . "' and consultant_id = '" . $employee_id . "'";
        $this->db->select('*');
        $this->db->from('vms_consultant_files');
        $this->db->where($condition);
        $query = $this->db->get();
//        echo $this->db->last_query();
        $data = $query->result_array();
        return $data;
    }

    public function getWorkNote($client_name) {

        $condition = "id = '" . $client_name . "'";
        $this->db->select('*');
        $this->db->from('vms_client_master');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function updateWorkOrderStatus($data, $work_order_id) {
        $this->db->where('id', $work_order_id);
        $this->db->update('vms_employee_work_order', $data);
//echo $this->db->last_query();
//die;
        if ($this->db->affected_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    public function getEmployeeInternalFilesDetails() {

//        $condition = "employee_type = 'C' and is_delete = '0'";
        $this->db->select('*');
        $this->db->from('vms_consultant_internal_files');
//        $this->db->where($condition);
        $this->db->order_by("entry_date", "desc");
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getEmployeeTotalInternalFilesDetails($id) {

        $condition = "employee_id =  '" . $id . "'";
        $this->db->select('*');
        $this->db->from('vms_consultant_internal_files');
        $this->db->where($condition);
        $this->db->order_by("entry_date", "desc");
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getEmployeeInternalFileDetails() {

//        $condition = "employee_type = 'C' and is_delete = '0'";
        $this->db->select('id, employee_id, COUNT(employee_id) as tot_emp, entry_date');
        $this->db->from('vms_consultant_internal_files');
//        $this->db->where($condition);
        $this->db->group_by('employee_id');
        $this->db->order_by("entry_date", "desc");
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getInternalFileDetails($file_id) {

        $condition = "id = '" . $file_id . "'";
        $this->db->select('*');
        $this->db->from('vms_consultant_internal_files');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getClientDetails() {

        $condition = "status = '1'";
        $this->db->select('*');
        $this->db->from('vms_client_master');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

//    public function getClientData() {
//
//        $condition = "status = '1'";
//        $this->db->select('*');
//        $this->db->from('vms_client_master');
//        $this->db->where($condition);
//        $query = $this->db->get();
//        $data = $query->result_array();
//        return $data;
//    }
    public function getClientData($id) {

        $condition = "status = '1' and id = '" . $id . "'";
        $this->db->select('*');
        $this->db->from('vms_client_master');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getUscisFiles($consultant_id) {

        $condition = "employee_id = '" . $consultant_id . "'";
        $this->db->select('*');
        $this->db->from('vms_emp_id_uscis_verifications_doc');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getvmsEmpIdListA() {

        $this->db->select('*');
        $this->db->from('vms_emp_id_list_a');
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getvmsEmpNameListA($id) {

        $condition = "id = '" . $id . "'";
        $this->db->select('*');
        $this->db->from('vms_emp_id_list_a');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getvmsEmpNameListB($id) {

        $condition = "id = '" . $id . "'";
        $this->db->select('*');
        $this->db->from('vms_emp_id_list_b');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getvmsEmpNameListC($id) {

        $condition = "id = '" . $id . "'";
        $this->db->select('*');
        $this->db->from('vms_emp_id_list_c');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getvmsEmpIdListB() {

        $this->db->select('*');
        $this->db->from('vms_emp_id_list_b');
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getvmsEmpIdListC() {

        $this->db->select('*');
        $this->db->from('vms_emp_id_list_c');
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getAllFilesByClient($employee_type, $is_uhg, $is_jci, $emp_enrollment_type) {

        //for consultants
		if ($employee_type == 'C') {
            if (($is_uhg == 0) && ($is_jci == 0)) {
				$condition = "FIND_IN_SET('" . $employee_type . "',required_for) > 0 and UPPER(document_name) not in ('CWA Form', 'JCI Disclosure Form', 'PTS Employee Agreement - Hourly', 'PTS Employee Agreement - Yearly')";
            } 
			else if (($is_uhg == 1) && ($is_jci == 0)) {
				$condition = "FIND_IN_SET('" . $employee_type . "',required_for) > 0 and UPPER(document_name) not in  ('JCI Disclosure Form', 'PTS Employee Agreement - Hourly', 'PTS Employee Agreement - Yearly')";
            }
			else if (($is_jci == 1) && ($is_uhg == 0)){
				$condition = "FIND_IN_SET('" . $employee_type . "',required_for) > 0 and UPPER(document_name) not in ('CWA Form', 'PTS Employee Agreement - Hourly', 'PTS Employee Agreement - Yearly')";
            }
			else{
				$condition = "FIND_IN_SET('" . $employee_type . "',required_for) > 0 and UPPER(document_name) not in ('CWA Form', 'JCI Disclosure Form', 'PTS Employee Agreement - Hourly', 'PTS Employee Agreement - Yearly')";
			}
        }
		
		//For hourly employees
		else if (($employee_type == 'E') && ($emp_enrollment_type == 'yearly')){
			if (($is_uhg == 0) && ($is_jci == 0)) {
				$condition = "FIND_IN_SET('" . $employee_type . "',required_for) > 0 and UPPER(document_name) not in ('CWA Form', 'JCI Disclosure Form', 'PTS Employee Agreement - Hourly')";
            } 
			else if (($is_uhg == 1) && ($is_jci == 0)) {
				$condition = "FIND_IN_SET('" . $employee_type . "',required_for) > 0 and UPPER(document_name) not in ('JCI Disclosure Form', 'PTS Employee Agreement - Hourly')";
            }
			else if (($is_jci == 1) && ($is_uhg == 0)){
				$condition = "FIND_IN_SET('" . $employee_type . "',required_for) > 0 and UPPER(document_name) not in ('CWA Form', 'PTS Employee Agreement - Hourly')";
            }
			else{
				$condition = "FIND_IN_SET('" . $employee_type . "',required_for) > 0 and UPPER(document_name) not in ('CWA Form', 'JCI Disclosure Form', 'PTS Employee Agreement - Hourly')";
			}
        }
		
		//For yearly employees
		else if (($employee_type == 'E') && ($emp_enrollment_type == 'hourly')){
			if (($is_uhg == 0) && ($is_jci == 0)) {
				$condition = "FIND_IN_SET('" . $employee_type . "',required_for) > 0 and UPPER(document_name) not in ('CWA Form', 'JCI Disclosure Form', 'PTS Employee Agreement - Yearly')";
            } 
			else if (($is_uhg == 1) && ($is_jci == 0)) {
				$condition = "FIND_IN_SET('" . $employee_type . "',required_for) > 0 and UPPER(document_name) not in ('JCI Disclosure Form', 'PTS Employee Agreement - Yearly')";
            }
			else if (($is_jci == 1) && ($is_uhg == 0)){
				$condition = "FIND_IN_SET('" . $employee_type . "',required_for) > 0 and UPPER(document_name) not in ('CWA Form', 'PTS Employee Agreement - Yearly')";
            }
			else{
				$condition = "FIND_IN_SET('" . $employee_type . "',required_for) > 0 and UPPER(document_name) not in ('CWA Form', 'JCI Disclosure Form', 'PTS Employee Agreement - Yearly')";
			}
        }
		
        $this->db->select('*');
        $this->db->from('vms_consultant_documents');
        $this->db->where($condition);
        $query = $this->db->get();
//        echo $this->db->last_query();
        $data = $query->result_array();
        return $data;
    }

    public function getTimesheetDetails() {

        $condition = "status = '2'";
        $this->db->select('*');
        $this->db->from('vms_project_timesheet_period');
        $this->db->where($condition);
        $this->db->order_by("entry_date", "desc");
        $this->db->limit(250);
        $query = $this->db->get(); 
        // echo $this->db->last_query();
        // exit;
        $data = $query->result_array();
        return $data;
    }

    public function getProcessedTimesheetDetails($from_date, $to_date, $employee_ids, $timesheet_status) {

        $timesheet_details = $this->getHistoricalTimesheet($from_date, $to_date, $employee_ids, $timesheet_status);
        if (!empty($timesheet_details)) {
            foreach ($timesheet_details as $tkey => $tvalue) {

                $get_project_data = $this->employee_model->getProjectData($tvalue['project_id']);
                $tvalue['project_code'] = $get_project_data[0]['project_code'];
                $tvalue['project_name'] = $get_project_data[0]['project_name'];

                $get_employee_data = $this->employee_model->getEmployeeData($tvalue['employee_id']);
                $tvalue['employee_code'] = $get_employee_data[0]['employee_code'];
                $tvalue['full_name'] = $get_employee_data[0]['first_name'] . " " . $get_employee_data[0]['last_name'];
                $tvalue['employee_type'] = $get_employee_data[0]['employee_type'];

                $tvalue['employee_type_str'] = "1099";
                if ($tvalue['employee_type'] == 'C') {
                    $tvalue['employee_type_str'] = 'Consultant';
                } else if ($tvalue['employee_type'] == 'E') {
                    $tvalue['employee_type_str'] = 'Employee';
                }

                $cal_st = $this->employee_model->getTotalST($tvalue['id']);
                $tvalue['tot_time'] = number_format($cal_st[0]['tot_time'], 2);

                $cal_ot = $this->employee_model->getTotalOT($tvalue['id']);
                $tvalue['over_time'] = number_format($cal_ot[0]['over_time'], 2);

                $period_arr = explode("~", $tvalue['period']);
                $tvalue['start_date'] = date("m-d-Y", strtotime($period_arr[0]));
                $ed = (isset($period_arr[1])) ? $period_arr[1] : "";  # To prevent undefined offset error
                $tvalue['end_date'] = date("m-d-Y", strtotime($ed));

                if ($tvalue['status'] == '0') {
                    $tvalue['status_str'] = 'Not Approved';
                    $tvalue['status_color'] = 'red';
                } elseif ($tvalue['status'] == '1') {
                    $tvalue['status_str'] = 'Approved';
                    $tvalue['status_color'] = 'green';
                } elseif ($tvalue['status'] == '2') {
                    $tvalue['status_str'] = 'Pending Approval';
                    $tvalue['status_color'] = '#f39c12';  
                }

                unset($get_project_data, $get_employee_data, $cal_st, $cal_ot, $period_arr, $ed);
            }
        }

        return $timesheet_details;
    }
    
    public function getTimesheetDetailsByID($tid) {

        $condition = "id = '" . $tid . "'";
        $this->db->select('*');
        $this->db->from('vms_project_timesheet_period');
        $this->db->where($condition);
//        $this->db->order_by("entry_date", "desc");
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getTimesheetPeriodDetails($tid) {

        $condition = "timesheet_period_id = '" . $tid . "'";
        $this->db->select('*');
        $this->db->from('vms_project_timesheet_mast');
        $this->db->where($condition);
//        $this->db->order_by("entry_date", "desc");
        $query = $this->db->get();
//        echo $this->db->last_query();
        $data = $query->result_array();
        return $data;
    }

    public function getTotalST($timesheet_id) {

        $condition = "timesheet_period_id = '" . $timesheet_id . "'";
        $this->db->select('sum(tot_time) as tot_time');
        $this->db->from('vms_project_timesheet_mast');
        $this->db->where($condition);
//        $this->db->order_by("entry_date", "desc");
        $query = $this->db->get();
//        echo $this->db->last_query();
        $data = $query->result_array();
        return $data;
    }

    public function getTotalOT($timesheet_id) {

        $condition = "timesheet_period_id = '" . $timesheet_id . "'";
        $this->db->select('sum(over_time) as over_time');
        $this->db->from('vms_project_timesheet_mast');
        $this->db->where($condition);
//        $this->db->order_by("entry_date", "desc");
        $query = $this->db->get();
//        echo $this->db->last_query();
        $data = $query->result_array();
        return $data;
    }

    public function getTimesheetDetailsByEmpSearch($employee_id, $start_date, $end_date) {

        $condition = "employee_id = '" . $employee_id . "' and (period like '" . $start_date . "%' OR period like '%" . $end_date . "')";
        $this->db->select('*');
        $this->db->from('vms_project_timesheet_period');
        $this->db->where($condition);
        $this->db->order_by("entry_date", "desc");
        $query = $this->db->get();
//        echo $this->db->last_query();
        $data = $query->result_array();
        return $data;
    }

    public function getTimesheetDetailsByEmp($employee_id) {

        $condition = "employee_id = '" . $employee_id . "' and status = '1'";
        $this->db->select('*');
        $this->db->from('vms_project_timesheet_period');
        $this->db->where($condition);
        $this->db->order_by("entry_date", "desc");
        $query = $this->db->get();
//        echo $this->db->last_query();
        $data = $query->result_array();
        return $data;
    }

    public function getTimesheetDetailsnotapprove($employee_id) {

        $condition = "employee_id = '" . $employee_id . "' and status = '0'";
        $this->db->select('*');
        $this->db->from('vms_project_timesheet_period');
        $this->db->where($condition);
        $this->db->order_by("entry_date", "desc");
        $query = $this->db->get();
//        echo $this->db->last_query();
        $data = $query->result_array();
        return $data;
    }

    public function getTimesheetDetailspending($employee_id) {

        $condition = "employee_id = '" . $employee_id . "' and status = '2'";
        $this->db->select('*');
        $this->db->from('vms_project_timesheet_period');
        $this->db->where($condition);
        $this->db->order_by("entry_date", "desc");
        $query = $this->db->get();
//        echo $this->db->last_query();
        $data = $query->result_array();
        return $data;
    }

    public function getApprovedTimesheet($employee_ids) {
        if ($employee_ids != '') {
            $employee_ids = $employee_ids;
        } else {
            $employee_ids = 0;
        }
        $condition = "employee_id in (" . $employee_ids . ") and status = '1'";
        $this->db->select('*');
        $this->db->from('vms_project_timesheet_period');
        $this->db->where($condition);
        $this->db->order_by("entry_date", "desc");
        $query = $this->db->get();
//        echo $this->db->last_query();
        $data = $query->result_array();
        return $data;
    }

    public function getNotApprovedTimesheet($employee_ids) {
        if ($employee_ids != '') {
            $employee_ids = $employee_ids;
        } else {
            $employee_ids = 0;
        }
        $condition = "employee_id in (" . $employee_ids . ") and status = '0'";
        $this->db->select('*');
        $this->db->from('vms_project_timesheet_period');
        $this->db->where($condition);
        $this->db->order_by("entry_date", "desc");
        $query = $this->db->get();
//        echo $this->db->last_query();
        $data = $query->result_array();
        return $data;
    }

    public function getPendingTimesheet($employee_ids) {
        if ($employee_ids != '') {
            $employee_ids = $employee_ids;
        } else {
            $employee_ids = 0;
        }
        $condition = "employee_id in (" . $employee_ids . ") and status = '2'";
        $this->db->select('*');
        $this->db->from('vms_project_timesheet_period');
        $this->db->where($condition);
        $this->db->order_by("entry_date", "desc");
        $query = $this->db->get();
//        echo $this->db->last_query();
        $data = $query->result_array();
        return $data;
    }

    public function getApprovedTimesheetAll($employee_id, $status, $start_month, $start_year, $end_month, $end_year)  {

        $draw = intval($this->input->post('draw'));
        $start = intval($this->input->post('start'));
        $length = intval($this->input->post('length'));
        $order = $this->input->post('order');
        $col = 0;
        $dir = "";
        $order_by_str = "";
        $search = $this->input->post('search');
        $search = $search['value'];
        $search_query = '';
        if (!empty($order))
        {
            foreach($order as $o) {
                $col = $o['column'];
                $dir = $o['dir'];
            }
        }
        if ($dir!='asc' && $dir!='desc') {
            $dir = 'desc';
        }
        $valid_columns = array(
            0 => 'vptp.timesheet_id',
            1 => 'vpm.project_code',
            2 => 'vpm.project_name',
            3 => 'vem.employee_code',
            4 => 'vem.first_name',
            5 => 'vem.employee_type',
            6 => 'vptp.period',
            7 => 'vptp.period',
            8 => 'tot_time',
            9 => 'over_time',
            11 => 'vam.first_name',
            12 => 'vptp.approved_by'
        );
        if (!isset($valid_columns[$col])) {
            $order = null;
        }
        else {
            $order = $valid_columns[$col];
        }
        if ($order != null) {
            $order_by_str = "ORDER BY $order $dir";
        }
        if (!empty($search)) {
            $x = 0;
            foreach ($valid_columns as $sterm) {
                if ($x == 0)
                {
                    $search_query = "and ($sterm LIKE '%$search%'";
                }
                else {
                    $search_query.= "OR $sterm LIKE  '%$search%'";
                }
                $x++;
            }
            $search_query.= ")";
        }

        $start_date = $start_month."/__/".$start_year;
        $end_date = $end_month."/__/".$end_year;
        
        $sql = "SELECT vptp.id, vptp.employee_id, vptp.project_id, vptp.timesheet_id, vptp.period, vptp.approved_by_id, vptp.approved_by, vpm.project_code, vpm.project_name, vem.employee_code, vem.first_name as employee_first_name, vem.last_name as employee_last_name, vem.employee_type, vsm.sa_name, vam.first_name, vam.last_name, SUM(vptm.tot_time) AS tot_time, sum(over_time) as over_time FROM vms_project_timesheet_period vptp LEFT JOIN vms_project_master vpm ON vptp.project_id = vpm.id LEFT JOIN vms_employee_master vem ON vptp.employee_id = vem.employee_id LEFT JOIN vms_superadmin_master vsm ON vptp.approved_by_id = vsm.sa_id LEFT JOIN vms_admin_master vam ON vptp.approved_by_id = vam.admin_id LEFT JOIN vms_project_timesheet_mast vptm ON vptp.id = vptm.timesheet_period_id WHERE vptp.employee_id = $employee_id and vptp.status = '$status' and (vptp.period like '%" . $start_date . "%' OR vptp.period like '%" . $end_date . "%') $search_query GROUP BY vptp.id $order_by_str LIMIT $start,$length";

        $sql2 = "SELECT vptp.id, vptp.employee_id, vptp.project_id, vptp.timesheet_id, vptp.period, vptp.approved_by_id, vptp.approved_by, vpm.project_code, vpm.project_name, vem.employee_code, vem.first_name as employee_first_name, vem.last_name as employee_last_name, vem.employee_type, vsm.sa_name, vam.first_name, vam.last_name, SUM(vptm.tot_time) AS tot_time, sum(over_time) as over_time FROM vms_project_timesheet_period vptp LEFT JOIN vms_project_master vpm ON vptp.project_id = vpm.id LEFT JOIN vms_employee_master vem ON vptp.employee_id = vem.employee_id LEFT JOIN vms_superadmin_master vsm ON vptp.approved_by_id = vsm.sa_id LEFT JOIN vms_admin_master vam ON vptp.approved_by_id = vam.admin_id LEFT JOIN vms_project_timesheet_mast vptm ON vptp.id = vptm.timesheet_period_id WHERE vptp.employee_id = $employee_id and vptp.status = '$status' and (vptp.period like '%" . $start_date . "%' OR vptp.period like '%" . $end_date . "%') GROUP BY vptp.id ORDER BY vptp.entry_date desc LIMIT 100";

        $query2 = $this->db->query($sql2);
        
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            if ($status == 1) {
                foreach ($query->result() as $rows) {
                    $approved_by = '';
                    $employee_type = '';
                    $approved_by_type = '';
                    if ($rows->approved_by != '') {
                        if ($rows->approved_by == 'superadmin') {
                            $approved_by = ucwords($rows->sa_name);
                        }
                        else if ($rows->approved_by == 'admin') {
                            $approved_by = ucwords($rows->first_name. " " . $rows->last_name);
                        }
                    } else {
                        $approved_by = "";
                    }
                    
                    $cal_st = number_format($rows->tot_time, 2);
                    $cal_ot = number_format($rows->over_time, 2);

                    $period_arr = explode("~", $rows->period);
                    $start_date = date("m-d-Y", strtotime($period_arr[0]));
                    $ed = (isset($period_arr[1])) ? $period_arr[1] : "" ;
                    $end_date = date("m-d-Y", strtotime($ed));

                    $approved_string = "<a href='".base_url() . "sadmin-view-period-timesheet/" . base64_encode($rows->id)."'>".$rows->timesheet_id."</a>";

                    if ($rows->employee_type == 'C') {
                        $employee_type = "Consultant";
                    } else if ($rows->employee_type == 'E') {
                        $employee_type = "Employee";
                    }

                    $approved_by_type = ucwords($rows->approved_by);

                    $json[] = array(
                        $approved_string,
                        $rows->project_code,
                        $rows->project_name,
                        $rows->employee_code,
                        $rows->employee_first_name." ".$rows->employee_last_name,
                        $employee_type,
                        $start_date,
                        $end_date,
                        $cal_st,
                        $cal_ot,
                        "<span style='color: green;'>Approved</span>",
                        $approved_by,
                        $approved_by_type
                    );

                }
            }

            if ($status == 2) {
                foreach ($query->result() as $rows) {
                    $employee_type = '';
                    
                    $cal_st = number_format($rows->tot_time, 2);
                    $cal_ot = number_format($rows->over_time, 2);

                    $period_arr = explode("~", $rows->period);
                    $start_date = date("m-d-Y", strtotime($period_arr[0]));
                    $ed = (isset($period_arr[1])) ? $period_arr[1] : "" ;
                    $end_date = date("m-d-Y", strtotime($ed));

                    $anchor_string = "<a href='".base_url() . "sadmin-view-period-timesheet/" . base64_encode($rows->id)."'>".$rows->timesheet_id."</a>";

                    if ($rows->employee_type == 'C') {
                        $employee_type = "Consultant";
                    } else if ($rows->employee_type == 'E') {
                        $employee_type = "Employee";
                    }

                    $json[] = array(
                        $anchor_string,
                        $rows->project_code,
                        $rows->project_name,
                        $rows->employee_code,
                        $rows->employee_first_name." ".$rows->employee_last_name,
                        $employee_type,
                        $start_date,
                        $end_date,
                        $cal_st,
                        $cal_ot,
                        "<span style='color: #f39c12;'>Pending Approval</span>"
                    );

                }
            }

            if ($status == 0) {
                foreach ($query->result() as $rows) {
                    $approved_by = '';
                    $employee_type = '';
                    $approved_by_type = '';
                    if ($rows->approved_by != '') {
                        if ($rows->approved_by == 'superadmin') {
                            $approved_by = ucwords($rows->sa_name);
                        }
                        else if ($rows->approved_by == 'admin') {
                            $approved_by = ucwords($rows->first_name. " " . $rows->last_name);
                        }
                    } else {
                        $approved_by = "";
                    }
                    
                    $cal_st = number_format($rows->tot_time, 2);
                    $cal_ot = number_format($rows->over_time, 2);

                    $period_arr = explode("~", $rows->period);
                    $start_date = date("m-d-Y", strtotime($period_arr[0]));
                    $ed = (isset($period_arr[1])) ? $period_arr[1] : "" ;
                    $end_date = date("m-d-Y", strtotime($ed));

                    $anchor_string = "<a href='".base_url() . "sadmin-view-period-timesheet/" . base64_encode($rows->id)."'>".$rows->timesheet_id."</a>";

                    $approved_by_type = ucwords($rows->approved_by);

                    if ($rows->employee_type == 'C') {
                        $employee_type = "Consultant";
                    } else if ($rows->employee_type == 'E') {
                        $employee_type = "Employee";
                    }

                    $json[] = array(
                        $anchor_string,
                        $rows->project_code,
                        $rows->project_name,
                        $rows->employee_code,
                        $rows->employee_first_name." ".$rows->employee_last_name,
                        $employee_type,
                        $start_date,
                        $end_date,
                        $cal_st,
                        $cal_ot,
                        "<span style='color: #f31c02;'>Not Approved</span>",
                        $approved_by,
                        $approved_by_type
                    );

                }
            }

            // print_r($json);
            // exit;
            
            $response = array(
                'draw' => $draw,
                'recordsTotal' => $query2->num_rows(),
                'recordsFiltered' => $query2->num_rows(),
                'data' => $json
            );

            echo json_encode($response);
            exit;
        }
        else {
            $response = array();
            $response['sEcho'] = 0;
            $response['iTotalRecords'] = 0;
            $response['iTotalDisplayRecords'] = 0;
            $response['aaData'] = [];
            echo json_encode($response);
            exit;
        }

        // $data = $query->result_array();
        // $data = $query->num_rows();
        // return $data;
    }

    public function getConsultantApprovedTimesheetAll($employee_id, $status, $start_month, $start_year, $end_month, $end_year) {

        $start_date = $start_month."/__/".$start_year;
        $end_date = $end_month."/__/".$end_year;

        $sql = "SELECT vptp.id, vptp.employee_id, vptp.project_id, vptp.timesheet_id, vptp.period, vptp.approved_by_id, vptp.approved_by, vpm.project_code, vpm.project_name, vem.employee_code, vem.first_name as employee_first_name, vem.last_name as employee_last_name, vem.employee_type, vsm.sa_name, vam.first_name, vam.last_name, SUM(vptm.tot_time) AS tot_time, sum(vptm.over_time) as over_time, vapm.id as pr_invoice, vpym.id as vn_invoice FROM vms_project_timesheet_period vptp LEFT JOIN vms_project_master vpm ON vptp.project_id = vpm.id LEFT JOIN vms_employee_master vem ON vptp.employee_id = vem.employee_id LEFT JOIN vms_superadmin_master vsm ON vptp.approved_by_id = vsm.sa_id LEFT JOIN vms_admin_master vam ON vptp.approved_by_id = vam.admin_id LEFT JOIN vms_project_timesheet_mast vptm ON vptp.id = vptm.timesheet_period_id LEFT JOIN vms_admin_payment_master vapm ON vptp.id = vapm.timesheet_period_id LEFT JOIN vms_payment_master vpym ON vptp.id = vpym.timesheet_period_id WHERE vptp.employee_id = $employee_id and vptp.status = '$status' and (vptp.period like '%" . $start_date . "%' OR vptp.period like '%" . $end_date . "%') GROUP BY vptp.id ORDER BY vptp.entry_date desc LIMIT 100";
            
        $query = $this->db->query($sql);
        $data = $query->result_array();
        return $data;
    }

    public function getPendingTimesheetAll() {
       
        $sql = "SELECT vptp.id, vptp.employee_id, vptp.project_id, vptp.timesheet_id, vptp.period, vptp.approved_by_id, vptp.approved_by, vpm.project_code, vpm.project_name, vem.employee_code, vem.first_name as employee_first_name, vem.last_name as employee_last_name, vem.employee_type, vsm.sa_name, vam.first_name, vam.last_name, SUM(vptm.tot_time) AS tot_time, sum(over_time) as over_time FROM vms_project_timesheet_period vptp LEFT JOIN vms_project_master vpm ON vptp.project_id = vpm.id LEFT JOIN vms_employee_master vem ON vptp.employee_id = vem.employee_id LEFT JOIN vms_superadmin_master vsm ON vptp.approved_by_id = vsm.sa_id LEFT JOIN vms_admin_master vam ON vptp.approved_by_id = vam.admin_id LEFT JOIN vms_project_timesheet_mast vptm ON vptp.id = vptm.timesheet_period_id WHERE vptp.employee_id in (SELECT employee_id FROM vms_employee_master WHERE employee_type = 'E' and is_delete = '0'ORDER BY employee_id desc) and vptp.status = '2' GROUP BY vptp.id ORDER BY vptp.entry_date desc LIMIT 100";
        
        $query = $this->db->query($sql);

        $data = $query->result_array();
        return $data;
    }

    public function changeEachTimesheetStatus($data, $timesheet_id) {
        $this->db->where('id', $timesheet_id);
        $this->db->update('vms_project_timesheet_mast', $data);
//        echo $this->db->last_query();
//        die;

        if ($this->db->affected_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    public function changePeriodTimesheetStatus($data, $timesheet_period_id) {
        $this->db->where('id', $timesheet_period_id);
        $this->db->update('vms_project_timesheet_period', $data);
//        echo $this->db->last_query();
//        die;

        if ($this->db->affected_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    public function DeleteInvoice($data, $timesheet_period_id) {
        $this->db->where('timesheet_period_id', $timesheet_period_id);
        $this->db->update('vms_admin_payment_master', $data);
//        echo $this->db->last_query();
//        die;

        if ($this->db->affected_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    public function getPeriodDetails($timesheet_period_id) {

        $condition = "id = '" . $timesheet_period_id . "'";
        $this->db->select('*');
        $this->db->from('vms_project_timesheet_period');
        $this->db->where($condition);
//        $this->db->order_by("entry_date", "desc");
        $query = $this->db->get();
//        echo $this->db->last_query();
        $data = $query->result_array();
        return $data;
    }

    public function getPrInvoice($timesheet_period_id) {

        $condition = "timesheet_period_id = '" . $timesheet_period_id . "'";
        $this->db->select('*');
        $this->db->from('vms_admin_payment_master');
        $this->db->where($condition);
//        $this->db->order_by("entry_date", "desc");
        $query = $this->db->get();
//        echo $this->db->last_query();
        $data = $query->result_array();
        return $data;
    }

    public function getVnInvoice($timesheet_period_id) {

        $condition = "timesheet_period_id = '" . $timesheet_period_id . "'";
        $this->db->select('*');
        $this->db->from('vms_payment_master');
        $this->db->where($condition);
//        $this->db->order_by("entry_date", "desc");
        $query = $this->db->get();
//        echo $this->db->last_query();
        $data = $query->result_array();
        return $data;
    }

    public function checkUscisUploadedDocss($employee_id) {

        $condition = "employee_id = '" . $employee_id . "'";
        $this->db->select('*');
        $this->db->from('vms_emp_id_uscis_verifications_doc');
        $this->db->where($condition);
        $query = $this->db->get();
//        echo $this->db->last_query();
        $data = $query->result_array();
        return $data;
    }

    function deletePrevUscDocs($employee_id) {
        $condition = "employee_id = '" . $employee_id . "'";
        $this->db->where($condition);
        $this->db->delete('vms_emp_id_uscis_verifications_doc');
        return 1;
    }

    public function add_consultants_uscis_documents($data) {
        $this->db->insert('vms_emp_id_uscis_verifications_doc', $data);
        $last_id = $this->db->insert_id();
        return $last_id;
    }

    public function getConProjectLists($employee_id) {

        $condition = "employee_id = '" . $employee_id . "'";
        $this->db->select('*');
        $this->db->from('vms_assign_projects_to_employee');
        $this->db->where($condition);
//        $this->db->order_by("entry_date", "desc");
        $query = $this->db->get();
//        echo $this->db->last_query();
        $data = $query->result_array();
        return $data;
    }
    public function add_timesheet_period($data) {
        $this->db->insert('vms_project_timesheet_period', $data);
        $last_id = $this->db->insert_id();
        return $last_id;
    }
    public function add_timesheet($data) {
        $this->db->insert('vms_project_timesheet_mast', $data);
//        $this->db->insert('vms_project_timesheet_master', $data);
        $last_id = $this->db->insert_id();
        return $last_id;
    }

    public function getEmpProjectLists($employee_id) {

        $condition = "employee_id = '" . $employee_id . "'";
        $this->db->select('*');
        $this->db->from('vms_assign_projects_to_employee');
        $this->db->where($condition);
//        $this->db->order_by("entry_date", "desc");
        $query = $this->db->get();
//        echo $this->db->last_query();
        $data = $query->result_array();
        return $data;
    }

    public function getConsultantInvoiceData($cons_str) {

        $condition = "employee_id not in (" . $cons_str . ") and status = '0' ";
        $this->db->select('*');
        $this->db->from('vms_payment_master');
        $this->db->where($condition);
        $this->db->order_by("invoice_code", "desc");
        $this->db->limit(250);
        $query = $this->db->get();
       // echo $this->db->last_query();
       // die;
        $data = $query->result_array();
        return $data;
    }

    public function getEmployeeInvoiceData($emp_str) {

        $condition = "employee_id in (" . $emp_str . ")";
        $this->db->select('*');
        $this->db->from('vms_admin_payment_master');
        $this->db->where($condition);
        $this->db->order_by("employee_id", "desc");
        $query = $this->db->get();
        $data = $query->result_array();
        // print_r($this->db->last_query());
        // echo $this->db->last_query();
        // exit;
        
        return $data;
    }

    public function getHistoricalTimesheet($from_date, $to_date, $employee_ids, $timesheet_status) {

        $condition = "employee_id in (" . $employee_ids . ") and status = " . "'" . $timesheet_status . "'" . " and ( period LIKE " . "'" . $from_date[0][0] . "%'" ." OR period LIKE " . "'" . $from_date[0][1] ."%'". " OR period LIKE " . "'" . $from_date[0][2] ."%'". "  OR period LIKE " . "'" . $from_date[0][3] ."%'". "  OR period LIKE " . "'" . $from_date[0][4] ."%'". "  OR period LIKE " . "'" . $from_date[0][5] ."%'". "  OR period LIKE " . "'" . $from_date[0][6] ."%'". ") and ( period LIKE " . "'%" . $to_date[0][0] . "'" . " OR period LIKE " . "'%" . $to_date[0][1] ."'". " OR period LIKE " . "'%" . $to_date[0][2] ."'". " OR period LIKE " . "'%" . $to_date[0][3] ."'". " OR period LIKE " . "'%" . $to_date[0][4] ."'". " OR period LIKE " . "'%" . $to_date[0][5] ."'". " OR period LIKE " . "'%" . $to_date[0][6] ."'". ")" ;
        $this->db->select('*');
        $this->db->from('vms_project_timesheet_period');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        //print_r($this->db->last_query());
        return $data;
    }

    public function getAllHistoricalTimesheetNew($db_from_date, $db_to_date, $dates, $employee_ids, $timesheet_status) {

        // print_r($dates);
        if (INDIA || US) {

            $query_str = "period LIKE '";
            $period = [];

            $time_db_from_date=strtotime($db_from_date);
            $month_db_from_date=date("m",$time_db_from_date);

            $time_db_to_date=strtotime($db_to_date);
            $month_db_to_date=date("m",$time_db_to_date);
            
            foreach($dates as $date) {
                $time=strtotime($date);
                $month=date("m",$time);
                $year=date("Y",$time);

                if ($month == $month_db_from_date) {
                    $query_str .= "$date%' OR  period LIKE '";
                }
                else if ($month == $month_db_to_date) {
                    $query_str .= "%$date' OR  period LIKE '";
                }
                else {
                    if (!in_array("$month"."____"."$year%", $period)) {
                        $period[] = "$month"."____"."$year%";
                        $query_str .= "$month"."____"."$year%' OR  period LIKE '";
                    }
                }
            }
        
            $query_str = substr($query_str, 0, strlen($query_str) - 18);
            // exit;
            $condition = "employee_id in (" . $employee_ids . ") and status = " . "'" . $timesheet_status . "'" . " and (  $query_str )" ;

            // print_r($condition);
            $this->db->select('*');
            $this->db->from('vms_project_timesheet_period');
            $this->db->where($condition);
            $query = $this->db->get();
            $data = $query->result_array();
            // print_r($this->db->last_query());
            return $data;
        }
    }

    public function getConsPeriodicInvoice($from_date, $to_date, $emp_str) {

        $condition = "employee_id not in (" . $emp_str . ") and status = '0' and (str_to_date(start_date, '%m/%d/%Y') >= str_to_date('$from_date', '%m/%d/%Y') and str_to_date(end_date, '%m/%d/%Y') <= str_to_date('$to_date', '%m/%d/%Y')) ";
        $this->db->select('*');
        $this->db->from('vms_payment_master');
        $this->db->where($condition);
        $this->db->order_by("invoice_code", "desc");
        $query = $this->db->get();
        $data = $query->result_array(); 
        //print_r($this->db->last_query());
        return $data;
    }

    public function getEmpPeriodicInvoice($from_date, $to_date, $emp_str) {

        $condition = "employee_id in (" . $emp_str . ") and (str_to_date(start_date, '%m/%d/%Y') >= str_to_date('$from_date', '%m/%d/%Y') and str_to_date(end_date, '%m/%d/%Y') <= str_to_date('$to_date', '%m/%d/%Y')) ";
        $this->db->select('*');
        $this->db->from('vms_admin_payment_master');
        $this->db->where($condition);
        $this->db->order_by("employee_id", "desc");
        $query = $this->db->get();
        $data = $query->result_array();
        //print_r($this->db->last_query());
        return $data;
    } 

    public function send_new_doc_email($emp_type, $doc_type = false) {

        if ($emp_type == 'E') {

            $condition = "vms_employee_master.employee_type = 'E'";

        } else if ($emp_type == 'C') {

            $condition = "vms_employee_master.employee_type = 'C'";

        } else {

            $condition = "(vms_employee_master.employee_type = 'C'  || vms_employee_master.employee_type = 'E')";   

        }

        $condition .= " AND vms_employee_login_details.status = '1'
            AND vms_employee_login_details.block_status = '1'
            AND vms_employee_login_details.is_delete = '0'";

        if ($doc_type) {
            
            $condition .= " AND vms_employee_master.date_of_joining >= '" . NEW_DOC_DATE . "'";
        }

        $this->db->_protect_identifiers = FALSE;
        $this->db->select('vms_employee_master.employee_email, vms_employee_master.employee_type, vms_employee_login_details.status, vms_employee_login_details.block_status, vms_employee_login_details.is_delete');
        $this->db->from('vms_employee_master');
        $this->db->join('vms_employee_login_details', 'vms_employee_master.employee_id = vms_employee_login_details.employee_id', 'inner');
        $this->db->where($condition);
        $query = $this->db->get();
        // print_r($this->db->last_query());
        // exit;
        $data = $query->result_array();
        return $data;
    }

    /**
     * Get the name of the user whose email ID is provided based on the user type
     */
    public function send_new_email_all_user_types($user_type, $email_id) {

        if (LATAM) {

            if ($user_type == 'E') { // Employee

                $select_list = 'vms_employee_master.first_name, vms_employee_master.last_name, vms_employee_master.employee_email';
                $main_from = 'vms_employee_master';
                $condition = "vms_employee_master.employee_type = 'E' and vms_employee_login_details.status='1' and vms_employee_login_details.block_status='1' and vms_employee_login_details.is_delete='0' and vms_employee_master.employee_email = '" . $email_id . "'";

            } else if ($user_type == 'C') { // Consultant

                $select_list = 'vms_employee_master.first_name, vms_employee_master.last_name, vms_employee_master.employee_email';
                $main_from = 'vms_employee_master';
                $condition = "vms_employee_master.employee_type = 'C' and vms_employee_login_details.status='1' and vms_employee_login_details.block_status='1' and vms_employee_login_details.is_delete='0' and vms_employee_master.employee_email = '" . $email_id . "'";

            } else if ($user_type == 'S') { // Super Admin

                $select_list = 'sa_name, sa_email';
                $main_from = 'vms_superadmin_master';
                $condition = "sa_email = '" . $email_id . "'";

            } else if ($user_type == 'A') { // Admin

                $select_list = 'first_name, last_name, admin_email';
                $main_from = 'vms_admin_master';
                $condition = "admin_email = '" . $email_id . "'";

            } else if ($user_type == 'V') { // Vendor

                $select_list = 'first_name, last_name, vendor_email';
                $main_from = 'vms_vendor_master';
                $condition = "vendor_email = '" . $email_id . "'";

            } else { // Others

                $select_list = 'vms_employee_master.first_name, vms_employee_master.last_name, vms_employee_master.employee_email';
                $main_from = 'vms_employee_master';
                $condition = "(vms_employee_master.employee_type = 'C' || vms_employee_master.employee_type = 'E') and vms_employee_login_details.status='1' and vms_employee_login_details.block_status='1' and vms_employee_login_details.is_delete='0' and vms_employee_master.employee_email = '" . $email_id . "'";

            }

            $this->db->_protect_identifiers = FALSE;
            $this->db->select($select_list);
            $this->db->from($main_from);

            /**
             * This join is true ONLY if the user type is not Admin or Super Admin or Vendor
             */
            if (!in_array($user_type, ['A', 'S', 'V'])) {
                $this->db->join('vms_employee_login_details', 'vms_employee_master.employee_id = vms_employee_login_details.employee_id', 'inner');
            }

            $this->db->where($condition);
            $query = $this->db->get();
            // print_r($this->db->last_query());
            // exit;
            $data = $query->result_array();
            return $data;
        }
    }

    public function final_approved_work_order($employee_id) {

        $condition = "employee_id = '" . $employee_id . "'";
        $this->db->select('*');
        $this->db->from('vms_historical_approved_work_order');
        $this->db->where($condition);
        $this->db->order_by('final_approval_date', 'desc');
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function asp_sign_work_order($data, $employee_id) {

        if (INDIA || US) {

            $this->db->where('employee_id', $employee_id);
            $this->db->update('vms_employee_work_order', $data);
            return $this->db->affected_rows();
        }
    }

    public function insert_historical_approved_work_order($data) {
        if (INDIA || US) {
            $this->db->insert('vms_historical_approved_work_order', $data);
            return $this->db->insert_id();
        }
    }

    public function insert_doc_template($data) {
        if (DEMO) {
            $this->db->insert('vms_document_template', $data);
            return $this->db->insert_id();
        }
    }

    /**
     * Gets the document template list.
     *
     * @return     <type>  The document template list.
     */
    public function get_doc_template_list() {
        if (DEMO) {
            $this->db->select('vms_document_template.*, vms_superadmin_master.sa_name, vms_admin_master.first_name, vms_admin_master.last_name');
            $this->db->from('vms_document_template');
            $this->db->join('vms_superadmin_master', 'vms_superadmin_master.sa_id = vms_document_template.inserted_by_sadmin_id', 'left');
            $this->db->join('vms_admin_master', 'vms_admin_master.admin_id = vms_document_template.inserted_by_admin_id', 'left');
            $query = $this->db->get();
            $result = $query->result_array();

            if (count($result)) {
                foreach ($result as $_each_record) {

                    $_each_record['inserted_by_name'] = '';
                    if (!empty($_each_record['inserted_by_sadmin_id'])) {
                        $_each_record['inserted_by_name'] = $_each_record['sa_name'];
                    } else if (!empty($_each_record['inserted_by_admin_id'])) {
                        $_each_record['inserted_by_name'] = $_each_record['first_name'];

                        if (!empty($_each_record['last_name'])) {
                            $_each_record['inserted_by_name'] .= " " . $_each_record['last_name'];
                        }
                    }
                    $final_result[] = $_each_record;
                }
            }
            return $final_result;
        }
    }

    public function get_individual_doc_template_data($id) {
        if (DEMO) {
            $condition = "id = '" . $id . "'";
            $this->db->select('*');
            $this->db->from('vms_document_template');
            $this->db->where($condition);
            $query = $this->db->get();
            return $query->result_array();
        }
    }




    
    
    
    
    


    
    












    public function update_document_template($data, $id) {
        if (DEMO) {
            $this->db->where('id', $id);
            $this->db->update('vms_document_template', $data);
            return $this->db->affected_rows();
        }
    }

    public function insert_doc_in_specific_doc_template($data) {
        if (DEMO) {
            $this->db->insert('vms_documents_of_templates', $data);
            return $this->db->insert_id();
        }
    }

    public function get_doc_list_of_specific_doc_template($doc_template_id) {
        if (DEMO) {
            $this->db->select('*');
            $this->db->from('vms_documents_of_templates');
            $this->db->where('doc_template_id', $doc_template_id);
            $query = $this->db->get();
            return $query->result_array();
        }
    }

    // public function insert_historical_approved_work_order($data) {
    //     if (INDIA || US) {
    //         $this->db->insert('vms_historical_approved_work_order', $data);
    //         return $this->db->insert_id();
    //     }
    // }

    public function copy_work_order($employee_id, $file, $stage, $status) {
        if (DEMO) {
            if ($stage < 5 && $status == '0') {
                // if (!copy(FCPATH.DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.'historical_work_order'.DIRECTORY_SEPARATOR.$file, FCPATH.DIRECTORY_SEPARATOR.'library'.DIRECTORY_SEPARATOR.$file)) {
                //     echo "<div class='alert alert-success'>
                //         Work Order is copied successfully since it was not complete
                //     </div>"; 
                // }

                $directory_name = './library/';
                $file_name = $employee_id . "-" . time() . rand(00, 99) . ".pdf";

                $get_work_details = $this->getWorkDetails($employee_id);
                $data['agreement_date'] = date("M d, Y", strtotime($get_work_details[0]['agreement_date']));
                $data['cons_start_date'] = date("M d, Y", strtotime($get_work_details[0]['start_date']));
                $data['consultant_name'] = $get_work_details[0]['consultant'];
                $data['project_duration'] = $get_work_details[0]['project_duration'];
                $data['bill_rate'] = $get_work_details[0]['bill_rate'];
                $data['ot_rate'] = $get_work_details[0]['ot_rate'];
                $data['invoicing_terms'] = $get_work_details[0]['invoicing_terms'];
                $data['payment_terms'] = $get_work_details[0]['payment_terms'];

                $data['client_name'] = $get_work_details[0]['client_name'];
                $data['client_name_str'] = '';
                if (empty($get_work_details[0]['client_name'])) {
                    $data['work_note'] = " ";
                } else {
                    $get_work_note = $this->getWorkNote($get_work_details[0]['client_name']);
                    $data['work_note'] = $get_work_note[0]['work_order_note'];
                    $data['client_name_str'] = $get_work_note[0]['client_name'];
                }

                $data['vendor_poc_name'] = $get_work_details[0]['vendor_poc_name'];
                $data['vendor_poc_designation'] = $get_work_details[0]['vendor_poc_designation'];
                if (!empty($get_work_details[0]['vendor_signature'])) {
                    $data['vendor_signature'] = $get_work_details[0]['vendor_signature'];
                } else {
                    $data['vendor_signature'] = " ";
                }

                if (!empty($get_work_details[0]['vendor_signature_date'])) {
                    $data['vendor_signature_date'] = date("M d, Y", strtotime($get_work_details[0]['vendor_signature_date']));
                } else {
                    $data['vendor_signature_date'] = " ";
                }

                $data['asp_name'] = $get_work_details[0]['asp_name'];
                $data['asp_designation'] = $get_work_details[0]['asp_designation'];
                $data['asp_signature'] = $get_work_details[0]['asp_signature'];
                $data['asp_signature_date'] = date("M d, Y", strtotime($get_work_details[0]['asp_signature_date']));

                $data['vendor_ip'] = $get_work_details[0]['vendor_ip'];
                $data['vendor_id'] = $get_work_details[0]['vendor_id'];
                $get_vendor_details = $this->getVendorDtls($get_work_details[0]['vendor_id']);
                $data['vendor_company_name'] = $get_vendor_details[0]['vendor_company_name'];

                $this->load->library('html2pdf');
                $result = $this->load->view('superadmin/wo_pdf_template', $data, true);

                $this->html2pdf->html($result);
                $this->html2pdf->folder($directory_name);
                $this->html2pdf->filename($file_name);
                $this->html2pdf->paper('A4', 'portrait');

                $this->html2pdf->create('save');
            }
        }
        else {
            if ($stage > 0 && $stage < 5) {

                $directory_name = './library/';
                $file_name = $employee_id . "_work_order_.pdf";

                $get_work_details = $this->getWorkDetails($employee_id);
                $data['agreement_date'] = date("M d, Y", strtotime($get_work_details[0]['agreement_date']));
                $data['cons_start_date'] = date("M d, Y", strtotime($get_work_details[0]['start_date']));
                $data['consultant_name'] = $get_work_details[0]['consultant'];
                $data['project_duration'] = $get_work_details[0]['project_duration'];
                $data['bill_rate'] = $get_work_details[0]['bill_rate'];
                $data['ot_rate'] = $get_work_details[0]['ot_rate'];
                $data['invoicing_terms'] = $get_work_details[0]['invoicing_terms'];
                $data['payment_terms'] = $get_work_details[0]['payment_terms'];

                $data['client_name'] = $get_work_details[0]['client_name'];
                $data['client_name_str'] = '';
                if (empty($get_work_details[0]['client_name'])) {
                    $data['work_note'] = " ";
                } else {
                    $get_work_note = $this->getWorkNote($get_work_details[0]['client_name']);
                    $data['work_note'] = $get_work_note[0]['work_order_note'];
                    $data['client_name_str'] = $get_work_note[0]['client_name'];
                }

                $data['vendor_poc_name'] = $get_work_details[0]['vendor_poc_name'];
                $data['vendor_poc_designation'] = $get_work_details[0]['vendor_poc_designation'];
                if (!empty($get_work_details[0]['vendor_signature'])) {
                    $data['vendor_signature'] = $get_work_details[0]['vendor_signature'];
                } else {
                    $data['vendor_signature'] = " ";
                }

                if (!empty($get_work_details[0]['vendor_signature_date'])) {
                    $data['vendor_signature_date'] = date("M d, Y", strtotime($get_work_details[0]['vendor_signature_date']));
                } else {
                    $data['vendor_signature_date'] = " ";
                }

                $data['asp_name'] = $get_work_details[0]['asp_name'];
                $data['asp_designation'] = $get_work_details[0]['asp_designation'];
                $data['asp_signature'] = $get_work_details[0]['asp_signature'];
                $data['asp_signature_date'] = date("M d, Y", strtotime($get_work_details[0]['asp_signature_date']));

                $data['vendor_ip'] = $get_work_details[0]['vendor_ip'];
                $data['vendor_id'] = $get_work_details[0]['vendor_id'];
                $get_vendor_details = $this->getVendorDtls($get_work_details[0]['vendor_id']);
                $data['vendor_company_name'] = $get_vendor_details[0]['vendor_company_name'];

                $this->load->library('html2pdf');
                $result = $this->load->view('superadmin/wo_pdf_template', $data, true);

                $this->html2pdf->html($result);
                $this->html2pdf->folder($directory_name);
                $this->html2pdf->filename($file_name);
                $this->html2pdf->paper('A4', 'portrait');

                $this->html2pdf->create('save');
            }
        }
    }
}
