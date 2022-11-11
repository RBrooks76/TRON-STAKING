<?php
class Common extends CI_Model {
	// Constructor
	function __construct() {
		parent::__construct();
	}
	/**
	 * INSERT data into table model
	 *
	 * @access Public
	 * @param $tableName - Name of the table(required)
	 * @param $data - Specifies the insert data(required)
	 * @return Last insert ID
	 */
	public function insertTableData($tableName = '', $data = array()) {
		$this->db->insert($tableName, $data);
		return $this->db->insert_id();
	}
	/**
	 * DELETE data from table
	 *
	 * @access Public
	 * @param $tableName - Name of the table(required)
	 * @param $where - Specifies the which row will be delete(optional)
	 * @return Affected rows
	 */
	public function deleteTableData($tableName = '', $where = array()) {
		if ((is_array($where)) && (count($where) > 0)) {
			$this->db->where($where);
		}
		$this->db->delete($tableName);
		return $this->db->affected_rows();
	}
	/**
	 * UPDATE data to table
	 *
	 * @access Public
	 * @param $tableName - Name of the table(required)
	 * @param $where - Specifies the where to update(optional)
	 * @param $data - Modified data(required)
	 * @return Affected rows
	 */
	public function updateTableData($tableName = '', $where = array(), $data = array()){
		if ((is_array($where)) && (count($where) > 0)) {
			$this->db->where($where);
		}
		return $this->db->update($tableName, $data);

	}
	/**
	 * SELECT data from table
	 *
	 * @access Public
	 * @param $tableName - Name of the table(required)
	 * @param $where - Specifies the where to update(optional)
	 * @param $data - Modified data(required)
	 * @return Affected rows
	 */
	public function getTableData($tableName = '', $where = array(), $selectFields = '', $like = array(), $where_or = array(), $like_or = array(), $offset = '', $limit = '', $orderBy = array(), $groupBy = array(), $where_not = array(), $where_in = array()) {
		// WHERE AND conditions
		if ((is_array($where)) && (count($where) > 0)) {
			$this->db->where($where);
		}
		// WHERE NOT conditions
		if ((is_array($where_not)) && (count($where_not) > 0)) {
			$this->db->where_not_in($where_not[0], $where_not[1]);
		}
		// WHERE IN conditions
		if ((is_array($where_in)) && (count($where_in) > 0)) {
			$this->db->where_in($where_in[0], $where_in[1]);
		}
		// WHERE OR conditions
		if ((is_array($where_or)) && (count($where_or) > 0)) {
			$this->db->or_where($where_or);
		}
		//LIKE AND
		if ((is_array($like)) && (count($like) > 0)) {
			$this->db->like($like);
		}
		//LIKE OR
		if ((is_array($like_or)) && (count($like_or) > 0)) {
			$this->db->or_like($like_or);
		}
		//SELECT fields
		if ($selectFields != '') {
			$this->db->select($selectFields);
		}
		//Group By
		if (is_array($groupBy) && (count($groupBy) > 0)) {
			$this->db->group_by($groupBy);
		}
		//Order By
		if (is_array($orderBy) && (count($orderBy) > 0)) {
			if (count($orderBy) > 2) {
				$this->db->order_by($orderBy[0] . ' ' . $orderBy[1] . ',' . $orderBy[2] . ' ' . $orderBy[3]);
			} else {
				$this->db->order_by($orderBy[0], $orderBy[1]);
			}
		}
		//OFFSET with LIMIT
		if ($limit != '' && $offset != '') {
			$this->db->limit($limit, $offset);
		}
		// LIMIT
		if ($limit != '') {
			$this->db->limit($limit);
		}

		return $this->db->get($tableName);
	}
	/**
	 * CUSTOM SQL query
	 *
	 * @access Public
	 * @param SQL query
	 * @return Response
	 */
	public function customQuery($query) {
		return $this->db->query($query);
	}

