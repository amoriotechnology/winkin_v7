<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Common_model extends CI_Model {
	public function __construct() {
		parent::__construct();
	}
	public function InsertData($table, $values) {
		$this->db->insert($table, $values);
		return $this->db->insert_id();
	}
	public function InsertBatchData($table, $values) {
    	$res = $this->db->insert_batch($table, $values);
    	return ($res) ? 1 : 0;
    }
	public function GetDatas($table, $select, $where = NULL, $orderby = NULL, $groupby = NULL) { /* order_by = "`column_name` ASC" */
		$query = $this->db->select($select)->from($table);
		(!empty($where)) ? $query->where($where) : $query;
		(!empty($groupby)) ? $query->group_by($groupby) : $query;
		(!empty($orderby)) ? $query->order_by($orderby) : $query;
		return $query->get()->result_array();
	}
	public function PaginationData($table, $select, $where = NULL, $orderby, $limit = 10, $start = 0, $search = NULL, $col_where = NULL) {
		$query = $this->db->select($select)->from($table);
		(!empty($where)) ? $query->where($where) : $query;
		(!empty($col_where)) ? $query->where($col_where) : $query;
		if (!empty($search)) {
	        $query->group_start();
	        $query->or_like($search);
	        $query->group_end();
	    }		
		return $query->limit($limit, $start)->order_by($orderby)->get()->result_array();
	}
	public function UpdateData($table, $values, $where) {
		$this->db->set($values)->where($where)->update($table);
		return ($this->db->affected_rows() > 0) ? 1 : 0;
	}
	public function UpdateBatchData($table, $values, $where) {
		$this->db->update_batch($table, $values, $where);
		return ($this->db->affected_rows() > 0) ? 1 : 0;
	}
	public function GetJoinDatas($table1, $table2, $joincond, $select, $where = NULL, $wherein = NULL,$groupby = NULL,$whereNotIn = NULL) {
        $query = $this->db->select($select)->from($table1);
        $query->join($table2, $joincond);
        (!empty($groupby)) ? $query->group_by($groupby) : $query;
        (!empty($where)) ? $query->where($where) : $query;
        (!empty($wherein)) ? $query->where_in($wherein) : $query;
		if (! empty($whereNotIn)) {
		foreach ($whereNotIn as $column => $values) {
			$query->where_not_in($column, $values);
		}
        }
        return $query->get()->result_array();
    }

    public function GetJoinDatasThreeTable($table1, $table2, $table3, $joincond1, $joincond2, $select, $where = NULL, $wherein = NULL, $groupby = NULL,$whereNotIn = NULL) {
		$query = $this->db->select($select)->from($table1);
		$query->join($table2, $joincond1);
		$query->join($table3, $joincond2);
		(!empty($groupby)) ? $query->group_by($groupby) : $query;
		(!empty($where)) ? $query->where($where) : $query;
		(!empty($wherein)) ? $query->where_in($wherein) : $query;
		if (! empty($whereNotIn)) {
		foreach ($whereNotIn as $column => $values) {
			$query->where_not_in($column, $values);
		}
        }
		return $query->get()->result_array();
    }

   public function getCount($table, $where = NULL, $search = NULL, $select = "*", $col_where = NULL ) {
        $query = $this->db->select($select)->from($table);
        (!empty($where)) ? $query->where($where) : $query;
        (!empty($col_where)) ? $query->where($col_where) : $query;
        if (!empty($search)) {
	        $query->group_start();
	        $query->or_like($search);
	        $query->group_end();
	    }
		return $query->count_all_results();
    }
    public function DeleteData($table, $where) {
        $this->db->where($where)->delete($table);
		return ($this->db->affected_rows() > 0) ? 1 : 0;
    }
    public function getAppointment($table1, $table2, $table3, $table4, $table5, $table1cond, $table2cond, $table3cond, $table4cond, $select, $orderby, $limit, $start, $search = '', $where='') {
        $this->db->select($select)
                 ->from($table1)
                 ->join($table2, $table1cond, 'left')
                 ->join($table3, $table2cond, 'left')
                 ->join($table4, $table3cond, 'left')
                 ->join($table5, $table4cond, 'left');
        if (!empty($search)) {
            $this->db->group_start();
            $columns = ['fld_appointid', 'fld_name', 'fld_phone', 'fld_astaffid', 'fld_aserv', 'fld_astatus', 'fld_abalance', 'fld_apaymode', 'fld_arate'];
            foreach ($columns as $column) {
                $this->db->or_like($column, $search);
            }
            $this->db->group_end();
        }
        $this->db->limit($limit, $start);
        if (!empty($orderby)) { $this->db->order_by($orderby); }
        return $this->db->get()->result_array();
    }
    public function getBookings($table1, $table2, $table3, $table1cond, $table2cond, $select, $orderby, $limit, $start, $search = '', $where='') 
    {
	    $this->db->select($select)->from($table1)->join($table2, $table1cond, 'left')->join($table3, $table2cond, 'left');
	    if (!empty($search)) {
	        $this->db->group_start();
	        $columns = ['A.fld_appointid', 'C.fld_name', 'C.fld_phone', 'A.fld_astaffid', 'A.fld_aserv', 'A.fld_astatus', 'A.fld_abalance','A.fld_atime', 'A.fld_apaymode', 'A.fld_arate'];
	        foreach ($columns as $column) {
	            $this->db->or_like($column, $search);
	        }
	        $this->db->group_end();
	    }
	    if (!empty($where)) {
	        $this->db->where($where);
	    }
	    $this->db->limit($limit, $start);
	    if (!empty($orderby)) {
	        $this->db->order_by($orderby);
	    }
	    return $this->db->get()->result_array();
	}
    public function getLogs($table1,$select, $orderby, $limit, $start, $search = '', $where='') {
        $this->db->select($select)->from($table1);
        if (!empty($search)) {
            $this->db->group_start();
            $columns = ['id', 'c_date', 'c_time', 'username', 'module', 'details'];
            foreach ($columns as $column) {
                $this->db->or_like($column, $search);
            }
            $this->db->group_end();
        }
        if (!empty($where)) {
	        $this->db->where($where);
	    }
        $this->db->limit($limit, $start);
        if (!empty($orderby)) { $this->db->order_by($orderby); }
        return $this->db->get()->result_array();
    }
    public function getCourtData($table1, $table2, $table3, $table4, $table1cond, $table2cond, $table3cond, $select, $orderby, $limit, $start, $search = '', $where= NULL) {
        $this->db->select($select)->from($table1)
                 ->join($table2, $table1cond, 'LEFT')
                 ->join($table3, $table2cond, 'LEFT')
                 ->join($table4, $table3cond, 'LEFT');
        if (!empty($search)) {
            $this->db->group_start();
            $columns = ['fld_appointid', 'fld_name', 'fld_phone', 'fld_astaffid', 'fld_aserv', 'fld_astatus', 'fld_abalance', 'fld_apaymode', 'fld_arate'];
            foreach ($columns as $column) {
                $this->db->or_like($column, $search);
            }
            $this->db->group_end();
        }
        if(!empty($where)) { $this->db->where($where); }
        $this->db->limit($limit, $start);
        if (!empty($orderby)) { $this->db->order_by($orderby); }
        return $this->db->get()->result_array();
    }
    public function getRevenue($table1, $table2, $table3, $table1cond, $table2cond, $select, $orderby, $limit, $start, $search = '', $where = NULL,$whereNotIn = NULL) {
        $this->db->select($select)->from($table1)->join($table2, $table1cond, 'left')->join($table3, $table2cond, 'left');
        if (!empty($search)) {
            $this->db->group_start();
            $columns = ['fld_appointid', 'fld_name', 'fld_phone', 'fld_adate', 'fld_arate', 'fld_abalance', 'fld_ppaid', 'fld_aid'];
            foreach ($columns as $column) {
                $this->db->or_like($column, $search);
            }
            $this->db->group_end();
        }
        if(!empty($where)) { $this->db->where($where); }
        if (! empty($whereNotIn)) {
		foreach ($whereNotIn as $column => $values) {
			$query->where_not_in($column, $values);
		}
        }
        $this->db->limit($limit, $start);
        if (!empty($orderby)) { $this->db->order_by($orderby); }
        return $this->db->get()->result_array();
    }
    public function getRazorpay($table1, $table2, $table3, $table1cond, $table2cond, $select, $orderby, $limit, $start, $search = '', $where = NULL,$whereNotIn = NULL) {
        $this->db->select($select)->from($table1)->join($table2, $table1cond, 'left')->join($table3, $table2cond, 'left');
        if (!empty(trim($search))) {
        	$search = trim($search);
            $this->db->group_start();
            $columns = ['DATE_FORMAT(A.fld_booked_date, "%d/%m/%Y")', 'DATE_FORMAT(P.fld_pdate, "%d/%m/%Y")', 'A.fld_appointid', 'C.fld_name', 'C.fld_phone', 'P.fld_pamt', 'A.fld_payment_id', 'P.fld_phistory','A.fld_apaystatus','A.fld_astatus'];
            foreach ($columns as $column) {
                $this->db->or_like($column, $search);
            }
            $this->db->group_end();
        }
        if(!empty($where)) { $this->db->where($where); }
        if (! empty($whereNotIn)) {
		foreach ($whereNotIn as $column => $values) {
			$query->where_not_in($column, $values);
		}
        }
        $this->db->limit($limit, $start);
        if (!empty($orderby)) { $this->db->order_by($orderby); }
        return $this->db->get()->result_array();
    }
    public function GetJoinDatasThreeTableRazorpay($table1, $table2, $table3, $joincond1, $joincond2, $select, $where = NULL, $groupby = NULL) {
		$query = $this->db->select($select)->from($table1);
		$query->join($table2, $joincond1);
		$query->join($table3, $joincond2);
		(!empty($groupby)) ? $query->group_by($groupby) : $query;
		(!empty($where)) ? $query->where($where) : $query;
		(!empty($wherein)) ? $query->where_in($wherein) : $query;
		return $query->get()->result_array();
    }
    public function getLikeDatas($table, $select, $where = NULL, $like) {
    	$query = $this->db->select($select)->from($table);
    	if(is_array($like)) {
    		$query->group_start();
    		foreach($like as $columname => $values) {
    			if(is_array($values)) {
	    			foreach($values as $val) {
	    				$query->or_like($columname, $val);
	    			}
	    		} else {
	    			$query->or_like($columname, $values);
	    		}
    		}
    		$query->group_end();
    	} else {
    		$query->group_start();
    		$query->or_like($like);
    		$query->group_end();
    	}
    	(!empty($where)) ? $query->where($where) : $query;
    	return $query->get()->result_array();
    }
    public function getBookingData() 
	{
	    $this->db->select("MONTH(fld_adate) as month, COUNT(fld_appointid) as count");
	    $this->db->from("appointments");
	    $this->db->where("YEAR(fld_adate)", date("Y")); 
	    $this->db->where("fld_astatus !=",'Cancelled');
		$this->db->where("fld_astatus !=", 'Pending'); 
	    $this->db->where("fld_atype IS NULL", null, false);
	    $this->db->group_by("MONTH(fld_adate)");
	    $this->db->order_by("MONTH(fld_adate)", "ASC");
	    $query = $this->db->get();
	    $result = $query->result_array();
	    $monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
	    $monthlyData = array_fill_keys($monthNames, 0);
	    foreach ($result as $row) {
	        $monthIndex = (int) $row['month'] - 1;
	        $monthlyData[$monthNames[$monthIndex]] = (int) $row['count'];
	    }
	    $formattedData = [];
	    foreach ($monthlyData as $month => $count) {
	        $formattedData[] = [$month, $count];
	    }
	    return $formattedData;
	}
	public function getPaymentsSummary() 
	{
	    $start_date = date('Y-m-d 00:00:00'); 
        $end_date = date('Y-m-d 23:59:59');  
	    $this->db->select('fld_apaymode, SUM(fld_arate) as total_amount');
	    $this->db->from('appointments');
	    $this->db->where('fld_booked_date >=', $start_date);
        $this->db->where('fld_booked_date <=', $end_date); 
	    $this->db->group_by('fld_apaymode'); 
	    $query = $this->db->get(); 
	    return $query->result_array();
	}
	public function check_opening_balance() 
	{
	    $date = date('Y-m-d'); 
	    $this->db->select('fld_opening_balance');
	    $this->db->from('day_close');
	    $this->db->where('fld_date', $date); 
	    $query = $this->db->get();
	    return ($query->num_rows() > 0);
	}
	public function opening_balance()
	{
	    $date = date('Y-m-d');
	    $this->db->select('fld_opening_balance');
	    $this->db->from('day_close');
	    $this->db->where('fld_date', $date);
	    $query = $this->db->get();
	    return $query->result_array();
	}
	// Check Status
	public function check_dayclose_status()
	{
	    $date = date('Y-m-d');
	    $this->db->select('*');
	    $this->db->from('day_close');
	    $this->db->where('fld_date', $date);
	    $query = $this->db->get();
	    return $query->result_array();
	}
	public function getDayClose($table1, $select, $orderby, $limit, $start, $search = '', $where = NULL) {
        $this->db->select($select)->from($table1);
        if (!empty($search)) {
            $this->db->group_start();
            $columns = ['fld_date', 'fld_opening_balance', 'fld_closing_balance', 'fld_id'];
            foreach ($columns as $column) {
                $this->db->or_like($column, $search);
            }
            $this->db->group_end();
        }
        if(!empty($where)) { $this->db->where($where); }
        $this->db->limit($limit, $start);
        if (!empty($orderby)) { $this->db->order_by($orderby); }
        return $this->db->get()->result_array();
    }
    public function totalBookingCount()
	{
	    $this->db->select("COUNT(fld_appointid) as count");
	    $this->db->from("appointments");
	    $this->db->where("YEAR(fld_adate)", date("Y"));
	    $this->db->where("fld_astatus !=",'Cancelled');
		$this->db->where("fld_astatus !=", 'Pending'); 
	    $this->db->where("fld_atype IS NULL", null, false);
	    $query = $this->db->get();
	    return $query->row()->count;
	}
	public function getAppointmentDetails($appointId) 
	{
	    $this->db->select('a.*, b.*, c.*');
	    $this->db->from('appointments a');
	    $this->db->join('appointment_meta b', 'b.fld_amappid = a.fld_aid');
	    $this->db->join('customers c', 'c.fld_id = a.fld_acustid');
	    $this->db->where('a.fld_appointid', $appointId);
	    $query = $this->db->get();
	    return $query->row_array(); 
	}
	public function isTimeSlotBooked($court, $date, $timeSlots) 
	{
	    $timeSlotsJson = json_encode($timeSlots);
	    $this->db->where('fld_aserv', $court);
	    $this->db->where('fld_adate', $date);
	    $this->db->where("JSON_CONTAINS(fld_atime, '$timeSlotsJson')"); 
	    $query = $this->db->get('appointments');
	    return $query->num_rows() > 0; 
	}
    public function RawSQL($query) {
    	return $this->db->query($query)->result_array();
    }
}