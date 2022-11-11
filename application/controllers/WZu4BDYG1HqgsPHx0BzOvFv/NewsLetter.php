<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class NewsLetter extends Admin_Controller {
	public function index() {
		echo 'News Letter';
	}
	
	public function newsmanage ($plan='', $tree='') {		
		$admindetails = FS::db()->where('id', 1)->get(AD)->row();
		$data['contact_email'] = $admindetails->subadmin_email;
		if(empty(admin_id())) {admin_url_redirect('', 'refresh');}

		
		$data['title'] = 'News Letter';
		$data['page'] = 'NewsLetter';
		$data['selectedPlan'] = 'all';
		$data['treeState'] = false;
		$data['selectedTree'] = 'all';
		$data['searchContent'] = '';
		$data['treeCount'] = 1;
		$data['referralStatus'] = false;
		
		if($plan == 'requestJoinLink') {
			$data['selectedPlan'] = 'requestJoinLink';
			$data['referralStatus'] = true;
			$searchText = isset($_GET['searchContent']) ? $_GET['searchContent'] : '';
			if(isset($_GET) && count($_GET) > 0 && isset($searchText)) $data['searchContent'] = $searchText;

			$this->db->select('link_id, request_value, created_at, request_type, request_e');
			$this->db->where("request_value != ", '');
			// $this->db->where("request_type = ", '1');
			if(isset($_GET) && count($_GET) > 0 && isset($searchText)) $this->db->where("request_value LIKE ", '%'.$searchText.'%');
			$this->db->order_by('created_at', 'desc');
			
			$data['usersData'] = $this->db->get(LR)->result();
		} else {
			$searchText = isset($_GET['searchContent']) ? $_GET['searchContent'] : '';
			if(isset($_GET) && count($_GET) > 0 && isset($searchText)) $data['searchContent'] = $searchText;
		
			$this->db->select('id, address, contract_id, plan_id, tree_id, email, updated_date, ref_id, ref_code');
			$this->db->where("email != ", '');
			
			if(isset($plan) && !empty($plan)) $this->db->where("plan_id", $plan);
			if(isset($plan) && !empty($plan) && $plan == 1 && isset($tree) && !empty($tree)) $this->db->where("tree_id", $tree);
			if(isset($_GET) && count($_GET) > 0 && isset($searchText)) $this->db->where("email LIKE ", '%'.$searchText.'%');
			$data['usersData'] = $this->db->get(USERS)->result();

			if(isset($plan) && !empty($plan)){
				$data['selectedPlan'] = $plan == 1 || $plan == 2 ? $plan : 'all';
				if($plan == 1) $data['treeState'] = true;
				if(isset($tree) && !empty($tree)){
					$data['selectedTree'] = $tree;
				}
			}
			$treeCount = $this->db->query('SELECT tree_id FROM `' . P . RL . '` ORDER BY tree_id DESC')->result()[0]->tree_id;
			if(isset($treeCount)) $data['treeCount'] = $treeCount;
		}

		FS::session()->set_userdata(array('news_referral'=> $data['referralStatus']));
		$this->view('pages/newsletter', $data);
	}
  
	function sendNewsLetter() {
		$data = $_POST;
		
		$resData = array('state' => false, 'message' => '');
		if(isset($_POST['subtitle']) && $_POST['subtitle'] != '' && isset($_POST['content']) && $_POST['content'] != '' && isset($_POST['usersID']) && $_POST['usersID'] != ''){
			$usersID = explode('@@', $_POST['usersID']);
			$list = array();
			
			if(FS::session()->news_referral){
				$this->db->select('link_id, request_value, created_at, request_type, request_e'); 
				foreach ($usersID as $value) {
					if(isset($value) && $value) $this->db->or_where('link_id', $value);
				}
				$users_data = $this->db->get(LR)->result();
				foreach ($users_data as $value) {
					if(isset($value->request_value) && $value->request_value && isset($value->request_type) &&$value->request_type == 1) array_push($list, $value->request_value);
					else if(isset($value->request_e) && $value->request_e && isset($value->request_type) && ($value->request_type == 2 || $value->request_type == 2)) array_push($list, $value->request_e);
				}
			}else {
				$this->db->select('id, address, contract_id, email'); 
				foreach ($usersID as $value) {
					if(isset($value) && $value) $this->db->or_where('id', $value);
				}
				$users_data = $this->db->get(USERS)->result();
				foreach ($users_data as $value) {
					if(isset($value->email) && $value->email) array_push($list, $value->email);
				}
			}
			
			if(isset($users_data) && count($users_data)){
				$path = base_url();
				$img_url = base_url() . 'ajqgzgmedscuoc/img/site/' . getSiteLogo();
				$news_subtitle = $_POST['subtitle'];
				$news_content = $_POST['content'];
				$attachInfo = array();


				if(isset($_FILES['file'])){
					$attachPath = $_FILES['file']['tmp_name'];
					$fileNameCmps = explode(".", $_FILES['file']['name']);
					$fileExtension = strtolower(end($fileNameCmps));
					$NewfileName = time() . '.' . $fileExtension;
					$full_path = 'ajqgzgmedscuoc/newsupload/' . $NewfileName;

					if(move_uploaded_file($attachPath, $full_path)){
						$attachInfo['full_path'] = $full_path;
						$attachInfo['name'] = $_FILES['file']['name'];
						$attachInfo['CmpsName'] = $fileNameCmps;

						$send_mail = FS::Emodelo()->snedNewsMail($list, '', '', $news_subtitle, $news_content, $attachInfo);
						if($send_mail) {
							$resData['state'] = true;
							$resData['message'] = 'Sent to your mail successfully';
							echo json_encode($resData);
							die();
						} else {
							$resData['message'] = 'Error occured while sending Email';
							echo json_encode($resData);
							die();
						}
					} else {
						$send_mail = FS::Emodelo()->snedNewsMail($list, '', '', $news_subtitle, $news_content, $attachInfo);
						if($send_mail) {
							$resData['state'] = true;
							$resData['message'] = 'Sent to your mail successfully';
							echo json_encode($resData);
							die();
						} else {
							$resData['message'] = 'Error occured while sending Email';
							echo json_encode($resData);
							die();
						}
					}
				} else {
					$send_mail = FS::Emodelo()->snedNewsMail($list, '', '', $news_subtitle, $news_content, $attachInfo);
						if($send_mail) {
							$resData['state'] = true;
							$resData['message'] = 'Sent to your mail successfully';
							echo json_encode($resData);
							die();
						} else {
							$resData['message'] = 'Error occured while sending Email';
							echo json_encode($resData);
							die();
						}
				}
			} else {
				$resData['message'] = 'please check again all data';
				echo json_encode($resData);
				die();
			}
		} else {
			$resData['message'] = 'please check again all data';
			echo json_encode($resData);
			die();
		}
	}
}