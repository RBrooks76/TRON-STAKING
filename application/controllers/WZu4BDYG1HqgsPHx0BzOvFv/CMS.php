<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CMS extends Admin_Controller {

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

	public function index(){
		echo "Gfgf";
	}


	function cmsmanage() {

		if(empty(admin_id())) 
		{
			admin_url_redirect('', 'refresh');
		}

		user_access();

		$user_view = $this->config->item('user_view');


		if(!in_array('6',$user_view))
		{
			admin_redirect('admindashboard', 'refresh');
		}

			$data['title'] 			= 	'CMS Manage';

			$data['cms'] 	=	FS::Common()->getTableData(CMS, '', '', '', '', '', '','', array('id', 'DESC'))->result();
				
			
			$this->view('pages/CMS/cmsmanage', $data);
		
	}


	// Edit page
	function editcms($id='') {

		user_access();
		$user_view = $this->config->item('user_view');
		if(!in_array('6',$user_view)){ admin_redirect('admindashboard', 'refresh'); }

		// Is logged in
		$sessionvar = $this->session->userdata('loggedadmin');
		if (!$sessionvar) { admin_url_redirect('', 'refresh'); }
		// Is valid
		$cms_id = insep_decode($id);
		if ($id == '') {
			FS::session()->set_flashdata('error', 'Invalid request');
			admin_redirect('emailtemplate', 'refresh');
		}
		$isValid = FS::Common()->getTableData(CMS, array('id' => $cms_id));
		if ($isValid->num_rows() == 0) {
			FS::session()->set_flashdata('error', 'Unable to find this page');
			admin_redirect('emailtemplate', 'refresh');
		}
		// Form validation
		$this->form_validation->set_rules('heading', 'heading', 'required|xss_clean');
		// $this->form_validation->set_rules('link', 'link', 'required|xss_clean');
		// $this->form_validation->set_rules('title', 'title', 'required');
		// $this->form_validation->set_rules('meta_keyword', 'meta_keyword', 'required|xss_clean');
		// $this->form_validation->set_rules('meta_description', 'meta_description', 'required|xss_clean');
		$this->form_validation->set_rules('content_description', 'content_description', 'required|xss_clean');
		//$this->form_validation->set_rules('language', 'language', 'required|xss_clean');
		
		if ($this->input->post()) {
			if ($this->form_validation->run()) {

				$updateData = array();
				$heading = escapeString(strip_tags($this->input->post('heading')));
				// $link = escapeString(strip_tags( $this->input->post('link')));
				// $title = escapeString(strip_tags($this->input->post('title')));
				// $meta_keyword = escapeString(strip_tags($this->input->post('meta_keyword')));
				// $meta_description = escapeString(strip_tags($this->input->post('meta_description')));
				$content_description = $this->input->post('content_description');

				$value = htmlentities($content_description);
   				$value = stripslashes($value);
				//  echo $value; die;
				//$language = escapeString(strip_tags($this->input->post('language')));
				$updateData['heading'] = $heading;
				// $updateData['link'] = $link;
				// $updateData['title'] = $title;
				// $updateData['meta_keywords'] = $meta_keyword;
				// $updateData['meta_description'] = $meta_description;

				$new_name = time().rand(10,100);
				$config['upload_path'] = 'ajqgzgmedscuoc/img/cms';
				$config['allowed_types'] = 'gif|jpg|png|jpeg';
				$ext = pathinfo($_FILES['cms_image']['name'], PATHINFO_EXTENSION);
				$config['file_name'] = $new_name . '.' . $ext;
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				if ($_FILES["cms_image"]["name"] != '') {
					if (!$this->upload->do_upload('cms_image')) {
						$error = array('error' => $this->upload->display_errors());
						$this->session->set_flashdata('error', $error['error']);
						admin_redirect('cms');
					} else {
						$d = $this->upload->data();
						if ($config['file_name']) {
							$this->load->library('image_lib');
							$configs['image_library'] = 'gd2';
							$configs['source_image'] = $config['upload_path'] .'/'. $config['file_name'];
							$configs['maintain_ratio'] = TRUE;
							$configs['width'] = 940;
							$configs['height'] = 788;
							$configs['overwrite'] = TRUE;
							$configs['new_image'] = $config['upload_path']  .'/'.  $config['file_name'];
							$this->image_lib->initialize($configs);
							$this->image_lib->resize();
							$this->image_lib->clear();
							$updateData['cms_image'] = $d['file_name'];
						}
					}
				}

				$updateData['content_description'] = $value;
				//$updateData['language'] = $language;
				$condition = array('id' => $cms_id);
				$update = FS::Common()->updateTableData(CMS, $condition, $updateData);

				if ($update) {
					FS::session()->set_flashdata('success', 'CMS has been updated successfully!');
					admin_redirect('cms', 'refresh');
				} else {
					FS::session()->set_flashdata('error', 'Unable to update this CMS');
					admin_redirect('cmsedit/' . $id, 'refresh');
				}

			} else {
				FS::session()->set_flashdata('error', 'Unable to update this CMS');
				admin_redirect('cmsedit/' . $id, 'refresh');
			}
		}
		$data['action'] 		= 	base_url() . 'editcms';
		$data['title'] 			= 	'Edit CMS';
		$data['cms'] 	=	FS::Common()->getTableData(CMS, array('id' => $cms_id))->row();
		$data['lang'] 	=	FS::Common()->getTableData(LANG)->result();

		$this->view('pages/CMS/editcms', $data);
	}
}