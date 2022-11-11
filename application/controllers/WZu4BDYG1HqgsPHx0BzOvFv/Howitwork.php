<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Howitwork extends Admin_Controller {

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

	public function index()
	{
		echo "Gfgf";
	}


	function howitworks() 
	{

		if(empty(admin_id())) 
		{
			admin_url_redirect('', 'refresh');
		}

		user_access();

		$user_view = $this->config->item('user_view');


		if(!in_array('9',$user_view))
		{
			admin_redirect('admindashboard', 'refresh');
		}

			$data['title'] 			= 	'CMS Manage';

			$data['work'] 	=	FS::Common()->getTableData(HOW_WORK, '', '', '', '', '', '','', array('id', 'ASC'))->result();				
			
			$this->view('pages/Howitworks/workmanage', $data);
		
	}


	// Edit page
	function edithowitwork($id='') {


		user_access();

		$user_view = $this->config->item('user_view');

		if(!in_array('9',$user_view))
		{
			admin_redirect('admindashboard', 'refresh');
		}

		// Is logged in
		$sessionvar = $this->session->userdata('loggedadmin');

		if (!$sessionvar) {
			admin_url_redirect('', 'refresh');
		}
		// Is valid
		$work_id = insep_decode($id);
		if ($id == '') {
			FS::session()->set_flashdata('error', 'Invalid request');
			admin_redirect('howitwork', 'refresh');

		}
		$isValid = FS::Common()->getTableData(HOW_WORK, array('id' => $work_id));
		if ($isValid->num_rows() == 0) {
			FS::session()->set_flashdata('error', 'Unable to find this page');
			admin_redirect('howitwork', 'refresh');

		}
		// Form validation
		$this->form_validation->set_rules('heading', 'heading', 'required|xss_clean');
		$this->form_validation->set_rules('content', 'content', 'required|xss_clean');
		$this->form_validation->set_rules('long_content', 'long_content', 'required|xss_clean');
		$this->form_validation->set_rules('language', 'language', 'required|xss_clean');
		
		if ($this->input->post()) {
			if ($this->form_validation->run()) {

				$updateData = array();
				$heading = $this->input->post('heading');
				$content = $this->input->post('content');
				$long_content = $this->input->post('long_content');
				$language = $this->input->post('language');
				$updateData['heading'] = $heading;
				$updateData['content'] = $content;
				$updateData['long_content'] = $long_content;
				$updateData['language'] = $language;
				$condition = array('id' => $work_id);
				
				
				$update = FS::Common()->updateTableData(HOW_WORK, $condition, $updateData);

				//print_r($this->db->last_query()); die;
				if ($update) {
					FS::session()->set_flashdata('success', 'How everything Work has been updated successfully!');
					admin_redirect('howitwork', 'refresh');
				} else {
					FS::session()->set_flashdata('error', 'Unable to update this How everything Work');
					admin_redirect('howitworkedit/' . $id, 'refresh');
				}

			} else {
				FS::session()->set_flashdata('error', 'Unable to update this How everything Work');
				admin_redirect('howitworkedit/' . $id, 'refresh');
			}

		}
			$data['action'] 		= 	base_url() . 'howitworkedit';
			
			$data['title'] 			= 	'Edit Work';

			$data['howwork'] 	=	FS::Common()->getTableData(HOW_WORK, array('id' => $work_id))->row();

			$data['lang'] 	=	FS::Common()->getTableData(LANG)->result();

			$this->view('pages/Howitworks/editwork', $data);
	}


	function whychoose() 
	{

		if(empty(admin_id())) 
		{
			admin_url_redirect('', 'refresh');
		}

		user_access();

		$user_view = $this->config->item('user_view');


		if(!in_array('21',$user_view))
		{
			admin_redirect('admindashboard', 'refresh');
		}

			$data['title'] 			= 	'WHYCHOOSE Manage';

			$data['why'] 	=	FS::Common()->getTableData(WHYCHOOSE, '', '', '', '', '', '','', array('id', 'DESC'))->result();				
			
			$this->view('pages/Whychoose/whymanage', $data);
		
	}


	// Edit page
	function editWhychoose($id='') {


		user_access();

		$user_view = $this->config->item('user_view');

		if(!in_array('21',$user_view))
		{
			admin_redirect('admindashboard', 'refresh');
		}

		// Is logged in
		$sessionvar = $this->session->userdata('loggedadmin');

		if (!$sessionvar) {
			admin_url_redirect('', 'refresh');
		}
		// Is valid
		$work_id = insep_decode($id);
		if ($id == '') {
			FS::session()->set_flashdata('error', 'Invalid request');
			admin_redirect('howitwork', 'refresh');

		}
		$isValid = FS::Common()->getTableData(WHYCHOOSE, array('id' => $work_id));
		if ($isValid->num_rows() == 0) {
			FS::session()->set_flashdata('error', 'Unable to find this page');
			admin_redirect('howitwork', 'refresh');

		}
		// Form validation
		$this->form_validation->set_rules('heading', 'heading', 'required|xss_clean');
		$this->form_validation->set_rules('language', 'language', 'required|xss_clean');


		
		if ($this->input->post()) {
			if ($this->form_validation->run()) {

				$updateData = array();
				$new_name = time();
				$config['upload_path'] = 'ajqgzgmedscuoc/img/admin/whychoose';
				$config['allowed_types'] = 'gif|jpg|png|jpeg';
				$ext = pathinfo($_FILES['icon']['name'], PATHINFO_EXTENSION);
				$config['file_name'] = $new_name . '.' . $ext;
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				if ($_FILES["icon"]["name"] != '') {
					if (!$this->upload->do_upload('icon')) {

						$error = array('error' => $this->upload->display_errors());
						$this->session->set_flashdata('error', $error['error']);
						admin_redirect('whyedit/' . $id, 'refresh');

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

							$updateData['icon'] = $d['file_name'];
						}
					}

				}
				
				$heading = escapeString(strip_tags($this->input->post('heading')));
				$language = escapeString(strip_tags($this->input->post('language')));
				$updateData['heading'] = $heading;
				$updateData['language'] = $language;
				$condition = array('id' => $work_id);
				
				
				$update = FS::Common()->updateTableData(WHYCHOOSE, $condition, $updateData);

				if ($update) {
					FS::session()->set_flashdata('success', 'Why choose section has been updated successfully!');
					admin_redirect('whychoose', 'refresh');
				} else {
					FS::session()->set_flashdata('error', 'Unable to update this Why choose section');
					admin_redirect('whyedit/' . $id, 'refresh');
				}

			} else {
				FS::session()->set_flashdata('error', 'Unable to update this Why choose section');
				admin_redirect('whyedit/' . $id, 'refresh');
			}

		}
			$data['action'] 		= 	base_url() . 'whyedit';
			
			$data['title'] 			= 	'Edit 
			Why';

			$data['whychoose'] 		=	FS::Common()->getTableData(WHYCHOOSE, array('id' => $work_id))->row();

			$data['lang'] 			=	FS::Common()->getTableData(LANG)->result();

			$this->view('pages/Whychoose/editwhy', $data);
	}
}
