<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Subadmin extends Admin_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	public function index() {
		echo "Gfgf";
	}

	function subadminManage() {

		if (empty(admin_id())) {
			admin_url_redirect('', 'refresh');
		}

		user_access();

		$user_view = $this->config->item('user_view');

		if (!in_array('24', $user_view)) {
			admin_redirect('admindashboard', 'refresh');
		}

		$data['access_user'] = FS::Common()->getTableData(TBL_ACCESS, '', '', '', '', '', '', '', '')->result();

		$data['subadmin'] = FS::Common()->getTableData(ASSIGN, '', '', '', '', '', '', '', '')->result();

		$data['title'] = 'Subadmin Management';

		$this->view('pages/Subadmin/subadminManage', $data);

	}

	// Add
	function addSubadmin() {

		if (empty(admin_id())) {
			admin_url_redirect('', 'refresh');
		}

		user_access();

		$user_view = $this->config->item('user_view');

		if (!in_array('24', $user_view)) {
			admin_redirect('admindashboard', 'refresh');
		}

		// Form validation
		$this->form_validation->set_rules('name', 'name', 'required|xss_clean');
		$this->form_validation->set_rules('email', 'Email Address', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required|xss_clean');

		if ($this->input->post()) {
			/*echo "<pre>";
			print_r($_POST);die;*/
			if ($this->form_validation->run()) {
				$user_access = $this->input->post('access_options');

				if ($user_access != "") {
					$access = json_encode($user_access);

					$email_address = encrypt_decrypt('encrypt', strtolower($this->input->post('email')));

					$user_password = encrypt_decrypt('encrypt', $this->input->post('password'));
					$pattern = '12369';
					$revpattern = strrev($pattern);

					$data = array(
						'type' => '2',
						'admin_name' => $this->input->post('name'),
						'email_id' => $email_address,
						'password' => $user_password,
						'status' => '1',
						'code' => $revpattern,
					);
					if (insert_data(AD, $data)) {
						$user_id = $this->db->insert_id();
						$data = array(
							'user_id' => $user_id,
							'access' => $access,
							'owner_id' => 1,
						);

						if (insert_data(ASSIGN, $data)) {
							$result = $this->db->insert_id();
							if ($result) {

								$copy = getcopyrightext();
								$img_url = base_url() . 'ajqgzgmedscuoc/img/site/' . getSiteLogo();
								$mail = $this->input->post('email');
								$special_vars = array(
									'###USERNAME###' => $this->input->post('email'),
									'###PASSWORD###' => $this->input->post('password'),
									'###PATTERN###' => '12369',
									'###ADMINNAME###' => $this->input->post('name'),
									'###LOGO###' => $img_url,
									'###COPYRIGHT###' => $copy,
								);
								//$send_mail = FS::Emodelo()->stuur_pos($mail, '', '', 2, $special_vars);
 
								/*if(!$send_mail) {
									FS::session()->set_flashdata('error', 'Unable to add admin');
									admin_redirect('subadmin', 'refresh');
								}*/

								$this->session->set_flashdata('success', 'Admin has been inserted successfully');

								admin_redirect('subadmin', 'refresh');
							} else {
								$this->session->set_flashdata('error', 'Unable to add the new admin !');
								admin_redirect('subadminadd', 'refresh');
							}
						}

					}
				} else {
					$this->session->set_flashdata('error', 'Some data are missing!');
					admin_redirect('subadminadd', 'refresh');
				}
			} else {
				$this->session->set_flashdata('error', 'Some data are missing!');
				admin_redirect('subadminadd', 'refresh');
			}

		}

		$data['access_user'] = FS::Common()->getTableData(TBL_ACCESS, '', '', '', '', '', '', '', '')->result();

		$data['action'] = admin_url() . 'subadminadd';
		$data['title'] = 'ADD Subadmin';
		$data['view'] = 'add';
		$this->view('pages/Subadmin/addSudadmin', $data);
	}

	// // Edit page
	function editSubadmin($id) {

		if (empty(admin_id())) {
			admin_url_redirect('', 'refresh');
		}

		user_access();

		$user_view = $this->config->item('user_view');

		if (!in_array('24', $user_view)) {
			admin_redirect('admindashboard', 'refresh');
		}

		// Is valid
		$id1 = insep_decode($id);
		if ($id == '') {
			$this->session->set_flashdata('error', 'Invalid request');
			admin_redirect('subadmin');
		}

		$isValid = FS::Common()->getTableData(ASSIGN, array('priviledge_id' => $id1));
		if ($isValid->num_rows() == 0) {

			$this->session->set_flashdata('error', 'Unable to find this page');
			admin_redirect('subadmin');
		}

		// Form validation

		$this->form_validation->set_rules('name', 'Username', 'required|xss_clean');
		$this->form_validation->set_rules('email', 'Email Address', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required|xss_clean');
		$this->form_validation->set_rules('status', 'status', 'required|xss_clean');

		if ($this->input->post()) {

			if ($this->form_validation->run()) {

				$user_id = $this->input->post('user_id');

				$user_access = $this->input->post('access_options');

				if ($user_access != "") {
					$access = json_encode($user_access);
					/*echo "<pre>";
						print_r($access);
					*/
					$data = array(
						'access' => $access,
					);
					$this->db->where('owner_id', 1);

					$this->db->where('user_id', $user_id);

					$this->db->where('priviledge_id', $id1);
					// echo '<pre>';print_r($data);

					$res = $this->db->update(ASSIGN, $data);
					// echo '<pre>';
					// print_r($this->db->last_query()); die;
					$udata1['admin_name'] = $this->input->post('name');
					$udata1['email_id'] = encrypt_decrypt('encrypt', $this->input->post('email'));
					$udata1['password'] = encrypt_decrypt('encrypt', $this->input->post('password'));
					$udata1['status'] = $this->input->post('status');

					$result = update_data(AD, $udata1, array('id' => $user_id));

					if ($result) {

						$this->session->set_flashdata('success', 'Admin has been Updated successfully');
						admin_redirect('subadmin', 'refresh');
					} else {
						admin_redirect('Subadmin/editSubadmin/' . $id, 'refresh');
					}

				} else {
					$this->session->set_flashdata('error', 'Unable to update this Subadmin');
					admin_redirect('Subadmin/editSubadmin/' . $id, 'refresh');
				}} else {
				$this->session->set_flashdata('error', 'Unable to update this Subadmin');
				admin_redirect('Subadmin/editSubadmin/' . $id, 'refresh');
			}

		}

		$data['res'] = $isValid->row();

		$data['title'] = 'Edit Subadmin';

		$data['access_user'] = FS::Common()->getTableData(TBL_ACCESS, '', '', '', '', '', '', '', '')->result();

		$data['action'] = admin_url() . 'subadminManage/edit/' . $id;

		$this->view('pages/Subadmin/editSudadmin', $data);
	}

	function deleteSubadmin($id) {

		user_access();

		$user_view = $this->config->item('user_view');

		if (!in_array('24', $user_view)) {
			admin_redirect('admindashboard', 'refresh');
		}

		// Is logged in
		$sessionvar = $this->session->userdata('loggedadmin');

		if (!$sessionvar) {
			admin_url_redirect('', 'refresh');
		}
		// Is valid
		$ad_id = insep_decode($id);

		if ($id == '') {
			$this->session->set_flashdata('error', 'Invalid request');
			admin_redirect('subadmin', 'refresh');
		}
		$isValid = FS::Common()->getTableData(ASSIGN, array('priviledge_id' => $ad_id));

		if ($isValid->num_rows() != 0) {

			// Check is valid
			$condition = array('priviledge_id' => $ad_id);
			$delete = FS::Common()->deleteTableData(ASSIGN, $condition);

			$condition = array('id' => $ad_id);
			$delete = FS::Common()->deleteTableData(AD, $condition);

			if ($delete) {
				// True // Delete success
				FS::session()->set_flashdata('success', 'subadmin deleted successfully');
				admin_redirect('subadmin', 'refresh');
			} else {
				//False
				FS::session()->set_flashdata('error', 'Problem occure with subadmin deletion');
				admin_redirect('subadmin', 'refresh');
			}
		} else {
			FS::session()->set_flashdata('error', 'Unable to find this page');
			admin_redirect('subadmin', 'refresh');
		}
	}

	function adduser_email_exists() {

		extract($this->input->post());

		$isValid = FS::Common()->getTableData(AD, array('email_id' => encrypt_decrypt('encrypt', strtolower($email))))->row();

		if ($isValid) {
			if (isset($user_id)) {
				if ($isValid->id != $user_id) {
					echo json_encode(FALSE);
				} else {
					echo json_encode(TRUE);
				}
			} else {
				echo json_encode(FALSE);
			}
		} else {
			echo json_encode(TRUE);
		}
	}

	function edituser_email_exists() {

		extract($this->input->post());

		$isValid = FS::Common()->getTableData(AD, array('email_id ' => encrypt_decrypt('encrypt', strtolower($email)), 'id !=' => insep_decode($id)))->row();
		if ($isValid) {
			if (isset($user_id)) {
				if ($isValid->id != $user_id) {
					echo json_encode(FALSE);
				} else {
					echo json_encode(TRUE);
				}
			} else {
				echo json_encode(FALSE);
			}
		} else {
			echo json_encode(TRUE);
		}
	}

}