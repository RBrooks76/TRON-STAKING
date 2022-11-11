<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Plan extends Admin_Controller {

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


	function planmanage() 
	{
		if(empty(admin_id())) 
		{
			admin_url_redirect('', 'refresh');
		}

		user_access();

		$user_view = $this->config->item('user_view');


		if(!in_array('23',$user_view))
		{
			admin_redirect('admindashboard', 'refresh');
		}

		$data['title'] 			= 	'Plan Management';

		$data['section'] 		= 	'Plan A';

		$data['plan'] 	=	FS::Common()->getTableData(PLANS, '', '', '', '', '', '','', array('id', 'DESC'))->result();

		$this->view('pages/Plans/planmanage', $data);
		
	}

	function planbmanage() 
	{
		if(empty(admin_id())) 
		{
			admin_url_redirect('', 'refresh');
		}

		user_access();

		$user_view = $this->config->item('user_view');

		if(!in_array('23',$user_view))
		{
			admin_redirect('admindashboard', 'refresh');
		}

		$data['title'] 			= 	'Plan Management';

		$data['section'] 		= 	'Plan B';

		$data['plan'] 	=	FS::Common()->getTableData(PLAN_B, array('plan_type' => 'B'), '', '', '', '', '','', array('id', 'DESC'))->result();


		$this->view('pages/Plans/planmanage', $data);
		
	}



	// Edit page
	function editplan($id='',$page='') {
		user_access();
		$user_view = $this->config->item('user_view');
		
		if(!in_array('23',$user_view)){
			admin_redirect('admindashboard', 'refresh');
		}
		
		// Is logged in
		$sessionvar = $this->session->userdata('loggedadmin');
		
		// Is valid
		$plan_id = insep_decode($id);
		if ($id == '') {
			FS::session()->set_flashdata('error', 'Invalid request');
			admin_redirect('plan', 'refresh');
		}
		
		if (!$sessionvar) {
			admin_url_redirect('', 'refresh');
		}
		
		if(insep_decode($page) == 'TYPEA'){
			$isValid = FS::Common()->getTableData(PLANS, array('id' => $plan_id));
			if ($isValid->num_rows() == 0) {
				FS::session()->set_flashdata('error', 'Unable to find this page');
				admin_redirect('plan', 'refresh');
			}
			// Form validation
			$this->form_validation->set_rules('plan_name_a', 'plan_name_a', 'required|xss_clean');
			$this->form_validation->set_rules('plan_type_a', 'plan_type_a', 'required|xss_clean');
			$this->form_validation->set_rules('amount', 'amount', 'required|xss_clean');
			$this->form_validation->set_rules('language_a', 'language_a', 'required|xss_clean');
		

			if ($this->input->post()) {
				if ($this->form_validation->run()) {

					$updateData = array();
				
					
					$plan_name_a = escapeString(strip_tags($this->input->post('plan_name_a')));
					$plan_type_a = escapeString(strip_tags($this->input->post('plan_type_a')));
					$amount = escapeString(strip_tags($this->input->post('amount')));
				
					$status   = escapeString(strip_tags($this->input->post('status')));
					$language = escapeString(strip_tags($this->input->post('language_a')));
					
					$updateData['plan_name']  = $plan_name_a;
					$updateData['plan_type']  = $plan_type_a;
					$updateData['amount']    = $amount;	
					$updateData['status']   	= $status;
					$updateData['language']   	= $language;
					$updateData['updated_at'] 	=  date('Y-m-d H:i:s');;
					$condition = array('id' => $plan_id);
					
					$update = FS::Common()->updateTableData(PLANS, $condition, $updateData);
					if ($update) {
						FS::session()->set_flashdata('success', 'Plan has been updated successfully!');
						admin_redirect('plan', 'refresh');
					} else {
						FS::session()->set_flashdata('error', 'Unable to update this plan');
						admin_redirect('planedit/' . $id, 'refresh');
					}

				} else {
					FS::session()->set_flashdata('error', 'Unable to update this plan');
					admin_redirect('planedit/' . $id, 'refresh');
				}

			}
		} else {
			$isValid = FS::Common()->getTableData(PLAN_B, array('id' => $plan_id));
			
			if ($isValid->num_rows() == 0) {
				FS::session()->set_flashdata('error', 'Unable to find this page');
				admin_redirect('plan', 'refresh');
			}
			// Form validation
			$this->form_validation->set_rules('plan_name', 'plan_name', 'required|xss_clean');
			$this->form_validation->set_rules('plan_type', 'plan_type', 'required|xss_clean');
			$this->form_validation->set_rules('receive', 'receive', 'required|xss_clean');
			$this->form_validation->set_rules('return_amt', 'return_amt', 'required|xss_clean');
			$this->form_validation->set_rules('days', 'days', 'required|xss_clean');
			$this->form_validation->set_rules('min_deposit', 'min_deposit', 'required|xss_clean');
			$this->form_validation->set_rules('max_withdraw', 'max_withdraw', 'required|xss_clean');
			$this->form_validation->set_rules('status', 'status', 'required|xss_clean');
			$this->form_validation->set_rules('withdraw_happen', 'withdraw_happen', 'required|xss_clean');
			$this->form_validation->set_rules('hold_bonus', 'hold_bonus', 'required|xss_clean');
			$this->form_validation->set_rules('fund_bonus', 'fund_bonus', 'required|xss_clean');
			$this->form_validation->set_rules('referral_bonus', 'referral_bonus', 'required|xss_clean');
			$this->form_validation->set_rules('referral_rewards', 'referral_rewards', 'required|xss_clean');
			$this->form_validation->set_rules('language', 'language', 'required|xss_clean');

			if ($this->input->post()) {
				if ($this->form_validation->run()) {
					$updateData = array();
					
					$plan_name = escapeString(strip_tags($this->input->post('plan_name')));
					$plan_type = escapeString(strip_tags($this->input->post('plan_type')));
					$receive = escapeString(strip_tags($this->input->post('receive')));
					$return_amt = escapeString(strip_tags($this->input->post('return_amt')));
					$days = escapeString(strip_tags($this->input->post('days')));
					$min_deposit = escapeString(strip_tags($this->input->post('min_deposit')));
					$max_withdraw = escapeString(strip_tags($this->input->post('max_withdraw')));
					$withdraw_happens = escapeString(strip_tags($this->input->post('withdraw_happen')));

					$hold_bonus = escapeString(strip_tags($this->input->post('hold_bonus')));
					$fund_bonus = escapeString(strip_tags($this->input->post('fund_bonus')));
					$referral_bonus = escapeString(strip_tags($this->input->post('referral_bonus')));
					$referral_rewards = $this->input->post('referral_rewards');

					$status   = escapeString(strip_tags($this->input->post('status')));
					$language = escapeString(strip_tags($this->input->post('language')));
					
					$updateData['plan_name']  = $plan_name;
					$updateData['plan_type']  = $plan_type;
					$updateData['receive']    = $receive;
					$updateData['return_amt'] = $return_amt;
					$updateData['days'] 	  = $days;
					$updateData['min_deposit']  = $min_deposit;
					$updateData['max_withdraw'] = $max_withdraw;
					$updateData['withdraw_happens'] = $withdraw_happens;
					$updateData['hold_bonus'] 	  = $hold_bonus;
					$updateData['fund_bonus']  = $fund_bonus;
					$updateData['referral_bonus'] = $referral_bonus;
					$updateData['referral_rewards'] = $referral_rewards;
					$updateData['status']   	= $status;
					$updateData['language']   	= $language;
					$updateData['updated_at'] 	=  date('Y-m-d H:i:s');;
					$condition = array('id' => $plan_id);
					
					$update = FS::Common()->updateTableData(PLAN_B, $condition, $updateData);
					if ($update) {
						FS::session()->set_flashdata('success', 'Plan has been updated successfully!');
						admin_redirect('plan', 'refresh');
					} else {
						FS::session()->set_flashdata('error', 'Unable to update this plan');
						admin_redirect('planedit/' . $id, 'refresh');
					}

				} else {
					FS::session()->set_flashdata('error', 'Unable to update this plan');
					admin_redirect('planedit/' . $id, 'refresh');
				}

			}
		}

		$data['action'] 		= 	base_url() . 'editplan';
		$data['title'] 			= 	'Edit plan';
		if(insep_decode($page) == 'TYPEA'){
			$data['mode'] 			= 	'A';
			$data['plan_data'] 	=	FS::Common()->getTableData(PLANS, array('id' => $plan_id))->row();
		} else {
			$data['mode'] 			= 	'B';
			$data['plan_data'] 	=	FS::Common()->getTableData(PLAN_B, array('id' => $plan_id))->row();
		}
		 
		$data['lang'] 	=	FS::Common()->getTableData(LANG)->result();
		$this->view('pages/Plans/editplan', $data);
	}
}