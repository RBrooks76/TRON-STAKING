<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Manageuser extends Admin_Controller {

	public function index($plan="",$tree_id="") {
		if (empty(admin_id())) { admin_url_redirect('', 'refresh');}
		
		user_access();
		$user_view = $this->config->item('user_view');
		if (!in_array('16', $user_view)) { admin_redirect('admindashboard', 'refresh');}
		
		$data['title']   = 'User Manage';
		$data['plan']    = $plan;
		$data['tree_id'] = $tree_id;
		
		$this->db->order_by('tree_id', 'DESC');
		$records = $this->db->get(USERS)->result();
		if($records[0] && $records[0]->tree_id) $data['top_tree'] = $records[0]->tree_id;
		else $data['top_tree'] = 1;

		$treeDataInfo = $this->db->query('SELECT tree_id FROM `' . P . RL . '` ORDER BY tree_id DESC')->result();
		if(isset($treeDataInfo) && $treeDataInfo[0] && $treeDataInfo[0]->tree_id && $treeDataInfo[0]->tree_id > $data['top_tree']){
			$data['top_tree'] = $treeDataInfo[0]->tree_id;
		}

		$this->view('pages/Manageuser/user_list', $data);
	}
	function changestatus($user_id = '') {
		if (empty(admin_id())) {
			admin_url_redirect('', 'refresh');
		}

		user_access();

		$user_view = $this->config->item('user_view');

		if (!in_array('16', $user_view)) {
			admin_redirect('admindashboard', 'refresh');
		}

		$userid = encrypt_decrypt('decrypt', $user_id);
		$users = FS::Common()->getTableData('users', array('user_id' => $userid), 'consumer_name,status')->row();

		$status = $users->status;

		if ($status == 'active') {
			$newstatus = 'admin_deactive';
			$title = 'deactivated';
		} else {
			$newstatus = 'active';
			$title = 'activated';
		}
		$res = FS::Common()->updateTableData('users', array('user_id' => $userid), array('status' => $newstatus));
		if ($res) {

			$template = array(
				'##ACTION##' => $title,
				'##USERNAME##' => $users->consumer_name,
			);

			$emailaddress = usermail($userid);
			$this->Email_model->sendMail($emailaddress, '', '', 64, $template);

			$msg = $title . ' the user ' . usermail($userid);
			insadminActivity($msg);

			$this->session->set_flashdata('success', 'User status ' . $title . ' successfully');
		} else {
			$this->session->set_flashdata('error', 'Something went wrong!');
		}

		admin_redirect('user', 'refresh');

	}
	function get_users($plan="",$tree_id="") {
		if (empty(admin_id())) {
			admin_url_redirect('', 'refresh');
		}

		user_access();

		$user_view = $this->config->item('user_view');

		if (!in_array('16', $user_view)) {
			admin_redirect('admindashboard', 'refresh');
		}

		$postData = $this->input->post();

		$response = array();
		
		## Read value
		$draw = $postData['draw'];
		$start = $postData['start'];
		$rowperpage = $postData['length']; // Rows display per page
		$columnIndex = $postData['order'][0]['column']; // Column index
		$columnName = $postData['columns'][$columnIndex]['data']; // Column name
		$columnSortOrder = $postData['order'][0]['dir']; // asc or desc
		$searchValue = $postData['search']['value']; // Search value
		
		## Search
		$searchQuery = "";
		if ($searchValue != '') {
			$searchQuery = " (address like '%" . $searchValue . "%' or contract_id like '%" . $searchValue . "%' or affiliate_id like'%" . $searchValue . "%' or current_level like'%" . $searchValue . "%' or tree_id like '%" . $searchValue . "%' ) ";
		}
		
		## Total number of records without filtering
		$this->db->select('count(*) as allcount');
		$this->db->where("plan_id", $plan == 'plana' ? 1 : 2);
		$this->db->where("tree_id", $tree_id );
		$records = $this->db->get(USERS)->result();
		$totalRecords = $records[0]->allcount;
		
		## Total number of record with filtering
		$this->db->select('count(*) as allcount');
		if ($searchQuery != '') {$this->db->where($searchQuery);}
		
		$this->db->where("plan_id", $plan == 'plana' ? 1 : 2);
		$this->db->where("tree_id", $tree_id );
		$records = $this->db->get(USERS)->result();
		$totalRecordwithFilter = $records[0]->allcount;
		
		## Fetch records
		$this->db->select('*');
		if ($searchQuery != '') {$this->db->where($searchQuery);}
		
		$this->db->where("plan_id", $plan == 'plana' ? 1 : 2);
		$this->db->where("tree_id", $tree_id );
		$this->db->order_by($columnName, $columnSortOrder);
		$this->db->limit($rowperpage, $start);
		$records = $this->db->get(USERS)->result();
		$byGroup = $this->group_by('address', $records);

		// echo "<pre>";
		// print_r( $byGroup); die;

		//echo FS::db()->last_query();die;

		$data = array();

		foreach ($byGroup as $key => $record) {

			$count = count($record);

			if ($count == 1) {
				$plan_id = $record[0]->plan_id;
				if ($plan_id == '1') {
					$planA = "YES";
					$planB = "NO";
				} else {
					$planA = "NO";
					$planB = "YES";
				}
				$contract_id = $record[0]->contract_id;
				$affiliate_id = $record[0]->affiliate_id;
			} else {
				$planA = "YES";
				$planB = "YES";
				$u_d = @get_data(USERS, array('address' => $record[0]->address, 'plan_id' => 1, 'tree_id' => $tree_id), 'affiliate_id,contract_id')->row();
				$affiliate_id = $u_d->affiliate_id; // $record[0]->affiliate_id;
				$contract_id = $u_d->contract_id; // $record[0]->affiliate_id;
			}

			$start = $start < 1 ? 1 : $start;
			// foreach($record as $keys => $rec ){

			if (empty($record[0]->ref_status)) {
				$ref_link = '<a href="' . base_url('updateRefStatus') . '/' . insep_encode($record[0]->id) . '" title="Enable Refferal Link"> <i class="fa fa-lock" style="color: red;" title="Enable Refferal Link"> </i></a>';
			} else {
				$ref_link = '<a href="' . base_url('updateRefStatus') . '/' . insep_encode($record[0]->id) . '" title="Disable Refferal Link"> <i class="fa fa-unlock" style="color: green;" title="Disable Refferal Link"> </i></a>';
			}

			$conre_se_status = findCore7($record[0]->contract_id, 1, $record[0]->tree_id);

			$data[] = array(
				"id" => $start,
				"address" => $key,
				"planA" => $planA,
				"planB" => $planB,
				"contract_id" => $contract_id,
				"affiliate_id" => $affiliate_id,
				"ref_link" => $ref_link,
				"ref_id" => $record[0]->ref_id,
				"c_status" => empty($conre_se_status) ? 'No' : 'Yes',
				"tree_id" => $record[0]->tree_id,
				"r_link" => site_url('/refer/plana/' . $record[0]->ref_code) . ' <a data-id="' . site_url('/refer/plana/' . $record[0]->ref_code) . '" href="javascript:;" class="copyToClipboard"> <i class="fa fa-copy"> </i></a>',
			);
			// }
			$start++;
		}

		## Response
		$response = array(
			"draw" => intval($draw),
			"iTotalRecords" => $totalRecords,
			"iTotalDisplayRecords" => $totalRecordwithFilter,
			"aaData" => $data,
		);

		echo json_encode($response);

	}

	function viewuser($user_id = '') {
		if (empty(admin_id())) {
			admin_url_redirect('', 'refresh');
		}

		user_access();

		$user_view = $this->config->item('user_view');

		if (!in_array('16', $user_view)) {
			admin_redirect('admindashboard', 'refresh');
		}

		$user_id = encrypt_decrypt('decrypt', $user_id);
		$data['result'] = FS::Common()->getTableData('users', array('user_id' => $user_id))->row();

		$data['title'] = 'User Manage';

		$this->view('pages/Manageuser/viewusers', $data);

	}

	function adduser() {

		user_access();

		$user_view = $this->config->item('user_view');

		if (!in_array('16', $user_view)) {
			admin_redirect('admindashboard', 'refresh');
		}

		// Is logged in
		$sessionvar = $this->session->userdata('loggedadmin');

		if (!$sessionvar) {
			admin_url_redirect('', 'refresh');
		}

		$this->form_validation->set_rules('ethaddress', 'ETH address', 'required|xss_clean');
		$this->form_validation->set_rules('contactid', 'Contract Id', 'required');
		$this->form_validation->set_rules('addstatus', 'status', 'required|xss_clean');
		$this->form_validation->set_rules('refferalid', 'Refferal ID', 'required|xss_clean');

		if ($this->input->post()) {

			if ($this->form_validation->run()) {

				$insertData = array();

				$ref_code = AlphaNumeric(10);

				$insertData['address'] = escapeString(strip_tags($this->input->post('ethaddress')));

				$insertData['affiliate_id'] = escapeString(strip_tags($this->input->post('contactid')));

				$insertData['status'] = escapeString(strip_tags($this->input->post('addstatus')));

				$insertData['ref_id'] = escapeString(strip_tags($this->input->post('refferalid')));

				$insertData['current_level'] = 1;

				$insertData['ref_code'] = $ref_code;

				$insertData['user_levels'] = $this->getUserLevel();

				$insert = FS::Common()->insertTableData(USERS, $insertData);

				if ($insert) {

					insertUserLevelHistory($insert, $insertData['current_level']);

					FS::session()->set_flashdata('success', 'User has been added successfully!');
					// admin_redirect('user', 'refresh');
					$js = "1";
					$this->session->set_flashdata('js', $js);
					echo "1";

				} else {
					FS::session()->set_flashdata('error', 'Unable to add the new User !');
					$js = "0";
					$this->session->set_flashdata('js', $js);
					echo "0";
					//    admin_redirect('user', 'refresh');
				}

			} else {
				FS::session()->set_flashdata('error', 'Some data are missing!');
				$js = "0";
				$this->session->set_flashdata('js', $js);
				echo "0";
				// admin_redirect('user', 'refresh');
			}

		}
		$data['action'] = base_url() . 'adduser';

		$data['title'] = 'Add User';

		$data['mode'] = 'Add';

		$this->view('pages/Manageuser/adduser', $data);

	}

	public function getUserLevel() {
		$USER_L_P = @get_data(USER_L_P, array('status' => 1), 'id , no_of_days')->result_array();

		if (!empty($USER_L_P)) {
			$user_level = [];

			foreach ($USER_L_P as $key => $value) {

				extract($value);

				if ($id == 1) {
					$start_date = date('Y-m-d H:i:s');

					$end_date = date('Y-m-d H:i:s', strtotime("+" . $no_of_days . " days"));

					$days = $no_of_days;
				} else {
					$start_date = '';

					$end_date = '';

					$days = 0;
				}

				$earned_value = 0;

				$earned_token = 0;

				$user_level[$id] = array("start_date" => $start_date, "end_date" => $end_date, "total_days" => $days, "earned_value" => $earned_value, "earned_token" => $earned_token);

			}

			return serialize($user_level);
		}
	}

	function check_eth() {
		$ethaddress = escapeString(strip_tags($this->input->post('ethaddress')));
		$data = FS::Common()->getTableData(USERS, array('address' => $ethaddress))->num_rows();
		if ($data != 0) {
			echo "false";
		} else {
			echo "true";
		}
	}

	function group_by($key, $data) {
		$result = array();

		foreach ($data as $val) {
			if (isset($val->$key)) {
				$result[$val->$key][] = $val;
			} else {
				$result[""][] = $val;
			}
		}

		return $result;
	}

	function updateRefStatus($id) {
		if (empty(admin_id())) {
			admin_url_redirect('', 'refresh');
		}

		$user_id = insep_decode($id);

		if (!empty($user_id)) {
			$getUserDetails = @get_data(USERS, array('id' => $user_id), 'id,ref_status')->row();

			if (!empty($getUserDetails)) {
				if (empty($getUserDetails->ref_status)) {
					$updateData['ref_status'] = 1;
				} else {
					$updateData['ref_status'] = 0;
				}

				if (update_data(USERS, $updateData, array('id' => $user_id))) {
					FS::session()->set_flashdata('success', 'Refferal Status Updated Successfully !!!');

					admin_redirect('user/plana', 'refresh');
				} else {
					FS::session()->set_flashdata('error', 'Invalid User!');

					admin_redirect('user/plana', 'refresh');
				}
			} else {
				FS::session()->set_flashdata('error', 'Invalid User!');

				admin_redirect('user/plana', 'refresh');
			}
		} else {
			FS::session()->set_flashdata('error', 'Invalid User!');

			admin_redirect('user/plana', 'refresh');
		}

	}

}