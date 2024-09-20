<?php

Class Manage_Employee_Model extends CI_Model
{
    public function insert_purchase_order($data) {
        $this->db->insert('purchase_order',$data);
        $insert_id = $this->db->insert_id();
        return  $insert_id;
    }

    public function change_employee_datewise_shift_summary_status_disapprove($clock_time_id, $admin_id) {
        if (US || INDIA) {
            $data = [
                'is_approved_by_admin' => 0,
                'admin_approver' => $admin_id,
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
        if (US || INDIA) {    
            $data = [
                'is_approved_by_admin' => 1,
                'admin_approver' => $admin_id,
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
            ' minutes '-- ,
            -- SECOND(
            -- SEC_TO_TIME(time_to_sec(timediff(clock_out, clock_in)))
           -- ),
            -- ' seconds'
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
                ct.is_approved_by_admin
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
                ' minutes '-- ,
                -- SECOND(
                -- SEC_TO_TIME(
                --    SUM(
                --    CASE
                --        WHEN break_type = 'personal' AND break_end_time != '0000-00-00 00:00:00' then time_to_sec(timediff(break_end_time, break_start_time))
                --        ELSE 0
                --    END
                --    )
                -- )
                -- ),
                -- ' seconds'
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
                ' minutes '-- ,
                -- SECOND(
                -- SEC_TO_TIME(
                --    SUM(
                --    CASE
                --        WHEN break_type = 'training' AND break_end_time != '0000-00-00 00:00:00' then time_to_sec(timediff(break_end_time, break_start_time))
                --        ELSE 0
                --    END
                --    )
                -- )
                -- ),
                -- ' seconds'
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
                ' minutes '-- ,
                -- SECOND(
                -- SEC_TO_TIME(
                --    SUM(
                --    CASE
                --        WHEN break_type = 'meeting' AND break_end_time != '0000-00-00 00:00:00' then time_to_sec(timediff(break_end_time, break_start_time))
                --        ELSE 0
                --    END
                --    )
                -- )
                -- ),
                -- ' seconds'
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
                ' minutes '-- ,
                -- SECOND(
                -- SEC_TO_TIME(
                --    SUM(
                --    CASE
                --        WHEN break_type = 'lunch' AND break_end_time != '0000-00-00 00:00:00' then time_to_sec(timediff(break_end_time, break_start_time))
                --       ELSE 0
                --    END
                --    )
                -- )
                -- ),
                -- ' seconds'
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
                ' minutes '-- ,
                -- SECOND(
                -- SEC_TO_TIME(
                --   SUM(
                --    CASE
                --        WHEN break_end_time != '0000-00-00 00:00:00' then time_to_sec(timediff(break_end_time, break_start_time))
                --        ELSE 0
                --    END
                --    )
                -- )
                -- ),
                -- ' seconds'
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
            ' minutes '-- ,
            -- SECOND(
            -- SEC_TO_TIME(time_to_sec(timediff(clock_out, clock_in)))
            -- ),
            -- ' seconds'
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
                ct.is_approved_by_admin
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
                ' minutes '-- ,
                -- SECOND(
                -- SEC_TO_TIME(
                    -- SUM(
                    -- CASE
                        -- WHEN break_type = 'personal' AND break_end_time != '0000-00-00 00:00:00' then time_to_sec(timediff(break_end_time, break_start_time))
                        -- ELSE 0
                    -- END
                    -- )
                -- )
                -- ),
                -- ' seconds'
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
                ' minutes '-- ,
                -- SECOND(
                -- SEC_TO_TIME(
                    -- SUM(
                    -- CASE
                        -- WHEN break_type = 'training' AND break_end_time != '0000-00-00 00:00:00' then time_to_sec(timediff(break_end_time, break_start_time))
                        -- ELSE 0
                    -- END
                    -- )
                -- )
                -- ),
                -- ' seconds'
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
                ' minutes '-- ,
                -- SECOND(
                -- SEC_TO_TIME(
                    -- SUM(
                    -- CASE
                        -- WHEN break_type = 'meeting' AND break_end_time != '0000-00-00 00:00:00' then time_to_sec(timediff(break_end_time, break_start_time))
                        -- ELSE 0
                    -- END
                    -- )
                -- )
                -- ),
                -- ' seconds'
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
                ' minutes '-- ,
                -- SECOND(
                -- SEC_TO_TIME(
                    -- SUM(
                    -- CASE
                        -- WHEN break_type = 'lunch' AND break_end_time != '0000-00-00 00:00:00' then time_to_sec(timediff(break_end_time, break_start_time))
                        -- ELSE 0
                    -- END
                    -- )
                -- )
                -- ),
                -- ' seconds'
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
                ' minutes '-- ,
                -- SECOND(
                -- SEC_TO_TIME(
                    -- SUM(
                    -- CASE
                        -- WHEN break_end_time != '0000-00-00 00:00:00' then time_to_sec(timediff(break_end_time, break_start_time))
                       -- ELSE 0
                    -- END
                    -- )
                -- )
                -- ),
                -- ' seconds'
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
        if (US) {
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
            Personal,
            Meeting,
            Training,
            Total,
            ct.is_approved_by_admin
            FROM
            vms_employee_master e
            INNER JOIN vms_employee_clock_time ct ON e.employee_id = ct.employee_id
            LEFT JOIN (
            SELECT
            clock_time_id,
            CONCAT(
                HOUR(
                sec_to_time(
                    SUM(
                    CASE
                        WHEN break_type = 'personal' then time_to_sec(timediff(break_end_time, break_start_time))
                        ELSE 0
                    END
                    )
                )
                ),
                ' hours ',
                MINUTE(
                sec_to_time(
                    SUM(
                    CASE
                        WHEN break_type = 'personal' then time_to_sec(timediff(break_end_time, break_start_time))
                        ELSE 0
                    END
                    )
                )
                ),
                ' minutes ',
                SECOND(
                sec_to_time(
                    SUM(
                    CASE
                        WHEN break_type = 'personal' then time_to_sec(timediff(break_end_time, break_start_time))
                        ELSE 0
                    END
                    )
                )
                ),
                ' seconds'
            ) as 'Personal',
            CONCAT(
                HOUR(
                sec_to_time(
                    SUM(
                    CASE
                        WHEN break_type = 'training' then time_to_sec(timediff(break_end_time, break_start_time))
                        ELSE 0
                    END
                    )
                )
                ),
                ' hours ',
                MINUTE(
                sec_to_time(
                    SUM(
                    CASE
                        WHEN break_type = 'training' then time_to_sec(timediff(break_end_time, break_start_time))
                        ELSE 0
                    END
                    )
                )
                ),
                ' minutes ',
                SECOND(
                sec_to_time(
                    SUM(
                    CASE
                        WHEN break_type = 'training' then time_to_sec(timediff(break_end_time, break_start_time))
                        ELSE 0
                    END
                    )
                )
                ),
                ' seconds'
            ) as 'Training',
            CONCAT(
                HOUR(
                sec_to_time(
                    SUM(
                    CASE
                        WHEN break_type = 'meeting' then time_to_sec(timediff(break_end_time, break_start_time))
                        ELSE 0
                    END
                    )
                )
                ),
                ' hours ',
                MINUTE(
                sec_to_time(
                    SUM(
                    CASE
                        WHEN break_type = 'meeting' then time_to_sec(timediff(break_end_time, break_start_time))
                        ELSE 0
                    END
                    )
                )
                ),
                ' minutes ',
                SECOND(
                sec_to_time(
                    SUM(
                    CASE
                        WHEN break_type = 'meeting' then time_to_sec(timediff(break_end_time, break_start_time))
                        ELSE 0
                    END
                    )
                )
                ),
                ' seconds'
            ) as 'Meeting',
            CONCAT(
                HOUR(
                sec_to_time(
                    SUM(
                    time_to_sec(timediff(break_end_time, break_start_time))
                    )
                )
                ),
                ' hours ',
                MINUTE(
                sec_to_time(
                    SUM(
                    time_to_sec(timediff(break_end_time, break_start_time))
                    )
                )
                ),
                ' minutes ',
                SECOND(
                sec_to_time(
                    SUM(
                    time_to_sec(timediff(break_end_time, break_start_time))
                    )
                )
                ),
                ' seconds'
            ) as 'Total'
            FROM
            vms_employee_break_time bt
            GROUP BY
            clock_time_id
            ) bt_test ON (ct.id = bt_test.clock_time_id) WHERE e.employee_id=".$employee_id." AND ct.clock_in >='".$from."' AND ct.clock_in <= '".$to."'";

            $query = $this->db->query($query_str);
            // print_r($this->db->last_query());
            $data = $query->result();
            return $data;

        }
    }

    public function activate_group($group_id) {
        $this->db->trans_start();

        $data = [
            'is_active' => 1,
        ];

        $this->db->where('group_id', $group_id);
        $this->db->update(DBASE.'.group', $data);

        $query_str = "SELECT employee_id FROM ".DBASE.".vms_employee_master WHERE group_id=$group_id";

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
        $this->db->update(DBASE.'.vms_employee_login_details', $data1);

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

    public function deactivate_group($group_id) {
        $this->db->trans_start();

        $data = [
            'is_active' => 0,
        ];

        $this->db->where('group_id', $group_id);
        $this->db->update(DBASE.'.group', $data);

        $query_str = "SELECT employee_id FROM ".DBASE.".vms_employee_master WHERE group_id=$group_id";

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
        $this->db->update(DBASE.'.vms_employee_login_details', $data1);

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














    public function get_all_shift_names() {
        if (US || INDIA) {
            $query_str = "SELECT employee_shift_type FROM ".DBASE.".vms_employee_shift_master";
            $query = $this->db->query($query_str);
            $data = $query->result_array();
            return $data;
        }
    }

    public function check_if_employee_clocked_in($employee_id) {
        if (US || INDIA) {
            $query_str = "SELECT vem.employee_id, vem.first_name, vem.last_name FROM ".DBASE.".vms_employee_master AS vem WHERE vem.shift_id IN (SELECT id FROM ".DBASE.".vms_employee_shift_master WHERE daily_shift_start_time < CURTIME() AND daily_shift_end_time > CURTIME())";
            $query_str = "SELECT vem.employee_id, vem.first_name, vem.last_name, vect.clock_in FROM ".DBASE.".vms_employee_master AS vem LEFT JOIN ".DBASE.".vms_employee_clock_time AS vect ON vem.employee_id = vect.employee_id AND DATE(vect.created_time) = current_date() WHERE vem.shift_id IN (SELECT id FROM ".DBASE.".vms_employee_shift_master WHERE daily_shift_start_time < CURTIME() AND daily_shift_end_time > CURTIME())";

            $query = $this->db->query($query_str);
            $data = $query->result();
            return $data;
        }
    }

    public function get_current_employees_shift_total_paid_breaks($from, $to, $employee_id) {
        if (US || INDIA) {  
            $query_str = "SELECT COUNT(*) AS total_paid_break FROM ".DBASE.".vms_employee_break_time WHERE break_start_time >= '".$from."' AND break_start_time <= '".$to."' AND employee_id = ".$employee_id." AND is_paid=1";

            $query = $this->db->query($query_str);
            $data = $query->result();
            return $data;
        }
    }

    public function get_current_employees_shift_total_unpaid_breaks($from, $to, $employee_id) {
        if (US || INDIA) {    
            $query_str = "SELECT COUNT(*) AS total_unpaid_break FROM ".DBASE.".vms_employee_break_time WHERE break_start_time >= '".$from."' AND break_start_time <= '".$to."' AND employee_id = ".$employee_id." AND is_paid=0";

            $query = $this->db->query($query_str);
            $data = $query->result();
            return $data;
        }
    }

    public function get_current_employees_shift_total_hours($from, $to, $employee_id) {
        if (US || INDIA) {    
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
            ) AS total_hours FROM ".DBASE.".vms_employee_clock_time WHERE clock_in >= '".$from."' AND clock_in <= '".$to."' AND employee_id = ".$employee_id;

            $query = $this->db->query($query_str);
            $data = $query->result();
            return $data;
        }
    }

    public function get_all_employees_list($admin_id) {
        if (US) {
            $query_str_timezone = "SET time_zone = '-6:00'";
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
            LEFT JOIN vms_employee_shift_master sm ON e.shift_id = sm.id
            LEFT JOIN vms_employee_clock_time ct ON e.employee_id = ct.employee_id
            LEFT JOIN vms_employee_break_time bt ON e.employee_id = bt.employee_id
            WHERE
            (
                (sm.daily_shift_start_time < CURTIME()
            AND sm.daily_shift_end_time > CURTIME()
            AND e.shift_admin_manager_id = ".$admin_id.")
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
        if (INDIA) {
            $query_str_timezone = "SET SESSION time_zone = '+5:30';";
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
            AND (MAX(bt.break_end_time) < MAX(bt.break_start_time)) AND ((
                MAX(ct.clock_in) IS NOT NULL
                AND sm.daily_shift_end_time < CURTIME()
            )
            or (
                    MAX(ct.clock_in) IS NOT NULL
                    AND sm.daily_shift_start_time > CURTIME()
            )) THEN 'Over-time-break'
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
            LEFT JOIN vms_employee_shift_master sm ON e.shift_id = sm.id
            LEFT JOIN vms_employee_clock_time ct ON e.employee_id = ct.employee_id
            LEFT JOIN vms_employee_break_time bt ON e.employee_id = bt.employee_id
            WHERE
            (
                (-- sm.daily_shift_start_time < CURTIME()  
            -- AND sm.daily_shift_end_time > CURTIME()
            -- AND
                e.shift_admin_manager_id = ".$admin_id.")
            -- OR (ct.clock_in IS NOT NULL AND ct.clock_out IS NULL)
            
            )
            GROUP BY
            e.employee_id
            ORDER BY
            clock_in_time DESC;";

            $query = $this->db->query($query_str);
            // print_r($this->db->last_query());
            // exit;
            $data = $query->result();
            return $data;
        }
    }

    public function get_employees_list_all() {
        if (INDIA) {
            $query_str_timezone = "SET SESSION time_zone = '+5:30';";
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
            AND (MAX(bt.break_end_time) < MAX(bt.break_start_time)) AND ((
                MAX(ct.clock_in) IS NOT NULL
                AND sm.daily_shift_end_time < CURTIME()
            )
            or (
                    MAX(ct.clock_in) IS NOT NULL
                    AND sm.daily_shift_start_time > CURTIME()
            )) THEN 'Over-time-break'
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
            // print_r($this->db->last_query());
            // exit;
            $data = $query->result();
            return $data;
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

    public function get_purchase_order_list() {
        $query_str = "SELECT po.PONumber, po.Store, po.Date, vvm.vendor_company_name AS vendor_name, po.poFilePath, po.sdFilePath FROM purchase_order po LEFT JOIN vms_vendor_master vvm ON po.VendorID = vvm.vendor_id WHERE vvm.status = '1' and vvm.block_status ='1' and vvm.is_delete = '0' ORDER BY vendor_id DESC;";

        $query = $this->db->query($query_str);
        $data = $query->result();
        return $data;
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
            ".DBASE.".group WHERE shift_id=".$shift_id;

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
            ".DBASE.".group WHERE shift_id=".$shift_id;

            $query = $this->db->query($query_str);
            // print_r($this->db->last_query());
            $data = $query->result();
            return $data;
        }
    }

    public function update_all_employee_shift_id($employee_ids, $shift_id) {
        if (INDIA) {
            $data = array('shift_id' => $shift_id);
            $this->db->where_in('employee_id', $employee_ids);
            $this->db->update('vms_employee_master', $data);
        }
    }

    public function insert_new_group($data) {
        if (INDIA) {
            $this->db->insert('group', $data);
            $insert_id = $this->db->insert_id();
            return  $insert_id;
        }
    }

    public function update_group_name($update_arr, $group_id) {
        if (INDIA) {
            $this->db->where('group_id', $group_id);
            $this->db->update('group', $update_arr);
        }
    }
    
    public function get_employee_group_list() {
        if (INDIA) {
            $query_str = "SELECT COUNT(e.group_id) as employee, g.group_id, g.group_name, g.group_description FROM ".DBASE.".group g LEFT JOIN ".DBASE.".vms_employee_master e ON g.group_id = e.group_id GROUP BY g.group_id";

            $query = $this->db->query($query_str);
            $data = $query->result();
            return $data;
        }
    }

    public function get_current_group_employees($group_id) {
        if (INDIA) {
            $query_str = "SELECT vem.first_name,vem.last_name,vem.employee_email,veld.status FROM ".DBASE.".vms_employee_master vem INNER JOIN ".DBASE.".vms_employee_login_details veld ON vem.employee_id = veld.employee_id WHERE group_id=$group_id";

            $query = $this->db->query($query_str);
            $data = $query->result();
            return $data;
        }
    }

    public function get_current_group_name($group_id) {
        if (INDIA) {
            $query_str = "SELECT group_name FROM ".DBASE.".group WHERE group_id=$group_id";

            $query = $this->db->query($query_str);
            $data = $query->result();
            return $data;
        }
    }

    public function get_members($group_id) {
        if (INDIA) {
            $query_str = "SELECT first_name,last_name,employee_email,employee_id FROM ".DBASE.".vms_employee_master WHERE group_id = $group_id";

            $query = $this->db->query($query_str);
            $data = $query->result();
            return $data;
        }
    }

    public function get_not_members($group_id) {
        if (INDIA) {
            $query_str = "SELECT first_name,last_name,employee_email,employee_id FROM ".DBASE.".vms_employee_master WHERE group_id = 0 OR group_id IS NULL";
            
            // group_id <> $group_id

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
            return ($this->db->affected_rows() > 0);
        }
    }

    public function remove_members_from_group($remove_ids) {
        if (INDIA) {
            $data = array('group_id' => null);
            $this->db->where_in('employee_id', $remove_ids);
            $this->db->update('vms_employee_master', $data);
            return ($this->db->affected_rows() > 0);
        }
    }

    public function update_all_employee_group_id($employee_ids, $group_id) {
        $data = array('group_id' => $group_id);
        $this->db->where_in('employee_id', $employee_ids);
        $this->db->update('vms_employee_master', $data);
    }

    public function get_all_employees($shift_id) {
        if (INDIA) {
            $query_str = "SELECT first_name,last_name,employee_email,employee_id FROM ".DBASE.".vms_employee_master WHERE shift_id IS NULL OR shift_id <> ".$shift_id;

            $query = $this->db->query($query_str);
            $data = $query->result();
            return $data;
        }
    }

    public function get_all_groups($shift_id) {
        if (INDIA) {
            $query_str = "SELECT group_id,group_name,group_description FROM ".DBASE.".group WHERE shift_id IS NULL OR shift_id <> ".$shift_id;

            $query = $this->db->query($query_str);
            $data = $query->result();
            return $data;
        }
    }

    public function get_shift_id_of_current_employee($employee_id) {
        if (INDIA) {
            $query_str = "SELECT shift_id FROM ".DBASE.".vms_employee_master WHERE employee_id = ".$employee_id;

            $query = $this->db->query($query_str);
            $data = $query->result();
            return $data;
        }
    }

    public function get_shift_id_of_current_group($group_id) {
        if (INDIA) {
            $query_str = "SELECT shift_id FROM ".DBASE.".group WHERE group_id = ".$group_id;

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

    public function assign_shift_to_group($group_id, $shift_id) {
        if (INDIA) {
            $data = array('shift_id' => $shift_id);
            $this->db->where('group_id', $group_id);
            $this->db->update('group', $data);
        }
    }

    public function assign_same_shift_to_group_employees($group_id, $shift_id) {
        if (INDIA) {
            $data = array('shift_id' => $shift_id);
            $this->db->where('group_id', $group_id);
            $this->db->update('vms_employee_master', $data);
        }
    }

    public function get_master_shift_list() {
        
        if (US || INDIA) {
            $query_str = "SELECT
            id,
            employee_shift_type,
            daily_shift_start_time,
            daily_shift_end_time,
            days
            FROM
            vms_employee_shift_master;";

            $query = $this->db->query($query_str);
            $data = $query->result();
            return $data;
        }
    }

    public function delete_master_shift($shift_id) {
        
        if (US || INDIA) {
            $this->db->where('id', $shift_id);
            $this->db->delete(DBASE.'.vms_employee_shift_master');

            if ($this->db->affected_rows() > 0) {
                return 1;
            } else {
                return 0;
            }
        }
    }

    public function get_master_shift_data($shift_id) {
        if (US || INDIA) {
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

    public function update_employee_master_shift_data($data, $shift_id) {
        if (US || INDIA) {
            $this->db->where('id', $shift_id);
            $this->db->update('vms_employee_shift_master', $data);
            return true;
        }
    }

    // public function get_all_employees_break_status() {

    //     $query_str = "SELECT DISTINCT vem.employee_id FROM ".DBASE.".vms_employee_master AS vem INNER JOIN ".DBASE.".vms_employee_clock_time AS vect ON vem.employee_id = vect.employee_id AND DATE(vect.created_time) = current_date() INNER JOIN ".DBASE.".vms_employee_break_time AS vebt ON vect.id=vebt.clock_time_id AND vebt.break_start_time IS NOT NULL AND vebt.break_end_time IS NULL WHERE vem.shift_id IN (SELECT id FROM ".DBASE.".vms_employee_shift_master WHERE daily_shift_start_time < CURTIME() AND daily_shift_end_time > CURTIME())";

    //     $query = $this->db->query($query_str);
    //     $data = $query->result();
    //     return $data;
    // }

    public function get_employee_shift_id($employee_id) {
        if (US || INDIA) {
            $this->db->select('shift_id');
            $this->db->from('vms_employee_master');
            $this->db->where('employee_id', $employee_id);
            $query = $this->db->get();
            $data = $query->result_array();
            return $data;
        }
    }

    public function insert_clock_data_admin($data) {
        if (US || INDIA) {
            $this->db->insert('vms_employee_clock_time', $data);
            $insert_id = $this->db->insert_id();
            return  $insert_id;
        }
    }




    public function get_clock_id_for_break($break_start_date, $break_start_time) {
        if (US || INDIA) {
            $break_start_datetime = date('Y-m-d H:i:s', strtotime("$break_start_date $break_start_time"));

            $break_start_date = date('Y-m-d', strtotime($break_start_date));

            $query_str = "SELECT vec.id as clock_time_id FROM ".DBASE.".vms_employee_clock_time vec WHERE vec.clock_out >= '$break_start_datetime' AND vec.clock_in <= '$break_start_datetime' AND DATE(clock_in) = '$break_start_date' LIMIT 1";
            // print_r($query_str);
            $query = $this->db->query($query_str);
            $data = $query->result();
            return $data;
        }
    }






    public function insert_shift_break_form_data($employee_id, $clock_time_id, $break_type, $start_date, $start_time, $end_date, $end_time, $is_paid, $comment, $created_by, $created_time) {

        if (US || INDIA) {
            $start_time = date('Y-m-d H:i:s', strtotime("$start_date $start_time"));
            $end_time = date('Y-m-d H:i:s', strtotime("$end_date $end_time"));

            if($is_paid == 'yes') {
                $is_paid=1;
            }
            else {
                $is_paid=0;
            }

            $query_str = "INSERT INTO `".DBASE."`.`vms_employee_break_time` (`employee_id`,`clock_time_id`,`break_type`,`break_start_time`,`break_end_time`,`is_paid`, `comment`, `created_by`,`created_time`) VALUES ($employee_id, $clock_time_id, '$break_type','$start_time','$end_time',$is_paid,'$comment', $created_by, '$created_time')";

            $this->db->query($query_str);
        }
    }

    public function update_clock_admin_data($clock_in_date, $clock_in_time, $clock_out_date, $clock_out_time, $comment, $clock_id) {
        if (US || INDIA) {
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

            $query_str = "UPDATE `".DBASE."`.`vms_employee_clock_time` SET `clock_in` = '$clock_in_date',`clock_out` = '$clock_out_date', `comment` = '$comment', `modified_by` = ".$this->session->userdata('clock_break_data_admin_id').", `modified_time` = '".date('Y-m-d H:i:s')."' WHERE `id` = $clock_id";

            $this->db->query($query_str);
        }
    }

    public function update_training_break_admin($training_break_start_date, $training_break_start_time, $training_break_end_date, $training_break_end_time, $comment,$training_break_id) {

        if (US || INDIA) {
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

            $query_str = "UPDATE `".DBASE."`.`vms_employee_break_time` SET `break_start_time` = '$training_break_start_date',`break_end_time` = '$training_break_end_date', `comment` = '$comment', `modified_by` = ".$this->session->userdata('clock_break_data_admin_id').", `modified_time` = '".date('Y-m-d H:i:s')."' WHERE `id` = $training_break_id";

            $this->db->query($query_str);
        }
    }

    public function update_personal_break_admin($personal_break_start_date, $personal_break_start_time, $personal_break_end_date, $personal_break_end_time, $comment, $personal_break_id) {

        if (US || INDIA) {
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

            $query_str = "UPDATE `".DBASE."`.`vms_employee_break_time` SET `break_start_time` = '$personal_break_start_date',`break_end_time` = '$personal_break_end_date',`comment` = '$comment',`modified_by` = ".$this->session->userdata('clock_break_data_admin_id').", `modified_time` = '".date('Y-m-d H:i:s')."' WHERE `id` = $personal_break_id";

            $this->db->query($query_str);
        }
    }

    public function update_meeting_break_admin($meeting_break_start_date, $meeting_break_start_time,$meeting_break_end_date, $meeting_break_end_time, $comment, $meeting_break_id) {
        
        if (US || INDIA) {
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

            $query_str = "UPDATE `".DBASE."`.`vms_employee_break_time` SET `break_start_time` = '$meeting_break_start_date',`break_end_time` = '$meeting_break_end_date',`comment` = '$comment', `modified_by` = ".$this->session->userdata('clock_break_data_admin_id').", `modified_time` = '".date('Y-m-d H:i:s')."' WHERE `id` = $meeting_break_id";

            $this->db->query($query_str);
        }
    }



    public function update_lunch_break_admin($lunch_break_start_date, $lunch_break_start_time,$lunch_break_end_date, $lunch_break_end_time, $comment, $lunch_break_id) {
        
        if (US || INDIA) {
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

            $query_str = "UPDATE `".DBASE."`.`vms_employee_break_time` SET `break_start_time` = '$lunch_break_start_date',`break_end_time` = '$lunch_break_end_date',`comment` = '$comment', `modified_by` = ".$this->session->userdata('clock_break_data_admin_id').", `modified_time` = '".date('Y-m-d H:i:s')."' WHERE `id` = $lunch_break_id";

            $this->db->query($query_str);
        }
    }




    public function get_employee_clock_data_main($employee_id, $date) {
        if (US || INDIA) {    
            $date = date('Y-m-d H:i:s', strtotime($date));

            $query_str = "SELECT *,vec.id as clock_id FROM ".DBASE.".vms_employee_clock_time vec WHERE vec.employee_id=$employee_id AND DATE(vec.clock_in)='$date'";

            $query = $this->db->query($query_str);
            $data = $query->result();
            return $data;
        }
    }

    public function get_employee_clock_data($employee_id, $date) {
        if (US || INDIA) {
            $date = date('Y-m-d H:i:s', strtotime($date));

            $query_str = "SELECT *,veb.id as break_id,vec.id as clock_id FROM ".DBASE.".vms_employee_clock_time vec LEFT JOIN ".DBASE.".vms_employee_break_time veb ON vec.id = veb.clock_time_id WHERE vec.employee_id=$employee_id AND DATE(vec.clock_in)='$date'";

            $query = $this->db->query($query_str);
            $data = $query->result();
            return $data;
        }
    }

    public function get_all_employees_shift($admin_id) {
        if (US || INDIA) {
            $this->db->select('employee_id, first_name, last_name');
            $this->db->from('vms_employee_master');
            $this->db->where('shift_admin_manager_id', $admin_id);
            $query = $this->db->get();
            $data = $query->result_array();
            return $data;
        }
    }

    public function get_employees_shift_all() {
        if (INDIA) {
            $this->db->select('employee_id, first_name, last_name');
            $this->db->from('vms_employee_master');
            $query = $this->db->get();
            $data = $query->result_array();
            return $data;
        }
    }

    public function add_employee_master_shift_data($data) {
        if (US || INDIA) {
            $this->db->insert('vms_employee_shift_master', $data);
            $last_id = $this->db->insert_id();
            return $last_id;
        }
    }

    public function get_shift_manager() {
        if (US || INDIA) {
            $query_str = "SELECT admin_id, first_name, last_name  FROM ".DBASE.".vms_admin_master";
            $query = $this->db->query($query_str);
            $data = $query->result();
            return $data;
        }
    }

    public function getShiftDropDownData() {
        if (US || INDIA) {
            $query_str = "SELECT id,employee_shift_type FROM ".DBASE.".vms_employee_shift_master";
            $query = $this->db->query($query_str);
            $data = $query->result();
            return $data;
        }
    }

    public function add_employee_user($data) {
            $this->db->insert('vms_employee_master', $data);
            $last_id = $this->db->insert_id();
            return $last_id;
    }

    public function get_multiple_employee_details($data) {
        $this->db->select('*');
        $this->db->from('vms_employee_master');
        $this->db->where_in('employee_id', $data);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function update_employee_bg_status($employee_id) {
        $data = array('bg_check_status' => 1);
        $this->db->where_in('employee_id', $employee_id);
        $this->db->update('vms_employee_master', $data);
    }

    public function update_employee_bg_order_id($bg_order_id, $emp_id) {
        $data = array('bg_order_id' => $bg_order_id);
        $this->db->where('employee_id', $emp_id);
        $this->db->update('vms_employee_master', $data);
    }

    public function get_order_id_by_phone_and_email($phone, $email) {
        $this->db->select('bg_order_id');
        $this->db->from('vms_employee_master');
        $multipleWhere = array('phone_no' => $phone, 'employee_email' => $email);
        $this->db->where($multipleWhere);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function update_order_status($phone, $email) {
        $data = array('bg_check_status' => 2);
        $multipleWhere = array('phone_no' => $phone, 'employee_email' => $email);
        $this->db->where($multipleWhere);
        $this->db->update('vms_employee_master', $data);
    }

    public function update_order_status_needs_attention($phone, $email) {
        $data = array('bg_check_status' => 3);
        $multipleWhere = array('phone_no' => $phone, 'employee_email' => $email);
        $this->db->where($multipleWhere);
        $this->db->update('vms_employee_master', $data);
    }

    public function update_order_status_canceled($phone, $email) {
        $data = array('bg_check_status' => 4);
        $multipleWhere = array('phone_no' => $phone, 'employee_email' => $email);
        $this->db->where($multipleWhere);
        $this->db->update('vms_employee_master', $data);
    }

    public function update_order_status_archived($phone, $email) {
        $data = array('bg_check_status' => 5);
        $multipleWhere = array('phone_no' => $phone, 'employee_email' => $email);
        $this->db->where($multipleWhere);
        $this->db->update('vms_employee_master', $data);
    }

    public function update_order_report($phone, $file, $email) {
        $data = array('bg_report_file' => $file);
        $multipleWhere = array('phone_no' => $phone, 'employee_email' => $email);
        $this->db->where($multipleWhere);
        $this->db->update('vms_employee_master', $data);
    }

    public function add_payment_mail($data)
    {
        $this->db->insert('vms_payment_mail_master', $data);
        $last_id = $this->db->insert_id();
        return $last_id;
    }

    public function update_employee_user($data, $id)
    {
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

    public function update_employee_login_user($data, $id) {
        if (LATAM) {
            $this->db->where('employee_id', $id);
            $this->db->update('vms_employee_login_details', $data);
            return $this->db->affected_rows();
        }
    }

    public function approveInvoice($data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('vms_payment_master', $data);
        //        echo $this->db->last_query();
        //        die;

        if ($this->db->affected_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    public function change_block_status($data, $id)
    {
        $this->db->where('employee_id', $id);
        if (US || INDIA) {
            $this->db->update('vms_employee_master', $data);
        }
        if (LATAM) {
            $this->db->update('vms_employee_login_details', $data);
        }
        //        echo $this->db->last_query();
        //        die;

        if ($this->db->affected_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    public function change_status($data, $id)
    {
        $this->db->where('employee_id', $id);
        if (US || INDIA) {
            $this->db->update('vms_employee_master', $data);
        }
        if (LATAM) {
            $this->db->update('vms_employee_login_details', $data);
        }
        //        echo $this->db->last_query();
        //        die;

        if ($this->db->affected_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    public function check_docs_status($employee_id, $doc_id)
    {

        $condition = "form_no = '" . $doc_id . "' and consultant_id = '" . $employee_id . "'";
        $this->db->select('*');
        $this->db->from('vms_consultant_files');
        $this->db->where($condition);
        $query = $this->db->get();
        //        echo $this->db->last_query();
        $data = $query->result_array();
        return $data;
    }

    public function getDetails($email)
    {

        $condition = "employee_email = '" . $email . "'";
        $this->db->select('*');
        $this->db->from('vms_employee_master');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getClientDetails()
    {

        $condition = "status = '1'";
        $this->db->select('*');
        $this->db->from('vms_client_master');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getWorkNote($client_name)
    {

        $condition = "id = '" . $client_name . "'";
        $this->db->select('*');
        $this->db->from('vms_client_master');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getAssignProjectDtls($employee_id, $vendor_id)
    {

        $condition = "employee_id = '" . $employee_id . "' and vendor_id = '" . $vendor_id . "'";
        $this->db->select('*');
        $this->db->from('vms_assign_projects_to_employee');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getAdminDetails($id)
    {

        $condition = "admin_id = '" . $id . "'";
        $this->db->select('*');
        $this->db->from('vms_admin_master');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getSuperAdminData($id)
    {

        $condition = "sa_id = '" . $id . "' and lower(sa_name) not like 'aurica%'";
        $this->db->select('*');
        $this->db->from('vms_superadmin_master');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function checkDuplicate($email)
    {
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

    public function checkWorkOrderStatus($employee_id)
    {

        $condition = "employee_id = '" . $employee_id . "'";
        $this->db->select('*');
        $this->db->from('vms_employee_work_order');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getWorkOrder($employee_id)
    {

        $condition = "employee_id = '" . $employee_id . "'";
        $this->db->select('*');
        $this->db->from('vms_employee_work_order');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getLoginDetails($employee_id)
    {

        $condition = "employee_id = '" . $employee_id . "'";
        $this->db->select('*');
        $this->db->from('vms_employee_login_details');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getGenerateStatus($employee_id)
    {

        $condition = "employee_id = '" . $employee_id . "'";
        $this->db->select('count(*) as cnt');
        $this->db->from('vms_employee_login_details');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getEmployeeLists($admin_id)
    {

        $condition = "admin_id = '" . $admin_id . "'";
        $this->db->select('*');
        $this->db->from('vms_employee_master');
        $this->db->where($condition);
        $this->db->order_by("employee_id", "desc");
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getAllEmployeeLists()
    {

        $condition = "is_delete = '0' and employee_type != '1099'";
        $this->db->select('*');
        $this->db->from('vms_employee_master');
        $this->db->where($condition);
        $this->db->order_by("employee_id", "desc");
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getEmployeeListsByVendor($vendor_ids, $admin_id)
    {

        if ($vendor_ids != '') {
            $vendor_ids_str = $vendor_ids;
        } else {
            $vendor_ids_str = '0';
        }

        $condition = "admin_id = '" . $admin_id . "' and vendor_id in(" . $vendor_ids_str . ") and  is_delete = '0'";
        $this->db->select('*');
        $this->db->from('vms_employee_master');
        $this->db->where($condition);
        $this->db->order_by("employee_id", "desc");
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getEmployeeData($id)
    {

        $condition = "employee_id = '" . $id . "'";
        $this->db->select('*');
        $this->db->from('vms_employee_master');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }
    public function getEmployeeFirst($id)
    {

        $condition = "employee_id = '" . $id . "'";
        $this->db->select('first_name');
        $this->db->from('vms_employee_master');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }
    public function getMigrateData($id)
    {

        $condition = "file = '" . $id . "'";
        $this->db->select('consultant_id,form_no');
        $this->db->from('vms_consultant_files');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }
    public function updateMigrateFile($update, $emp_id, $doc_id)
    {
        $condition = "form_no = '" . $doc_id . "' and consultant_id = '" . $emp_id . "'";
        $this->db->where($condition);
        $this->db->update('vms_consultant_files', $update);
        if ($this->db->affected_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    public function getVendorName($id)
    {

        $condition = "vendor_id = '" . $id . "'";
        $this->db->select('*');
        $this->db->from('vms_vendor_master');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getVendorID($id)
    {

        $condition = "employee_id = '" . $id . "'";
        $this->db->select('vendor_id');
        $this->db->from('vms_employee_master');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->row();
        return $data;
    }

    public function getVendorDetails($id)
    {

        $condition = "vendor_id = '" . $id . "'";
        $this->db->select('*');
        $this->db->from('vms_vendor_master');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->row();
        return $data;
    }

    public function getVendorDtls($id)
    {

        $condition = "vendor_id = '" . $id . "'";
        $this->db->select('*');
        $this->db->from('vms_vendor_master');
        $this->db->where($condition);
        $query = $this->db->get();
        //        echo $this->db->last_query();
        $data = $query->result_array();
        return $data;
    }

    public function getVendorLists()
    {

        #$admin_id
        //$condition = "admin_id = '" . $admin_id . "' and is_delete = '0'";
        $condition = "is_delete = '0' ";
        $this->db->select('*');
        $this->db->from('vms_vendor_master');
        $this->db->where($condition);
        $this->db->order_by("vendor_id", "desc");
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getAllVendor()
    {

        $condition = "status = '1' and block_status ='1' and is_delete = '0'";
        $this->db->select('*');
        $this->db->from('vms_vendor_master');
        $this->db->where($condition);
        $this->db->order_by("vendor_id", "desc");
        $query = $this->db->get();
        // echo $this->db->last_query();
        $data = $query->result_array();
        return $data;
    }

    public function getProjectLists()
    {

        $condition = "is_deleted = '1'";
        $this->db->select('*');
        $this->db->from('vms_project_master');
        $this->db->where($condition);
        $this->db->order_by("entry_date", "desc");
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getProjectData($project_id)
    {

        $condition = "id = '" . $project_id . "'";
        $this->db->select('*');
        $this->db->from('vms_project_master');
        $this->db->where($condition);
        $this->db->order_by("entry_date", "desc");
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getProjectDtls($project_id)
    {

        $condition = "id = '" . $project_id . "'";
        $this->db->select('*');
        $this->db->from('vms_project_master');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getLastID()
    {

        $this->db->select('id');
        $this->db->from('vms_project_master');
        $this->db->order_by("id", "desc");
        $this->db->limit(1);
        $query = $this->db->get();
        //        echo $this->db->last_query();
        $data = $query->result_array();
        return $data;
    }

    public function getProjectType()
    {

        //        $condition = "admin_id = '" . $admin_id . "'";
        $this->db->select('*');
        $this->db->from('vms_project_type_master');
        //        $this->db->where($condition);
        //        $this->db->order_by("entry_date", "desc");
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getEmployeeProjects($employee_id)
    {

        $condition = "employee_id = '" . $employee_id . "'";
        $this->db->select('*');
        $this->db->from('vms_assign_projects_to_employee');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getTimesheetData($project_id, $employee_id)
    {

        $condition = "project_id = '" . $project_id . "' and employee_id = '" . $employee_id . "'";
        $this->db->select('*');
        $this->db->from('vms_project_timesheet_master');
        $this->db->order_by("entry_date", "asc");
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getWorkDetails($employee_id)
    {

        $condition = "employee_id = '" . $employee_id . "'";
        $this->db->select('*');
        $this->db->from('vms_employee_work_order');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function update_work_order($data, $id)
    {
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

    public function update_projects($data, $id)
    {
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

    public function getInvoiceDetails($vendor_ids)
    {
        if ($vendor_ids != '') {
            $vendor_ids_str = $vendor_ids;
        } else {
            $vendor_ids_str = '0';
        }
        $condition = "vendor_id in(" . $vendor_ids_str . ")";
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

    public function checkInvoiceStatus($invoice_id)
    {

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

    public function checkAdminInvoiceStatus($invoice_id)
    {

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

    public function checkInvoice($employee_id, $payment_type)
    {

        $condition = "employee_id = '" . $employee_id . "' and payment_type = '" . $payment_type . "'";
        $this->db->select('*');
        $this->db->from('vms_payment_master');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getWorkingDays($payment_type, $start_date, $end_date, $employee_id)
    {
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

    public function getWorkingDaysMonthly($payment_type, $month, $year, $employee_id)
    {
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

    public function add_work_order($data)
    {
        $this->db->insert('vms_employee_work_order', $data);
        $last_id = $this->db->insert_id();
        return $last_id;
    }

    public function add_projects($data)
    {
        $this->db->insert('vms_project_master', $data);
        $last_id = $this->db->insert_id();
        return $last_id;
    }

    public function changeTimesheetStatus($data, $timesheet_id)
    {
        $this->db->where('id', $timesheet_id);
        $this->db->update('vms_project_timesheet_master', $data);
        //        echo $this->db->last_query();
        //        die;

        if ($this->db->affected_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    public function getCountEmployeesByProjects($project_id) {
        if (LATAM) {
            $condition = "project_id = '" . $project_id . "'  and is_assigned = '0'";
        }
        if (US || INDIA) {
            $condition = "project_id = '" . $project_id . "'";
        }
        $this->db->select('count(*) as cnt');
        $this->db->from('vms_assign_projects_to_employee');
        $this->db->where($condition);
        $query = $this->db->get();
        // $this->db->last_query();
        $data = $query->result_array();
        return $data;
    }

    public function getAssignedEmpoyees($project_id)
    {

        $condition = "project_id = '" . $project_id . "' and is_assigned = '0'";
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

    public function changeConsultantStatus($update_arr, $project_id, $employee_id)
    {
        $condition = "project_id = '" . $project_id . "' and employee_id = '" . $employee_id . "'";
        $this->db->where($condition);
        $this->db->update('vms_assign_projects_to_employee', $update_arr);
        //        echo $this->db->last_query();
        //        die;

        if ($this->db->affected_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    public function getDocumentsLists()
    {

        $condition = "status = '1'";
        $this->db->select('*');
        $this->db->from('vms_consultant_documents');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getAssignProjectDtlsbyEmp($employee_id)
    {

        $condition = "employee_id = '" . $employee_id . "'";
        $this->db->select('*');
        $this->db->from('vms_assign_projects_to_employee');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getUploadedDocs($doc_id, $employee_id)
    {

        $condition = "form_no = '" . $doc_id . "' and consultant_id = '" . $employee_id . "'";
        $this->db->select('*');
        $this->db->from('vms_consultant_files');
        $this->db->where($condition);
        $query = $this->db->get();
        //        echo $this->db->last_query();
        $data = $query->result_array();
        return $data;
    }

    public function getPaymentComments($invoice_id)
    {

        $condition = "invoice_id = '" . $invoice_id . "'";
        $this->db->select('*');
        $this->db->from('vms_payment_mail_master');
        $this->db->where($condition);
        $this->db->order_by("entry_date", "desc");
        $query = $this->db->get();
        //        echo $this->db->last_query();
        //        die;
        $data = $query->result_array();
        return $data;
    }

    public function getPaymentDetailsByInvoice($invoice_id)
    {

        $condition = "id = '" . $invoice_id . "'";
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

    public function getInvoiceDueDate()
    {

        $o_condition = "status = '1'";
        $this->db->select('*');
        $this->db->from('vms_payment_master');
        $this->db->where($o_condition);
        $o_query = $this->db->get();
        $o_data = $o_query->result_array();
        return $o_data;
    }

    public function getEmployeeListsbyAdmin($admin_id)
    {   
        if (DEMO) {
            #$admin_id
            //$condition = "admin_id = '" . $admin_id . "' and vendor_id = '0' and is_delete = '0' ";
            // $condition = "vem.employee_type = 'E' and vem.is_delete = '0' and vem.shift_admin_manager_id = ".$admin_id;

            // $this->db->select("vem.client_id,vem.file,vem.employee_email,vem.employee_code,vem.name_prefix,vem.first_name,vem.last_name,vem.employee_designation,vem.temp_classification,vem.employee_category,vem.temp_category,vem.address,vem.phone_no,vem.date_of_joining,vem.resume_file,vem.employee_bill_rate,vem.employee_pay_rate,vem.status,vem.employee_id,vem.fax_no,vem.emp_bill_rate_type,vem.emp_pay_rate_type,vem.bg_check_status,vem.bg_order_id,vem.bg_report_file, CONCAT(vam.first_name, ' ', vam.last_name) AS manager_name", FALSE);

            // $this->db->from('vms_employee_master AS vem');
            // $this->db->join('vms_admin_master AS vam', 'vem.shift_admin_manager_id = vam.admin_id');
            // $this->db->where($condition);
            // $this->db->order_by("vem.employee_id", "desc");
            // $query = $this->db->get();

            $sql = "SELECT vem.client_id,vem.file,vem.employee_email,vem.employee_code,vem.name_prefix,vem.first_name,vem.last_name,vem.employee_designation,vem.temp_classification,vem.employee_category,vem.temp_category,vem.address,vem.phone_no,vem.date_of_joining,vem.resume_file,vem.employee_bill_rate,vem.employee_pay_rate,vem.status,vem.employee_id,vem.fax_no,vem.emp_bill_rate_type,vem.emp_pay_rate_type,vem.bg_check_status,vem.bg_order_id,vem.bg_report_file, CONCAT(vam.first_name, ' ', vam.last_name) AS manager_name, veld.consultant_email, veld.status AS veld_status, veld.block_status, count(veld.id) as cnt, vcm.client_name FROM vms_employee_master vem INNER JOIN vms_admin_master vam ON vem.shift_admin_manager_id = vam.admin_id LEFT JOIN vms_employee_login_details veld ON vem.employee_id = veld.employee_id LEFT JOIN vms_client_master vcm ON vem.client_id=vcm.id and vcm.status = '1' WHERE vem.employee_type = 'E' and vem.is_delete = '0' and vem.shift_admin_manager_id = $admin_id GROUP BY vem.employee_id ORDER BY vem.employee_id DESC;";

            $query = $this->db->query($sql);

            
            $data = $query->result_array();
            return $data;
        }
        if (INDIA) {
            #$admin_id
            //$condition = "admin_id = '" . $admin_id . "' and vendor_id = '0' and is_delete = '0' ";
            // $condition = "vem.employee_type = 'E' and vem.is_delete = '0' and vem.shift_admin_manager_id = ".$admin_id;
            
            // $this->db->select("vem.client_id,vem.file,vem.employee_code,vem.name_prefix,vem.first_name,vem.last_name,vem.employee_designation,vem.temp_classification,vem.employee_category,vem.temp_category,vem.address,vem.phone_no,vem.date_of_joining,vem.resume_file,vem.employee_bill_rate,vem.employee_pay_rate,vem.status,vem.employee_id,vem.fax_no,vem.emp_bill_rate_type,vem.emp_pay_rate_type, CONCAT(vam.first_name, ' ', vam.last_name) AS manager_name", FALSE);

            // $this->db->from('vms_employee_master AS vem');
            // $this->db->join('vms_admin_master AS vam', 'vem.shift_admin_manager_id = vam.admin_id');
            // $this->db->where($condition);
            // $this->db->order_by("vem.employee_id", "desc");
            // $query = $this->db->get();

            $sql = "SELECT vem.client_id,vem.file,vem.employee_email,vem.employee_code,vem.name_prefix,vem.first_name,vem.last_name,vem.employee_designation,vem.temp_classification,vem.employee_category,vem.temp_category,vem.address,vem.phone_no,vem.date_of_joining,vem.resume_file,vem.employee_bill_rate,vem.employee_pay_rate,vem.status,vem.employee_id,vem.fax_no,vem.emp_bill_rate_type,vem.emp_pay_rate_type, CONCAT(vam.first_name, ' ', vam.last_name) AS manager_name, veld.consultant_email, veld.status AS veld_status, veld.block_status, count(veld.id) as cnt, vcm.client_name FROM vms_employee_master vem INNER JOIN vms_admin_master vam ON vem.shift_admin_manager_id = vam.admin_id LEFT JOIN vms_employee_login_details veld ON vem.employee_id = veld.employee_id LEFT JOIN vms_client_master vcm ON vem.client_id=vcm.id and vcm.status = '1' WHERE vem.employee_type = 'E' and vem.is_delete = '0' and vem.shift_admin_manager_id = $admin_id GROUP BY vem.employee_id ORDER BY vem.employee_id DESC;";

            $query = $this->db->query($sql);


            $data = $query->result_array();
            return $data;
        }
    }

    public function getAllEmployeeListsbyAdmin()
    {
        if (DEMO) {
            #$admin_id
            //$condition = "admin_id = '" . $admin_id . "' and vendor_id = '0' and is_delete = '0' ";
            $condition = "employee_type = 'E' and is_delete = '0'";

            $this->db->select('client_id,file,employee_code,name_prefix,first_name,last_name,employee_designation,temp_classification,employee_category,temp_category,address,phone_no,date_of_joining,resume_file,employee_bill_rate,employee_pay_rate,status,employee_id,fax_no,emp_bill_rate_type,emp_pay_rate_type');

            $this->db->from('vms_employee_master');
            $this->db->where($condition);
            $this->db->order_by("employee_id", "desc");
            $query = $this->db->get();
            $data = $query->result_array();
            return $data;
        }
        if (US || INDIA) {
            #$admin_id
            //$condition = "admin_id = '" . $admin_id . "' and vendor_id = '0' and is_delete = '0' ";
            // $condition = "employee_type = 'E' and is_delete = '0'"
            if (INDIA) {
                // $this->db->select('client_id,file,employee_code,name_prefix,first_name,last_name,employee_designation,temp_classification,employee_category,temp_category,address,phone_no,date_of_joining,resume_file,employee_bill_rate,employee_pay_rate,status,employee_id,fax_no,emp_bill_rate_type,emp_pay_rate_type');
            }

            if (US) {
                // $this->db->select('*');
            }
            // $this->db->from('vms_employee_master');
            // $this->db->where($condition);
            // $this->db->order_by("employee_id", "desc");
            // $query = $this->db->get();


            $sql = "SELECT vem.client_id,vem.file,vem.employee_email,vem.employee_code,vem.name_prefix,vem.first_name,vem.last_name,vem.employee_designation,vem.temp_classification,vem.employee_category,vem.temp_category,vem.address,vem.phone_no,vem.date_of_joining,vem.resume_file,vem.employee_bill_rate,vem.employee_pay_rate,vem.status,vem.employee_id,vem.fax_no,vem.emp_bill_rate_type,vem.emp_pay_rate_type, veld.consultant_email, veld.status AS veld_status, veld.block_status, count(veld.id) as cnt, vcm.client_name, CONCAT(vam.first_name, ' ', vam.last_name) AS manager_name FROM vms_employee_master vem LEFT JOIN vms_admin_master vam ON vem.shift_admin_manager_id = vam.admin_id LEFT JOIN vms_employee_login_details veld ON vem.employee_id = veld.employee_id LEFT JOIN vms_client_master vcm ON vem.client_id=vcm.id and vcm.status = '1' WHERE vem.employee_type = 'E' and vem.is_delete = '0' GROUP BY vem.employee_id ORDER BY vem.employee_id DESC;";

            $query = $this->db->query($sql);

            $data = $query->result_array();
            return $data;
        }
        if (LATAM) {
            #$admin_id
            //$condition = "admin_id = '" . $admin_id . "' and vendor_id = '0' and is_delete = '0' ";
            $condition = "employee_type = 'E' and is_delete = '0' ";
            $this->db->select('*');
            $this->db->from('vms_employee_master');
            $this->db->where($condition);
            $this->db->order_by("employee_id", "desc");
            $query = $this->db->get();
            $data = $query->result_array();
            return $data;
        }
    }

    public function checkCount($admin_id)
    {

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

    public function check_prev_assign($project_name, $employee_name)
    {

        $condition = "project_id = '" . $project_name . "' and employee_id = '" . $employee_name . "'";
        $this->db->select('count(*) as cnt');
        $this->db->from('vms_assign_projects_to_employee');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function add_assign_projects($data)
    {
        $this->db->insert('vms_assign_projects_to_employee', $data);
        $last_id = $this->db->insert_id();
        return $last_id;
    }

    public function generate_login_details($data)
    {
        $this->db->insert('vms_employee_login_details', $data);
        $last_id = $this->db->insert_id();
        return $last_id;
    }

    public function update_login_details($data, $id)
    {
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

    public function getDocumentsListsbyEmpType($employee_type)
    {

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

    public function change_docs_status($data, $employee_id, $doc_id)
    {
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

    public function getSuperAdminDetails($id)
    {

        $condition = "sa_id = '" . $id . "' and lower(sa_name) not like 'aurica%'";
        $this->db->select('*');
        $this->db->from('vms_superadmin_master');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function checkGenerateStatus($employee_id)
    {

        $condition = "employee_id = '" . $employee_id . "'";
        $this->db->select('count(*) as cnt');
        $this->db->from('vms_employee_login_details');
        $this->db->where($condition);
        $query = $this->db->get();
        //        echo $this->db->last_query();
        $data = $query->result_array();
        return $data;
    }

    public function getFiles($consultant_id)
    {

        $condition = "consultant_id = '" . $consultant_id . "'";
        $this->db->select('*');
        $this->db->from('vms_consultant_files');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function checkPrevUploadedDetails($doc_id, $employee_id)
    {

        $condition = "form_no = '" . $doc_id . "' and consultant_id = '" . $employee_id . "'";
        $this->db->select('*');
        $this->db->from('vms_consultant_files');
        $this->db->where($condition);
        $query = $this->db->get();
        //        echo $this->db->last_query();
        $data = $query->result_array();
        return $data;
    }

    public function getDocsDetails($id)
    {

        $condition = "id = '" . $id . "'";
        $this->db->select('*');
        $this->db->from('vms_consultant_documents');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function checkPrevUploaded($doc_id, $employee_id)
    {

        $condition = "form_no = '" . $doc_id . "' and consultant_id = '" . $employee_id . "'";
        $this->db->select('count(*) as cnt');
        $this->db->from('vms_consultant_files');
        $this->db->where($condition);
        $query = $this->db->get();
        //        echo $this->db->last_query();
        $data = $query->result_array();
        return $data;
    }

    public function add_employee_documents($data)
    {
        $this->db->insert('vms_consultant_files', $data);
        $last_id = $this->db->insert_id();
        return $last_id;
    }

    public function getEmpIDs()
    {
        #$admin_id
        //$condition = "employee_type = 'E' and admin_id = '" . $admin_id . "'";
        $condition = "employee_type = 'E' ";
        $this->db->select('*');
        $this->db->from('vms_employee_master');
        $this->db->where($condition);
        $query = $this->db->get();
        //       echo $this->db->last_query();
        //        die;
        $data = $query->result_array();
        return $data;
    }

    public function getInvoiceCodeByID($timesheet_id, $vendor_id)
    {

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

    public function getInvoiceDetailsbyConsultants()
    {
        //$vendor_ids, $emp_str

        // if ($vendor_ids != '') {
        //     $vendor_ids_str = $vendor_ids;
        // } else {
        //     $vendor_ids_str = '0';
        // }
        // $condition = "employee_id not in (" . $emp_str . ") and vendor_id in(" . $vendor_ids_str . ")";
        // $this->db->select('*');
        // $this->db->from('vms_payment_master');
        // $this->db->where($condition);
        // $this->db->order_by("employee_id", "desc");
        // if (US_INDIA) {
        //     $this->db->limit(250);
        // }
        // $query = $this->db->get();

        // $data = $query->result_array();
        // return $data;

        $limit = '';
        if (US || INDIA) {
            $limit = 'LIMIT 250';
        }

        $sql = "SELECT vpm.id,vapm.invoice_code,vpm.timesheet_period_id,vpm.employee_id, vpm.payment_type, vpm.start_date, vpm.end_date, vpm.tot_time, vpm.over_time, vpm.bill_rate, vpm.ot_rate, vpm.tot_time_pay, vpm.over_time_pay, vpm.status, vem.first_name, vem.last_name, vem.employee_code, vem.employee_designation, vptp.timesheet_id FROM vms_payment_master vpm LEFT JOIN vms_employee_master vem ON vpm.employee_id = vem.employee_id LEFT JOIN vms_project_timesheet_period vptp ON vpm.timesheet_period_id = vptp.id LEFT JOIN  vms_admin_payment_master vapm ON vpm.timesheet_period_id = vapm.timesheet_period_id AND vpm.vendor_id = vapm.vendor_id WHERE vpm.employee_id NOT IN (SELECT employee_id FROM vms_employee_master WHERE employee_type = 'E') AND vpm.vendor_id IN (SELECT vendor_id FROM vms_vendor_master WHERE is_delete = '0' ORDER BY vendor_id DESC) ORDER BY vpm.employee_id DESC $limit";

        $query = $this->db->query($sql);
        $data = $query->result_array();
        return $data;
    }

    public function getInvoiceDetailsbyEmployee($type)
    {

        // $condition = "employee_id in (" . $emp_str . ")";
        // $this->db->select('*');
        // $this->db->from('vms_admin_payment_master');
        // $this->db->where($condition);
        // $this->db->order_by("id", "desc");
        // $this->db->limit(250);
        // $query = $this->db->get();
        // // echo $this->db->last_query();
        // // die;
        // $data = $query->result_array();
        // return $data;
        $emp_type = '';
        if ($type == "ten99") {
            $emp_type = '1099';
        }
        else if ($type == "emp") {
            $emp_type = 'E';
        }

        $sql = "SELECT vapm.id, vapm.invoice_code,vapm.timesheet_period_id,vapm.employee_id, vapm.payment_type, vapm.start_date, vapm.end_date, vapm.tot_time, vapm.over_time, vapm.bill_rate, vapm.ot_rate, vapm.tot_time_pay, vapm.over_time_pay, vapm.status, vapm.payment_status, vapm.bank_name, vapm.transaction_id, vapm.payment_date, vem.first_name, vem.last_name, vem.employee_code, vem.employee_designation, vptp.timesheet_id FROM vms_admin_payment_master vapm LEFT JOIN vms_employee_master vem ON vapm.employee_id = vem.employee_id LEFT JOIN vms_project_timesheet_period vptp ON vapm.timesheet_period_id = vptp.id WHERE vapm.employee_id IN (SELECT employee_id FROM vms_employee_master WHERE employee_type = '$emp_type') ORDER BY vapm.id DESC LIMIT 250";

        $query = $this->db->query($sql);
        $data = $query->result_array();
        return $data;
    }

    public function getMonthlyTimesheet($month, $year, $employee_id)
    {
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

    public function getWeeklyTimesheet($start_date, $end_date, $employee_id)
    {
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

    public function checkTimesheet($project_id)
    {

        $condition = "project_id = '" . $project_id . "'";
        $this->db->select('count(*) as cnt');
        $this->db->from('vms_project_timesheet_master');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function checkTimesheetPeriod($project_id) {

        $condition = "project_id = '" . $project_id . "'";
        $this->db->select('count(*) as cnt');
        $this->db->from('vms_project_timesheet_period');
        $this->db->where($condition);
        $query = $this->db->get();
        //echo $this->db->last_query();
        $data = $query->result_array();
        return $data;
    }

    public function getPrevGeneratedCode()
    {

        $this->db->select('invoice_code');
        $this->db->from('vms_admin_payment_master');
        $this->db->limit(1);
        $this->db->order_by("id", "desc");
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getCheckMonth($month, $year, $employee_id)
    {

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

    public function getCheckDate($start_date, $end_date, $employee_id)
    {

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

    public function generate_payment($data)
    {
        $this->db->insert('vms_payment_master', $data);
        $last_id = $this->db->insert_id();
        return $last_id;
    }

    function deletePreviousDocs($form_name, $employee_id)
    {
        $condition = "form_name = '" . trim($form_name) . "' and consultant_id = '" . $employee_id . "'";
        $this->db->where($condition);
        $this->db->delete('vms_consultant_files');
        return 1;
    }

    public function checkApproveStatus($doc_id, $employee_id)
    {

        $condition = "form_no = '" . $doc_id . "' and consultant_id = '" . $employee_id . "'";
        $this->db->select('*');
        $this->db->from('vms_consultant_files');
        $this->db->where($condition);
        $query = $this->db->get();
        //        echo $this->db->last_query();
        $data = $query->result_array();
        return $data;
    }

    public function getVendorsName($id)
    {

        $condition = "vendor_id in (" . $id . ")";
        $this->db->select('*');
        $this->db->from('vms_vendor_master');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function get_ucsis_admin_approve_status($employee_id)
    {
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

    public function getUscisFiles($consultant_id)
    {

        $condition = "employee_id = '" . $consultant_id . "'";
        $this->db->select('*');
        $this->db->from('vms_emp_id_uscis_verifications_doc');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getvmsEmpIdListA()
    {

        $this->db->select('*');
        $this->db->from('vms_emp_id_list_a');
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getvmsEmpNameListA($id)
    {

        $condition = "id = '" . $id . "'";
        $this->db->select('*');
        $this->db->from('vms_emp_id_list_a');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getvmsEmpNameListB($id)
    {

        $condition = "id = '" . $id . "'";
        $this->db->select('*');
        $this->db->from('vms_emp_id_list_b');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getvmsEmpNameListC($id)
    {

        $condition = "id = '" . $id . "'";
        $this->db->select('*');
        $this->db->from('vms_emp_id_list_c');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getvmsEmpIdListB()
    {

        $this->db->select('*');
        $this->db->from('vms_emp_id_list_b');
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getvmsEmpIdListC()
    {

        $this->db->select('*');
        $this->db->from('vms_emp_id_list_c');
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function change_ucsis_docs_status($data, $employee_id)
    {
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

    /* public function getAllFilesByClient($employee_type, $is_uhg)
    {
        if ($employee_type == 'C') {
            if ($is_uhg > 0) {
                $condition = "FIND_IN_SET('" . $employee_type . "',required_for) > 0";
            } else {
                $condition = "FIND_IN_SET('" . $employee_type . "',required_for) > 0 and id <> '12'";
            }
        } elseif ($employee_type == 'E') {

            if ($is_uhg > 0) {
                $condition = "FIND_IN_SET('" . $employee_type . "',required_for) > 0";
            } else {
                $condition = "FIND_IN_SET('" . $employee_type . "',required_for) > 0 and id <> '12'";
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
    */


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
		//echo "emp type=" .$employee_type;
		//echo "is uhg=" .$is_uhg;
		//echo " is_jci=" .$is_jci;
		//echo " enrollment_type=" .$emp_enrollment_type;
		//echo $this->db->last_query();

		if($query !== FALSE && $query->num_rows() > 0){
				$data = $query->result_array();
		}

        //$data = $query->result_array();
        return $data;
    }



    public function getClientLists()
    {

        $condition = "status = '1'";
        $this->db->select('*');
        $this->db->from('vms_client_master');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getClientData($id)
    {

        $condition = "status = '1' and id = '" . $id . "'";
        $this->db->select('*');
        $this->db->from('vms_client_master');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getTimesheetDetails()
    {

        $this->db->select('*');
        $this->db->from('vms_project_timesheet_period');
        $this->db->order_by("entry_date", "desc");
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getPendingTimesheetDetails()
    {

        $condition = "status = '2'";
        $this->db->select('*');
        $this->db->from('vms_project_timesheet_period');
        $this->db->where($condition);
        $this->db->order_by("entry_date", "desc");
        $this->db->limit(250);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getTotalST($timesheet_id)
    {

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

    public function getTotalOT($timesheet_id)
    {

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

    public function getTimesheetDetailsByID($tid)
    {

        $condition = "id = '" . $tid . "'";
        $this->db->select('*');
        $this->db->from('vms_project_timesheet_period');
        $this->db->where($condition);
        //        $this->db->order_by("entry_date", "desc");
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getExpenseEmployees() {
        if (US || INDIA) {
            $query_str = "SELECT * FROM ".DBASE.".vms_employee_master WHERE employee_id IN (SELECT created_by FROM expense)";
            $query = $this->db->query($query_str);
            $data = $query->result_array();
            return $data;
        }
    }

    public function get_employee_all_expense($employee_id) {
        if (US || INDIA) {
            $query_str = "SELECT * FROM ".DBASE.".expense WHERE created_by =".$employee_id;
            $query = $this->db->query($query_str);
            $data = $query->result_array();
            return $data;
        }
    }






    public function get_all_expense() {
        if (US || INDIA) {
            $query_str = "SELECT vem.first_name, vem.last_name, vem.employee_id, e.id,e.created_time, e.expense_pdf_name,e.approved_or_denied_date FROM ".DBASE.".expense e LEFT JOIN vms_employee_master vem ON e.created_by = vem.employee_id ORDER BY id DESC";
            $query = $this->db->query($query_str);
            $data = $query->result_array();
            return $data;
        }
    }







    public function get_expense_details($expense_id) {
        if (US || INDIA) {
            $sql = "SELECT *,e.id AS id, ed.id as expense_details_id FROM ".DBASE.".expense e INNER JOIN ".DBASE.".expense_details ed ON e.id = ed.expense_id WHERE e.id=".$expense_id;
            $query = $this->db->query($sql);
            return $query->result_array();
        }
    }

    public function getParticularEmployeeData($employee_id) {
        if (US || INDIA) {
            $query_str = "SELECT * FROM ".DBASE.".vms_employee_master WHERE employee_id =".$employee_id;
            $query = $this->db->query($query_str);
            $data = $query->result_array();
            return $data;
        }
    }

    public function update_admin_expense($data,$id) {
        if (US || INDIA) {
            $this->db->where('id', $id);
            $this->db->update('expense', $data);

            if ($this->db->affected_rows() > 0) {
                return 1;
            } else {
                return 0;
            }
        }
    }

    public function get_expense_by_id($expense_id) {
        $sql = "SELECT is_approved,reason_for_approved_or_denied,admin_signature,approved_or_denied_date FROM ".DBASE.".expense WHERE id=".$expense_id;
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function get_payroll_data() {
        if (LATAM) {
            $this->db->select('first_name, last_name, employee_designation, employee_pay_rate');
            $this->db->from('vms_employee_master');
            $this->db->where('status', '1' );
            $query = $this->db->get();
            $data = $query->result_array();
            return $data;
        }
    }

    public function store_payroll_table_data($data) {
        if (LATAM) {
            $this->db->insert('payroll', $data);
            //        echo $this->db->last_query();
            //        die();
            $last_id = $this->db->insert_id();

            return $last_id;
        }
    }

    public function truncate_payroll_table_data() {
        if (LATAM) { 
            $this->db->truncate('payroll');
        }
    }

    public function getTimesheetPeriodDetails($tid)
    {

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

    public function changeEachTimesheetStatus($data, $timesheet_id)
    {
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

    public function changePeriodTimesheetStatus($data, $timesheet_period_id)
    {
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

    public function getTimesheetDetailsByEmp($employee_id)
    {

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

    public function getTimesheetDetailsnotapprove($employee_id)
    {

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

    public function getTimesheetDetailspending($employee_id)
    {

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

    public function getPeriodDetails($timesheet_period_id)
    {

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

    public function generateTimesheetInvoice($data)
    {
        $this->db->insert('vms_admin_payment_master', $data);
        //        echo $this->db->last_query();
        //        die();
        $last_id = $this->db->insert_id();

        return $last_id;
    }

    public function getAdminInvoiceDetailsbyConsultants()
    {
        //$vendor_ids, $emp_str

        $limit = '';

        if (US || INDIA) {
           $limit = 'LIMIT 250';
        }


        $sql = "SELECT vapm.id, vapm.invoice_code,vapm.timesheet_period_id,vapm.employee_id, vapm.payment_type, vapm.start_date, vapm.end_date, vapm.tot_time, vapm.over_time, vapm.bill_rate, vapm.ot_rate, vapm.tot_time_pay, vapm.over_time_pay, vapm.status, vem.first_name, vem.last_name, vem.employee_code, vem.employee_designation, vptp.timesheet_id FROM vms_admin_payment_master vapm LEFT JOIN vms_employee_master vem ON vapm.employee_id = vem.employee_id LEFT JOIN vms_project_timesheet_period vptp ON vapm.timesheet_period_id = vptp.id WHERE vapm.employee_id NOT IN (SELECT employee_id FROM vms_employee_master WHERE employee_type = 'E') AND vapm.vendor_id IN (SELECT vendor_id FROM vms_vendor_master WHERE is_delete = '0' ORDER BY vendor_id DESC) AND vapm.status='1' ORDER BY vapm.employee_id DESC $limit";

        // if ($vendor_ids != '') {
        //     $vendor_ids_str = $vendor_ids;
        // } else {
        //     $vendor_ids_str = '0';
        // }

        // $condition = "employee_id not in (" . $emp_str . ") and vendor_id in(" . $vendor_ids_str . ") and status = '1'";
        // $this->db->select('*');
        // $this->db->from('vms_admin_payment_master');
        // $this->db->where($condition);
        // $this->db->order_by("employee_id", "desc");
        // if (US_INDIA) {
        //     $this->db->limit(250);
        // }
        // $query = $this->db->get();
        // //        echo $this->db->last_query();
        // //        die;
        // $data = $query->result_array();
        // return $data;

        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function getAdminNotApprvInvoiceDetailsbyConsultants()
    {
        //  $vendor_ids, $emp_str

        // if ($vendor_ids != '') {
        //     $vendor_ids_str = $vendor_ids;
        // } else {
        //     $vendor_ids_str = '0';
        // }

        // $condition = "employee_id not in (" . $emp_str . ") and vendor_id in(" . $vendor_ids_str . ") and status = '2'";
        // $this->db->select('*');
        // $this->db->from('vms_admin_payment_master');
        // $this->db->where($condition);
        // $this->db->order_by("employee_id", "desc");
        // $query = $this->db->get();
//        echo $this->db->last_query();
//        die;

        $sql = "SELECT vapm.id, vapm.invoice_code,vapm.timesheet_period_id,vapm.employee_id, vapm.payment_type, vapm.start_date, vapm.end_date, vapm.tot_time, vapm.over_time, vapm.bill_rate, vapm.ot_rate, vapm.tot_time_pay, vapm.over_time_pay, vapm.status, vem.first_name, vem.last_name, vem.employee_code, vem.employee_designation, vptp.timesheet_id FROM vms_admin_payment_master vapm LEFT JOIN vms_employee_master vem ON vapm.employee_id = vem.employee_id LEFT JOIN vms_project_timesheet_period vptp ON vapm.timesheet_period_id = vptp.id WHERE vapm.employee_id NOT IN (SELECT employee_id FROM vms_employee_master WHERE employee_type = 'E') AND vapm.vendor_id IN (SELECT vendor_id FROM vms_vendor_master WHERE is_delete = '0' ORDER BY vendor_id DESC) AND vapm.status='2' ORDER BY vapm.employee_id DESC";

        $query = $this->db->query($sql);
        $data = $query->result_array();
        return $data;
    }

    public function getPrevInvoice($timesheet_period_id, $employee_id, $vendor_id, $start_date, $end_date)
    {

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

    public function DeleteInvoice($data, $timesheet_period_id)
    {
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

    public function deleteInvoicePermanently($invoice_id)
    {

        $this->db->where('id', $invoice_id);
        $this->db->delete('vms_admin_payment_master');

        if ($this->db->affected_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    public function deleteVendorInvoicePermanently($invoice_id)
    {

        $this->db->where('id', $invoice_id);
        $this->db->delete('vms_payment_master');

        if ($this->db->affected_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    public function checkUscisUploadedDocss($employee_id)
    {

        $condition = "employee_id = '" . $employee_id . "'";
        $this->db->select('*');
        $this->db->from('vms_emp_id_uscis_verifications_doc');
        $this->db->where($condition);
        $query = $this->db->get();
//        echo $this->db->last_query();
        $data = $query->result_array();
        return $data;
    }

    function deletePrevUscDocs($employee_id)
    {
        $condition = "employee_id = '" . $employee_id . "'";
        $this->db->where($condition);
        $this->db->delete('vms_emp_id_uscis_verifications_doc');
        return 1;
    }

    public function add_consultants_uscis_documents($data)
    {
        $this->db->insert('vms_emp_id_uscis_verifications_doc', $data);
        $last_id = $this->db->insert_id();
        if (LATAM) {
            return $last_id;
        }
        if (US || INDIA){
            // return $last_id;
            if ($this->db->affected_rows() > 0) {
                return 1;
            } else {
                return 0;
            }
        }
    }

    public function change_ucsis_status($data, $uscis_id)
    {
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

    public function getVendorData($id)
    {

        $condition = "vendor_id = '" . $id . "'";
        $this->db->select('*');
        $this->db->from('vms_vendor_master');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getConsultantLists()
    {

        $condition = "employee_type = 'C' and is_delete = '0'";
        $this->db->select('*');
        $this->db->from('vms_employee_master');
        $this->db->where($condition);
        $this->db->order_by("employee_id", "desc");
        // echo $this->db->last_query();
        // die;
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getConsultantListsByAdmin($admin_id)
    {

        $condition = "employee_type = 'C' and is_delete = '0' and admin_id = '".$admin_id."'";
        $this->db->select('*');
        $this->db->from('vms_employee_master');
        $this->db->where($condition);
        $this->db->order_by("employee_id", "desc");
        // echo $this->db->last_query();
        // die;
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getConProjectLists($employee_id)
    {

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

    public function add_timesheet_period($data)
    {
        $this->db->insert('vms_project_timesheet_period', $data);
        $last_id = $this->db->insert_id();
        return $last_id;
    }

    public function add_timesheet($data)
    {
        $this->db->insert('vms_project_timesheet_mast', $data);
//        $this->db->insert('vms_project_timesheet_master', $data);
        $last_id = $this->db->insert_id();
        return $last_id;
    }

    public function getEmployeeListsbyTypeNew($admin_id) {
        if (DEMO) {
            $condition = "employee_type = 'E' and is_delete = '0' and shift_admin_manager_id =".$admin_id;
            $this->db->select('*');
            $this->db->from('vms_employee_master');
            $this->db->where($condition);
            $this->db->order_by("employee_id", "desc");
            $query = $this->db->get();
            $data = $query->result_array();
            return $data;
        }
    }

    public function getEmployeeListsbyType()
    {

        $condition = "employee_type = 'E' and is_delete = '0'";
        $this->db->select('*');
        $this->db->from('vms_employee_master');
        $this->db->where($condition);
        $this->db->order_by("employee_id", "desc");
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getEmpProjectLists($employee_id)
    {

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

    public function getInvoiceDetailsbyInvoiceCode($invoice_code)
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

    public function update_admin_employee_invoice_summary($data, $id) {
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

    public function getApprovedTimesheet()  {
        if (INDIA || LATAM) {
            $sql = "SELECT vptp.id, vptp.employee_id, vptp.project_id, vptp.timesheet_id, vptp.period, vptp.approved_by_id, vptp.approved_by, vpm.project_code, vpm.project_name, vem.employee_code, vem.first_name as employee_first_name, vem.last_name as employee_last_name, vem.employee_type, vsm.sa_name, vam.first_name, vam.last_name, SUM(vptm.tot_time) AS tot_time, sum(over_time) as over_time FROM vms_project_timesheet_period vptp LEFT JOIN vms_project_master vpm ON vptp.project_id = vpm.id LEFT JOIN vms_employee_master vem ON vptp.employee_id = vem.employee_id LEFT JOIN vms_superadmin_master vsm ON vptp.approved_by_id = vsm.sa_id LEFT JOIN vms_admin_master vam ON vptp.approved_by_id = vam.admin_id LEFT JOIN vms_project_timesheet_mast vptm ON vptp.id = vptm.timesheet_period_id WHERE vptp.employee_id in (SELECT employee_id FROM vms_employee_master WHERE employee_type = 'E' and is_delete = '0'ORDER BY employee_id desc) and vptp.status = '1' GROUP BY vptp.id ORDER BY vptp.entry_date desc LIMIT 100";
        }
        if (US) {
            $sql = "SELECT vptp.id, vptp.employee_id, vptp.project_id, vptp.timesheet_id, vptp.period, vptp.approved_by_id, vptp.approved_by, vpm.project_code, vpm.project_name, vem.employee_code, vem.first_name as employee_first_name, vem.last_name as employee_last_name, vem.employee_type, vsm.sa_name, vam.first_name, vam.last_name, SUM(vptm.tot_time) AS tot_time, sum(over_time) as over_time FROM vms_project_timesheet_period vptp INNER JOIN vms_project_master vpm ON vptp.project_id = vpm.id INNER JOIN vms_employee_master vem ON vptp.employee_id = vem.employee_id INNER JOIN vms_superadmin_master vsm ON vptp.approved_by_id = vsm.sa_id INNER JOIN vms_admin_master vam ON vptp.approved_by_id = vam.admin_id INNER JOIN vms_project_timesheet_mast vptm ON vptp.id = vptm.timesheet_period_id WHERE vptp.employee_id in (SELECT employee_id FROM vms_employee_master WHERE employee_type = 'E' and is_delete = '0'ORDER BY employee_id desc) and vptp.status = '1' GROUP BY vptp.id ORDER BY vptp.entry_date desc LIMIT 100";
        }

        $query = $this->db->query($sql);
        $data = $query->result_array();
        return $data;
    }

    public function getNotApprovedTimesheet() {
        if (INDIA || LATAM) {
            $sql = "SELECT vptp.id, vptp.employee_id, vptp.project_id, vptp.timesheet_id, vptp.period, vptp.approved_by_id, vptp.approved_by, vpm.project_code, vpm.project_name, vem.employee_code, vem.first_name as employee_first_name, vem.last_name as employee_last_name, vem.employee_type, vsm.sa_name, vam.first_name, vam.last_name, SUM(vptm.tot_time) AS tot_time, sum(over_time) as over_time FROM vms_project_timesheet_period vptp LEFT JOIN vms_project_master vpm ON vptp.project_id = vpm.id LEFT JOIN vms_employee_master vem ON vptp.employee_id = vem.employee_id LEFT JOIN vms_superadmin_master vsm ON vptp.approved_by_id = vsm.sa_id LEFT JOIN vms_admin_master vam ON vptp.approved_by_id = vam.admin_id LEFT JOIN vms_project_timesheet_mast vptm ON vptp.id = vptm.timesheet_period_id WHERE vptp.employee_id in (SELECT employee_id FROM vms_employee_master WHERE employee_type = 'E' and is_delete = '0'ORDER BY employee_id desc) and vptp.status = '0' GROUP BY vptp.id ORDER BY vptp.entry_date desc LIMIT 100";
        }

        if (US) {
            $sql = "SELECT vptp.id, vptp.employee_id, vptp.project_id, vptp.timesheet_id, vptp.period, vptp.approved_by_id, vptp.approved_by, vpm.project_code, vpm.project_name, vem.employee_code, vem.first_name as employee_first_name, vem.last_name as employee_last_name, vem.employee_type, vsm.sa_name, vam.first_name, vam.last_name, SUM(vptm.tot_time) AS tot_time, sum(over_time) as over_time FROM vms_project_timesheet_period vptp INNER JOIN vms_project_master vpm ON vptp.project_id = vpm.id INNER JOIN vms_employee_master vem ON vptp.employee_id = vem.employee_id INNER JOIN vms_superadmin_master vsm ON vptp.approved_by_id = vsm.sa_id INNER JOIN vms_admin_master vam ON vptp.approved_by_id = vam.admin_id INNER JOIN vms_project_timesheet_mast vptm ON vptp.id = vptm.timesheet_period_id WHERE vptp.employee_id in (SELECT employee_id FROM vms_employee_master WHERE employee_type = 'E' and is_delete = '0'ORDER BY employee_id desc) and vptp.status = '0' GROUP BY vptp.id ORDER BY vptp.entry_date desc LIMIT 100";
        }
        $query = $this->db->query($sql);
        $data = $query->result_array();
        return $data;
    }

    public function getPendingTimesheet() {
        if (INDIA || LATAM) {
        $sql = "SELECT vptp.id, vptp.employee_id, vptp.project_id, vptp.timesheet_id, vptp.period, vpm.project_code, vpm.project_name, vem.employee_code, vem.first_name as employee_first_name, vem.last_name as employee_last_name, vem.employee_type, SUM(vptm.tot_time) AS tot_time, sum(over_time) as over_time FROM vms_project_timesheet_period vptp LEFT JOIN vms_project_master vpm ON vptp.project_id = vpm.id LEFT JOIN vms_employee_master vem ON vptp.employee_id = vem.employee_id LEFT JOIN vms_project_timesheet_mast vptm ON vptp.id = vptm.timesheet_period_id WHERE vptp.employee_id in (SELECT employee_id FROM vms_employee_master WHERE employee_type = 'E' and is_delete = '0'ORDER BY employee_id desc) and vptp.status = '2' GROUP BY vptp.id ORDER BY vptp.entry_date desc LIMIT 100";
        }

        if (US) {
            $sql = "SELECT vptp.id, vptp.employee_id, vptp.project_id, vptp.timesheet_id, vptp.period, vpm.project_code, vpm.project_name, vem.employee_code, vem.first_name as employee_first_name, vem.last_name as employee_last_name, vem.employee_type, SUM(vptm.tot_time) AS tot_time, sum(over_time) as over_time FROM vms_project_timesheet_period vptp INNER JOIN vms_project_master vpm ON vptp.project_id = vpm.id INNER JOIN vms_employee_master vem ON vptp.employee_id = vem.employee_id INNER JOIN vms_project_timesheet_mast vptm ON vptp.id = vptm.timesheet_period_id WHERE vptp.employee_id in (SELECT employee_id FROM vms_employee_master WHERE employee_type = 'E' and is_delete = '0'ORDER BY employee_id desc) and vptp.status = '2' GROUP BY vptp.id ORDER BY vptp.entry_date desc LIMIT 100";
        }
        $query = $this->db->query($sql);

        $data = $query->result_array();
        return $data;
    }

    public function getApprovedTimesheetConsultant($employee_ids)  {
        if (US) {
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
            $this->db->limit(100);
            $query = $this->db->get();
            //        echo $this->db->last_query();
            $data = $query->result_array();
            return $data;
        }
    }

    public function getNotApprovedTimesheetConsultant($employee_ids) {
        if (US) {
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
            $this->db->limit(100);
            $query = $this->db->get();
            //        echo $this->db->last_query();
            $data = $query->result_array();
            return $data;
        }
    }

    public function getPendingTimesheetConsultant($employee_ids) {
        if (US) {
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
            $this->db->limit(100);
            $query = $this->db->get();
            //        echo $this->db->last_query();
            $data = $query->result_array();
            return $data;
        }
    }

    public function getConListForTimesheet() {

        $condition = "employee_type = 'C' and is_delete = '0'";
        //$condition = "is_delete = '0'";
        $this->db->select('*');
        $this->db->from('vms_employee_master');
        $this->db->where($condition);
        $this->db->order_by("employee_id", "desc");
       // echo $this->db->last_query();
       // die;
        $query = $this->db->get();
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

    public function getAdminData($id) {

        $condition = "admin_id = '" . $id . "'";
        $this->db->select('*');
        $this->db->from('vms_admin_master');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getAllConsList() {

        $condition = "employee_type = 'C' and is_delete = '0'";
        $this->db->select('*');
        $this->db->from('vms_employee_master');
        $this->db->where($condition);
        $this->db->order_by("employee_id", "desc");
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;

    }

    public function getHistoricalTimesheet($from_date, $to_date, $employee_ids, $timesheet_status) {

        $condition = "employee_id in (" . $employee_ids . ") and status = " . "'" . $timesheet_status . "'" . " and ( period LIKE " . "'" . $from_date[0][0] . "%'" ." OR period LIKE " . "'" . $from_date[0][1] ."%'". " OR period LIKE " . "'" . $from_date[0][2] ."%'". "  OR period LIKE " . "'" . $from_date[0][3] ."%'". "  OR period LIKE " . "'" . $from_date[0][4] ."%'". "  OR period LIKE " . "'" . $from_date[0][5] ."%'". "  OR period LIKE " . "'" . $from_date[0][6] ."%'". ") and ( period LIKE " . "'%" . $to_date[0][0] . "'" . " OR period LIKE " . "'%" . $to_date[0][1] ."'". " OR period LIKE " . "'%" . $to_date[0][2] ."'". " OR period LIKE " . "'%" . $to_date[0][3] ."'". " OR period LIKE " . "'%" . $to_date[0][4] ."'". " OR period LIKE " . "'%" . $to_date[0][5] ."'". " OR period LIKE " . "'%" . $to_date[0][6] ."'". ")" ;
        $this->db->select('*');
        $this->db->from('vms_project_timesheet_period');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function getAdminConsInvoice($from_date, $to_date, $emp_str, $payment_status) {

        if ($payment_status == 'all') {

            $condition = "employee_id in (" . $emp_str . ") and (str_to_date(start_date, '%m/%d/%Y') >= str_to_date('$from_date', '%m/%d/%Y') and str_to_date(end_date, '%m/%d/%Y') <= str_to_date('$to_date', '%m/%d/%Y'))";
        } else {

            $condition = "employee_id in (" . $emp_str . ") and (str_to_date(start_date, '%m/%d/%Y') >= str_to_date('$from_date', '%m/%d/%Y') and str_to_date(end_date, '%m/%d/%Y') <= str_to_date('$to_date', '%m/%d/%Y')) and payment_status = " . $payment_status . "";
        }
        $this->db->select('*');
        $this->db->from('vms_admin_payment_master');
        $this->db->where($condition);
        $this->db->order_by("id", "desc");
        $query = $this->db->get();
      // echo $this->db->last_query();
       // die;
        $data = $query->result_array();
        return $data;
    }

    public function invoice_payment_details($data,$id) {

        $this->db->where('id', $id);
        $this->db->update('vms_admin_payment_master', $data);
//        echo $this->db->last_query();
//        die;

        if ($this->db->affected_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    public function remove_emp_from_project($update_arr, $project_id, $employee_id)
    {
        $condition = "project_id = '" . $project_id . "' and employee_id = '" . $employee_id . "'";
        $this->db->where($condition);
        $this->db->update('vms_assign_projects_to_employee', $update_arr);
//        echo $this->db->last_query();
//        die;

        if ($this->db->affected_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    public function show_company_policy_documents() {

        $condition = "status = '1'";
        $this->db->select('*');
        $this->db->from('vms_company_policy_document');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function insert_company_policy_document($data) {

        $this->db->insert('vms_company_policy_document', $data);
        $last_id = $this->db->insert_id();
        return $last_id;
    }

    public function insert_paid_stuff_document($data) {

        $this->db->insert('vms_employee_paid_stuff', $data);
        $last_id = $this->db->insert_id();
        return $last_id;
    }

    public function insert_w2_document($data) {

        $this->db->insert('vms_employee_w2', $data);
        $last_id = $this->db->insert_id();
        return $last_id;
    }

    public function load_paid_stuff($employee_id) {

        $condition = "employee_id = '" .$employee_id. "' and status = '1'";
        $this->db->select('*');
        $this->db->from('vms_employee_paid_stuff');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function load_w2($employee_id) {

        $condition = "employee_id = '" .$employee_id. "' and status = '1'";
        $this->db->select('*');
        $this->db->from('vms_employee_w2');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

    public function add_consultants_documents($data) {
        if (LATAM || INDIA) {    
            $this->db->insert('vms_consultant_documents', $data);
            $last_id = $this->db->insert_id();
            return $last_id;
        }
    }

    public function send_new_doc_email($emp_type) {
        if (LATAM || INDIA) {
            if($emp_type == 'E') {

            $condition = "vms_employee_master.employee_type = 'E' and vms_employee_login_details.status='1' and vms_employee_login_details.block_status='1' and vms_employee_login_details.is_delete='0'";

            } else if ($emp_type == 'C') {

            $condition = "vms_employee_master.employee_type = 'C' and vms_employee_login_details.status='1' and vms_employee_login_details.block_status='1' and vms_employee_login_details.is_delete='0'";

            } else {

            $condition = "(vms_employee_master.employee_type = 'C'  || vms_employee_master.employee_type = 'E') and vms_employee_login_details.status='1' and vms_employee_login_details.block_status='1' and vms_employee_login_details.is_delete='0'";   

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
    }

    public function getConsultantDocsDetails($id) {
        if (LATAM || INDIA) {
            $condition = "id = '" . $id . "'";
            $this->db->select('*');
            $this->db->from('vms_consultant_documents');
            $this->db->where($condition);
            $query = $this->db->get();
            $data = $query->result_array();
            return $data;
        }
    }

    public function update_cons_emp_docs($data, $id) {
        if (LATAM || INDIA) {
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
    }

    public function insert_requisition($data) {
        if (US || LATAM || INDIA) {
            $this->db->insert('vms_requisition_master', $data);
            $last_id = $this->db->insert_id();
            return $last_id;
        }
    }

    public function get_requisition_list() {
        
        if (US || LATAM || INDIA) {
            //$condition = "NOT status = '0'";
            $this->db->select('*');
            $this->db->from('vms_requisition_master');
            if (US) {
                $this->db->order_by("req_id", "desc");
            }
            // $this->db->where($condition);
            $query = $this->db->get();
            $data = $query->result_array();
            return $data;
        }
    }

    public function get_requisition_data($req_id) {
        
        if (US || INDIA) {
            $condition = "req_id = '" . $req_id . "'";
            $this->db->select('*');
            $this->db->from('vms_requisition_master');
            $this->db->where($condition);
            $query = $this->db->get();
            $data = $query->result_array();
            return $data;
        }
    }

    public function assign_requisition_to_vendor($vendor_tier, $req_id) {
        if (US || INDIA) {
            $condition = "req_id = '" . $req_id . "'";
            $this->db->where($condition);
            $this->db->update('vms_requisition_master', $vendor_tier);

            if ($this->db->affected_rows() > 0) {
                return 1;
            } else {
                return 0;
            }
        }
    }
    
    public function insert_requisition_candidate($data) {
        
        if (US) {
            $this->db->insert('vms_candidate_master', $data);
            $last_id = $this->db->insert_id();
            return $last_id;
        }
        if (LATAM || INDIA) {
            $this->db->insert('vms_requisition_vendors', $data);
        $last_id = $this->db->insert_id();
        return $last_id;
        }
    }

    public function get_requisition_candidate_list($req_id) {
        
        if (US) {
            $condition = "req_id = '" . $req_id . "'";
            $this->db->select('*');
            $this->db->from('vms_candidate_master');
            $this->db->where($condition);
            $query = $this->db->get();
            return $query->result_array();
        }
    }

    public function get_requisition_candidate_details($candidate_id) {
        
        if (US) {
            $condition = "candidate_id = '" . $candidate_id . "'";
            $this->db->select('*');
            $this->db->from('vms_candidate_master');
            $this->db->where($condition);
            $query = $this->db->get();
            return $query->result_array();
        }
    }

    public function insert_historical_approved_work_order($data) {

        $this->db->insert('vms_historical_approved_work_order', $data);
        $last_id = $this->db->insert_id();
        return $last_id;
    }

    public function check_final_approval_date($employee_id, $final_approval_date) {

        $condition = "employee_id = '" . $employee_id . "' AND final_approval_date = '" . $final_approval_date . "'";
        $this->db->select('*');
        $this->db->from('vms_historical_approved_work_order');
        $this->db->where($condition);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;

    }

    public function historical_approved_work_order_list($employee_id) {

        $condition = "employee_id = '" . $employee_id . "'";
        $this->db->select('*');
        $this->db->from('vms_historical_approved_work_order');
        $this->db->where($condition);
        $this->db->order_by('final_approval_date', 'desc');
        $query = $this->db->get();
        return $query->result_array();
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

    public function get_temporary_employee_documents() {
        if (LATAM) {
            $condition = "FIND_IN_SET('" . TEMP_EMP_DOC . "',required_for) > 0";
            $this->db->select('*');
            $this->db->from('vms_consultant_documents');
            $this->db->where($condition);
            $query = $this->db->get();
            $data = $query->result_array();
            return $data;
        }
    }   

    public function get_employee_documents_by_emp_type($employee_type) {
        if (LATAM) {
            $condition = "FIND_IN_SET('" . $employee_type . "',required_for) > 0"; 
            $this->db->select('*');
            $this->db->from('vms_consultant_documents');
            $this->db->where($condition);
            $query = $this->db->get();
            $data = $query->result_array();
            return $data;
        }
    }
    
    /**
     * Copy work order function to create the work order
     */

    // public function copy_work_order($employee_id, $file, $stage, $status) {
    //     // if (!copy(FCPATH.DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.'historical_work_order'.DIRECTORY_SEPARATOR.$file, FCPATH.DIRECTORY_SEPARATOR.'library'.DIRECTORY_SEPARATOR.$file)) {
    //     //     echo "<div class='alert alert-success'>
    //     //         Work Order is copied successfully since it was not complete
    //     //     </div>"; 
    //     // }

    //     $directory_name = './library/';
    //     $file_name = $employee_id . "_work_order_.pdf";

    //     $get_work_details = $this->getWorkDetails($employee_id);
    //     $data['agreement_date'] = date("M d, Y", strtotime($get_work_details[0]['agreement_date']));
    //     $data['cons_start_date'] = date("M d, Y", strtotime($get_work_details[0]['start_date']));
    //     $data['consultant_name'] = $get_work_details[0]['consultant'];
    //     $data['project_duration'] = $get_work_details[0]['project_duration'];
    //     $data['bill_rate'] = $get_work_details[0]['bill_rate'];
    //     $data['ot_rate'] = $get_work_details[0]['ot_rate'];
    //     $data['invoicing_terms'] = $get_work_details[0]['invoicing_terms'];
    //     $data['payment_terms'] = $get_work_details[0]['payment_terms'];

    //     $data['client_name'] = $get_work_details[0]['client_name'];
    //     $data['client_name_str'] = '';
    //     if (empty($get_work_details[0]['client_name'])) {
    //         $data['work_note'] = " ";
    //     } else {
    //         $get_work_note = $this->getWorkNote($get_work_details[0]['client_name']);
    //         $data['work_note'] = $get_work_note[0]['work_order_note'];
    //         $data['client_name_str'] = $get_work_note[0]['client_name'];
    //     }

    //     $data['vendor_poc_name'] = $get_work_details[0]['vendor_poc_name'];
    //     $data['vendor_poc_designation'] = $get_work_details[0]['vendor_poc_designation'];
    //     if (!empty($get_work_details[0]['vendor_signature'])) {
    //         $data['vendor_signature'] = $get_work_details[0]['vendor_signature'];
    //     } else {
    //         $data['vendor_signature'] = " ";
    //     }

    //     if (!empty($get_work_details[0]['vendor_signature_date'])) {
    //         $data['vendor_signature_date'] = date("M d, Y", strtotime($get_work_details[0]['vendor_signature_date']));
    //     } else {
    //         $data['vendor_signature_date'] = " ";
    //     }

    //     $data['asp_name'] = $get_work_details[0]['asp_name'];
    //     $data['asp_designation'] = $get_work_details[0]['asp_designation'];
    //     $data['asp_signature'] = $get_work_details[0]['asp_signature'];
    //     $data['asp_signature_date'] = date("M d, Y", strtotime($get_work_details[0]['asp_signature_date']));

    //     $data['vendor_ip'] = $get_work_details[0]['vendor_ip'];
    //     $data['vendor_id'] = $get_work_details[0]['vendor_id'];
    //     $get_vendor_details = $this->getVendorDtls($get_work_details[0]['vendor_id']);
    //     $data['vendor_company_name'] = $get_vendor_details[0]['vendor_company_name'];

    //     $this->load->library('html2pdf');
    //     $result = $this->load->view('superadmin/wo_pdf_template', $data, true);

    //     $this->html2pdf->html($result);
    //     $this->html2pdf->folder($directory_name);
    //     $this->html2pdf->filename($file_name);
    //     $this->html2pdf->paper('A4', 'portrait');

    //     $this->html2pdf->create('save');
    // }
}
