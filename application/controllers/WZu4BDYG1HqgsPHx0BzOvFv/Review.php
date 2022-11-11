<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Review extends Admin_Controller {

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


	function reviewmanage() 
	{
		if(empty(admin_id())) 
		{
			admin_url_redirect('', 'refresh');
		}

		user_access();

		$user_view = $this->config->item('user_view');


		if(!in_array('22',$user_view))
		{
			admin_redirect('admindashboard', 'refresh');
		}

			$data['title'] 			= 	'Review';

			$data['review'] 	=	FS::Common()->getTableData(REVIEWS, '', '', '', '', '', '','', array('id', 'DESC'))->result();

			$this->view('pages/Review/reviewmanage', $data);
		
	}


	// Edit page
	function editreview($id='') {

		user_access();

		$user_view = $this->config->item('user_view');

		if(!in_array('22',$user_view))
		{
			admin_redirect('admindashboard', 'refresh');
		}

		// Is logged in
		$sessionvar = $this->session->userdata('loggedadmin');

		if (!$sessionvar) {
			admin_url_redirect('', 'refresh');
		}
		// Is valid
		$review_id = insep_decode($id);
		if ($id == '') {
			FS::session()->set_flashdata('error', 'Invalid request');
			admin_redirect('review', 'refresh');

		}
		$isValid = FS::Common()->getTableData(REVIEWS, array('id' => $review_id));
		if ($isValid->num_rows() == 0) {
			FS::session()->set_flashdata('error', 'Unable to find this page');
			admin_redirect('review', 'refresh');

		}
		// Form validation
		$this->form_validation->set_rules('title', 'title', 'required|xss_clean');
		$this->form_validation->set_rules('url_value', 'url_value', 'required|xss_clean');
		$this->form_validation->set_rules('status', 'status', 'required|xss_clean');
		$this->form_validation->set_rules('language', 'language', 'required|xss_clean');

		if ($this->input->post()) {
			if ($this->form_validation->run()) {

				$updateData = array();
				$new_name = time();
				$config['upload_path'] = 'ajqgzgmedscuoc/img/admin/Review';
				$config['allowed_types'] = 'gif|jpg|png|jpeg';
				$ext = pathinfo($_FILES['review_img']['name'], PATHINFO_EXTENSION);
				$config['file_name'] = $new_name . '.' . $ext;
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				if ($_FILES["review_img"]["name"] != '') {
					if (!$this->upload->do_upload('review_img')) {

						$error = array('error' => $this->upload->display_errors());
						$this->session->set_flashdata('error', $error['error']);
						admin_redirect('banneredit/' . $id, 'refresh');

					} else {
						$d = $this->upload->data();
						if ($config['file_name']) {
							$this->load->library('image_lib');
							$configs['image_library'] = 'gd2';
							$configs['source_image'] = $config['upload_path'] .'/'.  $config['file_name'];
							$configs['maintain_ratio'] = TRUE;
							$configs['width'] = 200;
							$configs['height'] = 200;
							$configs['overwrite'] = TRUE;
							$configs['new_image'] = $config['upload_path'] .'/'.  $config['file_name'];
							$this->image_lib->initialize($configs);
							$this->image_lib->clear();
							$updateData['image'] = $d['file_name'];
						}
					}
				}

				$title = escapeString(strip_tags($this->input->post('title')));
				$url_value = escapeString(strip_tags($this->input->post('url_value')));
				$status = escapeString(strip_tags($this->input->post('status')));
				$language = escapeString(strip_tags($this->input->post('language')));
				$updateData['title'] = $title;
				$updateData['status'] = $status;
				$updateData['url_value'] = $url_value;
				$updateData['updated_at'] =  date('Y-m-d H:i:s');;
				$condition = array('id' => $review_id);
				
				$update = FS::Common()->updateTableData(REVIEWS, $condition, $updateData);
				if ($update) {
					FS::session()->set_flashdata('success', 'Review has been updated successfully!');
					admin_redirect('review', 'refresh');
				} else {
					FS::session()->set_flashdata('error', 'Unable to update this Banner');
					admin_redirect('reviewedit/' . $id, 'refresh');
				}

			} else {
				FS::session()->set_flashdata('error', 'Unable to update this Banner');
				admin_redirect('reviewedit/' . $id, 'refresh');
			}

		}
			$data['action'] 		= 	base_url() . 'editreview';
			
			$data['title'] 			= 	'Edit Review';

			$data['mode'] 			= 	'Edit';

			$data['review'] 	=	FS::Common()->getTableData(REVIEWS, array('id' => $review_id))->row();

			// echo '<pre>';
			// print_r($data['review']);
			// die;
			$data['lang'] 	=	FS::Common()->getTableData(LANG)->result();
			
			$this->view('pages/Review/editreview', $data);
	}



	function deletereview($id) {

		user_access();

		$user_view = $this->config->item('user_view');

		if(!in_array('22',$user_view))
		{
			admin_redirect('admindashboard', 'refresh');
		}

		// Is logged in
		$sessionvar = $this->session->userdata('loggedadmin');

		if (!$sessionvar) {
			admin_url_redirect('', 'refresh');
		}
		// Is valid
		$ban_id = insep_decode($id);

		if ($id == '') {
			$this->session->set_flashdata('error', 'Invalid request');
			admin_redirect('review', 'refresh');
		}
		$isValid = FS::Common()->getTableData(REVIEWS, array('id' => $ban_id))->num_rows();
		if ($isValid > 0) {
			// Check is valid
			$condition = array('id' => $ban_id);
			$delete = FS::Common()->deleteTableData(REVIEWS, $condition);
			
			if ($delete) {
				// True // Delete success
				FS::session()->set_flashdata('success', 'Review deleted successfully');
				admin_redirect('review', 'refresh');
			} else {
				//False
				FS::session()->set_flashdata('error', 'Problem occure with review deletion');
					admin_redirect('review', 'refresh');
			}
		} else {
			FS::session()->set_flashdata('error', 'Unable to find this page');
			admin_redirect('review', 'refresh');
		}
	}


	function addreview() {

		user_access();

		$user_view = $this->config->item('user_view');

		if(!in_array('22',$user_view))
		{
			admin_redirect('admindashboard', 'refresh');
		}

		// Is logged in
		$sessionvar = $this->session->userdata('loggedadmin');

		if (!$sessionvar) {
			admin_url_redirect('', 'refresh');
		}
		// Form validation
		$this->form_validation->set_rules('addtitle', 'question', 'required|xss_clean');
		$this->form_validation->set_rules('addstatus', 'status', 'required|xss_clean');
		
		if ($this->input->post()) {
			if ($this->form_validation->run()) {
				$insertData = array();
				$new_name = time();
				$config['upload_path'] = 'ajqgzgmedscuoc/img/admin/Review';
				$config['allowed_types'] = 'gif|jpg|png|jpeg';
				$ext = pathinfo($_FILES['addreview_img']['name'], PATHINFO_EXTENSION);
				$config['file_name'] = $new_name . '.' . $ext;
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				if ($_FILES["addreview_img"]["name"] != '') {
					if (!$this->upload->do_upload('addreview_img')) {

						$error = array('error' => $this->upload->display_errors());
						$this->session->set_flashdata('error', $error['error']);
						admin_redirect('review', 'refresh');

					} else {
						$d = $this->upload->data();
						if ($config['file_name']) {
							$this->load->library('image_lib');
							$configs['image_library'] = 'gd2';
							$configs['source_image'] = $config['upload_path'] .'/'.  $config['file_name'];
							$configs['maintain_ratio'] = TRUE;
							$configs['width'] = 200;
							$configs['height'] = 200;
							$configs['overwrite'] = TRUE;
							$configs['new_image'] = $config['upload_path'] .'/'.  $config['file_name'];
							$this->image_lib->initialize($configs);
							$this->image_lib->clear();
							$insertData['image'] = $d['file_name'];
						}
					}
				}

				
				$insertData['title'] = escapeString(strip_tags($this->input->post('addtitle')));				
			
				$insertData['status'] = escapeString(strip_tags($this->input->post('addstatus')));
			
				$insertData['created_at'] = strtotime("now");

				
				$insert = FS::Common()->insertTableData(REVIEWS, $insertData);
				if ($insert) {
					FS::session()->set_flashdata('success', 'Review has been added successfully!');
				admin_redirect('review', 'refresh');
				} else {
					FS::session()->set_flashdata('error', 'Unable to add the new review !');
				admin_redirect('review', 'refresh');
				}

			} else {
				FS::session()->set_flashdata('error', 'Some data are missing!');
				admin_redirect('review', 'refresh');
			}

		}
		$data['action'] 		= 	base_url() . 'addreview';
			
		$data['title'] 			= 	'Add Review';

		$data['mode'] 			= 	'Add';

		$data['lang'] 	=	FS::Common()->getTableData(LANG)->result();

		$this->view('pages/Review/editreview', $data);

	}
}