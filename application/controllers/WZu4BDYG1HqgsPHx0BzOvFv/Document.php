<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Document extends Admin_Controller {

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

	function docmanage() {
		if(empty(admin_id())) { admin_url_redirect('', 'refresh'); }

		user_access();
		$user_view = $this->config->item('user_view');
		if(!in_array('14', $user_view)){ admin_redirect('admindashboard', 'refresh'); }

		$data['title'] = 'Document Manage';
		$data['doc'] = FS::Common()->getTableData(DOC, array(), '', array(), array(), array(), '', '', array('language', 'ASC'), )->result();
		$data['lang'] =	FS::Common()->getTableData(LANG)->result();
		$this->view('pages/Document/docmanage', $data);
	}

	// Edit page
	function docemail($id='') {
		user_access();
		$user_view = $this->config->item('user_view');
		if(!in_array('14',$user_view)) { admin_redirect('admindashboard', 'refresh'); }
		
		// Is logged in
		$sessionvar = $this->session->userdata('loggedadmin');
		if (!$sessionvar) { admin_url_redirect('', 'refresh'); }
		
		// Is valid
		$doc_id = insep_decode($id);
		if ($id == '') {
			FS::session()->set_flashdata('error', 'Invalid request');
			admin_redirect('document', 'refresh');
		}

		$doc_data = FS::Common()->getTableData(DOC, array('id' => $doc_id))->result();
		$isValid = FS::Common()->getTableData(DOC, array('id' => $doc_id));
		
		if ($isValid->num_rows() == 0) {
			FS::session()->set_flashdata('error', 'Unable to find this page');
			admin_redirect('document', 'refresh');
		}

		// Form validation
		$this->form_validation->set_rules('title', 'title', 'required|xss_clean');
		$this->form_validation->set_rules('language', 'language', 'required|xss_clean');

		if ($this->input->post()) {
			if ($this->form_validation->run()) {
				$updateData = array();

				$new_name = time();
				$config['upload_path'] = 'ajqgzgmedscuoc/img/admin/document';
				$config['allowed_types'] = 'pdf|rtf|doc|docx|txt|jpeg|png';
				$ext = pathinfo($_FILES['doc']['name'], PATHINFO_EXTENSION);
				$config['file_name'] = $new_name . '.' . $ext;
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				if ($_FILES["doc"]["name"] != '') {
					if (!$this->upload->do_upload('doc')) {
						$error = array('error' => $this->upload->display_errors());
						$this->session->set_flashdata('error', $error['error']);
						admin_redirect('document', 'refresh');
					} else {
						if(file_exists($config['upload_path'] . '/' . $doc_data[0]->document)) unlink($config['upload_path'] . '/' . $doc_data[0]->document);
			
						$d = $this->upload->data();
						if ($config['file_name']) {
							$updateData['document'] = $d['file_name'];
						}
					}
				}

				$title = escapeString(strip_tags($this->input->post('title')));				
				$language = escapeString(strip_tags($this->input->post('language')));

				$updateData['title'] = $title;
				$updateData['language'] = $language;
				$condition = array('id' => $doc_id);
				
				$update = FS::Common()->updateTableData(DOC, $condition, $updateData);
				if ($update) {
					FS::session()->set_flashdata('success', 'Document has been updated successfully!');
					admin_redirect('document', 'refresh');
				} else {
					FS::session()->set_flashdata('error', 'Unable to update this Document');
					admin_redirect('docedit/' . $id, 'refresh');
				}

			} else {
				FS::session()->set_flashdata('error', 'Unable to update this Document');
				admin_redirect('docedit/' . $id, 'refresh');
			}
		}
		
		$data['action'] = base_url() . 'docedit';
		$data['title'] = 'Edit Document';
		$data['doc'] = FS::Common()->getTableData(DOC, array('id' => $doc_id))->row();
		$data['lang'] =	FS::Common()->getTableData(LANG)->result();		
		$this->view('pages/Document/editdoc', $data);
	}

	function doc_add(){
		user_access();
		$user_view = $this->config->item('user_view');
		if(!in_array('14',$user_view)) { admin_redirect('admindashboard', 'refresh'); }

		// Is logged in
		$sessionvar = $this->session->userdata('loggedadmin');
		if (!$sessionvar) { admin_url_redirect('', 'refresh'); }

		// Form validation
		$this->form_validation->set_rules('title', 'title', 'required|xss_clean');
		$this->form_validation->set_rules('language', 'language', 'required|xss_clean');

		if ($this->input->post()) {
			if ($this->form_validation->run()) {
				$updateData = array();

				$new_name = time();
				$config['upload_path'] = 'ajqgzgmedscuoc/img/admin/document';
				$config['allowed_types'] = 'pdf|rtf|doc|docx|txt|jpeg|png';
				$ext = pathinfo($_FILES['doc']['name'], PATHINFO_EXTENSION);
				$config['file_name'] = $new_name . '.' . $ext;

				$this->load->library('upload', $config);
				$this->upload->initialize($config);

				if ($_FILES["doc"]["name"] != '') {
					if (!$this->upload->do_upload('doc')) {
						$error = array('error' => $this->upload->display_errors());
						$this->session->set_flashdata('error', $error['error']);
						admin_redirect('document', 'refresh');
					} else {
						$d = $this->upload->data();
						if ($config['file_name']) {
							$updateData['document'] = $d['file_name'];
						}
					}
				} else {
					FS::session()->set_flashdata('error', 'Unable to update this Document');
					admin_redirect('docadd', 'refresh');
				}
				
				$title = escapeString(strip_tags($this->input->post('title')));				
				$language = escapeString(strip_tags($this->input->post('language')));

				$updateData['title'] = $title;
				$updateData['language'] = $language;

				$update = FS::Common()->insertTableData(DOC, $updateData);
				if ($update) {
					FS::session()->set_flashdata('success', 'Document has been add successfully!');
					admin_redirect('document', 'refresh');
				} else {
					FS::session()->set_flashdata('error', 'Unable to add this Document');
					admin_redirect('docadd/' . $id, 'refresh');
				}
			} else {
				FS::session()->set_flashdata('error', 'Unable to update this Document');
				admin_redirect('docadd', 'refresh');
			}
		}

		$data['action'] = base_url() . 'docadd';
		$data['title'] = 'Add Document';
		$data['lang'] =	FS::Common()->getTableData(LANG)->result();	
		
		$this->view('pages/Document/docadd', $data);
	}

	function doc_delete($id) {
		user_access();
		$user_view = $this->config->item('user_view');
		if(!in_array('5',$user_view)) { admin_redirect('admindashboard', 'refresh'); }

		// Is logged in
		$sessionvar = $this->session->userdata('loggedadmin');
		if (!$sessionvar) { admin_url_redirect('', 'refresh'); }

		// Is valid
		$doc_id = insep_decode($id);
		if ($id == '') {
			$this->session->set_flashdata('error', 'Invalid request');
			admin_redirect('faq', 'refresh');
		}
		
		$doc_data = FS::Common()->getTableData(DOC, array('id' => $doc_id))->result();
		$isValid = count($doc_data);
		if ($isValid > 0) {
			$filename = 'ajqgzgmedscuoc/img/admin/document/';
			if(file_exists($filename . $doc_data[0]->document)) unlink($filename . $doc_data[0]->document);
			// Check is valid
			$condition = array('id' => $doc_id);
			$delete = FS::Common()->deleteTableData(DOC, $condition);
			
			if ($delete) {
				// True // Delete success
				FS::session()->set_flashdata('success', 'Document deleted successfully');
				admin_redirect('document', 'refresh');
			} else {
				//False
				FS::session()->set_flashdata('error', 'Problem occure with faq deletion');
				admin_redirect('document', 'refresh');
			}
		} else {
			FS::session()->set_flashdata('error', 'Unable to find this page');
			admin_redirect('faq', 'refresh');
		}
	}
}