	//select records from joined tables
	public function getJoinedTableData($tableName = '', $joins = array(), $where = array(), $selectFields = '', $like = array(), $where_or = array(), $like_or = array(), $offset = '', $limit = '', $orderBy = array(), $group_by = array()) {

		$this->db->from($tableName);
		//join tables list
		if ((is_array($joins)) && (count($joins) > 0)) {
			foreach ($joins as $jointb => $joinON) {
				$this->db->join($jointb, $joinON);
			}
		}
		// WHERE AND conditions
		if ((is_array($where)) && (count($where) > 0)) {
			$this->db->where($where);
		}
		// WHERE OR conditions
		if ((is_array($where_or)) && (count($where_or) > 0)) {
			$this->db->or_where($where_or);
		}
		//LIKE AND
		if ((is_array($like)) && (count($like) > 0)) {
			$this->db->like($like);
		}
		//LIKE OR
		if ((is_array($like_or)) && (count($like_or) > 0)) {
			$this->db->or_like($like_or);
		}
		//SELECT fields
		if ($selectFields != '') {
			$this->db->select($selectFields, false);
		}
		//Order By
		if (is_array($orderBy) && (count($orderBy) > 0)) {
			$this->db->order_by($orderBy[0], $orderBy[1]);
		}
		//Group By
		if (is_array($group_by) && (count($group_by) > 0)) {
			$this->db->group_by($group_by[0]);
		}
		//OFFSET with LIMIT
		if ($limit != '' && $offset != '') {
			$this->db->limit($limit, $offset);
		}
		// LIMIT
		if ($limit != '' && $offset == '') {
			$this->db->limit($limit);
		}
		return $this->db->get();
	}

	public function getTableDatas($tableName = '', $where = array(), $selectFields = '', $like = array(), $where_or = array(), $like_or = array(), $offset = '', $limit = '', $orderBy = array(), $groupBy = array(), $where_not = array(), $where_in = array()) {
		// WHERE AND conditions
		if ((is_array($where)) && (count($where) > 0)) {
			$this->db->where($where);
		}
		// WHERE NOT conditions
		if ((is_array($where_not)) && (count($where_not) > 0)) {
			$this->db->where_not_in($where_not[0], $where_not[1]);
		}
		// WHERE IN conditions
		if ((is_array($where_in)) && (count($where_in) > 0)) {
			$this->db->where_in($where_in[0], $where_in[1]);
		}
		// WHERE OR conditions
		if ((is_array($where_or)) && (count($where_or) > 0)) {
			$this->db->or_where($where_or);
		}
		//LIKE AND
		$this->db->group_start();
		if ((is_array($like)) && (count($like) > 0)) {
			$this->db->like($like);
		}
		//LIKE OR
		if ((is_array($like_or)) && (count($like_or) > 0)) {
			$this->db->or_like($like_or);
		}
		$this->db->group_end();
		//SELECT fields
		if ($selectFields != '') {
			$this->db->select($selectFields);
		}
		//Group By
		if (is_array($groupBy) && (count($groupBy) > 0)) {
			$this->db->group_by($groupBy[0]);
		}
		//Order By
		if (is_array($orderBy) && (count($orderBy) > 0)) {
			if (count($orderBy) > 2) {
				$this->db->order_by($orderBy[0] . ' ' . $orderBy[1] . ',' . $orderBy[2] . ' ' . $orderBy[3]);
			} else {
				$this->db->order_by($orderBy[0], $orderBy[1]);
			}
		}
		//OFFSET with LIMIT
		if ($limit != '' && $offset != '') {
			$this->db->limit($limit, $offset);
		}
		// LIMIT
		if ($limit != '' && $offset == '') {
			$this->db->limit($limit);
		}

		return $this->db->get($tableName);
	}

