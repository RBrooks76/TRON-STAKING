<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Linkrequest extends Admin_Controller {

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
		if(empty(admin_id())) { admin_url_redirect('', 'refresh'); }
		user_access();
		$user_view = $this->config->item('user_view');
		if(!in_array('26',$user_view)){ admin_redirect('admindashboard', 'refresh'); }

		$data['title'] = 'Link Request Management';
		$data['result'] = @get_data(LR)->result_array();

		$this->view('pages/Linkrequst/manage', $data);  
	}

	public function join_link_request () {
		$this->form_validation->set_rules('email', 'Email', 'required');
		$return_info = array('status'=>'');
		if($this->form_validation->run() && isset($_POST['type'])){
			$data = $_POST; $type = $_POST['type'];
			if($type == '1' || $type == '2' || $type == '3'){
				$join_info = array();
				$join_info['request_type'] = $type;
				
				if($type == '1'){
					$join_info['request_value'] = $data['email'];
					$join_info['request_e'] = 0;
				} else if($type == '2') {
					if(isset($data['Whatsapp']) && $data['Whatsapp'] != ''){
						$join_info['request_value'] = $data['Whatsapp'];
						$join_info['request_e'] = $data['email'];
					} else {
						$join_info['request_type'] = 1;
						$join_info['request_value'] = $data['email'];
						$join_info['request_e'] = 0;
					}
				} else if($type == '3'){
					if(isset($data['Telegram']) && $data['Telegram'] != ''){
						$join_info['request_value'] = $data['Telegram'];
						$join_info['request_e'] = $data['email'];
					} else {
						$join_info['request_type'] = 1;
						$join_info['request_value'] = $data['email'];
						$join_info['request_e'] = 0;
					}
				}

				$res = $this->db->insert(LR, $join_info);
				if($res == true){
					$return_info['status'] = 'success';
					echo json_encode($return_info);
					die();
				} else {
					$return_info['status'] = 'error';
					echo json_encode($return_info);
					die();
				}

			} else {
				$return_info['status'] = 'error';
				echo json_encode($return_info);
				die();
			}
		} else {
			$return_info['status'] = 'error';
			echo json_encode($return_info);
			die();
		}
	}
}