	public function getJoinedTableDatas($tableName = '', $joins = array(), $where = array(), $selectFields = '', $like = array(), $where_or = array(), $like_or = array(), $offset = '', $limit = '', $orderBy = array(), $group_by = array()) {

		$this->db->from($tableName);
		//join tables list
		if ((is_array($joins)) && (count($joins) > 0)) {
			foreach ($joins as $jointb => $joinON) {
				$this->db->join($jointb, $joinON);
			}
		}

		// WHERE AND conditions
		if ((is_array($where)) && (count($where) > 0)) {
			$this->db->where($where);
		}
		// WHERE OR conditions
		if ((is_array($where_or)) && (count($where_or) > 0)) {
			$this->db->or_where($where_or);
		}
		//LIKE AND
		$this->db->group_start();
		if ((is_array($like)) && (count($like) > 0)) {
			$this->db->like($like);
		}
		//LIKE OR
		if ((is_array($like_or)) && (count($like_or) > 0)) {
			$this->db->or_like($like_or);
		}
		$this->db->group_end();
		//SELECT fields
		if ($selectFields != '') {
			$this->db->select($selectFields, false);
		}
		//Order By
		if (is_array($orderBy) && (count($orderBy) > 0)) {
			$this->db->order_by($orderBy[0], $orderBy[1]);
		}

		//Group By
		if (is_array($group_by) && (count($group_by) > 0)) {
			$this->db->group_by($group_by[0]);
		}
		//OFFSET with LIMIT
		if ($limit != '' && $offset != '') {
			$this->db->limit($limit, $offset);
		}
		// LIMIT
		if ($limit != '' && $offset == '') {
			$this->db->limit($limit);
		}
		return $this->db->get();

	}

	//select records from joined tables
	public function getleftJoinedTableData($tableName = '', $joins = array(), $where = array(), $selectFields = '', $like = array(), $where_or = array(), $like_or = array(), $offset = '', $limit = '', $orderBy = array(), $group_by = array(), $where_in = array()) {

		$this->db->from($tableName);
		//join tables list
		if ((is_array($joins)) && (count($joins) > 0)) {
			foreach ($joins as $jointb => $joinON) {
				$this->db->join($jointb, $joinON, 'LEFT');
			}
		}

		// WHERE AND conditions
		if ((is_array($where)) && (count($where) > 0)) {
			$this->db->where($where);
		}
		// WHERE IN conditions
		if ((is_array($where_in)) && (count($where_in) > 0)) {
			$this->db->where_in($where_in[0], $where_in[1]);
		}
		// WHERE OR conditions
		if ((is_array($where_or)) && (count($where_or) > 0)) {
			$this->db->or_where($where_or);
		}
		//LIKE AND
		if ((is_array($like)) && (count($like) > 0)) {
			$this->db->like($like);
		}
		//LIKE OR
		if ((is_array($like_or)) && (count($like_or) > 0)) {
			$this->db->or_like($like_or);
		}
		//SELECT fields
		if ($selectFields != '') {
			$this->db->select($selectFields);
		}
		//Order By
		if (is_array($orderBy) && (count($orderBy) > 0)) {
			if (count($orderBy) > 2) {
				$this->db->order_by($orderBy[0] . ' ' . $orderBy[1] . ',' . $orderBy[2] . ' ' . $orderBy[3]);
			} else {
				$this->db->order_by($orderBy[0], $orderBy[1]);
			}
		}
		//Group By
		if (is_array($group_by) && (count($group_by) > 0)) {
			$this->db->group_by($group_by[0]);
		}
		//OFFSET with LIMIT
		if ($limit != '' && $offset != '') {
			$this->db->limit($limit, $offset);
		}
		// LIMIT
		if ($limit != '' && $offset == '') {
			$this->db->limit($limit);
		}

		return $this->db->get();

	}
	
	function last_activity($activity, $id = '0', $type = '') {
		$date = gmdate(time());
		$ip_address = $_SERVER['REMOTE_ADDR'];
		$session_data = array(
			'last_ip_address' => $ip_address,
			'last_login_date' => $date,
		);
		$this->session->set_userdata($session_data);
		$data = array('date' => $date,
			'ip_address' => $ip_address,
			'activity' => $activity,
			'browser_name' => getBrowser(),
			'os_name' => getOS(),
			'type' => $type,
			'user_id' => $id);
		$this->insertTableData(USACT, $data);
	}
	function sitevisits() {
		$browser_name = getBrowser();
		$ip_address = $_SERVER['REMOTE_ADDR'];
		$date = date('Y-m-d');
		$insertData = array('ip_address' => $ip_address, 'browser' => $browser_name, 'date_added' => $date);
		$already = $this->getTableData('site_visits', $insertData);
		if ($already->num_rows() == 0) {
			$this->insertTableData('site_visits', $insertData);
		}
	}
}

/*
 * End of the file common_model.php
 * Location: application/models/common_model.php
 */